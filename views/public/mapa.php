<?php
// Función para generar slugs limpios y legibles
if (!function_exists('generarSlug')) {
    function generarSlug(string $texto): string {
        $texto = mb_strtolower(trim($texto), 'UTF-8');
        $reemplazos = [
            'á'=>'a', 'é'=>'e', 'í'=>'i', 'ó'=>'o', 'ú'=>'u',
            'à'=>'a', 'è'=>'e', 'ì'=>'i', 'ò'=>'o', 'ù'=>'u',
            'ä'=>'a', 'ë'=>'e', 'ï'=>'i', 'ö'=>'o', 'ü'=>'u',
            'ñ'=>'n', 'ç'=>'c', '&' => 'y'
        ];
        $texto = strtr($texto, $reemplazos);
        $texto = preg_replace('/[^a-z0-9]+/i', '-', $texto);
        return trim($texto, '-');
    }
}

// Base URL dinámica para soporte de subcarpetas y URLs limpias /mapa/{slug}
$baseDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$baseUrl = ($baseDir !== '' ? $baseDir : '') . '/';

// Pre-procesar productores para paso directo a JavaScript (renderizado instantáneo de Leaflet)
$jsonProductores = [];
if (!empty($productores)) {
    foreach ($productores as $row) {
        $jsonProductores[] = [
            'id'          => (int)$row['id'],
            'slug'        => generarSlug($row['nombre'] ?? ''),
            'nombre'      => htmlspecialchars($row['nombre'] ?? '', ENT_QUOTES, 'UTF-8'),
            'rubro'       => htmlspecialchars($row['rubro'] ?? '', ENT_QUOTES, 'UTF-8'),
            'categoria'   => htmlspecialchars($row['categoria'] ?? '', ENT_QUOTES, 'UTF-8'),
            'tagLabel'    => htmlspecialchars($row['tagLabel'] ?? '', ENT_QUOTES, 'UTF-8'),
            'tagClass'    => htmlspecialchars($row['tagClass'] ?? '', ENT_QUOTES, 'UTF-8'),
            'pinColor'    => htmlspecialchars($row['pinColor'] ?? '', ENT_QUOTES, 'UTF-8'),
            'imagen'      => htmlspecialchars($row['imagen'] ?? '', ENT_QUOTES, 'UTF-8'),
            'iconoSvg'    => $row['iconoSvg'],
            'coords'      => [(float)$row['lat'], (float)$row['lng']],
            'direccion'   => htmlspecialchars($row['direccion'] ?? '', ENT_QUOTES, 'UTF-8'),
            'telefono'    => htmlspecialchars($row['telefono'] ?: '', ENT_QUOTES, 'UTF-8'),
            'whatsapp'    => htmlspecialchars($row['whatsapp'] ?? '', ENT_QUOTES, 'UTF-8'),
            'horario'     => htmlspecialchars($row['horario'] ?: '', ENT_QUOTES, 'UTF-8'),
            'descripcion' => htmlspecialchars($row['descripcion'] ?? '', ENT_QUOTES, 'UTF-8'),
            'destacado'   => (bool)$row['destacado'],
            'gondolas'    => !empty($row['gondolas_nombres']) ? explode('||', $row['gondolas_nombres']) : []
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <base href="<?= htmlspecialchars($baseUrl) ?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mapa Productivo de la Ciudad de San José - Hecho en San José</title>
  <meta name="description" content="Mapa interactivo georreferenciado de productores y emprendedores locales de la ciudad de San José, Entre Ríos. Integración turística y productiva.">
  
  <!-- Tipografía Google Fonts optimizada -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap">

  <!-- Hoja de Estilos Propia -->
  <link rel="stylesheet" href="style.css?v=<?= filemtime(__DIR__ . '/../../style.css') ?>">
  <link rel="stylesheet" href="assets/css/normalized.css">
  
  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
  
  <!-- Favicon -->
  <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🗺️</text></svg>">
  
  <!-- Script para prevenir parpadeo de modo oscuro (Zero FOUC) -->
  <script>
    (function() {
      try {
        const savedTheme = localStorage.getItem('sanjose-theme');
        if (savedTheme) {
          document.documentElement.setAttribute('data-theme', savedTheme);
        } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
          document.documentElement.setAttribute('data-theme', 'dark');
        }
      } catch (e) {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
          document.documentElement.setAttribute('data-theme', 'dark');
        }
      }
    })();
  </script>
</head>
<body class="map-page-body">

  <!-- Cabecera Superior Institucional -->
  <header class="site-header">
    <div class="header-main s-b4b5776f">
      <div class="logo-group">
        <a href="./" class="btn-back" title="Regresar a Hecho en San José">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
          </svg>
          <span>Inicio</span>
        </a>
        <div class="s-f312428b"></div>
        <a href="./" class="logo-link-wrap" title="Municipalidad de San José, Entre Ríos">
          <img src="assets/logo-sanjose.png" alt="Municipalidad de San José, Entre Ríos" class="municipal-logo s-5a0c6663">
        </a>
        <div class="logo-divider s-77d2eba4"></div>
        <div class="logo-titles">
          <h1 class="s-577ad58c">Hecho en <span>San José</span></h1>
          <div class="logo-subtitle s-606efc58">Mapa Productivo</div>
        </div>
      </div>

      <div class="header-right-group">
        <div class="nav-actions" id="main-nav-actions">
          <!-- Enlaces a subpáginas (sin duplicar Inicio que ya está en el extremo izquierdo) -->
          <div class="s-3e22b634 nav-subpages-links">
            <a href="catalogo" class="btn btn-outline s-9dae10a3">Catálogo</a>
            <a href="gondola" class="btn btn-outline s-9dae10a3">Góndolas</a>
            <a href="inscribir" class="btn btn-outline s-9dae10a3">Inscribirse</a>
          </div>

          <button class="btn btn-outline" onclick="window.resetMapBounds()" class="s-1534828e" title="Restablecer vista a todos los productores">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="22" y1="12" x2="18" y2="12"></line>
              <line x1="6" y1="12" x2="2" y2="12"></line>
              <line x1="12" y1="6" x2="12" y2="2"></line>
              <line x1="12" y1="22" x2="12" y2="18"></line>
            </svg>
            <span>Centrar todo</span>
          </button>
          <a href="https://sanjose.tur.ar/" target="_blank" rel="noopener" class="btn btn-primary s-7d6b206a">
            <span>Portal Turístico</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
              <polyline points="15 3 21 3 21 9"></polyline>
              <line x1="10" y1="14" x2="21" y2="3"></line>
            </svg>
          </a>

          <!-- Redes Sociales Oficiales -->
          <div class="social-links-minimal">
            <a href="https://www.instagram.com/turismosanjose/" target="_blank" rel="noopener" class="social-btn-minimal social-instagram" title="Instagram Oficial @turismosanjose" aria-label="Instagram">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
              </svg>
            </a>
            <a href="http://www.facebook.com/turismosanjose" target="_blank" rel="noopener" class="social-btn-minimal social-facebook" title="Facebook Oficial @turismosanjose" aria-label="Facebook">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
              </svg>
            </a>
          </div>
        </div>

        <div class="header-ctrl-btns">
          <button class="theme-toggle-btn" id="theme-toggle-btn" aria-label="Cambiar entre modo claro y oscuro" title="Cambiar tema">
            <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
            </svg>
            <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="4"></circle>
              <path d="M12 2v2"></path>
              <path d="M12 20v2"></path>
              <path d="m4.93 4.93 1.41 1.41"></path>
              <path d="m17.66 17.66 1.41 1.41"></path>
              <path d="M2 12h2"></path>
              <path d="M20 12h2"></path>
              <path d="m6.34 17.66-1.41 1.41"></path>
              <path d="m19.07 4.93-1.41 1.41"></path>
            </svg>
          </button>

          <button class="mobile-menu-toggle" id="mobile-menu-btn" aria-label="Abrir menú de navegación" aria-expanded="false">
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- Barra de Controles y Filtros por Rubro -->
  <div class="map-control-bar">
    <div class="map-page-title-group">
      <h2>Productores de San José</h2>
    </div>

    <!-- Chips de Filtrado por Rubro -->
    <div class="filter-categories-container" role="group" aria-label="Filtrar por categoría">
      <button class="filter-chip active" data-filter="todos">
        <span>🌱 Todos</span>
      </button>
      <button class="filter-chip" data-filter="pecan">
        <span>🌰 Pecán & Agro</span>
      </button>
      <button class="filter-chip" data-filter="bebidas">
        <span>🍷 Licores, Vinos & Cerveza</span>
      </button>
      <button class="filter-chip" data-filter="alimentos">
        <span>🧀 Miel, Quesos & Dulces</span>
      </button>
      <button class="filter-chip" data-filter="artesania">
        <span>💎 Artesanías & Piedras</span>
      </button>
    </div>

    <!-- Buscador en tiempo real -->
    <div class="search-box-wrap">
      <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
      </svg>
      <input type="search" id="search-producer" class="search-input" aria-label="Buscar productores" placeholder="Buscar por nombre, rubro o calle...">
    </div>
  </div>

  <!-- Conmutador de Pestañas para Móvil -->
  <div class="map-mobile-tabs" id="map-mobile-tabs">
    <button class="map-tab-btn active" id="tab-btn-map" aria-pressed="true" onclick="switchMapTab('map')">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"></polygon>
        <line x1="9" y1="3" x2="9" y2="18"></line>
        <line x1="15" y1="6" x2="15" y2="21"></line>
      </svg>
      <span>Ver Mapa</span>
    </button>
    <button class="map-tab-btn" id="tab-btn-list" aria-pressed="false" onclick="switchMapTab('list')">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="8" y1="6" x2="21" y2="6"></line>
        <line x1="8" y1="12" x2="21" y2="12"></line>
        <line x1="8" y1="18" x2="21" y2="18"></line>
        <line x1="3" y1="6" x2="3.01" y2="6"></line>
        <line x1="3" y1="12" x2="3.01" y2="12"></line>
        <line x1="3" y1="18" x2="3.01" y2="18"></line>
      </svg>
      <span>Ver Lista (<span id="tab-counter">5</span>)</span>
    </button>
  </div>

  <!-- Layout de Doble Panel: Lista + Mapa Leaflet -->
  <div class="map-app-layout layout-show-map">
    
    <!-- Sidebar de Productores -->
    <aside class="producers-sidebar">
      <div class="sidebar-header">
        <h3>Circuito Productivo</h3>
        <span class="counter-badge" id="producers-counter">5 productores</span>
      </div>
      
      <!-- Contenedor dinámico de tarjetas -->
      <div class="producers-list-scroll" id="producers-list">
        <!-- Renderizado dinámicamente por app.js -->
      </div>

      <!-- Pie discreto de la barra lateral con acceso administrativo -->
      <div class="sidebar-admin-footer s-8b308977">
        <span class="s-b32654dc">&copy; 2026 San José</span>
        <div class="s-3e22b634">
          <a href="admin/login" class="btn-admin-access" title="Acceso al Panel de Gestión" class="s-6e78680b">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>
            </svg>
            <span>Panel de Gestión</span>
          </a>
        </div>
      </div>
    </aside>

    <!-- Lienzo del Mapa Leaflet -->
    <main class="map-canvas-container">
      <div id="map"></div>
    </main>

  </div>

  <!-- Pre-carga de datos para Leaflet instantáneo -->
  <script>
    window.INITIAL_PRODUCTORES = <?= json_encode($jsonProductores, JSON_UNESCAPED_UNICODE) ?>;
    window.TARGET_PRODUCER_PARAM = <?= json_encode($targetParam ?? null, JSON_UNESCAPED_UNICODE) ?>;
  </script>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  
  <!-- Lógica de la Aplicación -->
  <script src="app.js?v=<?= filemtime(__DIR__ . '/../../app.js') ?>"></script>
</body>
</html>
