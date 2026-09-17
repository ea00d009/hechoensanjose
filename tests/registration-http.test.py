"""Prueba HTTP del flujo de inscripción sobre la copia local aislada.
La contraseña se recibe por variable QA_ADMIN_PASSWORD, nunca se guarda aquí.
"""
import argparse, json, os, re, subprocess, time
from concurrent.futures import ThreadPoolExecutor
import urllib.request, urllib.parse, urllib.error
from http.cookiejar import CookieJar
from pathlib import Path

HERE = Path(__file__).parent
parser = argparse.ArgumentParser(description=__doc__)
parser.add_argument('url', nargs='?', default=os.environ.get('QA_BASE_URL'), help='URL local de la copia (o QA_BASE_URL)')
parser.add_argument('--site', default=os.environ.get('QA_SITE_DIR'), help='Directorio de la copia aislada (o QA_SITE_DIR)')
parser.add_argument('--php', default=os.environ.get('QA_PHP_BIN', 'php'), help='Ejecutable PHP con pdo_mysql (o QA_PHP_BIN)')
options = parser.parse_args()
if not __debug__:
    parser.error('Ejecutá Python sin -O para conservar todas las comprobaciones de seguridad y resultados.')
if not options.url or not options.site or not os.environ.get('QA_ADMIN_PASSWORD'):
    parser.error('Indicá URL, directorio QA y QA_ADMIN_PASSWORD antes de ejecutar.')
BASE = options.url.rstrip('/')
BASE_URL = urllib.parse.urlsplit(BASE)
if BASE_URL.scheme not in ['http', 'https'] or BASE_URL.hostname not in ['127.0.0.1', 'localhost', '::1'] or BASE_URL.username or BASE_URL.password or BASE_URL.query or BASE_URL.fragment:
    parser.error('Sólo se permite una URL http/https de localhost, sin credenciales, consulta ni fragmento.')
SITE = Path(options.site).resolve()
if not (SITE / 'config/db.php').is_file() or SITE == HERE.parent.resolve():
    parser.error('Usá una copia aislada del proyecto con config/db.php, nunca el checkout de trabajo.')
TAG = 'QAFLUJO' + str(time.time_ns())
FAIL_TRIGGER = 'qa_fail_' + TAG
DELAY_TRIGGER = 'qa_delay_' + TAG
checks = []

class LocalRedirects(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, req, fp, code, msg, headers, newurl):
        target = urllib.parse.urlsplit(newurl)
        if (target.scheme, target.hostname, target.port) != (BASE_URL.scheme, BASE_URL.hostname, BASE_URL.port):
            raise RuntimeError('La copia QA intentó redirigir fuera del servidor local configurado.')
        return super().redirect_request(req, fp, code, msg, headers, newurl)

def new_client():
    return urllib.request.build_opener(urllib.request.HTTPCookieProcessor(CookieJar()), LocalRedirects())

client = new_client()

def db(sql, params=None):
    run = subprocess.run([options.php, str(HERE / 'registration-db.php'), str(SITE)], input=json.dumps({'sql': sql, 'params': params or []}), capture_output=True, text=True, encoding='utf-8', timeout=20)
    assert run.returncode == 0, run.stderr
    return json.loads(run.stdout)

def request(path, data=None, raw=None, session=None):
    body = raw.encode() if raw is not None else urllib.parse.urlencode(data, doseq=True).encode() if data is not None else None
    headers = {'Content-Type': 'application/json'} if raw is not None else {}
    req = urllib.request.Request(BASE + path, data=body, headers=headers)
    try:
        response = (session or client).open(req, timeout=20)
    except urllib.error.HTTPError as error:
        response = error
    return response.status, response.read().decode('utf-8'), response.geturl()

def check(label, result):
    assert result, label
    checks.append(label)
    print('OK ' + label, flush=True)

def csrf(html):
    return re.search(r'name="csrf" value="([^"]+)"', html)[1]

def scalar(sql, params=None):
    return next(iter(db(sql, params)['rows'][0].values()))

def checked(html, name, value):
    return bool(re.search(r'name="' + name + r'\[\]" value="' + str(value) + r'"\s+checked', html))

def run():
    # Confirmar que la URL consulta la misma base aislada antes del primer POST.
    probe_id = int(db("INSERT INTO ps_productores (nombre,rubro,categoria_id,imagen,lat,lng,direccion,whatsapp,descripcion) VALUES (?,?,'pecan','',-32.2,-58.2,'Prueba','5493447123456','Prueba local')", [TAG+'Sonda','Prueba'])['lastId'])
    status, html, _ = request('/api/productores')
    check('la URL sirve la misma base de datos aislada', status == 200 and any(p['id']==probe_id and p['nombre']==TAG+'Sonda' for p in json.loads(html)['productores']))
    db('DELETE FROM ps_productores WHERE id=?', [probe_id])
    payload = dict(nombre_titular='Persona de prueba', dni_cuit='12345678', whatsapp='+54 9 3447 123456', email='qa@example.test', nombre_emprendimiento=TAG, rubro='Artesanías, Cuero & Cuchillería', direccion='Calle de prueba 123', descripcion='Registro de prueba local que se elimina al finalizar.', interes_catalogo='1', interes_mapa='1', interes_gondola='1')
    for label, values in [
        ('tipo array', dict(nombre_titular=[])), ('correo inválido', dict(email='no-es-un-email')),
        ('longitud máxima', dict(nombre_emprendimiento='x'*151)), ('campo obligatorio vacío', dict(direccion='   ')),
        ('WhatsApp inválido', dict(whatsapp='abc')), ('interés inválido', dict(interes_ferias=[])),
    ]:
        status, html, _ = request('/api/inscribir', raw=json.dumps(payload | values))
        check('rechaza ' + label, status == 400 and json.loads(html)['success'] is False)
    for raw in ['{', '[]', 'null']:
        status, html, _ = request('/api/inscribir', raw=raw)
        check('rechaza JSON ' + raw, status == 400 and json.loads(html)['success'] is False)
    status, html, _ = request('/api/productores?categoria[]=pecan')
    check('rechaza filtro de categoría con array', status == 400 and not json.loads(html)['success'])
    check('los intentos inválidos no crean solicitudes', scalar('SELECT COUNT(*) FROM ps_solicitudes_inscripcion WHERE nombre_emprendimiento=?', [TAG]) == 0)
    status, html, _ = request('/api/inscribir', data=payload)
    sid = json.loads(html)['id']
    check('inscripción válida por formulario', status == 201)
    status, html, _ = request('/admin/login')
    token = csrf(html)
    status, html, url = request('/admin/login', data={'csrf': token, 'usuario': 'admin', 'password': os.environ['QA_ADMIN_PASSWORD']})
    check('acceso autorizado al panel', status == 200 and '/admin/' in url and 'name="password"' not in html)
    status, html, _ = request('/admin/solicitudes.php')
    token = csrf(html)
    check('solicitud en bandeja', status == 200 and TAG in html)
    status, html, _ = request('/admin/productor-form.php?from_solicitud=' + str(sid))
    check('categoría Artesanía sugerida correctamente', 'value="artesania" selected' in html)
    gid = int(db('INSERT INTO ps_gondolas (nombre,tipo,descripcion,direccion,activo) VALUES (?,?,?,?,0)', [TAG+'G','Góndola Oficial','Prueba','Dirección'])['lastId'])
    status, html, _ = request('/admin/productor-form.php?from_solicitud=' + str(sid))
    check('góndola inactiva disponible en el formulario', TAG+'G' in html and '(inactiva)' in html)
    producer = dict(csrf=csrf(html), nombre=TAG, rubro='Artesanías', categoria_id='artesania', tag_label='', direccion='Calle de prueba 123', telefono='', whatsapp='5493447123456', horario='', descripcion='Descripción de prueba', lat='-32.2123', lng='-58.2191', activo='1', imagen_url='assets/productores/establecimiento-los-pecanes.jpg', **{'gondolas[]': [gid]})
    db('CREATE TRIGGER '+FAIL_TRIGGER+" BEFORE INSERT ON ps_gondola_productores FOR EACH ROW BEGIN IF NEW.gondola_id = "+str(gid)+" THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'QA: fallo de asignación'; END IF; END")
    status, html, _ = request('/admin/productor-form.php?from_solicitud=' + str(sid), data=producer)
    db('DROP TRIGGER '+FAIL_TRIGGER)
    check('fallo de asignación muestra error y mantiene formulario', status == 200 and 'Error interno al guardar' in html and checked(html, 'gondolas', gid))
    check('rollback evita productor parcial', scalar('SELECT COUNT(*) FROM ps_productores WHERE nombre=?', [TAG]) == 0)
    check('rollback deja solicitud pendiente', scalar('SELECT estado FROM ps_solicitudes_inscripcion WHERE id=?', [sid]) == 'pendiente')
    status, html, _ = request('/admin/productor-form.php?from_solicitud=' + str(sid), data=producer)
    check('aprobación y alta completas', status == 200 and scalar('SELECT estado FROM ps_solicitudes_inscripcion WHERE id=?', [sid]) == 'aprobada')
    pid = scalar('SELECT id FROM ps_productores WHERE nombre=?', [TAG])
    check('asignación conservada', scalar('SELECT COUNT(*) FROM ps_gondola_productores WHERE productor_id=? AND gondola_id=?', [pid,gid]) == 1)
    status, html, _ = request('/api/productores')
    check('productor publicado en API', status == 200 and any(p['id']==pid for p in json.loads(html)['productores']))
    status, html, _ = request('/admin/productor-form.php?from_solicitud=' + str(sid), data=producer)
    check('repetir aprobación no duplica productor', scalar('SELECT COUNT(*) FROM ps_productores WHERE nombre=?', [TAG]) == 1)
    status, html, _ = request('/admin/solicitudes.php', data=dict(csrf=token, solicitud_id=sid, nuevo_estado='pendiente'))
    check('no permite restaurar solicitud aprobada', scalar('SELECT estado FROM ps_solicitudes_inscripcion WHERE id=?', [sid]) == 'aprobada')
    status, html, _ = request('/admin/productor-form.php?id=' + str(pid))
    check('editar muestra góndola inactiva seleccionada', checked(html, 'gondolas', gid))
    status, html, _ = request('/admin/productor-form.php?id=' + str(pid), data=producer | {'nombre':TAG+'Editado', 'direccion':''})
    check('validación conserva datos y selección', status==200 and TAG+'Editado' in html and checked(html, 'gondolas', gid))
    status, html, _ = request('/admin/productor-form.php?id=' + str(pid), data=producer)
    check('guardar productor conserva góndola inactiva', scalar('SELECT COUNT(*) FROM ps_gondola_productores WHERE productor_id=? AND gondola_id=?', [pid,gid]) == 1)
    db('UPDATE ps_productores SET activo=0 WHERE id=?', [pid])
    status, html, _ = request('/admin/gondola-form.php?id=' + str(gid))
    check('editar góndola muestra productor inactivo seleccionado', checked(html,'productores',pid) and '(inactivo)' in html)
    gondola = dict(csrf=csrf(html), nombre=TAG+'G', tipo='Góndola Oficial', color='icon-emerald', descripcion='Prueba', direccion='Dirección', horario='', telefono='', whatsapp='', productos_destacados='', google_maps_url='', lat='', lng='', orden='1', **{'productores[]':[pid]})
    status, html, _ = request('/admin/gondola-form.php?id=' + str(gid), data=gondola)
    check('guardar góndola conserva productor inactivo', status==200 and scalar('SELECT COUNT(*) FROM ps_gondola_productores WHERE productor_id=? AND gondola_id=?',[pid,gid])==1)
    status, html, _ = request('/admin/gondola-form.php?id=' + str(gid), data=gondola | {'lat':'-95','lng':'-58'})
    check('rechaza coordenadas fuera de rango', status==200 and 'coordenadas geográficas no son válidas' in html)
    status, html, _ = request('/admin/productores?q='+TAG)
    check('buscador de productores funciona con PDO real', status==200 and TAG in html and 'Error interno' not in html)
    status, html, _ = request('/admin/gondolas?q='+TAG)
    check('buscador de góndolas funciona con PDO real', status==200 and TAG+'G' in html and 'Error interno' not in html)

    # Dos sesiones distintas evitan que el bloqueo de sesión PHP oculte una carrera.
    status, html, _ = request('/api/inscribir', data=payload | {'nombre_emprendimiento':TAG+'Concurrente', 'rubro':'Quesería & Lácteos de Campo'})
    sid2 = json.loads(html)['id']
    status, html, _ = request('/admin/productor-form.php?from_solicitud=' + str(sid2))
    check('categoría Alimentos para Quesería', 'value="alimentos" selected' in html)
    sessions = []
    for _ in range(2):
        session = new_client()
        _, login, _ = request('/admin/login', session=session)
        _, _, _ = request('/admin/login', data={'csrf':csrf(login),'usuario':'admin','password':os.environ['QA_ADMIN_PASSWORD']}, session=session)
        _, form, _ = request('/admin/productor-form.php?from_solicitud='+str(sid2), session=session)
        sessions.append((session, csrf(form)))
    db('CREATE TRIGGER '+DELAY_TRIGGER+" BEFORE INSERT ON ps_productores FOR EACH ROW BEGIN IF NEW.nombre = '"+TAG+"Concurrente' THEN SET @qa_delay = SLEEP(0.25); END IF; END")
    def approve(pair):
        session, token2 = pair
        return request('/admin/productor-form.php?from_solicitud='+str(sid2), data=producer | {'csrf':token2,'nombre':TAG+'Concurrente'}, session=session)[0]
    with ThreadPoolExecutor(max_workers=2) as pool:
        statuses = list(pool.map(approve, sessions))
    db('DROP TRIGGER '+DELAY_TRIGGER)
    check('dos administradores no duplican la aprobación simultánea', all(status == 200 for status in statuses) and scalar('SELECT COUNT(*) FROM ps_productores WHERE nombre=?',[TAG+'Concurrente']) == 1)
    check('solicitud concurrente queda aprobada', scalar('SELECT estado FROM ps_solicitudes_inscripcion WHERE id=?',[sid2])=='aprobada')

# Verificación de configuración y conexión antes de habilitar incluso la limpieza.
db('SELECT 1')
try:
    run()
finally:
    db('DROP TRIGGER IF EXISTS '+FAIL_TRIGGER)
    db('DROP TRIGGER IF EXISTS '+DELAY_TRIGGER)
    db('DELETE gp FROM ps_gondola_productores gp LEFT JOIN ps_productores p ON p.id=gp.productor_id LEFT JOIN ps_gondolas g ON g.id=gp.gondola_id WHERE p.nombre LIKE ? OR g.nombre LIKE ?', [TAG+'%',TAG+'%'])
    db('DELETE FROM ps_productores WHERE nombre LIKE ?', [TAG+'%'])
    db('DELETE FROM ps_gondolas WHERE nombre LIKE ?', [TAG+'%'])
    db('DELETE FROM ps_solicitudes_inscripcion WHERE nombre_emprendimiento LIKE ?', [TAG+'%'])
    print('Limpieza completada; ' + str(len(checks)) + ' comprobaciones correctas.')
