# Bibliotecas para el PDF de productores

Se sirven desde el propio sitio, con versiones fijas y sin compilación ni Composer:

- [jsPDF 4.2.1](https://github.com/parallax/jsPDF/releases/tag/v4.2.1): `jspdf/jspdf.umd.min.js`, licencia MIT en `jspdf/LICENSE`.
- [qrcode-generator 2.0.4](https://www.npmjs.com/package/qrcode-generator/v/2.0.4): `qrcode-generator/qrcode.js`, licencia MIT en `qrcode-generator/LICENSE`.

Origen de las distribuciones: `https://unpkg.com/jspdf@4.2.1/dist/jspdf.umd.min.js` y `https://unpkg.com/qrcode-generator@2.0.4/dist/qrcode.js`.

Al desplegar, subir estas carpetas junto con `assets/js/productor-qr-pdf.js` y la vista `views/admin/productores.php`. La generación no requiere cambios en la base de datos.
