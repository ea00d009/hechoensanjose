<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Encontrá la Góndola «Hecho en San José» - Puntos de Venta Adheridos</title>
  <meta name="description" content="Localizá los comercios y supermercados de la ciudad que cuentan con las góndolas exclusivas del programa municipal «Hecho en San José». Comprá directo al productor.">
  <link rel="stylesheet" href="style.css">
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
    <div class="header-topbar">
      <div class="topbar-badge">
        <span>San José, Entre Ríos &bull; Red de Góndolas Exclusivas del Sector Productivo</span>
      </div>
      <div class="topbar-extra" style="display: flex; gap: 1rem; align-items: center;">
        <span style="font-size: 0.78rem; opacity: 0.9;">Comercios Adheridos Oficiales</span>
        <a href="https://sanjose.tur.ar/hechoensanjose/" target="_blank" rel="noopener" style="color: #fff; text-decoration: underline; font-size: 0.78rem;">Sitio Oficial &nearr;</a>
      </div>
    </div>

    <!-- Navegación Principal -->
    <div class="header-main">
      <div class="logo-group">
        <a href="index.php" class="logo-link-wrap" title="Municipalidad de San José, Entre Ríos">
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
          <div style="display: flex; gap: 8px; align-items: center;" class="nav-subpages-links">
            <a href="index.php" class="btn btn-outline" style="padding: 0.5rem 0.9rem; font-size: 0.82rem;">Inicio</a>
            <a href="catalogo.php" class="btn btn-outline" style="padding: 0.5rem 0.9rem; font-size: 0.82rem;">Catálogo</a>
            <a href="inscribir.php" class="btn btn-outline" style="padding: 0.5rem 0.9rem; font-size: 0.82rem;">Inscribirse</a>
            <a href="mapa.php" class="btn btn-accent" style="padding: 0.5rem 1rem; font-size: 0.82rem;">
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
  <section class="hero-section" style="padding: 3rem 1.5rem 2.5rem;">
    <div class="hero-container" style="max-width: 1280px; margin: 0 auto; display: block;">
      <div style="max-width: 820px; margin: 0 auto; text-align: center;">
        <div class="hero-badge-initiative" style="background: var(--color-secondary-light); color: var(--color-secondary); border-color: rgba(5, 150, 105, 0.2);">
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
  <section style="max-width: 1280px; margin: 0 auto; padding: 3rem 1.5rem 1rem;">
    <div class="gondola-intro-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: center; background: var(--bg-card); border-radius: var(--radius-lg); padding: 2.5rem; border: 1px solid var(--border-light); box-shadow: var(--shadow-sm);">
      <div>
        <span style="font-size: 0.78rem; font-weight: 800; color: var(--color-secondary); text-transform: uppercase; letter-spacing: 1px;">Iniciativa Municipal</span>
        <h2 style="font-size: 1.8rem; color: var(--text-main); margin: 0.5rem 0 1rem;">Un espacio exclusivo para el trabajo local</h2>
        <p style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem;">
          Las góndolas <strong>«Hecho en San José»</strong> son exhibidores especialmente identificados ubicados en los principales comercios, supermercados y centros turísticos de nuestra ciudad.
        </p>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.9rem; color: var(--text-main);">
          <li style="display: flex; gap: 10px; align-items: center;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Identificación clara con cartelería y diseño institucional.</span>
          </li>
          <li style="display: flex; gap: 10px; align-items: center;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Precios justos y productos genuinamente sanjosesinos.</span>
          </li>
          <li style="display: flex; gap: 10px; align-items: center;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Fácil acceso para turistas y residentes sin tener que recorrer toda la colonia.</span>
          </li>
        </ul>
      </div>

      <div class="gondola-cta-box">
        <div style="width: 72px; height: 72px; background: var(--bg-card); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: #059669; box-shadow: var(--shadow-sm);">
          <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
        </div>
        <h3>¿Qué vas a encontrar en las góndolas?</h3>
        <p>
          Nueces pecán en mitades y caramelizadas, miel pura de monte nativo, licores centenarios Bard, mermeladas artesanales La Juanita, cuchillos criollos y artesanías en fibra yatay.
        </p>
        <a href="catalogo.php" class="btn btn-outline" style="border-color: #059669; color: var(--text-main); font-size: 0.85rem;">
          Ver todos los productos del catálogo
        </a>
      </div>
    </div>
  </section>

  <!-- Puntos de Venta Adheridos -->
  <main style="max-width: 1280px; margin: 0 auto; padding: 3rem 1.5rem 5rem;">
    <div style="text-align: center; margin-bottom: 3rem;">
      <span style="font-size: 0.8rem; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 1.5px;">Mapa de Puntos de Venta</span>
      <h2 style="font-size: 2.2rem; color: var(--text-main); margin-top: 0.4rem;">Comercios con Góndola Oficial Habilitada</h2>
      <p style="color: var(--text-muted); font-size: 1rem; margin-top: 0.5rem;">Visitá cualquiera de estos establecimientos habilitados para comprar directo del productor.</p>
    </div>

    <div class="portal-grid">

      <!-- Comercio 1 -->
      <article class="grid-card" style="padding: 2rem; border-radius: var(--radius-md);">
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
          <div class="card-icon-container icon-emerald" style="margin-bottom: 0; width: 52px; height: 52px;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          </div>
          <span style="background: #ecfdf5; color: #065f46; font-size: 0.72rem; font-weight: 800; padding: 4px 10px; border-radius: 9999px; height: fit-content;">Góndola Central</span>
        </div>
        <h3 class="card-title" style="font-size: 1.3rem;">Supermercado y Autoservicio San José</h3>
        <p class="card-description" style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;">
          Góndola destacada en el pasillo principal. Amplio surtido en nueces pecán, dulces coloniales, conservas de la colonia y licores artesanales Bard.
        </p>
        <div class="gondola-detail-list" style="font-size: 0.82rem; color: var(--text-main); display: flex; flex-direction: column; gap: 6px; margin-bottom: 1.25rem;">
          <div style="display: flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            <span><strong>Dirección:</strong> Mitre y Centenario (Pleno centro)</span>
          </div>
          <div style="display: flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span>Lun a Sáb: 08:00 a 13:00 y 16:30 a 21:00 hs</span>
          </div>
        </div>
        <a href="https://www.google.com/maps/search/?api=1&query=Mitre+y+Centenario+San+Jose+Entre+Rios" target="_blank" rel="noopener" class="btn btn-outline" style="width: 100%; font-size: 0.85rem;">
          <span>Cómo llegar con GPS &nearr;</span>
        </a>
      </article>

      <!-- Comercio 2 -->
      <article class="grid-card" style="padding: 2rem; border-radius: var(--radius-md);">
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
          <div class="card-icon-container icon-blue" style="margin-bottom: 0; width: 52px; height: 52px;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
          </div>
          <span style="background: #e0f2fe; color: #0369a1; font-size: 0.72rem; font-weight: 800; padding: 4px 10px; border-radius: 9999px; height: fit-content;">Punto Turístico</span>
        </div>
        <h3 class="card-title" style="font-size: 1.3rem;">Centro de Información Turística Oficial</h3>
        <p class="card-description" style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;">
          Góndola institucional con muestras, degustaciones guiadas, folletería del circuito productivo y venta directa de artesanías de la colonia.
        </p>
        <div class="gondola-detail-list" style="font-size: 0.82rem; color: var(--text-main); display: flex; flex-direction: column; gap: 6px; margin-bottom: 1.25rem;">
          <div style="display: flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0096c7" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            <span><strong>Dirección:</strong> Centenario y Entre Ríos</span>
          </div>
          <div style="display: flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0096c7" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span>Todos los días: 08:00 a 20:00 hs (Horario corrido)</span>
          </div>
        </div>
        <a href="https://www.google.com/maps/search/?api=1&query=Centenario+y+Entre+Rios+San+Jose+Entre+Rios" target="_blank" rel="noopener" class="btn btn-outline" style="width: 100%; font-size: 0.85rem;">
          <span>Cómo llegar con GPS &nearr;</span>
        </a>
      </article>

      <!-- Comercio 3 -->
      <article class="grid-card" style="padding: 2rem; border-radius: var(--radius-md);">
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
          <div class="card-icon-container icon-amber" style="margin-bottom: 0; width: 52px; height: 52px;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20"/><path d="m17 5-5-3-5 3"/><path d="m17 19-5 3-5-3"/></svg>
          </div>
          <span style="background: #fef3c7; color: #92400e; font-size: 0.72rem; font-weight: 800; padding: 4px 10px; border-radius: 9999px; height: fit-content;">Almacén de Campo</span>
        </div>
        <h3 class="card-title" style="font-size: 1.3rem;">Almacén Histórico y Regional Francou</h3>
        <p class="card-description" style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;">
          Tradicional almacén de ramos generales con góndola dedicada a embutidos artesanales, miel de pradera, quesos de colonia y cuchillería entrerriana.
        </p>
        <div class="gondola-detail-list" style="font-size: 0.82rem; color: var(--text-main); display: flex; flex-direction: column; gap: 6px; margin-bottom: 1.25rem;">
          <div style="display: flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            <span><strong>Dirección:</strong> Camino de los Colonos y Los Cedros</span>
          </div>
          <div style="display: flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span>Mar a Dom: 09:00 a 13:00 y 16:00 a 20:30 hs</span>
          </div>
        </div>
        <a href="https://www.google.com/maps/search/?api=1&query=Camino+de+los+Colonos+San+Jose+Entre+Rios" target="_blank" rel="noopener" class="btn btn-outline" style="width: 100%; font-size: 0.85rem;">
          <span>Cómo llegar con GPS &nearr;</span>
        </a>
      </article>

      <!-- Comercio 4 -->
      <article class="grid-card" style="padding: 2rem; border-radius: var(--radius-md);">
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
          <div class="card-icon-container icon-accent" style="margin-bottom: 0; width: 52px; height: 52px;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
          </div>
          <span style="background: #ffe4e8; color: #9f1239; font-size: 0.72rem; font-weight: 800; padding: 4px 10px; border-radius: 9999px; height: fit-content;">Complejo Termal</span>
        </div>
        <h3 class="card-title" style="font-size: 1.3rem;">Proveeduría Regional Termas San José</h3>
        <p class="card-description" style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;">
          Ubicada en el predio del parque termal. Góndola exclusiva con productos listos para regalar: alfajores de nuez pecán, licores en miniatura y cosmética apícola.
        </p>
        <div class="gondola-detail-list" style="font-size: 0.82rem; color: var(--text-main); display: flex; flex-direction: column; gap: 6px; margin-bottom: 1.25rem;">
          <div style="display: flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#e54260" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            <span><strong>Dirección:</strong> Acceso a Termas San José s/n</span>
          </div>
          <div style="display: flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#e54260" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span>Abierto todos los días de 09:00 a 20:00 hs</span>
          </div>
        </div>
        <a href="https://www.google.com/maps/search/?api=1&query=Termas+San+Jose+Entre+Rios" target="_blank" rel="noopener" class="btn btn-outline" style="width: 100%; font-size: 0.85rem;">
          <span>Cómo llegar con GPS &nearr;</span>
        </a>
      </article>

    </div>

    <!-- Banner Invitación a Comerciantes -->
    <div style="margin-top: 4rem; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; border-radius: var(--radius-lg); padding: 2.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
      <div style="max-width: 600px;">
        <span style="font-size: 0.78rem; font-weight: 800; color: #38bdf8; text-transform: uppercase; letter-spacing: 1px;">Sumá tu comercio</span>
        <h3 style="font-size: 1.6rem; color: #ffffff; margin: 0.3rem 0 0.6rem;">¿Tenés un comercio y querés tener una góndola?</h3>
        <p style="font-size: 0.92rem; color: #94a3b8; line-height: 1.6;">
          El municipio provee el mueble exhibidor sin costo, material de difusión y vinculación directa con los productores registrados del programa.
        </p>
      </div>
      <a href="inscribir.php" class="btn btn-accent" style="padding: 0.85rem 1.6rem; font-size: 0.95rem;">
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
          <li><a href="index.php">Inicio</a></li>
          <li><a href="catalogo.php">Catálogo de Negocios</a></li>
          <li><a href="gondola.php">Encontrá la Góndola</a></li>
          <li><a href="inscribir.php">Inscribí tu Negocio</a></li>
          <li><a href="mapa.php">Mapa Productivo Interactivo</a></li>
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
      <div style="display: flex; align-items: center; gap: 10px;">
        <span style="color: var(--text-light);">Gestión Municipal</span>
        <a href="admin/login.php" class="btn-admin-access" title="Acceso al Panel de Gestión" style="text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>
          </svg>
          <span>Panel de Gestión</span>
        </a>
        <button type="button" class="btn-admin-access" onclick="window.abrirModalAdminPin()" title="Acceso Administrativo HCD / Gestión" aria-label="Acceso Administrativo">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
          </svg>
          <span>Acceso HCD</span>
        </button>
      </div>
    </div>
  </footer>

  <script src="app.js"></script>
</body>
</html>
