<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • API PÚBLICA DE PRODUCTORES LOCALES
 * ==============================================================================
 * Devuelve el listado de productores activos en formato JSON para Leaflet.js
 * y el Catálogo digital.
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/db.php';

try {
    $pdo = getDBConnection();

    // Filtros opcionales por categoría o búsqueda si se pasan por query string
    $categoria = $_GET['categoria'] ?? null;
    $soloDestacados = isset($_GET['destacados']) && $_GET['destacados'] === '1';

    $sql = "
        SELECT 
            p.id,
            p.nombre,
            p.rubro,
            p.categoria_id AS categoria,
            COALESCE(p.tag_label, c.tag_label) AS tagLabel,
            COALESCE(p.tag_class, c.tag_class) AS tagClass,
            COALESCE(p.pin_color, c.pin_color) AS pinColor,
            p.imagen,
            COALESCE(p.icono_svg, c.icono_svg) AS iconoSvg,
            p.lat,
            p.lng,
            p.direccion,
            p.telefono,
            p.whatsapp,
            p.horario,
            p.descripcion,
            p.destacado
        FROM `ps_productores` p
        LEFT JOIN `ps_categorias` c ON p.categoria_id = c.id
        WHERE p.activo = 1
    ";

    $params = [];

    if ($categoria && $categoria !== 'todos') {
        $sql .= " AND p.categoria_id = :categoria";
        $params[':categoria'] = $categoria;
    }

    if ($soloDestacados) {
        $sql .= " AND p.destacado = 1";
    }

    $sql .= " ORDER BY p.destacado DESC, p.id ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();

    // Formatear al esquema exacto que Leaflet y app.js consumen
    $productores = [];
    foreach ($rows as $row) {
        $productores[] = [
            'id'          => (int)$row['id'],
            'nombre'      => htmlspecialchars($row['nombre'] ?? '', ENT_QUOTES, 'UTF-8'),
            'rubro'       => htmlspecialchars($row['rubro'] ?? '', ENT_QUOTES, 'UTF-8'),
            'categoria'   => htmlspecialchars($row['categoria'] ?? '', ENT_QUOTES, 'UTF-8'),
            'tagLabel'    => htmlspecialchars($row['tagLabel'] ?? '', ENT_QUOTES, 'UTF-8'),
            'tagClass'    => htmlspecialchars($row['tagClass'] ?? '', ENT_QUOTES, 'UTF-8'),
            'pinColor'    => htmlspecialchars($row['pinColor'] ?? '', ENT_QUOTES, 'UTF-8'),
            'imagen'      => htmlspecialchars($row['imagen'] ?? '', ENT_QUOTES, 'UTF-8'),
            'iconoSvg'    => $row['iconoSvg'], // SVG proviene de tabla categorías (seguro)
            'coords'      => [(float)$row['lat'], (float)$row['lng']],
            'direccion'   => htmlspecialchars($row['direccion'] ?? '', ENT_QUOTES, 'UTF-8'),
            'telefono'    => htmlspecialchars($row['telefono'] ?: '', ENT_QUOTES, 'UTF-8'),
            'whatsapp'    => htmlspecialchars($row['whatsapp'] ?? '', ENT_QUOTES, 'UTF-8'),
            'horario'     => htmlspecialchars($row['horario'] ?: '', ENT_QUOTES, 'UTF-8'),
            'descripcion' => htmlspecialchars($row['descripcion'] ?? '', ENT_QUOTES, 'UTF-8'),
            'destacado'   => (bool)$row['destacado']
        ];
    }

    echo json_encode([
        'success'     => true,
        'total'       => count($productores),
        'productores' => $productores
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Throwable $e) {
    error_log("Error API Productores: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'No se pudo conectar a la base de datos MySQL o hubo un error en la consulta.'
    ], JSON_UNESCAPED_UNICODE);
}
