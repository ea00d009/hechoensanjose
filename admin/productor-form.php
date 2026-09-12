<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • FORMULARIO DE ALTA Y EDICIÓN DE PRODUCTOR (ABM)
 * ==============================================================================
 * Incluye selector interactivo de coordenadas sobre mapa Leaflet de San José
 * y gestor de subida de imágenes.
 */

require_once __DIR__ . '/auth.php';
requireAdmin();

$pdo = getDBConnection();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$fromSolicitudId = isset($_GET['from_solicitud']) ? (int)$_GET['from_solicitud'] : 0;
$isEditing = ($id > 0);

// Cargar categorías disponibles
$categorias = $pdo->query("SELECT * FROM `ps_categorias` ORDER BY `orden` ASC")->fetchAll();

// Valores por defecto
$datos = [
    'nombre'       => '',
    'rubro'        => '',
    'categoria_id' => 'pecan',
    'tag_label'    => '',
    'tag_class'    => '',
    'pin_color'    => '',
    'imagen'       => 'assets/productores/establecimiento-los-pecanes.jpg',
    'lat'          => -32.21230000, // Plaza Urquiza, San José
    'lng'          => -58.21910000,
    'direccion'    => '',
    'telefono'     => '',
    'whatsapp'     => '5493447',
    'horario'      => '',
    'descripcion'  => '',
    'destacado'    => 0,
    'activo'       => 1
];

// Si es edición, cargar datos existentes
if ($isEditing) {
    $stmt = $pdo->prepare("SELECT * FROM `ps_productores` WHERE `id` = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $existente = $stmt->fetch();
    if (!$existente) {
        setFlash('danger', 'El productor solicitado no existe.');
        header('Location: productores.php');
        exit;
    }
    $datos = array_merge($datos, $existente);
} elseif ($fromSolicitudId > 0) {
    // Si proviene de una solicitud pública, pre-cargar datos enviados por el vecino
    $stmtSol = $pdo->prepare("SELECT * FROM `ps_solicitudes_inscripcion` WHERE `id` = :sid LIMIT 1");
    $stmtSol->execute([':sid' => $fromSolicitudId]);
    $sol = $stmtSol->fetch();
    if ($sol) {
        $datos['nombre']      = $sol['nombre_emprendimiento'];
        $datos['rubro']       = $sol['rubro'];
        $datos['whatsapp']    = $sol['whatsapp'];
        $datos['direccion']   = $sol['direccion'];
        $datos['descripcion'] = $sol['descripcion'];
        // Mapear categoría aproximada
        $rubroLower = strtolower($sol['rubro']);
        if (strpos($rubroLower, 'miel') !== false || strpos($rubroLower, 'queso') !== false || strpos($rubroLower, 'dulce') !== false || strpos($rubroLower, 'conserva') !== false) {
            $datos['categoria_id'] = 'alimentos';
        } elseif (strpos($rubroLower, 'vino') !== false || strpos($rubroLower, 'licor') !== false || strpos($rubroLower, 'cerveza') !== false) {
            $datos['categoria_id'] = 'bebidas';
        } elseif (strpos($rubroLower, 'artesania') !== false || strpos($rubroLower, 'cuero') !== false || strpos($rubroLower, 'mineral') !== false || strpos($rubroLower, 'cuchillo') !== false) {
            $datos['categoria_id'] = 'artesania';
        }
    }
}

$errores = [];

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf'] ?? '';
    if (!verifyCsrfToken($csrf)) {
        $errores[] = 'Token de seguridad inválido. Por favor recargá la página.';
    }

    $nombre       = trim($_POST['nombre'] ?? '');
    $rubro        = trim($_POST['rubro'] ?? '');
    $categoria_id = trim($_POST['categoria_id'] ?? '');
    $tag_label    = trim($_POST['tag_label'] ?? '');
    $direccion    = trim($_POST['direccion'] ?? '');
    $telefono     = trim($_POST['telefono'] ?? '');
    $whatsapp     = preg_replace('/[^0-9+]/', '', trim($_POST['whatsapp'] ?? ''));
    $horario      = trim($_POST['horario'] ?? '');
    $descripcion  = trim($_POST['descripcion'] ?? '');
    $lat          = filter_var($_POST['lat'] ?? '', FILTER_VALIDATE_FLOAT);
    $lng          = filter_var($_POST['lng'] ?? '', FILTER_VALIDATE_FLOAT);
    $destacado    = !empty($_POST['destacado']) ? 1 : 0;
    $activo       = !empty($_POST['activo']) ? 1 : 0;

    // Validaciones
    if (empty($nombre)) $errores[] = 'El nombre del emprendimiento es obligatorio.';
    if (empty($rubro)) $errores[] = 'El rubro es obligatorio.';
    if (empty($categoria_id)) $errores[] = 'Debés seleccionar una categoría.';
    if (empty($direccion)) $errores[] = 'La dirección es obligatoria.';
    if (empty($whatsapp)) $errores[] = 'El número de WhatsApp es obligatorio.';
    if (empty($descripcion)) $errores[] = 'La descripción es obligatoria.';
    if ($lat === false || $lng === false) $errores[] = 'Coordenadas geográficas inválidas. Seleccionalas en el mapa.';

    // Manejo de imagen
    $rutaImagen = $datos['imagen'];

    if (isset($_FILES['imagen_archivo']) && $_FILES['imagen_archivo']['error'] === UPLOAD_ERR_OK) {
        $archivo = $_FILES['imagen_archivo'];
        $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $extensionesValidas = ['jpg', 'jpeg', 'png', 'webp'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $archivo['tmp_name']);
        finfo_close($finfo);
        $mimesValidos = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($ext, $extensionesValidas) || !in_array($mime, $mimesValidos)) {
            $errores[] = 'Formato de imagen inválido. Solo se permiten JPG, PNG o WEBP reales.';
        } elseif ($archivo['size'] > 5 * 1024 * 1024) {
            $errores[] = 'La imagen no debe superar los 5MB.';
        } else {
            // Generar nombre de archivo limpio y único
            $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $nombre));
            $nombreArchivo = 'prod-' . trim($slug, '-') . '-' . time() . '.' . $ext;
            $directorioDestino = __DIR__ . '/../assets/productores/';

            if (!is_dir($directorioDestino)) {
                mkdir($directorioDestino, 0755, true);
            }

            $rutaFisica = $directorioDestino . $nombreArchivo;
            if (move_uploaded_file($archivo['tmp_name'], $rutaFisica)) {
                $rutaImagen = 'assets/productores/' . $nombreArchivo;
            } else {
                $errores[] = 'No se pudo guardar la imagen en el servidor.';
            }
        }
    } elseif (!empty($_POST['imagen_url'])) {
        $rutaImagen = trim($_POST['imagen_url']);
    }

    // Si no hay errores, persistir en la base de datos
    if (empty($errores)) {
        try {
            // Buscar datos de estilo por defecto de la categoría
            $catInfoStmt = $pdo->prepare("SELECT * FROM `ps_categorias` WHERE `id` = :cid LIMIT 1");
            $catInfoStmt->execute([':cid' => $categoria_id]);
            $catInfo = $catInfoStmt->fetch();

            $tagClass = $catInfo['tag_class'] ?? 'tag-licores';
            $pinColor = $catInfo['pin_color'] ?? '#0284c7';
            $iconoSvg = $catInfo['icono_svg'] ?? '';

            if ($isEditing) {
                $sql = "
                    UPDATE `ps_productores` SET
                        `nombre`       = :nombre,
                        `rubro`        = :rubro,
                        `categoria_id` = :categoria_id,
                        `tag_label`    = :tag_label,
                        `tag_class`    = :tag_class,
                        `pin_color`    = :pin_color,
                        `imagen`       = :imagen,
                        `icono_svg`    = :icono_svg,
                        `lat`          = :lat,
                        `lng`          = :lng,
                        `direccion`    = :direccion,
                        `telefono`     = :telefono,
                        `whatsapp`     = :whatsapp,
                        `horario`      = :horario,
                        `descripcion`  = :descripcion,
                        `destacado`    = :destacado,
                        `activo`       = :activo
                    WHERE `id` = :id
                ";
                $params = [
                    ':nombre'       => $nombre,
                    ':rubro'        => $rubro,
                    ':categoria_id' => $categoria_id,
                    ':tag_label'    => $tag_label ?: ($catInfo['tag_label'] ?? ''),
                    ':tag_class'    => $tagClass,
                    ':pin_color'    => $pinColor,
                    ':imagen'       => $rutaImagen,
                    ':icono_svg'    => $iconoSvg,
                    ':lat'          => $lat,
                    ':lng'          => $lng,
                    ':direccion'    => $direccion,
                    ':telefono'     => $telefono,
                    ':whatsapp'     => $whatsapp,
                    ':horario'      => $horario,
                    ':descripcion'  => $descripcion,
                    ':destacado'    => $destacado,
                    ':activo'       => $activo,
                    ':id'           => $id
                ];
                $pdo->prepare($sql)->execute($params);
                setFlash('success', '¡Productor "' . htmlspecialchars($nombre) . '" actualizado correctamente!');

            } else {
                $sql = "
                    INSERT INTO `ps_productores` (
                        `nombre`, `rubro`, `categoria_id`, `tag_label`, `tag_class`, `pin_color`,
                        `imagen`, `icono_svg`, `lat`, `lng`, `direccion`, `telefono`,
                        `whatsapp`, `horario`, `descripcion`, `destacado`, `activo`
                    ) VALUES (
                        :nombre, :rubro, :categoria_id, :tag_label, :tag_class, :pin_color,
                        :imagen, :icono_svg, :lat, :lng, :direccion, :telefono,
                        :whatsapp, :horario, :descripcion, :destacado, :activo
                    )
                ";
                $params = [
                    ':nombre'       => $nombre,
                    ':rubro'        => $rubro,
                    ':categoria_id' => $categoria_id,
                    ':tag_label'    => $tag_label ?: ($catInfo['tag_label'] ?? ''),
                    ':tag_class'    => $tagClass,
                    ':pin_color'    => $pinColor,
                    ':imagen'       => $rutaImagen,
                    ':icono_svg'    => $iconoSvg,
                    ':lat'          => $lat,
                    ':lng'          => $lng,
                    ':direccion'    => $direccion,
                    ':telefono'     => $telefono,
                    ':whatsapp'     => $whatsapp,
                    ':horario'      => $horario,
                    ':descripcion'  => $descripcion,
                    ':destacado'    => $destacado,
                    ':activo'       => $activo
                ];
                $pdo->prepare($sql)->execute($params);

                // Si provenía de una solicitud pública, marcarla como aprobada
                if ($fromSolicitudId > 0) {
                    $updSol = $pdo->prepare("UPDATE `ps_solicitudes_inscripcion` SET `estado` = 'aprobada' WHERE `id` = :sid");
                    $updSol->execute([':sid' => $fromSolicitudId]);
                }

                setFlash('success', '¡Productor "' . htmlspecialchars($nombre) . '" dado de alta exitosamente en la plataforma!');
            }

            header('Location: productores.php');
            exit;

        } catch (Throwable $e) {
            error_log("Error ABM Productor: " . $e->getMessage());
            $errores[] = 'Error interno al guardar en la base de datos. Intentá más tarde.';
        }
    } else {
        // En caso de error, retener datos ingresados en el formulario
        $datos = array_merge($datos, $_POST);
        $datos['destacado'] = $destacado;
        $datos['activo'] = $activo;
    }
}

$pageTitle = $isEditing ? 'Editar Productor #' . $id : 'Cargar Nuevo Productor';
require_once __DIR__ . '/header.php';
$csrf = getCsrfToken();
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
  <div>
    <h2 style="font-size: 1.6rem; color: var(--text-main, #0f172a); margin: 0 0 0.35rem 0; font-weight: 800;">
      <?= $isEditing ? 'Modificar Ficha de Productor #' . $id : 'Dar de Alta Nuevo Productor' ?>
    </h2>
    <p style="color: var(--text-muted, #64748b); margin: 0; font-size: 0.9rem;">
      <?= $isEditing ? 'Editá la información, ubicación satelital y fotografías del establecimiento.' : 'Cargá los datos oficiales para integrarlo al mapa, catálogo y góndolas.' ?>
    </p>
  </div>
  <a href="productores.php" class="btn btn-outline" style="padding: 9px 18px; font-size: 0.88rem;">
    &larr; Volver al Listado
  </a>
</div>

<?php if (!empty($errores)): ?>
  <div class="alert-flash danger" style="flex-direction: column; align-items: flex-start;">
    <strong>Por favor corregí los siguientes errores:</strong>
    <ul style="margin: 0.5rem 0 0 1.25rem; padding: 0;">
      <?php foreach ($errores as $err): ?>
        <li><?= htmlspecialchars($err) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="POST" action="productor-form.php<?= $isEditing ? '?id=' . $id : ($fromSolicitudId ? '?from_solicitud=' . $fromSolicitudId : '') ?>" enctype="multipart/form-data" class="card-admin">
  <input type="hidden" name="csrf" value="<?= $csrf ?>">

  <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 2rem;">
    
    <!-- Columna Izquierda: Datos Principales -->
    <div>
      <h3 style="font-size: 1.15rem; color: #0284c7; margin: 0 0 1.25rem 0; border-bottom: 1px solid var(--border-light); padding-bottom: 0.5rem;">
        1. Información General del Emprendimiento
      </h3>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
        <div style="grid-column: 1 / -1;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Nombre del Establecimiento / Marca *</label>
          <input type="text" name="nombre" value="<?= htmlspecialchars($datos['nombre']) ?>" required class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="ej: Licores Bard">
        </div>

        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Categoría Oficial *</label>
          <select name="categoria_id" required class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);">
            <?php foreach ($categorias as $cat): ?>
              <option value="<?= htmlspecialchars($cat['id']) ?>" <?= $datos['categoria_id'] === $cat['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Rubro Productivo *</label>
          <input type="text" name="rubro" value="<?= htmlspecialchars($datos['rubro']) ?>" required class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="ej: Licores Artesanales Tradicionales">
        </div>

        <div style="grid-column: 1 / -1;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Etiqueta Corta / Tag Distintivo (Opcional)</label>
          <input type="text" name="tag_label" value="<?= htmlspecialchars($datos['tag_label']) ?>" class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="ej: Licores desde 1908, Pecán Premiado, etc.">
        </div>
      </div>

      <h3 style="font-size: 1.15rem; color: #0284c7; margin: 1.75rem 0 1.25rem 0; border-bottom: 1px solid var(--border-light); padding-bottom: 0.5rem;">
        2. Canales de Contacto y Atención
      </h3>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">WhatsApp Oficial (para pedidos directos) *</label>
          <input type="text" name="whatsapp" value="<?= htmlspecialchars($datos['whatsapp']) ?>" required class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="ej: 5493447405163">
        </div>

        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Teléfono Visible (opcional)</label>
          <input type="text" name="telefono" value="<?= htmlspecialchars($datos['telefono']) ?>" class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="ej: +54 9 3447 40-5163">
        </div>

        <div style="grid-column: 1 / -1;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Dirección física en San José o Colonias *</label>
          <input type="text" name="direccion" value="<?= htmlspecialchars($datos['direccion']) ?>" required class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="ej: Entre Ríos 1046 (e/ 3 de Febrero y Caseros), San José">
        </div>

        <div style="grid-column: 1 / -1;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Días y Horarios de Atención</label>
          <input type="text" name="horario" value="<?= htmlspecialchars($datos['horario']) ?>" class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="ej: Lun a Sáb: 08:30 a 12:30 y 17:00 a 21:00 hs">
        </div>

        <div style="grid-column: 1 / -1;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Descripción Detallada e Identidad Local *</label>
          <textarea name="descripcion" rows="4" required class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main); resize: vertical;" placeholder="Contanos la historia del productor, qué materias primas utiliza y qué ofrece al turista..."><?= htmlspecialchars($datos['descripcion']) ?></textarea>
        </div>
      </div>

      <!-- Opciones de publicación -->
      <div style="display: flex; gap: 1.5rem; padding: 1rem; border-radius: 8px; background: var(--bg-hover); margin-top: 1rem;">
        <label style="display: flex; align-items: center; gap: 8px; font-size: 0.9rem; font-weight: 700; color: var(--text-main); cursor: pointer;">
          <input type="checkbox" name="activo" value="1" <?= $datos['activo'] ? 'checked' : '' ?> style="width: 18px; height: 18px; accent-color: #0284c7;">
          <span>Visible en Mapa y Catálogo (Activo)</span>
        </label>

        <label style="display: flex; align-items: center; gap: 8px; font-size: 0.9rem; font-weight: 700; color: #d97706; cursor: pointer;">
          <input type="checkbox" name="destacado" value="1" <?= $datos['destacado'] ? 'checked' : '' ?> style="width: 18px; height: 18px; accent-color: #d97706;">
          <span>Establecimiento Destacado ★</span>
        </label>
      </div>

    </div>

    <!-- Columna Derecha: Imagen y Mini-Mapa Selector -->
    <div>
      <h3 style="font-size: 1.15rem; color: #0284c7; margin: 0 0 1.25rem 0; border-bottom: 1px solid var(--border-light); padding-bottom: 0.5rem;">
        3. Fotografía del Establecimiento
      </h3>

      <div style="text-align: center; margin-bottom: 1.5rem; padding: 1rem; border: 1px dashed var(--border-light); border-radius: 12px; background: var(--bg-hover);">
        <img 
          id="preview-img" 
          src="../<?= htmlspecialchars($datos['imagen']) ?>" 
          alt="Vista previa" 
          style="max-width: 100%; height: 160px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 1rem;"
          onerror="this.src='../assets/logo-sanjose.png'"
        >
        <div>
          <label class="btn btn-outline btn-sm" style="cursor: pointer; display: inline-block;">
            <span>Subir nueva imagen (.jpg, .png, .webp)</span>
            <input type="file" name="imagen_archivo" id="imagen_archivo" accept="image/*" style="display: none;" onchange="previewImage(this)">
          </label>
        </div>
        <input type="hidden" name="imagen_url" value="<?= htmlspecialchars($datos['imagen']) ?>">
      </div>

      <h3 style="font-size: 1.15rem; color: #0284c7; margin: 1.75rem 0 0.5rem 0; border-bottom: 1px solid var(--border-light); padding-bottom: 0.5rem;">
        4. Ubicación Satelital (Selector en Mini-Mapa)
      </h3>
      <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0 0 10px 0;">
        Hacé clic o arrastrá el pin rojo sobre el mapa de San José para posicionar el establecimiento con exactitud:
      </p>

      <!-- Contenedor del Mini Mapa Leaflet -->
      <div id="selector-map" style="height: 280px; width: 100%; border-radius: 12px; border: 1px solid var(--border-light); box-shadow: 0 4px 14px rgba(0,0,0,0.06); margin-bottom: 0.75rem; z-index: 1;"></div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
        <div>
          <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px;">Latitud GPS</label>
          <input type="text" id="input-lat" name="lat" value="<?= htmlspecialchars($datos['lat']) ?>" required class="form-control" style="padding: 8px; font-size: 0.85rem; width: 100%; box-sizing: border-box; border-radius: 6px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" onchange="updateMarkerFromInputs()">
        </div>
        <div>
          <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px;">Longitud GPS</label>
          <input type="text" id="input-lng" name="lng" value="<?= htmlspecialchars($datos['lng']) ?>" required class="form-control" style="padding: 8px; font-size: 0.85rem; width: 100%; box-sizing: border-box; border-radius: 6px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" onchange="updateMarkerFromInputs()">
        </div>
      </div>

      <button type="button" class="btn btn-outline btn-sm" onclick="centrarPlaza()" style="width: 100%; margin-bottom: 1.5rem;">
        🎯 Centrar en Plaza Urquiza (Centro de San José)
      </button>

      <div style="border-top: 1px solid var(--border-light); padding-top: 1.5rem; display: flex; gap: 1rem; justify-content: flex-end;">
        <a href="productores.php" class="btn btn-outline" style="padding: 12px 20px;">Cancelar</a>
        <button type="submit" class="btn btn-accent" style="padding: 12px 28px; font-size: 1rem;">
          <?= $isEditing ? 'Guardar Cambios' : 'Registrar Productor' ?> &rarr;
        </button>
      </div>

    </div>

  </div>
</form>

<!-- Scripts de interacción: Mini Mapa y Previsualización de Imagen -->
<script>
  let miniMap = null;
  let selectorMarker = null;

  function previewImage(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('preview-img').src = e.target.result;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function initSelectorMap() {
    const defaultLat = parseFloat(document.getElementById('input-lat').value) || -32.2123;
    const defaultLng = parseFloat(document.getElementById('input-lng').value) || -58.2191;

    miniMap = L.map('selector-map').setView([defaultLat, defaultLng], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(miniMap);

    // Marcador arrastrable
    selectorMarker = L.marker([defaultLat, defaultLng], {
      draggable: true
    }).addTo(miniMap);

    // Evento de arrastre del marcador
    selectorMarker.on('dragend', function(e) {
      const position = selectorMarker.getLatLng();
      updateCoordinates(position.lat, position.lng);
    });

    // Evento de clic sobre cualquier punto del mapa
    miniMap.on('click', function(e) {
      selectorMarker.setLatLng(e.latlng);
      updateCoordinates(e.latlng.lat, e.latlng.lng);
    });
  }

  function updateCoordinates(lat, lng) {
    document.getElementById('input-lat').value = lat.toFixed(7);
    document.getElementById('input-lng').value = lng.toFixed(7);
  }

  function updateMarkerFromInputs() {
    const lat = parseFloat(document.getElementById('input-lat').value);
    const lng = parseFloat(document.getElementById('input-lng').value);
    if (!isNaN(lat) && !isNaN(lng) && selectorMarker && miniMap) {
      selectorMarker.setLatLng([lat, lng]);
      miniMap.panTo([lat, lng]);
    }
  }

  function centrarPlaza() {
    const plaza = [-32.2123, -58.2191];
    if (selectorMarker && miniMap) {
      selectorMarker.setLatLng(plaza);
      miniMap.setView(plaza, 15);
      updateCoordinates(plaza[0], plaza[1]);
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    initSelectorMap();
  });
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
