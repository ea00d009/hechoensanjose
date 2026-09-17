<?php
if (!isset($gondolas)) {
    require_once __DIR__ . '/../../models/GondolaRepository.php';
    $gRepo = new GondolaRepository();
    $gondolas = $gRepo->getActivasConProductores();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Encontrá la Góndola «Hecho en San José» - Puntos de Venta Adheridos</title>
  <meta name="description" content="Localizá los comercios y supermercados de la ciudad que cuentan con las góndolas exclusivas del programa municipal «Hecho en San José». Comprá directo al productor.">
  
  <!-- Tipografía Google Fonts optimizada -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap">

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="assets/css/normalized.css">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛒</text></svg>">
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
<body>

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
          <div class="s-b131259d nav-subpages-links">
            <a href="./" class="btn btn-outline s-894fcfb8">Inicio</a>
            <a href="catalogo" class="btn btn-outline s-894fcfb8">Catálogo</a>
            <a href="inscribir" class="btn btn-outline s-894fcfb8">Inscribirse</a>
            <a href="mapa" class="btn btn-accent s-cdd7a746">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"></polygon>
                <line x1="9" y1="3" x2="9" y2="18"></line>
                <line x1="15" y1="6" x2="15" y2="21"></line>
              </svg>
              <span>Ver Mapa</span>
            </a>
          </div>

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

  <!-- Hero Góndolas -->
  <section class="hero-section s-515a3e0a">
    <div class="hero-container s-7b1c691d">
      <div class="s-e5ccebc6">
        <div class="hero-badge-initiative s-14814aca">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            <path d="m11 8 3 3-3 3"></path>
          </svg>
          <span>Puntos de Comercialización y Fomento Local</span>
        </div>
        <h1 class="page-hero-title">
          Encontrá la Góndola <span class="highlight">«Hecho en San José»</span>
        </h1>
        <p class="page-hero-desc">
          Para que cuando necesites hacer un regalo, llevarte un recuerdo o degustar los auténticos sabores de nuestra colonia, puedas encontrarlos reunidos en un mismo lugar en los comercios adheridos de la ciudad.
        </p>
      </div>
    </div>
  </section>

  <!-- Sección: ¿Qué es la Góndola? -->
  <section class="s-7423c938">
    <div class="gondola-intro-grid s-40d55e42">
      <div>
        <span class="s-065e24cf">Iniciativa Municipal</span>
        <h2 class="s-311158cd">Un espacio exclusivo para el trabajo local</h2>
        <p class="s-281fa8a5">
          Las góndolas <strong>«Hecho en San José»</strong> son exhibidores especialmente identificados ubicados en los principales comercios, supermercados y centros turísticos de nuestra ciudad.
        </p>
        <ul class="s-0f045196">
          <li class="s-c6235d4d">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Identificación clara con cartelería y diseño institucional.</span>
          </li>
          <li class="s-c6235d4d">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Precios justos y productos genuinamente sanjosesinos.</span>
          </li>
          <li class="s-c6235d4d">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Fácil acceso para turistas y residentes sin tener que recorrer toda la colonia.</span>
          </li>
        </ul>
      </div>

      <div class="gondola-cta-box">
        <div class="s-8984aa3a">
          <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
        </div>
        <h3>¿Qué vas a encontrar en las góndolas?</h3>
        <p>
          Nueces pecán en mitades y caramelizadas, miel pura de monte nativo, licores centenarios Bard, mermeladas artesanales La Juanita, cuchillos criollos y artesanías en fibra yatay.
        </p>
        <a href="catalogo" class="btn btn-outline s-2be05879">
          Ver todos los productos del catálogo
        </a>
      </div>
    </div>
  </section>

  <!-- Puntos de Venta Adheridos -->
  <main class="s-530eb510">
    <div class="s-f7536595">
      <span class="s-328256b5">Mapa de Puntos de Venta</span>
      <h2 class="s-43f76b62">Comercios con Góndola Oficial Habilitada</h2>
      <p class="s-fa92a45f">Visitá cualquiera de estos establecimientos habilitados para comprar directo del productor.</p>
    </div>

    <div class="portal-grid">

      <?php if (empty($gondolas)): ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 3.5rem 1.5rem; background: var(--bg-card); border-radius: var(--radius-md); border: 1px solid var(--border-light);">
          <div style="font-size: 2.8rem; margin-bottom: 0.6rem;">🛒</div>
          <h3 style="color: var(--text-main); font-size: 1.3rem; margin-bottom: 0.5rem; font-weight: 700;">Próximamente más puntos de venta adheridos</h3>
          <p style="color: var(--text-muted); font-size: 0.95rem; max-width: 520px; margin: 0 auto; line-height: 1.5;">
            El municipio continúa incorporando comercios para acercar los productos genuinamente sanjosesinos a todos los barrios de nuestra ciudad.
          </p>
        </div>
      <?php else: ?>
        <?php foreach ($gondolas as $g): ?>
          <?php
            $color = $g['color'] ?? 'icon-emerald';
            $badgeClass = 's-a23b7701';
            $strokeColor = '#059669';

            if ($color === 'icon-blue') {
                $badgeClass = 's-1b789f48';
                $strokeColor = '#0096c7';
            } elseif ($color === 'icon-amber') {
                $badgeClass = 's-610e1852';
                $strokeColor = '#d97706';
            } elseif ($color === 'icon-accent') {
                $badgeClass = 's-00197ddd';
                $strokeColor = '#e54260';
            }

            $gpsUrl = !empty($g['google_maps_url']) 
                ? $g['google_maps_url'] 
                : (!empty($g['lat']) && !empty($g['lng']) 
                    ? "https://www.google.com/maps/search/?api=1&query={$g['lat']},{$g['lng']}" 
                    : "https://www.google.com/maps/search/?api=1&query=" . urlencode($g['direccion'] . ' San Jose Entre Rios'));
          ?>
          <article class="grid-card s-98097ca5">
            <div class="s-f7930129">
              <div class="card-icon-container <?= htmlspecialchars($color) ?> s-bd944105">
                <?php if (!empty($g['icono_svg'])): ?>
                  <?= $g['icono_svg'] ?>
                <?php elseif ($color === 'icon-blue'): ?>
                  <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <?php elseif ($color === 'icon-amber'): ?>
                  <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20"/><path d="m17 5-5-3-5 3"/><path d="m17 19-5 3-5-3"/></svg>
                <?php elseif ($color === 'icon-accent'): ?>
                  <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                <?php else: ?>
                  <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <?php endif; ?>
              </div>
              <span class="<?= $badgeClass ?>"><?= htmlspecialchars($g['tipo']) ?></span>
            </div>
            <h3 class="card-title s-382e0963"><?= htmlspecialchars($g['nombre']) ?></h3>
            <p class="card-description s-8980900f">
              <?= htmlspecialchars($g['descripcion']) ?>
            </p>
            <div class="gondola-detail-list s-06594bb1">
              <div class="s-650e1230">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="<?= $strokeColor ?>" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                <span><strong>Dirección:</strong> <?= htmlspecialchars($g['direccion']) ?></span>
              </div>
              <?php if (!empty($g['horario'])): ?>
                <div class="s-650e1230">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="<?= $strokeColor ?>" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                  <span><?= htmlspecialchars($g['horario']) ?></span>
                </div>
              <?php endif; ?>
              <?php if (!empty($g['productos_destacados'])): ?>
                <div class="s-650e1230" style="margin-top: 2px;">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="<?= $strokeColor ?>" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/></svg>
                  <span><strong>Encontrás:</strong> <?= htmlspecialchars($g['productos_destacados']) ?></span>
                </div>
              <?php endif; ?>
              <?php if (!empty($g['whatsapp'])): ?>
                <div class="s-650e1230">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="<?= $strokeColor ?>" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                  <span><strong>WhatsApp:</strong> <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $g['whatsapp']) ?>" target="_blank" rel="noopener" style="color: inherit; text-decoration: underline;"><?= htmlspecialchars($g['whatsapp']) ?></a></span>
                </div>
              <?php endif; ?>
            </div>

            <?php if (!empty($g['productores'])): ?>
              <div style="margin: 0.85rem 0 1.15rem 0; padding-top: 0.85rem; border-top: 1px dashed var(--border-light);">
                <div style="font-size: 0.76rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 5px;">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                  <span>Productores en este exhibidor (<?= count($g['productores']) ?>):</span>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 0.35rem;">
                  <?php foreach ($g['productores'] as $gp): ?>
                    <a href="catalogo?q=<?= urlencode($gp['nombre']) ?>" style="display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; font-size: 0.74rem; border-radius: var(--radius-full); background: var(--bg-surface); border: 1px solid var(--border-light); color: var(--text-main); text-decoration: none; font-weight: 600; transition: var(--transition);" title="Ver en catálogo a <?= htmlspecialchars($gp['nombre']) ?>">
                      <span><?= htmlspecialchars($gp['nombre']) ?></span>
                    </a>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>

            <a href="<?= htmlspecialchars($gpsUrl) ?>" target="_blank" rel="noopener" class="btn btn-outline s-19df37d1">
              <span>Cómo llegar con GPS &nearr;</span>
            </a>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>

    </div>

    <!-- Banner Invitación a Comerciantes -->
    <div class="s-fcdec711">
      <div class="s-4d1e5c7d">
        <span class="s-cc1b8cc8">Sumá tu comercio</span>
        <h3 class="s-5df4ade3">¿Tenés un comercio y querés tener una góndola?</h3>
        <p class="s-426c5a55">
          El municipio provee el mueble exhibidor sin costo, material de difusión y vinculación directa con los productores registrados del programa.
        </p>
      </div>
      <a href="inscribir" class="btn btn-accent s-37558bce">
        <span>Solicitar Góndola para mi local &rarr;</span>
      </a>
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
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
            </a>
            <a href="http://www.facebook.com/turismosanjose" target="_blank" rel="noopener" class="social-btn-minimal social-btn-footer social-facebook" title="Facebook @turismosanjose" aria-label="Facebook">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
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
      <div class="s-b512c985">
        <span class="s-b32654dc">Gestión Municipal</span>
        <a href="admin/login" class="btn-admin-access" title="Acceso al Panel de Gestión" class="s-de742dc8">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>
          </svg>
          <span>Panel de Gestión</span>
        </a>
      </div>
    </div>
  </footer>

  <script src="app.js"></script>
</body>
</html>
