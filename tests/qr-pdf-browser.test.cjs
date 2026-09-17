// Integración del botón con el DOM y la descarga; no requiere servidor.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const { jsPDF } = require('../assets/vendor/jspdf/jspdf.umd.min.js');
const qrcode = require('../assets/vendor/qrcode-generator/qrcode.js');
const source = fs.readFileSync(require.resolve('../assets/js/productor-qr-pdf.js'), 'utf8');
const view = fs.readFileSync(require.resolve('../views/admin/productores.php'), 'utf8');
const fallback = [...view.matchAll(/<script>([\s\S]*?)<\/script>/g)].map(match => match[1]).find(script => script.includes('window.ProductorQrPdf'));
assert.ok(fallback, 'Debe existir una respuesta si falta el script del generador');

function fixture({ missingQr = false, saveError = false } = {}) {
  const clicks = [], loaded = [], saved = [];
  const status = { textContent: '', attrs: {}, scrolled: false,
    setAttribute(key, value) { this.attrs[key] = value; },
    scrollIntoView() { this.scrolled = true; }
  };
  const button = { textContent: 'QR PDF', disabled: false, attrs: {},
    dataset: { productorQr: JSON.stringify({ nombre: 'Licores Bard', slug: 'licores-bard', url: 'https://sanjose.tur.ar/hechoensanjose/licores-bard', whatsapp: '5493447123456' }) },
    setAttribute(key, value) { this.attrs[key] = value; },
    removeAttribute(key) { delete this.attrs[key]; },
    addEventListener(event, listener) { assert.equal(event, 'click'); clicks.push(listener); }
  };
  const document = {
    querySelectorAll(selector) { assert.equal(selector, '[data-productor-qr]'); return [button]; },
    getElementById(id) { assert.equal(id, 'qr-pdf-status'); return status; },
    addEventListener(event, listener) { assert.equal(event, 'DOMContentLoaded'); loaded.push(listener); }
  };
  const context = vm.createContext({ document, URL, setTimeout, qrcode: missingQr ? undefined : qrcode,
    jspdf: { jsPDF: function (options) {
      const doc = new jsPDF(options);
      doc.save = async (name, settings) => {
        if (saveError) throw new Error('Descarga interrumpida');
        saved.push({ name, settings, bytes: Buffer.from(doc.output('arraybuffer')) });
      };
      return doc;
    } }
  });
  context.window = context;
  return { context, clicks, loaded, saved, status, button };
}

(async () => {
  const good = fixture();
  vm.runInContext(source, good.context);
  vm.runInContext(fallback, good.context);
  good.loaded[0]();
  assert.equal(good.clicks.length, 1, 'No duplicar el clic si el generador cargó');
  const pending = good.clicks[0]();
  assert.equal(good.button.disabled, true);
  assert.equal(good.button.attrs['aria-busy'], 'true');
  await pending;
  assert.equal(good.saved.length, 1);
  assert.equal(good.saved[0].name, 'productor-licores-bard-qr.pdf');
  assert.equal(good.saved[0].settings.returnPromise, true);
  assert.equal(good.saved[0].bytes.subarray(0, 5).toString(), '%PDF-');
  assert.match(good.status.textContent, /PDF de Licores Bard generado/);
  assert.equal(good.button.disabled, false);
  assert.equal(good.button.textContent, 'QR PDF');
  assert.ok(!good.button.attrs['aria-busy']);

  for (const options of [{ missingQr: true }, { saveError: true }]) {
    const failed = fixture(options);
    vm.runInContext(source, failed.context);
    await failed.clicks[0]();
    assert.equal(failed.saved.length, 0);
    assert.equal(failed.status.attrs.role, 'alert');
    assert.equal(failed.status.scrolled, true, 'El error debe quedar visible');
    assert.match(failed.status.textContent, options.missingQr ? /herramientas de PDF/ : /Descarga interrumpida/);
    assert.equal(failed.button.disabled, false);
    assert.equal(failed.button.textContent, 'QR PDF');
  }

  const missingScript = fixture();
  vm.runInContext(fallback, missingScript.context);
  missingScript.loaded[0]();
  missingScript.clicks[0]();
  assert.match(missingScript.status.textContent, /actualización completa/);
  assert.equal(missingScript.status.attrs.role, 'alert');
  assert.equal(missingScript.status.scrolled, true);
  console.log('OK: clic, PDF, descarga, restauración del botón y errores visibles de carga/descarga.');
})().catch(error => { console.error(error); process.exitCode = 1; });
