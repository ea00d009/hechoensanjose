// Ejecutar: node tests/qr-pdf.test.cjs [directorio para PDFs de muestra]
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');

globalThis.jspdf = require('../assets/vendor/jspdf/jspdf.umd.min.js');
globalThis.qrcode = require('../assets/vendor/qrcode-generator/qrcode.js');
require('../assets/js/productor-qr-pdf.js');
const { createDocument } = globalThis.ProductorQrPdf;
const outputDir = process.argv[2];
if (outputDir) fs.mkdirSync(outputDir, { recursive: true });

const base = {
  nombre: 'Viñedos & Bodega Vulliez Sermet',
  rubro: 'Vinos de la región y visitas guiadas',
  direccion: 'Camino de los Colonos 123, San José, Entre Ríos',
  telefono: '+54 (3447) 42-1234',
  whatsapp: '+54 9 3447 123456',
  horario: 'Lunes a sábados de 9:00 a 18:00 hs',
  slug: 'vinedos-y-bodega-vulliez-sermet',
  url: 'https://sanjose.tur.ar/mapa/vinedos-y-bodega-vulliez-sermet'
};

const samples = [
  ['productor-qr', base],
  ['sin-contacto', { ...base, nombre: 'Ñandú Artesanías', direccion: '', telefono: null, whatsapp: '', horario: null, rubro: '' }],
  ['datos-largos', {
    ...base,
    nombre: 'Cooperativa de productores de nuez pecán, miel, conservas y artesanías de la colonia San José y pueblos vecinos de Entre Ríos',
    rubro: 'Elaboración artesanal de alimentos regionales, productos de granja y conservas de estación. Visitas al establecimiento y venta directa de productores de la colonia.',
    direccion: 'Camino de los Colonos, kilómetro 12, establecimiento de la familia Fernández, frente a la antigua escuela rural, acceso por calle vecinal junto al puente, Colonia San José, departamento Colón, provincia de Entre Ríos, Argentina.',
    telefono: '+54 (3447) 42-1234 / +54 (3447) 42-5678',
    horario: 'Lunes a viernes de 08:00 a 13:00 y de 16:00 a 20:00 hs. Sábados de 09:00 a 13:00 hs. Domingos y feriados, visitas con reserva previa.'
  }],
  ['texto-literal', { ...base, nombre: 'Cabaña "El Ñandú" & <San José>', direccion: 'Calle <script>alert(1)</script> 123' }]
];

for (const [filename, data] of samples) {
  const doc = createDocument(data);
  assert.equal(doc.getNumberOfPages(), 1, filename + ': debe ser una sola página');
  assert.ok(Math.abs(doc.internal.pageSize.getWidth() - 210) < 0.1);
  assert.ok(Math.abs(doc.internal.pageSize.getHeight() - 297) < 0.1);
  const bytes = Buffer.from(doc.output('arraybuffer'));
  assert.equal(bytes.subarray(0, 5).toString(), '%PDF-');
  if (filename === 'productor-qr') assert.ok(doc.output().includes('tel:+543447421234'));
  if (filename === 'datos-largos') assert.ok(!doc.output().includes('tel:'));
  if (outputDir) fs.writeFileSync(path.join(outputDir, filename + '.pdf'), bytes);
}

assert.throws(() => createDocument({ ...base, nombre: '' }), /no tiene nombre/);
assert.throws(() => createDocument({ ...base, url: 'javascript:alert(1)' }), /no es válido/);
assert.throws(() => createDocument({ ...base, url: 'https://example.com/mapa/productor' }), /no es válido/);
assert.throws(() => createDocument({ ...base, url: base.url + '?otro=1' }), /no es válido/);
const originalQr = globalThis.qrcode;
delete globalThis.qrcode;
assert.throws(() => createDocument(base), /Recargá la página/);
globalThis.qrcode = originalQr;
console.log('OK: 4 fichas A4 de una página; contactos vacíos, textos largos, acentos y entradas inválidas.');
