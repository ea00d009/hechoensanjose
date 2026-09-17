# Actualización: móviles, inscripciones y panel

Esta actualización mantiene las fichas `/mapa/{slug}` y el PDF de los QR. No modifica el esquema de la base de datos ni necesita ejecutar scripts de instalación o migración.

## Subida manual al hosting

1. Guardar una copia de los archivos actuales de la aplicación.
2. Extraer el ZIP de actualización dentro de la carpeta de **Hecho en San José**, conservando las subcarpetas y reemplazando los archivos existentes. Activar la visualización de archivos ocultos para incluir ambos `.htaccess`.
3. El `.htaccess` principal corresponde a la carpeta de esta aplicación. No reemplazar el `.htaccess` de WordPress si WordPress está en otra carpeta.
4. Conservar la configuración de conexión existente (`config/env.php` o `.env`) y las imágenes de los productores. El ZIP no contiene credenciales, SQL ni imágenes.
5. Abrir `/admin/login`, revisar el buscador de productores y una solicitud pendiente. Revisar `/catalogo` y una ficha `/mapa/{slug}` desde un teléfono. Si existe una caché del hosting, vaciarla.

## Cambios

- Fichas del mapa con altura ajustada al espacio disponible, desplazamiento interno y botones de contacto visibles. Se mantiene la apertura directa por slug.
- Encabezado y catálogo más compactos en celulares, filtros accesibles desde la primera categoría y controles táctiles ampliados.
- Inscripciones con validación de formato, longitud, correo y WhatsApp; mensajes de error sin datos internos del servidor.
- Aprobación de solicitudes y asignaciones a góndolas en una transacción. Repetir o enviar dos aprobaciones simultáneas no crea productores duplicados.
- Edición que conserva selecciones y asignaciones a góndolas o productores inactivos.
- Corrección de los buscadores con consultas PDO nativas y de las redirecciones del panel al instalar en una subcarpeta.
- Validación CSRF al iniciar sesión, renovación de sesión y bloqueo HTTP de archivos internos, SQL, instaladores y scripts subidos a la carpeta de imágenes.

## Validación

Pruebas realizadas con Apache, PHP 8.2 y una base MySQL local aislada, tanto en la raíz como en `/hechoensanjose`. Las pruebas crean y eliminan exclusivamente registros temporales en esa base. No se modificaron datos de producción.

- 36 comprobaciones del flujo de inscripción por instalación: 72 en total, incluyendo verificación de la base aislada, rollback y aprobación concurrente.
- Suite HTTP de acceso, CSRF, cierre de sesión, rutas y archivos protegidos en ambas instalaciones.
- Regresión del PDF: cuatro fichas A4 de una página, textos largos, acentos y contactos vacíos.
- Revisión de sintaxis PHP y JavaScript y comprobación visual del mapa y catálogo en tamaños móviles.

Las protecciones de `.htaccess` requieren Apache con permisos para aplicar esas directivas. En otro servidor deben trasladarse a su configuración equivalente.
