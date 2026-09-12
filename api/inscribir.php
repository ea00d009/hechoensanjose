<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • API DE INSCRIPCIÓN PÚBLICA DE PRODUCTORES
 * ==============================================================================
 * Procesa las solicitudes enviadas desde inscribir.php y las almacena
 * en la tabla solicitudes_inscripcion para revisión del Administrador.
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido. Solo POST.']);
    exit;
}

require_once __DIR__ . '/../config/db.php';

// Leer datos enviados (soporta form-data, x-www-form-urlencoded y raw JSON)
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
$data = [];

if (str_contains($contentType, 'application/json')) {
    $rawInput = file_get_contents('php://input');
    $data = json_decode($rawInput, true) ?: [];
} else {
    $data = $_POST;
}

// Sanitización y extracción
$nombreEmprendimiento = trim($data['nombre_emprendimiento'] ?? '');
$nombreTitular        = trim($data['nombre_titular'] ?? '');
$whatsapp             = preg_replace('/[^0-9+]/', '', trim($data['whatsapp'] ?? ''));
$email                = filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL) ?: null;
$rubro                = trim($data['rubro'] ?? '');
$direccion            = trim($data['direccion'] ?? '');
$descripcion          = trim($data['descripcion'] ?? '');

$interesCatalogo      = !empty($data['interes_catalogo']) ? 1 : 0;
$interesMapa          = !empty($data['interes_mapa']) ? 1 : 0;
$interesGondola       = !empty($data['interes_gondola']) ? 1 : 0;
$interesFerias        = !empty($data['interes_ferias']) ? 1 : 0;

// Validaciones requeridas
if (empty($nombreEmprendimiento) || empty($nombreTitular) || empty($whatsapp) || empty($rubro) || empty($direccion) || empty($descripcion)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Por favor completá todos los campos obligatorios marcados con asterisco (*).'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $pdo = getDBConnection();

    $stmt = $pdo->prepare("
        INSERT INTO `ps_solicitudes_inscripcion` (
            `nombre_emprendimiento`,
            `nombre_titular`,
            `whatsapp`,
            `email`,
            `rubro`,
            `direccion`,
            `descripcion`,
            `interes_catalogo`,
            `interes_mapa`,
            `interes_gondola`,
            `interes_ferias`,
            `estado`
        ) VALUES (
            :nombre_emprendimiento,
            :nombre_titular,
            :whatsapp,
            :email,
            :rubro,
            :direccion,
            :descripcion,
            :interes_catalogo,
            :interes_mapa,
            :interes_gondola,
            :interes_ferias,
            'pendiente'
        )
    ");

    $stmt->execute([
        ':nombre_emprendimiento' => $nombreEmprendimiento,
        ':nombre_titular'        => $nombreTitular,
        ':whatsapp'             => $whatsapp,
        ':email'                => $email,
        ':rubro'                => $rubro,
        ':direccion'            => $direccion,
        ':descripcion'          => $descripcion,
        ':interes_catalogo'     => $interesCatalogo,
        ':interes_mapa'         => $interesMapa,
        ':interes_gondola'      => $interesGondola,
        ':interes_ferias'       => $interesFerias,
    ]);

    $idInsertado = $pdo->lastInsertId();

    echo json_encode([
        'success' => true,
        'message' => '¡Solicitud enviada con éxito! Nos comunicaremos a la brevedad.',
        'id'      => (int)$idInsertado
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    error_log("Error API Inscribir: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'Error interno al guardar la solicitud en la base de datos.'
    ], JSON_UNESCAPED_UNICODE);
}
