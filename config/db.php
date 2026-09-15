<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • CONFIGURACIÓN Y CONEXIÓN PDO A BASE DE DATOS
 * ==============================================================================
 */

// Cargar archivo de credenciales (.env o env.php)
$envFiles = [
    __DIR__ . '/../.env',
    __DIR__ . '/.env'
];

foreach ($envFiles as $envFile) {
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if (strpos($line, '#') === 0) continue; // Ignorar comentarios
            
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $val = trim($parts[1]);
                // Quitar comillas si las hay
                $val = trim($val, '"\'');
                $_ENV[$key] = $val;
            }
        }
    }
}

// Soporte para config/env.php (bypass 403 en cPanel/FTP)
if (file_exists(__DIR__ . '/env.php')) {
    $envPhp = require __DIR__ . '/env.php';
    if (is_array($envPhp)) {
        foreach ($envPhp as $k => $v) {
            $_ENV[$k] = $v;
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
        // En entorno local (localhost / 127.0.0.1), si fallan credenciales de hosting remoto, intentar credenciales locales de desarrollo
        if (DB_HOST === '127.0.0.1' || DB_HOST === 'localhost') {
            $localConfigs = [
                ['user' => 'root', 'pass' => 'root', 'db' => 'productores_sanjose'],
                ['user' => 'root', 'pass' => '',     'db' => 'productores_sanjose']
            ];
            foreach ($localConfigs as $cfg) {
                try {
                    $localDsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . $cfg['db'] . ";charset=" . DB_CHARSET;
                    $pdo = new PDO($localDsn, $cfg['user'], $cfg['pass'], $options);
                    return $pdo;
                } catch (Throwable $eLocal) {
                    continue;
                }
            }
        }
        // Registrar error en log para depuración
        error_log("Error de conexión a la base de datos: " . $e->getMessage());
        throw $e;
    }
}
