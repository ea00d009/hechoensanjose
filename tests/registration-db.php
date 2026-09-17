<?php
// Puente CLI de las pruebas: nunca debe aceptar solicitudes web.
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit;
}
$site = realpath($argv[1] ?? getenv('QA_SITE_DIR') ?: '');
if (!$site || !is_file($site . '/config/db.php')) {
    throw new RuntimeException('Indicá el directorio de la copia QA con su configuración de base de datos.');
}
require $site . '/config/db.php';
if (!in_array(DB_HOST, ['127.0.0.1', 'localhost', '::1'], true) || strpos(DB_NAME, 'codex_sanjose_qa_') !== 0) {
    throw new RuntimeException('Las pruebas sólo pueden ejecutarse contra la base aislada.');
}
$pdo = getDBConnection();
// getDBConnection tiene un fallback local: verificar la conexión real antes de escribir.
if ($pdo->query('SELECT DATABASE()')->fetchColumn() !== DB_NAME) {
    throw new RuntimeException('La conexión no corresponde a la base QA configurada.');
}
$args = json_decode(stream_get_contents(STDIN), true);
$stmt = $pdo->prepare($args['sql']);
$stmt->execute($args['params'] ?? []);
echo json_encode(['rows' => $stmt->columnCount() ? $stmt->fetchAll() : [], 'lastId' => $pdo->lastInsertId(), 'affected' => $stmt->rowCount()]);
