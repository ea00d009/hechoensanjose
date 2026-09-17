# Corrección del botón QR PDF

El panel publicado mostraba el botón, pero el servidor devolvía HTTP 404 para los tres archivos JavaScript necesarios. El ZIP de esta corrección incluye todos los recursos del generador, además del listado actualizado y las licencias de las bibliotecas.

1. Extraer el contenido dentro de la carpeta `hechoensanjose` del hosting, conservando las rutas. No copiar solamente `productores.php`.
2. Verificar que existan:
   - `views/admin/productores.php`
   - `assets/js/productor-qr-pdf.js`
   - `assets/vendor/jspdf/jspdf.umd.min.js`
   - `assets/vendor/qrcode-generator/qrcode.js`
3. Recargar el listado de productores y pulsar **QR PDF**. Debe descargarse `productor-<nombre>-qr.pdf`.

Esta corrección también resuelve las rutas de los scripts cuando el listado termina en `/`, renueva su versión de caché y muestra un aviso visible si falla la carga o descarga. No requiere cambiar la base de datos ni la configuración del hosting.
