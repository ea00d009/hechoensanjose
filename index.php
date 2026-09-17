<?php
/**
 * ==============================================================================
 * FRONT CONTROLLER
 * ==============================================================================
 */

// Los detalles internos se registran en el servidor, sin mostrarlos al visitante.
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

// Forzar codificación UTF-8 para evitar problemas de caracteres en vistas HTML
if (!headers_sent() && strpos($_SERVER['REQUEST_URI'] ?? '', '/api') === false) {
    header('Content-Type: text/html; charset=utf-8');
}

// Cargar configuración base
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Router.php';

// Cargar Controladores
require_once __DIR__ . '/controllers/PublicController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/ApiController.php';

$router = new Router();

// ==========================================
// RUTAS PÚBLICAS (compatibles con y sin .php)
// ==========================================
$router->get('/', [PublicController::class, 'home']);
$router->get('/index.php', [PublicController::class, 'home']);
$router->get('/catalogo', [PublicController::class, 'catalogo']);
$router->get('/catalogo.php', [PublicController::class, 'catalogo']);
$router->get('/gondola', [PublicController::class, 'gondola']);
$router->get('/gondola.php', [PublicController::class, 'gondola']);
$router->get('/mapa', [PublicController::class, 'mapa']);
$router->get('/mapa.php', [PublicController::class, 'mapa']);
$router->get('/mapa/{slug}', [PublicController::class, 'mapa']);
$router->get('/inscribir', [PublicController::class, 'inscribir']);
$router->get('/inscribir.php', [PublicController::class, 'inscribir']);

// ==========================================
// RUTAS API
// ==========================================
$router->get('/api/productores', [ApiController::class, 'getProductores']);
$router->get('/api/productores.php', [ApiController::class, 'getProductores']);
$router->get('/api/gondolas', [ApiController::class, 'getGondolas']);
$router->get('/api/gondolas.php', [ApiController::class, 'getGondolas']);
$router->post('/api/inscribir', [ApiController::class, 'postInscribir']);
$router->post('/api/inscribir.php', [ApiController::class, 'postInscribir']);

// ==========================================
// RUTAS ADMIN
// ==========================================
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/login', [AdminController::class, 'login']);
$router->post('/admin/login', [AdminController::class, 'postLogin']);
$router->get('/admin/login.php', [AdminController::class, 'login']);
$router->post('/admin/login.php', [AdminController::class, 'postLogin']);
$router->get('/admin/logout', [AdminController::class, 'logout']);
$router->get('/admin/logout.php', [AdminController::class, 'logout']);
$router->get('/admin/productores', [AdminController::class, 'productores']);
$router->get('/admin/productores.php', [AdminController::class, 'productores']);
$router->get('/admin/categorias', [AdminController::class, 'categorias']);
$router->get('/admin/categorias.php', [AdminController::class, 'categorias']);
$router->get('/admin/gondolas', [AdminController::class, 'gondolas']);
$router->get('/admin/gondolas.php', [AdminController::class, 'gondolas']);

// Rutas de Solicitudes y Formularios (con y sin .php)
$router->get('/admin/solicitudes', function() { require __DIR__ . '/views/admin/solicitudes.php'; });
$router->get('/admin/solicitudes.php', function() { require __DIR__ . '/views/admin/solicitudes.php'; });
$router->post('/admin/solicitudes', function() { require __DIR__ . '/views/admin/solicitudes.php'; });
$router->post('/admin/solicitudes.php', function() { require __DIR__ . '/views/admin/solicitudes.php'; });

$router->get('/admin/productor-form', function() { require __DIR__ . '/views/admin/productor-form.php'; });
$router->get('/admin/productor-form.php', function() { require __DIR__ . '/views/admin/productor-form.php'; });
$router->post('/admin/productor-form', function() { require __DIR__ . '/views/admin/productor-form.php'; });
$router->post('/admin/productor-form.php', function() { require __DIR__ . '/views/admin/productor-form.php'; });

$router->get('/admin/productor-acciones.php', function() { require __DIR__ . '/views/admin/productor-acciones.php'; });
$router->post('/admin/productor-acciones.php', function() { require __DIR__ . '/views/admin/productor-acciones.php'; });

// Rutas de Góndolas (Formulario y Acciones)
$router->get('/admin/gondola-form', function() { require __DIR__ . '/views/admin/gondola-form.php'; });
$router->get('/admin/gondola-form.php', function() { require __DIR__ . '/views/admin/gondola-form.php'; });
$router->post('/admin/gondola-form', function() { require __DIR__ . '/views/admin/gondola-form.php'; });
$router->post('/admin/gondola-form.php', function() { require __DIR__ . '/views/admin/gondola-form.php'; });

$router->get('/admin/gondola-acciones.php', function() { require __DIR__ . '/views/admin/gondola-acciones.php'; });
$router->post('/admin/gondola-acciones.php', function() { require __DIR__ . '/views/admin/gondola-acciones.php'; });

$router->get('/admin/exportar-csv', function() { require __DIR__ . '/views/admin/exportar-csv.php'; });
$router->get('/admin/exportar-csv.php', function() { require __DIR__ . '/views/admin/exportar-csv.php'; });
$router->get('/admin/manual', function() { require __DIR__ . '/views/admin/manual.php'; });
$router->get('/admin/manual.php', function() { require __DIR__ . '/views/admin/manual.php'; });

// QR: /hechoensanjose/{slug} cuando la aplicación está en esa subcarpeta.
// Las rutas exactas de las secciones conservan prioridad.
$router->get('/{slug}', [PublicController::class, 'fichaProductor']);

// Despachar ruta actual
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = $_SERVER['REQUEST_URI'] ?? '/';
$router->dispatch($method, $uri);
