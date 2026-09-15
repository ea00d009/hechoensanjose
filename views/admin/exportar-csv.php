<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • EXPORTACIÓN A CSV
 * ==============================================================================
 */

require_once __DIR__ . '/auth.php';
requireAdmin();

$pdo = getDBConnection();
$tipo = $_GET['tipo'] ?? '';

if ($tipo === 'productores') {
    $filename = "productores_sanjose_" . date('Y-m-d') . ".csv";
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    
    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM para que Excel lea acentos
    
    fputcsv($output, ['ID', 'Nombre', 'Categoría', 'Rubro', 'WhatsApp', 'Teléfono', 'Dirección', 'Horario', 'Activo', 'Destacado', 'Actualizado']);
    
    $stmt = $pdo->query("
        SELECT p.*, c.nombre AS categoria_nombre 
        FROM `ps_productores` p
        LEFT JOIN `ps_categorias` c ON p.categoria_id = c.id
        ORDER BY p.nombre ASC
    ");
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, [
            $row['id'],
            $row['nombre'],
            $row['categoria_nombre'],
            $row['rubro'],
            $row['whatsapp'],
            $row['telefono'],
            $row['direccion'],
            $row['horario'],
            $row['activo'] ? 'Si' : 'No',
            $row['destacado'] ? 'Si' : 'No',
            $row['actualizado_en']
        ]);
    }
    fclose($output);
    exit;

} elseif ($tipo === 'solicitudes') {
    $filename = "solicitudes_inscripcion_" . date('Y-m-d') . ".csv";
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    
    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    fputcsv($output, ['ID', 'Emprendimiento', 'Titular', 'Rubro', 'WhatsApp', 'Email', 'Dirección', 'Interés Catálogo', 'Interés Mapa', 'Interés Góndola', 'Interés Ferias', 'Estado', 'Fecha']);
    
    $stmt = $pdo->query("SELECT * FROM `ps_solicitudes_inscripcion` ORDER BY `creado_en` DESC");
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, [
            $row['id'],
            $row['nombre_emprendimiento'],
            $row['nombre_titular'],
            $row['rubro'],
            $row['whatsapp'],
            $row['email'],
            $row['direccion'],
            $row['interes_catalogo'] ? 'Si' : 'No',
            $row['interes_mapa'] ? 'Si' : 'No',
            $row['interes_gondola'] ? 'Si' : 'No',
            $row['interes_ferias'] ? 'Si' : 'No',
            $row['estado'],
            $row['creado_en']
        ]);
    }
    fclose($output);
    exit;
} else {
    die("Tipo de exportación no válido.");
}
