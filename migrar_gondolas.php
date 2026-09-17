<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • SCRIPT DE MIGRACIÓN: TABLA DE GÓNDOLAS
 * ==============================================================================
 * Este script crea únicamente la tabla `ps_gondolas` e inserta los 4 puntos de venta
 * oficiales iniciales si aún no existen.
 * 
 * NO borra ni modifica ninguna tabla existente (productores, categorías, solicitudes, etc.).
 * 
 * INSTRUCCIONES:
 * 1. Subir este archivo a la raíz de tu servidor.
 * 2. Abrirlo en tu navegador (ej: https://tusitio.com/migrar_gondolas.php).
 * 3. Una vez finalizado, eliminar este archivo del servidor por seguridad.
 */

// Habilitar errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/db.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Migración de Base de Datos &bull; Góndolas Hecho en San José</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f8fafc; color: #0f172a; padding: 2rem; margin: 0; }
    .box { max-width: 650px; margin: 2rem auto; background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; }
    h2 { margin-top: 0; color: #0284c7; }
    .success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 1rem; border-radius: 8px; margin: 1rem 0; }
    .error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 1rem; border-radius: 8px; margin: 1rem 0; }
    .btn { display: inline-block; background: #0284c7; color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; margin-top: 1rem; }
    code { background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 0.9em; }
  </style>
</head>
<body>
<div class="box">
  <h2>🛒 Migración: Góndolas Municipales</h2>

<?php
try {
    $pdo = getDBConnection();

    // 1. Crear tabla ps_gondolas si no existe
    $sqlTabla = "CREATE TABLE IF NOT EXISTS `ps_gondolas` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `nombre` VARCHAR(150) NOT NULL,
      `tipo` VARCHAR(100) NOT NULL DEFAULT 'Góndola Oficial',
      `color` VARCHAR(30) NOT NULL DEFAULT 'icon-emerald',
      `icono_svg` TEXT NULL,
      `descripcion` TEXT NOT NULL,
      `direccion` VARCHAR(255) NOT NULL,
      `horario` VARCHAR(150) NULL,
      `telefono` VARCHAR(50) NULL,
      `whatsapp` VARCHAR(50) NULL,
      `productos_destacados` TEXT NULL,
      `lat` DECIMAL(10, 8) NULL,
      `lng` DECIMAL(11, 8) NULL,
      `google_maps_url` VARCHAR(255) NULL,
      `imagen` VARCHAR(255) NULL,
      `destacado` TINYINT(1) DEFAULT 0,
      `activo` TINYINT(1) DEFAULT 1,
      `orden` INT DEFAULT 0,
      `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      `actualizado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      INDEX (`activo`),
      INDEX (`orden`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    // 2. Crear tabla relacional ps_gondola_productores si no existe
    $sqlRel = "CREATE TABLE IF NOT EXISTS `ps_gondola_productores` (
      `gondola_id` INT NOT NULL,
      `productor_id` INT NOT NULL,
      `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`gondola_id`, `productor_id`),
      INDEX (`gondola_id`),
      INDEX (`productor_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($sqlRel);

    // 3. Verificar cantidad de registros en ps_gondolas
    $count = (int)$pdo->query("SELECT COUNT(*) FROM `ps_gondolas`")->fetchColumn();

    if ($count === 0) {
        $insert = "INSERT INTO `ps_gondolas` (`id`, `nombre`, `tipo`, `color`, `icono_svg`, `descripcion`, `direccion`, `horario`, `telefono`, `whatsapp`, `productos_destacados`, `lat`, `lng`, `google_maps_url`, `imagen`, `destacado`, `activo`, `orden`) VALUES
        (1, 'Supermercado y Autoservicio San José', 'Góndola Central', 'icon-emerald', '<svg width=\"26\" height=\"26\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><path d=\"m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z\"/><polyline points=\"9 22 9 12 15 12 15 22\"/></svg>', 'Góndola destacada en el pasillo principal. Amplio surtido en nueces pecán, dulces coloniales, conservas de la colonia y licores artesanales Bard.', 'Mitre y Centenario (Pleno centro)', 'Lun a Sáb: 08:00 a 13:00 y 16:30 a 21:00 hs', NULL, '5493447405163', 'Nueces pecán, dulces coloniales, conservas y licores Bard.', -32.21230000, -58.21910000, 'https://www.google.com/maps/search/?api=1&query=Mitre+y+Centenario+San+Jose+Entre+Rios', NULL, 1, 1, 1),
        (2, 'Centro de Información Turística Oficial', 'Punto Turístico', 'icon-blue', '<svg width=\"26\" height=\"26\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><circle cx=\"12\" cy=\"12\" r=\"10\"/><line x1=\"12\" y1=\"16\" x2=\"12\" y2=\"12\"/><line x1=\"12\" y1=\"8\" x2=\"12.01\" y2=\"8\"/></svg>', 'Góndola institucional con muestras, degustaciones guiadas, folletería del circuito productivo y venta directa de artesanías de la colonia.', 'Centenario y Entre Ríos', 'Todos los días: 08:00 a 20:00 hs (Horario corrido)', '+54 9 3447 43-8000', '5493447438000', 'Degustaciones, folletería, artesanías y recuerdos oficiales.', -32.20860000, -58.22050000, 'https://www.google.com/maps/search/?api=1&query=Centenario+y+Entre+Rios+San+Jose+Entre+Rios', NULL, 1, 1, 2),
        (3, 'Almacén Histórico y Regional Francou', 'Almacén de Campo', 'icon-amber', '<svg width=\"26\" height=\"26\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><path d=\"M12 2v20\"/><path d=\"m17 5-5-3-5 3\"/><path d=\"m17 19-5 3-5-3\"/></svg>', 'Tradicional almacén de ramos generales con góndola dedicada a embutidos artesanales, miel de pradera, quesos de colonia y cuchillería entrerriana.', 'Camino de los Colonos y Los Cedros', 'Mar a Dom: 09:00 a 13:00 y 16:00 a 20:30 hs', NULL, '5493447470220', 'Embutidos artesanales, miel pura, quesos coloniales y cuchillería.', -32.21940000, -58.19210000, 'https://www.google.com/maps/search/?api=1&query=Camino+de+los+Colonos+San+Jose+Entre+Rios', NULL, 0, 1, 3),
        (4, 'Proveeduría Regional Termas San José', 'Complejo Termal', 'icon-accent', '<svg width=\"26\" height=\"26\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><circle cx=\"12\" cy=\"12\" r=\"10\"/><path d=\"M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20\"/><path d=\"M2 12h20\"/></svg>', 'Ubicada en el predio del parque termal. Góndola exclusiva con productos listos para regalar: alfajores de nuez pecán, licores en miniatura y cosmética apícola.', 'Acceso a Termas San José s/n', 'Abierto todos los días de 09:00 a 20:00 hs', NULL, '5493447483344', 'Alfajores artesanales, licores miniatura y cosmética apícola.', -32.20350000, -58.17000000, 'https://www.google.com/maps/search/?api=1&query=Termas+San+Jose+Entre+Rios', NULL, 0, 1, 4);";
        $pdo->exec($insert);
        $count = 4;
        echo "<div class='success'><strong>✅ ¡Tabla creada exitosamente!</strong><br>Se creó la tabla <code>ps_gondolas</code> y se cargaron los 4 puntos de venta oficiales iniciales.</div>";
    } else {
        echo "<div class='success'><strong>ℹ️ La tabla de góndolas ya se encuentra lista.</strong><br>La tabla <code>ps_gondolas</code> ya existe y cuenta con {$count} góndolas registradas.</div>";
    }

    // 4. Sembrar asignaciones iniciales en ps_gondola_productores si está vacía
    $relCount = (int)$pdo->query("SELECT COUNT(*) FROM `ps_gondola_productores`")->fetchColumn();
    if ($relCount === 0) {
        $sampleRels = [
            [1, 1], [1, 2], [1, 3], [1, 6],
            [2, 1], [2, 4], [2, 8], [2, 11],
            [3, 4], [3, 5], [3, 7],
            [4, 1], [4, 2], [4, 5]
        ];
        $insertRelStmt = $pdo->prepare("INSERT IGNORE INTO `ps_gondola_productores` (`gondola_id`, `productor_id`) VALUES (:gid, :pid)");
        foreach ($sampleRels as $rel) {
            $insertRelStmt->execute([':gid' => $rel[0], ':pid' => $rel[1]]);
        }
        echo "<div class='success'><strong>✅ Relaciones iniciales vinculadas:</strong><br>Se asociaron los productores iniciales a las góndolas municipales correspondientes.</div>";
    } else {
        echo "<div class='success'><strong>ℹ️ Padrón de góndolas-productores activo:</strong><br>Existen {$relCount} vinculaciones de productores en góndolas.</div>";
    }

    echo "<p style='color: #b91c1c; font-weight: 600;'>⚠️ Por razones de seguridad, eliminá el archivo <code>migrar_gondolas.php</code> de tu servidor luego de ejecutarlo.</p>";
    echo "<a href='admin/gondolas' class='btn'>Ir al Panel de Góndolas &rarr;</a> ";
    echo "<a href='gondola' class='btn' style='background: #059669;'>Ver Góndolas en la Web &rarr;</a>";

} catch (Throwable $e) {
    echo "<div class='error'><strong>❌ Error en la migración:</strong><br>" . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<p>Verificá que la configuración en <code>config/db.php</code> o <code>config/.env</code> sea correcta.</p>";
}
?>
</div>
</body>
</html>
