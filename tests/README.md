# Pruebas locales

Ejecutar desde la raíz del repositorio. No requieren instalar paquetes de npm o Python.

## Preparar la copia de prueba

Las suites HTTP requieren Apache con PHP, `mod_rewrite` y `AllowOverride All`, PHP con `pdo_mysql`, `mbstring` y `fileinfo`, y MySQL/MariaDB local. Usar **una copia separada del proyecto**, servida exclusivamente en localhost; no utilizar la carpeta de producción ni su base de datos.

1. Crear una base nueva con prefijo `codex_sanjose_qa_`, por ejemplo `codex_sanjose_qa_pruebas`.
2. Importar `sql/database.sql` **sólo en esa base nueva**. El archivo elimina y recrea tablas.
3. Configurar `config/env.php` únicamente en la copia para esa base local. Su usuario de base de datos necesita permisos de lectura/escritura y `CREATE TRIGGER`/`DROP TRIGGER` para probar fallas y concurrencia.
4. Crear un usuario `admin` en `ps_usuarios_admin`, con una contraseña exclusiva de prueba guardada mediante `password_hash($clave, PASSWORD_DEFAULT)` de PHP. El esquema inicial no lo crea. No guardar la contraseña ni el hash en el repositorio.
5. Servir la copia, por ejemplo en `http://127.0.0.1:8766`. Conviene repetir con una instalación en subdirectorio, como `http://127.0.0.1:8767/hechoensanjose`.

Configurar las variables en PowerShell adaptando las rutas:

```powershell
$env:QA_SITE_DIR = 'C:\qa\hechoensanjose'
$env:QA_PHP_BIN = 'C:\xampp\php\php.exe'
$env:QA_BASE_URL = 'http://127.0.0.1:8766'
$env:QA_ADMIN_PASSWORD = Read-Host 'Contraseña del admin exclusivo de prueba'
```

## Inscripción y aprobación

Requiere Python 3.9 o posterior:

```powershell
python tests/registration-http.test.py
python tests/registration-http.test.py 'http://127.0.0.1:8767/hechoensanjose'
```

También admite `--site RUTA` y `--php EJECUTABLE` para reemplazar las variables. La suite comprueba localhost, el prefijo de la base, la conexión real y que la URL consulte esa misma base antes de enviar formularios. Rechaza usar el checkout como copia QA y redirecciones a otros servidores.

Cubre validaciones de API, inscripción, aprobación y publicación, rollback, aprobación simultánea desde dos sesiones, estados, búsquedas y conservación de asignaciones inactivas. Crea registros y triggers temporales con identificadores propios y los limpia al terminar, también ante una aserción fallida. No interrumpir el proceso durante la ejecución; si se interrumpe externamente, recrear la base QA antes de repetir.

## Acceso administrativo y archivos protegidos

Requiere Node.js 20 o posterior y la misma contraseña de prueba:

```powershell
node tests/admin-http.test.cjs $env:QA_BASE_URL
node tests/admin-http.test.cjs 'http://127.0.0.1:8767/hechoensanjose'
```

Cubre redirecciones y alias de acceso, CSRF, renovación de sesión, logout, archivos bloqueados y disponibilidad de recursos públicos. Esta suite valida que la URL sea local; corresponde ejecutarla sólo contra la copia QA preparada arriba. Ejecutar las suites HTTP una después de la otra.

## PDF con QR

No necesita servidor ni base de datos:

```powershell
node tests/qr-pdf.test.cjs
node tests/qr-pdf.test.cjs 'C:\qa\pdfs'
```

Verifica cuatro fichas A4 de una página, textos largos, contactos opcionales y entradas inválidas. El directorio opcional guarda PDFs para revisión visual; revisar también su legibilidad y escanear el QR antes de publicar cambios de diseño.

Al finalizar las pruebas HTTP, quitar la contraseña del entorno:

```powershell
Remove-Item Env:QA_ADMIN_PASSWORD
```
