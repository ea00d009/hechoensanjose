<?php
require_once __DIR__ . '/config/db.php';
try {
    $pdo = getDBConnection();
    echo "Conexión exitosa a la base de datos.\n";
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tablas encontradas: " . implode(", ", $tables) . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
