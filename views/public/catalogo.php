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

// Base URL dinámica para soporte de subcarpetas y URLs limpias
$baseDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$baseUrl = ($baseDir !== '' ? $baseDir : '') . '/';

// Pre-procesar productores para paso directo a JavaScript (carga instantánea sin latencia)
$totalProds = !empty($productores) ? count($productores) : 0;
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
  <meta charset="UTF-8">
  <base href="<?= htmlspecialchars($baseUrl) ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catálogo de Negocios - Hecho en San José &bull; Turismo Oficial</title>
  <meta name="description" content="Explorá el catálogo oficial de productores, emprendedores y artesanos de la ciudad de San José, Entre Ríos. Nuez pecán, licores centenarios, miel y creaciones con identidad local.">
  
  <!-- Tipografía Google Fonts optimizada -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap">

  <link rel="stylesheet" href="style.css?v=<?= filemtime(__DIR__ . '/../../style.css') ?>">
  <link rel="stylesheet" href="assets/css/normalized.css?v=<?= filemtime(__DIR__ . '/../../assets/css/normalized.css') ?>">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛍️</text></svg>">
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
<body class="catalogo-page">

  <!-- Barra Superior Institucional -->
  <header class="site-header">

    <!-- Navegación Principal -->
    <div class="header-main">
      <div class="logo-group">
        <a href="./" class="logo-link-wrap" title="Municipalidad de San José, Entre Ríos">
          <img src="assets/logo-sanjose.png" alt="Municipalidad de San José, Entre Ríos" class="municipal-logo">
        </a>
        <div class="logo-divider"></div>
        <div class="logo-titles">
          <h1>Hecho en <span>San José</span></h1>
          <div class="logo-subtitle">Secretaría de Educación, Cultura y Turismo</div>
        </div>
      </div>

      <div class="header-right-group">
        <nav class="nav-actions" id="main-nav-actions">
          <!-- Enlaces a otros módulos -->
          <div class="nav-subpages-links flex-center-gap-8px">
            <a href="./" class="btn btn-outline btn-nav-sub">Inicio</a>
            <a href="gondola" class="btn btn-outline btn-nav-sub">Góndolas</a>
            <a href="inscribir" class="btn btn-outline btn-nav-sub">Inscribirse</a>
            <a href="mapa" class="btn btn-accent btn-nav-map">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"></polygon>
                <line x1="9" y1="3" x2="9" y2="18"></line>
                <line x1="15" y1="6" x2="15" y2="21"></line>
              </svg>
              <span>Ver Mapa</span>
            </a>
          </div>

          <!-- Redes Sociales Oficiales -->
          <div class="social-links-minimal">
            <a href="https://www.instagram.com/turismosanjose/" target="_blank" rel="noopener" class="social-btn-minimal social-instagram" title="Instagram Oficial @turismosanjose" aria-label="Instagram">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
              </svg>
            </a>
            <a href="http://www.facebook.com/turismosanjose" target="_blank" rel="noopener" class="social-btn-minimal social-facebook" title="Facebook Oficial @turismosanjose" aria-label="Facebook">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
              </svg>
            </a>
          </div>
        </nav>

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

  <!-- Hero del Catálogo -->
  <section class="hero-section hero-section-custom">
    <div class="hero-container hero-container-custom">
      <div class="hero-inner-custom">
        <div class="hero-badge-initiative">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
            <path d="M3 6h18"></path>
            <path d="M16 10a4 4 0 0 1-8 0"></path>
          </svg>
          <span>Producción Local con Identidad de Origen</span>
        </div>
        <h1 class="page-hero-title">
          Catálogo Oficial de <span class="highlight">Negocios y Productores</span>
        </h1>
        <p class="page-hero-desc">
          Descubrí los emprendimientos registrados de San José. Productos artesanales, agroecología, sabores centenarios y creaciones únicas que impulsan el desarrollo de nuestra comunidad.
        </p>

        <!-- Barra de Búsqueda y Filtros en el Catálogo -->
        <div class="hero-search-wrapper">
          <div class="hero-search-inner">
            <svg class="search-icon-svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="search" id="catalogo-search" aria-label="Buscar en el catálogo" placeholder="Buscar por producto, negocio o ingrediente..." class="search-input search-input-custom">
          </div>

          <!-- Filtros de categoría -->
          <div class="filter-categories-container filter-container-center" id="catalogo-filters">
            <button class="filter-chip active" data-cat="todos">🌱 Todos (<span id="cat-count-todos"><?= $totalProds > 0 ? $totalProds : '13' ?></span>)</button>
            <button class="filter-chip" data-cat="pecan">🌰 Pecán & Campo</button>
            <button class="filter-chip" data-cat="bebidas">🍷 Licores, Vinos & Cerveza</button>
            <button class="filter-chip" data-cat="alimentos">🧀 Miel, Quesos & Dulces</button>
            <button class="filter-chip" data-cat="artesania">💎 Artesanías & Piedras</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Grilla del Catálogo -->
  <main class="main-container-custom catalogo-main-container">
    <div class="catalogo-results-bar">
      <div class="catalogo-results-info">
        <span class="catalogo-status-dot" aria-hidden="true"></span>
        <h2 class="catalogo-counter-title" id="catalogo-title-counter">Mostrando <?= $totalProds > 0 ? $totalProds : '13' ?> emprendimientos adheridos</h2>
      </div>
    </div>

    <!-- Contenedor dinámico de tarjetas del catálogo en formato Masonry orgánico -->
    <div class="catalogo-cards-masonry" id="catalogo-cards-container">
      <!-- Inyectado por JS o pre-renderizado -->
    </div>
  </main>

  <!-- Pie de Página Institucional -->
  <footer class="site-footer">
    <div class="footer-container">
      <div class="footer-brand">
        <div class="footer-logo-card">
          <img src="assets/logo-sanjose.png" alt="Municipalidad de San José, Entre Ríos">
        </div>
        <h4>Turismo San José &bull; Hecho en San José</h4>
        <p>
          Iniciativa de la Municipalidad de San José, Entre Ríos. Programa de fomento del consumo de cercanía y fortalecimiento del sector productivo y artesanal en armonía con el desarrollo turístico.
        </p>
        <div class="footer-social-wrap">
          <span class="footer-social-title">Redes Oficiales:</span>
          <div class="social-links-minimal">
            <a href="https://www.instagram.com/turismosanjose/" target="_blank" rel="noopener" class="social-btn-minimal social-btn-footer social-instagram" title="Instagram @turismosanjose" aria-label="Instagram">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
              </svg>
            </a>
            <a href="http://www.facebook.com/turismosanjose" target="_blank" rel="noopener" class="social-btn-minimal social-btn-footer social-facebook" title="Facebook @turismosanjose" aria-label="Facebook">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
              </svg>
            </a>
          </div>
        </div>
      </div>
      <div class="footer-col">
        <h5>Módulos del Programa</h5>
        <ul class="footer-links">
          <li><a href="./">Inicio</a></li>
          <li><a href="catalogo">Catálogo de Negocios</a></li>
          <li><a href="gondola">Encontrá la Góndola</a></li>
          <li><a href="inscribir">Inscribí tu Negocio</a></li>
          <li><a href="mapa">Mapa Productivo Interactivo</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h5>Contacto Municipal</h5>
        <ul class="footer-links">
          <li><a href="#">Secretaría de Turismo</a></li>
          <li><a href="#">Centenario y Entre Ríos</a></li>
          <li><a href="#">turismo@sanjose.tur.ar</a></li>
          <li><a href="#">San José, Entre Ríos (CP 3280)</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <div>&copy; 2026 Municipalidad de San José, Entre Ríos. Todos los derechos reservados.</div>
      <div class="flex-center-gap-10px">
        <span class="footer-admin-text">Gestión Municipal</span>
        <a href="admin/login" class="btn-admin-access btn-admin-access-custom" title="Acceso al Panel de Gestión">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>
          </svg>
          <span>Panel de Gestión</span>
        </a>
      </div>
    </div>
  </footer>

  <!-- Pre-carga de datos para renderizado instantáneo -->
  <script>
    window.INITIAL_PRODUCTORES = <?= json_encode($jsonProductores, JSON_UNESCAPED_UNICODE) ?>;
  </script>

  <!-- Script del Catálogo Interactivo -->
  <script src="app.js?v=<?= filemtime(__DIR__ . '/../../app.js') ?>"></script>
  <script>
    // Lógica específica para la vista de cuadrícula del catálogo
    document.addEventListener('DOMContentLoaded', async () => {
      if (window.INITIAL_PRODUCTORES && window.INITIAL_PRODUCTORES.length > 0) {
        PRODUCTORES_SAN_JOSE = window.INITIAL_PRODUCTORES;
        window.PRODUCTORES_SAN_JOSE = PRODUCTORES_SAN_JOSE;
      }
      if (window.loadProducersPromise) {
        await window.loadProducersPromise;
      }
      const container = document.getElementById('catalogo-cards-container');
      const searchInput = document.getElementById('catalogo-search');
      const filterChips = document.querySelectorAll('#catalogo-filters .filter-chip');
      const counterEl = document.getElementById('catalogo-title-counter');
      const catCountTodosEl = document.getElementById('cat-count-todos');

      let currentCat = 'todos';
      const urlParams = new URLSearchParams(window.location.search);
      let currentQuery = urlParams.get('q') ? urlParams.get('q').trim() : '';
      if (currentQuery && searchInput) {
        searchInput.value = currentQuery;
      }

      function renderCatalogo() {
        if (catCountTodosEl && PRODUCTORES_SAN_JOSE.length > 0) {
          catCountTodosEl.textContent = PRODUCTORES_SAN_JOSE.length;
        }

        const filtered = PRODUCTORES_SAN_JOSE.filter(p => {
          const matchCat = currentCat === 'todos' || p.categoria === currentCat;
          const q = currentQuery.trim().toLowerCase();
          const matchQ = q === '' ||
            p.nombre.toLowerCase().includes(q) ||
            p.rubro.toLowerCase().includes(q) ||
            p.descripcion.toLowerCase().includes(q) ||
            p.direccion.toLowerCase().includes(q);
          return matchCat && matchQ;
        });

        if (counterEl) {
          counterEl.textContent = `Mostrando ${filtered.length} ${filtered.length === 1 ? 'emprendimiento' : 'emprendimientos'} adheridos`;
        }

        if (filtered.length === 0) {
          container.innerHTML = `
            <div class="no-results-wrapper">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="no-results-icon">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
              <h3 class="no-results-title">No se encontraron resultados</h3>
              <p class="no-results-text">Probá buscando con otro término o seleccionando otra categoría.</p>
            </div>
          `;
          return;
        }

        container.innerHTML = filtered.map(p => {
          const gMaps = `https://www.google.com/maps/dir/?api=1&destination=${p.coords[0]},${p.coords[1]}`;
          const waMsg = encodeURIComponent(`Hola! Los contacto a través del Catálogo «Hecho en San José». Me gustaría consultar sobre sus productos.`);
          const wa = `https://wa.me/${p.whatsapp}?text=${waMsg}`;

          return `
            <article class="grid-card catalog-producer-card catalog-card-custom">
              <div class="catalog-card-img-wrap catalog-card-img-wrap-custom">
                <img src="${p.imagen || 'assets/logo-sanjose.png'}" alt="${p.nombre}" class="catalog-card-img catalog-card-img-custom ${!p.imagen ? 'img-fallback-logo' : ''}" loading="lazy" onerror="this.onerror=null; this.src='assets/logo-sanjose.png'; this.classList.add('img-fallback-logo');">
                <div class="card-icon-wrapper-abs">
                  <div class="card-icon-container card-icon-container-custom s-eefcf430">
                    ${p.iconoSvg}
                  </div>
                </div>
                <div class="card-tags-wrapper">
                  <span class="category-tag ${p.tagClass} category-tag-custom">${p.tagLabel}</span>
                  ${p.destacado ? '<span class="sello-destacado">★ Sello Destacado</span>' : ''}
                </div>
              </div>

              <div class="card-content-custom">
                <h3 class="card-title card-title-custom">${p.nombre}</h3>
                <div class="card-rubro">${p.rubro}</div>
                
                <p class="card-description card-desc-custom">
                  ${p.descripcion}
                </p>

                <div class="catalogo-card-info card-info-box">
                  <div class="card-info-row">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="card-info-icon"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span>${p.direccion}</span>
                  </div>
                  <div class="card-info-row">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="card-info-icon"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span>${p.horario}</span>
                  </div>
                </div>

                ${p.gondolas && p.gondolas.length > 0 ? `
                  <div class="card-gondolas-badge-wrap">
                    <span class="gondola-badge-icon">🛒</span>
                    <div>
                      <strong class="gondola-badge-label">Disponible en Góndola:</strong>
                      <span class="gondola-badge-names"> ${p.gondolas.map(escapeHtmlText).join(', ')}</span>
                    </div>
                  </div>
                ` : ''}

                <div class="card-actions">
                  <a href="${wa}" target="_blank" rel="noopener" class="btn btn-primary btn-contact">
                    <span>Contactar</span>
                  </a>
                  <a href="mapa/${p.slug || p.id}" class="btn btn-outline btn-map-custom" title="Ver ubicación exacta en el Mapa Interactivo">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"></polygon>
                      <line x1="9" y1="3" x2="9" y2="18"></line>
                      <line x1="15" y1="6" x2="15" y2="21"></line>
                    </svg>
                    <span>Ver en Mapa</span>
                  </a>
                </div>
              </div>
            </article>
          `;
        }).join('');
      }

      // Escuchadores
      if (searchInput) {
        searchInput.addEventListener('input', (e) => {
          currentQuery = e.target.value;
          renderCatalogo();
        });
      }

      filterChips.forEach(chip => {
        chip.addEventListener('click', (e) => {
          filterChips.forEach(c => { c.classList.remove('active'); c.setAttribute('aria-pressed', 'false'); });
          chip.classList.add('active');
          chip.setAttribute('aria-pressed', 'true');
          currentCat = chip.getAttribute('data-cat');
          renderCatalogo();
        });
      });

      renderCatalogo();
    });
  </script>
</body>
</html>
