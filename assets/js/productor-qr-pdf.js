/* Ficha A4 de productor. PDF y QR vectoriales generados sin servicios externos. */
(function (root) {
  'use strict';

  const cleanText = value => String(value ?? '').replace(/[\u0000-\u001f\u007f]/g, ' ').replace(/\s+/g, ' ').trim();

  function fitText(doc, text, width, height, maxSize, minSize, style) {
    doc.setFont('helvetica', style);
    for (let size = maxSize; size >= minSize; size -= 0.5) {
      doc.setFontSize(size);
      const lines = doc.splitTextToSize(text, width);
      const lineHeight = size * 0.352778 * 1.2;
      if (lines.length * lineHeight <= height) return { lines, size, lineHeight };
    }
    throw new Error('Los datos son demasiado extensos para una página. Revisá la ficha del productor.');
  }

  function drawCentered(doc, text, top, width, height, maxSize, minSize, style) {
    const fitted = fitText(doc, text, width, height, maxSize, minSize, style);
    doc.text(fitted.lines, 105, top + fitted.size * 0.352778, { align: 'center', lineHeightFactor: 1.2 });
  }

  function drawContacts(doc, rows) {
    let layout;
    doc.setFont('helvetica', 'normal');
    for (let size = 11; size >= 7; size -= 0.5) {
      doc.setFontSize(size);
      const lineHeight = size * 0.352778 * 1.2;
      const measured = rows.map(row => ({ ...row, lines: doc.splitTextToSize(row.value, 127) }));
      const height = measured.reduce((total, row) => total + row.lines.length * lineHeight + 2, 0);
      if (height <= 48) { layout = { rows: measured, size, lineHeight }; break; }
    }
    if (!layout) throw new Error('Los datos de contacto son demasiado extensos. Revisá la ficha del productor.');
    let y = 234;
    doc.setFontSize(layout.size);
    for (const row of layout.rows) {
      doc.setTextColor(35, 68, 78);
      doc.setFont('helvetica', 'bold');
      doc.text(row.label, 20, y);
      doc.setTextColor(30, 41, 59);
      doc.setFont('helvetica', 'normal');
      doc.text(row.lines, 63, y, { lineHeightFactor: 1.2 });
      if (row.link) doc.link(63, y - layout.size * 0.352778, 127, row.lines.length * layout.lineHeight, { url: row.link });
      y += row.lines.length * layout.lineHeight + 2;
    }
  }

  function createDocument(data) {
    if (!root.jspdf?.jsPDF || typeof root.qrcode !== 'function') {
      throw new Error('No se pudieron cargar las herramientas de PDF. Recargá la página e intentá de nuevo.');
    }
    const name = cleanText(data.nombre);
    if (!name) throw new Error('El productor no tiene nombre. Completá su ficha antes de descargar.');
    const url = new URL(data.url);
    if (url.origin !== 'https://sanjose.tur.ar' || !/^\/hechoensanjose\/[a-z0-9-]+$/.test(url.pathname) || url.search || url.hash) {
      throw new Error('El enlace del productor no es válido. Revisá su nombre antes de descargar.');
    }
    const doc = new root.jspdf.jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4', compress: true });
    doc.setProperties({ title: name + ' - QR y contacto', subject: 'Ficha de productor de Hecho en San José', author: 'Hecho en San José' });
    doc.setFillColor(2, 132, 165);
    doc.rect(0, 0, 210, 5, 'F');
    doc.setTextColor(2, 113, 145);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(15);
    doc.text('HECHO EN SAN JOSÉ', 105, 20, { align: 'center' });
    doc.setFont('helvetica', 'normal');
    doc.setTextColor(71, 85, 105);
    doc.setFontSize(10);
    doc.text('Productores locales | San José, Entre Ríos', 105, 27, { align: 'center' });
    doc.setTextColor(15, 23, 42);
    drawCentered(doc, name, 36, 172, 27, 27, 12, 'bold');
    doc.setTextColor(71, 85, 105);
    drawCentered(doc, cleanText(data.rubro), 66, 168, 12, 12, 7, 'normal');

    // Cuatro módulos blancos alrededor del QR, conservados también al imprimir.
    const qr = root.qrcode(0, 'M');
    qr.addData(url.href, 'Byte');
    qr.make();
    const count = qr.getModuleCount();
    const size = 120;
    const moduleSize = size / (count + 8);
    const left = (210 - size) / 2 + moduleSize * 4;
    const top = 83 + moduleSize * 4;
    doc.setFillColor(0, 0, 0);
    // Agrupar módulos contiguos mantiene bordes nítidos y reduce el tamaño del PDF.
    for (let row = 0; row < count; row++) {
      for (let col = 0; col < count; col++) {
        if (!qr.isDark(row, col)) continue;
        const start = col;
        while (col + 1 < count && qr.isDark(row, col + 1)) col++;
        doc.rect(left + start * moduleSize, top + row * moduleSize, (col - start + 1) * moduleSize, moduleSize, 'F');
      }
    }
    doc.link(45, 83, size, size, { url: url.href });
    doc.setTextColor(15, 23, 42);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(12);
    doc.text('Escaneá para conocer al productor y ver su ubicación', 105, 213, { align: 'center' });
    doc.setDrawColor(203, 213, 225);
    doc.line(20, 221, 190, 221);

    const phone = cleanText(data.telefono);
    const whatsapp = cleanText(data.whatsapp);
    // Si el campo contiene varios teléfonos o notas, conservar el texto sin inventar un enlace.
    const phoneNumber = /^\+?[\d\s().-]+$/.test(phone) ? phone.replace(/[^\d+]/g, '') : '';
    const whatsappNumber = /^\+?[\d\s().-]+$/.test(whatsapp) ? whatsapp.replace(/\D/g, '') : '';
    const rows = [
      { label: 'Dirección', value: cleanText(data.direccion) },
      { label: 'Teléfono', value: phone, link: phoneNumber ? 'tel:' + phoneNumber : null },
      { label: 'WhatsApp', value: whatsapp, link: whatsappNumber ? 'https://wa.me/' + whatsappNumber : null },
      { label: 'Horario', value: cleanText(data.horario) }
    ].filter(row => row.value);
    if (!rows.length) rows.push({ label: 'Contacto', value: 'Consultá la ficha del productor escaneando el QR.' });
    drawContacts(doc, rows);
    doc.setTextColor(100, 116, 139);
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(8);
    doc.text('Municipalidad de San José | Hecho en San José', 105, 288, { align: 'center' });
    return doc;
  }

  async function download(button) {
    const status = root.document.getElementById('qr-pdf-status');
    const originalLabel = button.textContent;
    button.disabled = true;
    button.setAttribute('aria-busy', 'true');
    button.textContent = 'Generando…';
    if (status) {
      status.setAttribute('role', 'status');
      status.textContent = 'Preparando el PDF del productor…';
    }
    try {
      // Permitir que el navegador muestre el estado antes de generar el documento.
      await new Promise(resolve => root.setTimeout(resolve, 0));
      const data = JSON.parse(button.dataset.productorQr);
      const doc = createDocument(data);
      const filename = 'productor-' + String(data.slug || 'san-jose').replace(/[^a-z0-9-]/gi, '-') + '-qr.pdf';
      await doc.save(filename, { returnPromise: true });
      if (status) status.textContent = 'PDF de ' + cleanText(data.nombre) + ' generado. Revisá las descargas del navegador.';
    } catch (error) {
      if (status) {
        status.setAttribute('role', 'alert');
        status.textContent = error.message || 'No se pudo generar el PDF. Intentá nuevamente.';
        status.scrollIntoView({ block: 'nearest' });
      }
    } finally {
      button.disabled = false;
      button.removeAttribute('aria-busy');
      button.textContent = originalLabel;
    }
  }

  root.ProductorQrPdf = { createDocument };
  if (root.document) {
    root.document.querySelectorAll('[data-productor-qr]').forEach(button => {
      button.addEventListener('click', () => download(button));
    });
  }
})(globalThis);
