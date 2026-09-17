// Ejecutar: node tests/producer-target.test.cjs
// Ejecuta la inicialización real de app.js; sustituye sólo API y efectos de interfaz.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');
const source = fs.readFileSync(path.join(__dirname, '../app.js'), 'utf8');

async function focusedProducer(productores, target, search = '') {
  let onReady;
  const focused = [];
  const sandbox = {
    console, URLSearchParams,
    window: { INITIAL_PRODUCTORES: productores, TARGET_PRODUCER_PARAM: target, location: { search } },
    document: { addEventListener(event, handler) { if (event === 'DOMContentLoaded') onReady = handler; } },
    fetch: async () => ({ ok: false }),
    setTimeout: callback => callback()
  };
  vm.createContext(sandbox);
  vm.runInContext(source, sandbox, { filename: 'app.js' });
  for (const name of ['initThemeToggle', 'initMobileNav', 'initMap', 'renderProducersList', 'setupFilterListeners', 'setupSearchListener']) {
    sandbox[name] = () => {};
  }
  sandbox.focusProducer = id => focused.push(id);
  await onReady();
  return focused;
}

(async () => {
  const productores = [
    { id: 9, slug: 'bodega', nombre: 'Bodega' },
    { id: 21, slug: '9-lunas', nombre: '9 Lunas' },
    { id: 30, slug: '9', nombre: '9' }
  ];
  assert.deepEqual(await focusedProducer(productores, '9-lunas'), [21], 'El prefijo 9 no debe abrir al productor con ID 9');
  assert.deepEqual(await focusedProducer(productores, '9'), [30], 'Un slug totalmente numérico también tiene prioridad sobre ID');
  assert.deepEqual(await focusedProducer(productores, '9-inexistente'), [], 'Un slug desconocido no debe interpretarse como ID');
  assert.deepEqual(await focusedProducer(productores.slice(0, 2), null, '?id=9'), [9], 'Se conserva el acceso histórico por ID');
  assert.deepEqual(await focusedProducer(productores, null, '?productor=9-lunas'), [21]);
  assert.deepEqual(await focusedProducer([{ id: 9, nombre: 'Bodega' }, { id: 21, nombre: '9 Lunas' }], '9-lunas'), [21], 'Funciona al generar el slug desde el nombre');
  console.log('OK: slug exacto, slug numérico, prefijo numérico inexistente y acceso histórico por ID.');
})().catch(error => { console.error(error); process.exitCode = 1; });
