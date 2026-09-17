<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • FORMULARIO DE ALTA Y EDICIÓN DE GÓNDOLAS MUNICIPALES
 * ==============================================================================
 * Incluye selector interactivo de coordenadas sobre mapa Leaflet de San José.
 */

require_once __DIR__ . '/auth.php';
requireAdmin();

require_once __DIR__ . '/../../models/GondolaRepository.php';
require_once __DIR__ . '/../../models/ProductorRepository.php';

$repo = new GondolaRepository();
$prodRepo = new ProductorRepository();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEditing = ($id > 0);

$todosProductores = $prodRepo->getActivos();
$productoresAsignados = [];
if ($isEditing) {
    $productoresAsignados = $repo->getProductorIdsForGondola($id);
}

// Valores por defecto
$datos = [
    'nombre'               => '',
    'tipo'                 => 'Góndola Central',
    'color'                => 'icon-emerald',
    'icono_svg'            => '',
    'descripcion'          => '',
    'direccion'            => '',
    'horario'              => '',
    'telefono'             => '',
    'whatsapp'             => '',
    'productos_destacados' => '',
    'lat'                  => -32.21230000, // Plaza Urquiza, San José
    'lng'                  => -58.21910000,
    'google_maps_url'      => '',
    'imagen'               => '',
    'destacado'            => 0,
    'activo'               => 1,
    'orden'                => 1
];

// Si es edición, cargar datos existentes
if ($isEditing) {
    $existente = $repo->getById($id);
    if (!$existente) {
        setFlash('danger', 'La góndola solicitada no existe.');
        header('Location: gondolas.php');
        exit;
    }
    $datos = array_merge($datos, $existente);
}

$errores = [];

// Procesar formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf'] ?? '';
    if (!verifyCsrfToken($csrf)) {
        $errores[] = 'Token de seguridad inválido o expirado. Por favor recargá la página.';
    }

    $nombre              = trim($_POST['nombre'] ?? '');
    $tipo                = trim($_POST['tipo'] ?? 'Góndola Oficial');
    $color               = trim($_POST['color'] ?? 'icon-emerald');
    $descripcion         = trim($_POST['descripcion'] ?? '');
    $direccion           = trim($_POST['direccion'] ?? '');
    $horario             = trim($_POST['horario'] ?? '');
    $telefono            = trim($_POST['telefono'] ?? '');
    $whatsapp            = preg_replace('/[^0-9+]/', '', trim($_POST['whatsapp'] ?? ''));
    $productosDestacados = trim($_POST['productos_destacados'] ?? '');
    $googleMapsUrl       = trim($_POST['google_maps_url'] ?? '');
    $latVal              = trim($_POST['lat'] ?? '');
    $lngVal              = trim($_POST['lng'] ?? '');
    $lat                 = ($latVal !== '') ? filter_var($latVal, FILTER_VALIDATE_FLOAT) : null;
    $lng                 = ($lngVal !== '') ? filter_var($lngVal, FILTER_VALIDATE_FLOAT) : null;
    $destacado           = !empty($_POST['destacado']) ? 1 : 0;
    $activo              = !empty($_POST['activo']) ? 1 : 0;
    $orden               = (int)($_POST['orden'] ?? 0);

    // Validaciones
    if (empty($nombre)) $errores[] = 'El nombre del comercio o establecimiento es obligatorio.';
    if (empty($direccion)) $errores[] = 'La dirección física del comercio es obligatoria.';
    if (empty($descripcion)) $errores[] = 'La descripción de la góndola o exhibidor es obligatoria.';

    // Generar enlace a Google Maps automático si no se proporcionó y hay coordenadas
    if (empty($googleMapsUrl) && $lat !== null && $lng !== null) {
        $googleMapsUrl = "https://www.google.com/maps/search/?api=1&query=" . urlencode("{$direccion} San Jose Entre Rios");
    }

    // Actualizar datos en memoria para rellenar formulario en caso de error
    $datos['nombre']               = $nombre;
    $datos['tipo']                 = $tipo;
    $datos['color']                = $color;
    $datos['descripcion']          = $descripcion;
    $datos['direccion']            = $direccion;
    $datos['horario']              = $horario;
    $datos['telefono']             = $telefono;
    $datos['whatsapp']             = $whatsapp;
    $datos['productos_destacados'] = $productosDestacados;
    $datos['lat']                  = $lat;
    $datos['lng']                  = $lng;
    $datos['google_maps_url']      = $googleMapsUrl;
    $datos['destacado']            = $destacado;
    $datos['activo']               = $activo;
    $datos['orden']                = $orden;

    if (empty($errores)) {
        try {
            if ($isEditing) {
                $repo->update($id, $datos);
                $targetGondolaId = $id;
                setFlash('success', '¡La góndola en «' . htmlspecialchars($nombre) . '» fue actualizada correctamente!');
            } else {
                $targetGondolaId = $repo->create($datos);
                setFlash('success', '¡Nueva góndola en «' . htmlspecialchars($nombre) . '» registrada con éxito!');
            }

            // Sincronizar productores asignados
            $productoresPost = isset($_POST['productores']) && is_array($_POST['productores']) ? $_POST['productores'] : [];
            $repo->syncProductoresForGondola($targetGondolaId, $productoresPost);

            header('Location: gondolas.php');
            exit;
        } catch (Throwable $e) {
            error_log("Error al guardar góndola: " . $e->getMessage());
            $errores[] = 'Error de base de datos al procesar la solicitud: ' . $e->getMessage();
        }
    }
}

$csrf = getCsrfToken();
$pageTitle = $isEditing ? 'Editar Góndola #' . $id : 'Nueva Góndola Oficial';
require_once __DIR__ . '/header.php';
?>

  <!-- Cabecera del Formulario -->
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
      <div style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem; color: #0284c7; margin-bottom: 0.25rem;">
        <a href="gondolas.php" style="color: inherit; text-decoration: none;">&larr; Volver al Padrón de Góndolas</a>
      </div>
      <h2 style="font-size: 1.6rem; color: var(--text-main, #0f172a); margin: 0 0 0.35rem 0; font-weight: 800;">
        <?= $isEditing ? 'Modificar Góndola: ' . htmlspecialchars($datos['nombre']) : 'Registrar Nueva Góndola Oficial' ?>
      </h2>
      <p style="color: var(--text-muted, #64748b); margin: 0; font-size: 0.9rem;">
        Completá los datos del comercio adherido y seleccioná su ubicación satelital en el mapa.
      </p>
    </div>
  </div>

  <?php if (!empty($errores)): ?>
    <div class="alert-flash danger" style="flex-direction: column; align-items: flex-start; margin-bottom: 1.5rem;">
      <strong>Por favor corregí los siguientes inconvenientes:</strong>
      <ul style="margin: 0.5rem 0 0 1.25rem; padding: 0;">
        <?php foreach ($errores as $err): ?>
          <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" action="gondola-form.php<?= $isEditing ? '?id=' . $id : '' ?>" class="card-admin" style="padding: 1.75rem;">
    <input type="hidden" name="csrf" value="<?= $csrf ?>">

    <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 2rem;">
      
      <!-- Columna Izquierda: Información del Comercio y Exhibidor -->
      <div>
        <h3 style="font-size: 1.15rem; color: #0284c7; margin: 0 0 1.25rem 0; border-bottom: 1px solid var(--border-light); padding-bottom: 0.5rem;">
          1. Datos del Comercio y Exhibidor
        </h3>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
          <div style="grid-column: 1 / -1;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Nombre del Comercio o Establecimiento *</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($datos['nombre']) ?>" required class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="ej: Supermercado San José, Proveeduría Termas, etc.">
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Tipo / Distintivo *</label>
            <input type="text" name="tipo" value="<?= htmlspecialchars($datos['tipo']) ?>" required list="tipos-sugeridos" class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="ej: Góndola Central, Punto Turístico...">
            <datalist id="tipos-sugeridos">
              <option value="Góndola Central">
              <option value="Punto Turístico">
              <option value="Almacén de Campo">
              <option value="Complejo Termal">
              <option value="Comercio Adherido">
              <option value="Regional Céntrico">
            </datalist>
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Color / Estilo Visual *</label>
            <select name="color" class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);">
              <option value="icon-emerald" <?= $datos['color'] === 'icon-emerald' ? 'selected' : '' ?>>Verde Esmeralda (Principal / Agroecología)</option>
              <option value="icon-blue" <?= $datos['color'] === 'icon-blue' ? 'selected' : '' ?>>Azul Institucional (Turismo & Servicios)</option>
              <option value="icon-amber" <?= $datos['color'] === 'icon-amber' ? 'selected' : '' ?>>Ámbar Colonial (Almacenes & Sabores)</option>
              <option value="icon-accent" <?= $datos['color'] === 'icon-accent' ? 'selected' : '' ?>>Rojo / Acento (Complejos & Artesanías)</option>
            </select>
          </div>

          <div style="grid-column: 1 / -1;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Descripción del Exhibidor y Ubicación en Local *</label>
            <textarea name="descripcion" rows="3" required class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main); resize: vertical;" placeholder="ej: Góndola destacada en el pasillo principal. Amplio surtido en nueces pecán, dulces coloniales y licores artesanales..."><?= htmlspecialchars($datos['descripcion']) ?></textarea>
          </div>

          <div style="grid-column: 1 / -1;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Productos Destacados en esta Góndola</label>
            <input type="text" name="productos_destacados" value="<?= htmlspecialchars($datos['productos_destacados']) ?>" class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="ej: Miel pura, nueces pecán, dulces caseros, vinos varietales y licores Bard">
          </div>
        </div>

        <h3 style="font-size: 1.15rem; color: #0284c7; margin: 1.75rem 0 1.25rem 0; border-bottom: 1px solid var(--border-light); padding-bottom: 0.5rem;">
          2. Canales de Contacto y Atención
        </h3>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
          <div style="grid-column: 1 / -1;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Dirección física en San José *</label>
            <input type="text" name="direccion" id="input-direccion" value="<?= htmlspecialchars($datos['direccion']) ?>" required class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="ej: Mitre y Centenario (Pleno centro)">
          </div>

          <div style="grid-column: 1 / -1;">
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Días y Horarios de Atención al Público</label>
            <input type="text" name="horario" value="<?= htmlspecialchars($datos['horario']) ?>" class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="ej: Lun a Sáb: 08:00 a 13:00 y 16:30 a 21:00 hs">
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">WhatsApp de Contacto (opcional)</label>
            <input type="text" name="whatsapp" value="<?= htmlspecialchars($datos['whatsapp']) ?>" class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="ej: 5493447405163">
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">Teléfono Visible (opcional)</label>
            <input type="text" name="telefono" value="<?= htmlspecialchars($datos['telefono']) ?>" class="form-control" style="padding: 10px; width: 100%; box-sizing: border-box; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="ej: +54 9 3447 43-8000">
          </div>
        </div>

        <!-- Opciones de visibilidad y orden -->
        <div style="display: flex; gap: 1.5rem; padding: 1rem; border-radius: 8px; background: var(--bg-hover); margin-top: 1rem; flex-wrap: wrap; align-items: center;">
          <label style="display: flex; align-items: center; gap: 8px; font-size: 0.9rem; font-weight: 700; color: var(--text-main); cursor: pointer;">
            <input type="checkbox" name="activo" value="1" <?= $datos['activo'] ? 'checked' : '' ?> style="width: 18px; height: 18px; accent-color: #059669;">
            <span>Góndola Habilitada (Visible en Portal)</span>
          </label>

          <label style="display: flex; align-items: center; gap: 8px; font-size: 0.9rem; font-weight: 700; color: #d97706; cursor: pointer;">
            <input type="checkbox" name="destacado" value="1" <?= $datos['destacado'] ? 'checked' : '' ?> style="width: 18px; height: 18px; accent-color: #d97706;">
            <span>Punto Destacado ★</span>
          </label>

          <div style="display: flex; align-items: center; gap: 8px; margin-left: auto;">
            <label style="font-size: 0.85rem; font-weight: 700; color: var(--text-main);">Prioridad / Orden:</label>
            <input type="number" name="orden" value="<?= (int)$datos['orden'] ?>" min="0" style="width: 70px; padding: 6px 8px; border-radius: 6px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main); text-align: center;">
          </div>
        </div>

      </div>

      <!-- Columna Derecha: Selector Satelital en Mini-Mapa -->
      <div>
        <h3 style="font-size: 1.15rem; color: #0284c7; margin: 0 0 0.5rem 0; border-bottom: 1px solid var(--border-light); padding-bottom: 0.5rem;">
          3. Ubicación Satelital & GPS
        </h3>
        <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0 0 10px 0;">
          Arrastrá el pin sobre el mapa para ubicar el comercio y generar el enlace de llegada con GPS:
        </p>

        <!-- Contenedor del Mini Mapa Leaflet -->
        <div id="gondola-map" style="height: 290px; width: 100%; border-radius: 12px; border: 1px solid var(--border-light); box-shadow: 0 4px 14px rgba(0,0,0,0.06); margin-bottom: 0.75rem; z-index: 1;"></div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 0.75rem;">
          <div>
            <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px;">Latitud GPS</label>
            <input type="text" id="input-lat" name="lat" value="<?= htmlspecialchars($datos['lat']) ?>" class="form-control" style="padding: 8px; font-size: 0.85rem; width: 100%; box-sizing: border-box; border-radius: 6px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" onchange="updateMarkerFromInputs()">
          </div>
          <div>
            <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px;">Longitud GPS</label>
            <input type="text" id="input-lng" name="lng" value="<?= htmlspecialchars($datos['lng']) ?>" class="form-control" style="padding: 8px; font-size: 0.85rem; width: 100%; box-sizing: border-box; border-radius: 6px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" onchange="updateMarkerFromInputs()">
          </div>
        </div>

        <div style="margin-bottom: 1.25rem;">
          <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px;">Enlace Directo a Google Maps (GPS)</label>
          <input type="url" id="input-gmaps" name="google_maps_url" value="<?= htmlspecialchars($datos['google_maps_url']) ?>" class="form-control" style="padding: 8px; font-size: 0.82rem; width: 100%; box-sizing: border-box; border-radius: 6px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main);" placeholder="https://www.google.com/maps/search/?api=1&query=...">
        </div>

        <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
          <button type="button" class="btn btn-outline btn-sm" onclick="setPresetCoords(-32.2123, -58.2191, 'Mitre y Centenario (Plaza Urquiza)')" style="flex: 1; font-size: 0.76rem;">
            📍 Plaza Urquiza
          </button>
          <button type="button" class="btn btn-outline btn-sm" onclick="setPresetCoords(-32.2086, -58.2205, 'Centenario y Entre Ríos (Turismo)')" style="flex: 1; font-size: 0.76rem;">
            ℹ️ Centro Turístico
          </button>
          <button type="button" class="btn btn-outline btn-sm" onclick="setPresetCoords(-32.2035, -58.1700, 'Termas San José')" style="flex: 1; font-size: 0.76rem;">
            ♨️ Complejo Termas
          </button>
        </div>

        <!-- Productores Asignados a la Góndola -->
        <h3 style="font-size: 1.15rem; color: #0284c7; margin: 1.75rem 0 0.5rem 0; border-bottom: 1px solid var(--border-light); padding-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;">
          <span>👨‍🌾 Productores Oficiales en esta Góndola</span>
        </h3>
        <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0 0 10px 0;">
          Seleccioná qué productores del padrón municipal tienen sus productos en exhibición en este punto de venta:
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 8px; background: var(--bg-hover); padding: 12px; border-radius: 10px; border: 1px solid var(--border-light); margin-bottom: 1.5rem; max-height: 260px; overflow-y: auto;">
          <?php if (empty($todosProductores)): ?>
            <div style="font-size: 0.85rem; color: var(--text-muted);">No hay productores registrados en el padrón.</div>
          <?php else: ?>
            <?php foreach ($todosProductores as $tp): ?>
              <label style="display: flex; align-items: flex-start; gap: 8px; font-size: 0.85rem; cursor: pointer; padding: 6px 8px; border-radius: 6px; background: var(--bg-card); border: 1px solid var(--border-light);">
                <input type="checkbox" name="productores[]" value="<?= (int)$tp['id'] ?>" <?= in_array((int)$tp['id'], $productoresAsignados) ? 'checked' : '' ?> style="margin-top: 3px; cursor: pointer; width: 15px; height: 15px;">
                <div>
                  <strong style="color: var(--text-main); font-size: 0.86rem;"><?= htmlspecialchars($tp['nombre']) ?></strong>
                  <div style="font-size: 0.74rem; color: var(--text-muted); margin-top: 2px;"><?= htmlspecialchars($tp['rubro']) ?></div>
                </div>
              </label>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div style="border-top: 1px solid var(--border-light); padding-top: 1.5rem; display: flex; gap: 1rem; justify-content: flex-end;">
          <a href="gondolas.php" class="btn btn-outline" style="padding: 12px 20px;">Cancelar</a>
          <button type="submit" class="btn btn-accent" style="padding: 12px 28px; font-size: 1rem;">
            <?= $isEditing ? 'Guardar Cambios' : 'Registrar Góndola' ?> &rarr;
          </button>
        </div>

      </div>

    </div>
  </form>

  <!-- Script del Mapa Leaflet para Selección de Ubicación -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const initialLat = parseFloat(document.getElementById('input-lat').value) || -32.2123;
      const initialLng = parseFloat(document.getElementById('input-lng').value) || -58.2191;

      const map = L.map('gondola-map').setView([initialLat, initialLng], 14);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
      }).addTo(map);

      const marker = L.marker([initialLat, initialLng], {
        draggable: true
      }).addTo(map);

      marker.on('dragend', function(e) {
        const coord = e.target.getLatLng();
        updateCoords(coord.lat, coord.lng);
      });

      map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateCoords(e.latlng.lat, e.latlng.lng);
      });

      function updateCoords(lat, lng) {
        document.getElementById('input-lat').value = lat.toFixed(8);
        document.getElementById('input-lng').value = lng.toFixed(8);

        const gmapsInput = document.getElementById('input-gmaps');
        if (!gmapsInput.value || gmapsInput.value.includes('google.com/maps')) {
          const dir = document.getElementById('input-direccion').value.trim();
          if (dir) {
            gmapsInput.value = 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(dir + ' San Jose Entre Rios');
          } else {
            gmapsInput.value = 'https://www.google.com/maps/search/?api=1&query=' + lat.toFixed(6) + ',' + lng.toFixed(6);
          }
        }
      }

      window.updateMarkerFromInputs = function() {
        const lat = parseFloat(document.getElementById('input-lat').value);
        const lng = parseFloat(document.getElementById('input-lng').value);
        if (!isNaN(lat) && !isNaN(lng)) {
          marker.setLatLng([lat, lng]);
          map.panTo([lat, lng]);
        }
      };

      window.setPresetCoords = function(lat, lng, label) {
        document.getElementById('input-lat').value = lat.toFixed(8);
        document.getElementById('input-lng').value = lng.toFixed(8);
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], 15);
        
        const gmapsInput = document.getElementById('input-gmaps');
        const dirInput = document.getElementById('input-direccion');
        if (!dirInput.value) {
          dirInput.value = label;
        }
        gmapsInput.value = 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(label + ' San Jose Entre Rios');
      };

      setTimeout(function() {
        map.invalidateSize();
      }, 300);
    });
  </script>

<?php require_once __DIR__ . '/footer.php'; ?>
