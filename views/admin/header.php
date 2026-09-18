<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • CABECERA COMÚN DEL PANEL DE ADMINISTRACIÓN
 * ==============================================================================
 */

require_once __DIR__ . '/auth.php';
requireAdmin();

$flash = getFlash();

// Obtener conteo de solicitudes pendientes para el badge
$solicitudesPendientesCount = 0;
try {
    $pdoHeader = getDBConnection();
    $solicitudesPendientesCount = (int)$pdoHeader->query("SELECT COUNT(*) FROM `ps_solicitudes_inscripcion` WHERE `estado` = 'pendiente'")->fetchColumn();
} catch (Throwable $e) {
    // Silencioso en cabecera
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' &bull; ' : '' ?>Panel de Gestión &bull; Hecho en San José</title>
  
  <!-- Tipografía Google Fonts optimizada -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap">

  <link rel="stylesheet" href="../style.css?v=<?= filemtime(__DIR__ . '/../../style.css') ?>">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🏛️</text></svg>">
  
  <!-- Leaflet CSS para vistas que requieran mapa -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">

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
      } catch (e) {}
    })();
  </script>

  <link rel="stylesheet" href="../assets/css/admin.css?v=<?= filemtime(__DIR__ . '/../../assets/css/admin.css') ?>">
</head>
<body>

  <!-- Barra Superior Institucional del Panel -->
  <header class="site-header">
    <div class="header-topbar">
      <div class="topbar-badge">
        <span>Panel de Control Municipal &bull; San José, Entre Ríos</span>
      </div>
      <div class="topbar-extra" style="display: flex; gap: 1rem; align-items: center;">
        <a href="manual.php" style="display: flex; align-items: center; gap: 5px; color: #fff; text-decoration: none; font-size: 0.78rem; background: rgba(255,255,255,0.15); padding: 4px 10px; border-radius: 20px; font-weight: 600; transition: background 0.2s;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
          Manual de Usuario
        </a>
        <span style="font-size: 0.78rem; opacity: 0.9;">Sesión activa: <strong><?= htmlspecialchars($_SESSION['admin_nombre'] ?? 'Administrador') ?></strong></span>
        <a href="logout" style="color: #fff; text-decoration: underline; font-size: 0.78rem;">Cerrar Sesión</a>
      </div>
    </div>

    <!-- Navegación Principal -->
    <div class="header-main">
      <div class="logo-group">
        <a href="./" class="logo-link-wrap" title="Panel de Gestión">
          <img src="../assets/logo-sanjose.png" alt="Municipalidad de San José" class="municipal-logo">
        </a>
        <div class="logo-divider"></div>
        <div class="logo-titles">
          <h1>Hecho en <span>San José</span></h1>
          <div class="logo-subtitle">Panel de Gestión de Productores</div>
        </div>
      </div>

      <div class="header-right-group">
        <nav class="admin-nav-pills">
          <a href="./" class="admin-nav-item <?= $currentPage === 'index.php' ? 'active' : '' ?>">
            Dashboard
          </a>
          <a href="productores" class="admin-nav-item <?= in_array($currentPage, ['productores.php', 'productor-form.php']) ? 'active' : '' ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Gestión de Productores
          </a>
          <a href="categorias" class="admin-nav-item <?= $currentPage === 'categorias.php' ? 'active' : '' ?>">
            Categorías
          </a>
          <a href="gondolas" class="admin-nav-item <?= in_array($currentPage, ['gondolas.php', 'gondola-form.php']) ? 'active' : '' ?>">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            Góndolas
          </a>
          <a href="productor-form.php" class="admin-nav-item <?= $currentPage === 'productor-form.php' && empty($_GET['id']) ? 'active' : '' ?>" style="color: #0284c7; font-weight: 700;">
            + Nueva Alta
          </a>
          <a href="solicitudes.php" class="admin-nav-item <?= $currentPage === 'solicitudes.php' ? 'active' : '' ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            <span>Solicitudes de Inscripción</span>
            <?php if ($solicitudesPendientesCount > 0): ?>
              <span class="badge-pill"><?= $solicitudesPendientesCount ?></span>
            <?php endif; ?>
          </a>
          <a href="../" target="_blank" class="admin-nav-item" style="color: #059669;" title="Abrir sitio web público en nueva pestaña">
            Sitio Web &nearr;
          </a>
        </nav>

        <!-- Conmutador de Modo Oscuro -->
        <button type="button" class="theme-toggle-btn" id="admin-theme-toggle" aria-label="Cambiar modo de color" style="margin-left: 0.5rem;">
          <svg class="theme-icon icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
          <svg class="theme-icon icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        </button>
      </div>
    </div>
  </header>

  <main class="admin-container">
    <?php if ($flash): ?>
      <div class="alert-flash <?= htmlspecialchars($flash['type']) ?>">
        <div><?= htmlspecialchars($flash['message']) ?></div>
      </div>
    <?php endif; ?>
