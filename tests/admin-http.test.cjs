// QA_ADMIN_PASSWORD debe existir en el entorno. Usar solo una copia local aislada.
const assert = require('node:assert/strict');
const password = process.env.QA_ADMIN_PASSWORD;
assert.ok(password, 'Definí QA_ADMIN_PASSWORD para la base local de prueba');
const bases = process.argv.slice(2);
assert.ok(bases.length, 'Indicá al menos una URL local');

(async () => {
  for (const base of bases) {
    const url = new URL(base);
    assert.ok(['127.0.0.1', 'localhost'].includes(url.hostname), 'Solo se permite probar en localhost');
    const admin = url.pathname.replace(/\/$/, '') + '/admin/';
    let cookie = '';
    async function request(path, form) {
      const response = await fetch(base + path, {
        redirect: 'manual', headers: { Cookie: cookie, ...(form ? { 'Content-Type': 'application/x-www-form-urlencoded' } : {}) },
        method: form ? 'POST' : 'GET', body: form ? new URLSearchParams(form) : undefined
      });
      const setCookie = response.headers.getSetCookie();
      if (setCookie.length) cookie = setCookie.map(value => value.split(';')[0]).join('; ');
      return { status: response.status, headers: response.headers, text: await response.text() };
    }
    const unauth = await request('/admin');
    assert.equal(unauth.status, 302);
    assert.equal(unauth.headers.get('location'), admin + 'login');
    const unauthForm = await request('/admin/solicitudes');
    assert.equal(unauthForm.headers.get('location'), admin + 'login');
    cookie = '';
    const login = await request('/admin/login.php');
    assert.equal(login.status, 200);
    const csrf = login.text.match(/name="csrf" value="([^"]+)"/)[1];
    assert.match(login.headers.get('set-cookie'), /HttpOnly/i);
    assert.match(login.headers.get('set-cookie'), /SameSite=Lax/i);
    assert.equal((await request('/admin/login', {usuario:'admin',password,csrf:'incorrecto'})).status, 403);
    assert.equal((await request('/admin/login', {usuario:'admin',password,'csrf[]':'incorrecto'})).status, 403);
    const wrong = await request('/admin/login', {usuario:'admin',password:'contraseña-incorrecta-qa',csrf});
    assert.match(wrong.text, /Usuario o contraseña incorrectos/);
    const before = cookie;
    const accepted = await request('/admin/login.php', {usuario:'admin',password,csrf});
    assert.equal(accepted.status, 302);
    assert.equal(accepted.headers.get('location'), admin);
    assert.notEqual(cookie, before, 'La sesión debe rotar al autenticar');
    assert.equal((await request('/admin/')).status, 200);
    assert.equal((await request('/admin')).headers.get('location'), admin);
    for (const path of ['/admin/productores?q[]=x&categoria[]=x&estado[]=x', '/admin/gondolas?q[]=x&estado[]=x']) {
      assert.equal((await request(path)).status, 200, 'Los filtros compuestos no deben causar errores');
    }
    for (const path of ['/sql/database.sql', '/config/env.php', '/.env.example', '/setup.php', '/migrar_gondolas.php', '/test_db.php', '/views/admin/productores.php']) {
      assert.equal((await request(path)).status, 403, path + ' debe estar protegido');
    }
    for (const path of ['/style.css', '/app.js', '/assets/productores/licores-bard.jpg', '/api/productores', '/mapa/licores-bard']) {
      assert.equal((await request(path)).status, 200, path + ' debe seguir disponible');
    }
    const missing = await request('/ruta-%3Cscript%3E');
    assert.ok([403, 404].includes(missing.status));
    assert.equal((await request('/ruta-inexistente-qa')).status, 404);
    assert.ok(!missing.text.includes('<script>'));
    const logout = await request('/admin/logout.php');
    assert.equal(logout.headers.get('location'), admin + 'login');
    assert.equal((await request('/admin/')).status, 302);
    console.log('OK: acceso, CSRF, sesión, logout, rutas y archivos protegidos en ' + base);
  }
})().catch(error => { console.error(error); process.exitCode = 1; });
