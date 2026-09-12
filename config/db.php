<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • CONFIGURACIÓN Y CONEXIÓN PDO A BASE DE DATOS
 * ==============================================================================
 */

// Si existe archivo .env local, cargarlo para no hardcodear contraseñas
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $val) = explode('=', $line, 2);
            $key = trim($key);
            $val = trim($val, " \t\n\r\0\x0B\"'");
            if (!getenv($key)) {
                putenv("{$key}={$val}");
                $_ENV[$key] = $val;
            }
        }
    }
}

// Parámetros de conexión con valores predeterminados (compatibles con XAMPP / MySQL local)
// Usar directamente $_ENV si putenv está bloqueado en hosting compartido
$host = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
$port = $_ENV['DB_PORT'] ?? getenv('DB_PORT');
$dbname = $_ENV['DB_NAME'] ?? getenv('DB_NAME');
$user = $_ENV['DB_USER'] ?? getenv('DB_USER');
$pass = $_ENV['DB_PASS'] ?? getenv('DB_PASS');

define('DB_HOST', $host ?: '127.0.0.1');
define('DB_PORT', $port ?: '3306');
define('DB_NAME', $dbname ?: 'productores_sanjose');
define('DB_USER', $user ?: 'root');
define('DB_PASS', $pass !== false && $pass !== null ? $pass : '');
define('DB_CHARSET', 'utf8mb4');

/**
 * Obtiene o reutiliza la instancia de conexión PDO a MySQL
 * @return PDO
 * @throws PDOException
 */
function getDBConnection(): PDO {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        // Registrar error en log para depuración
        error_log("Error de conexión a la base de datos: " . $e->getMessage());
        throw $e;
    }
}
