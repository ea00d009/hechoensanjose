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
  <link rel="stylesheet" href="../style.css">
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

  <style>
    .admin-container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 1.5rem;
    }
    .admin-nav-pills {
      display: flex;
      gap: 0.5rem;
      align-items: center;
      flex-wrap: wrap;
    }
    .admin-nav-item {
      padding: 0.5rem 0.9rem;
      border-radius: 8px;
      font-size: 0.85rem;
      font-weight: 600;
      text-decoration: none;
      color: var(--text-muted, #64748b);
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    .admin-nav-item:hover {
      background: var(--bg-hover, #f1f5f9);
      color: var(--text-main, #0f172a);
    }
    .admin-nav-item.active {
      background: #0284c7;
      color: #ffffff !important;
    }
    .badge-pill {
      background: #ef4444;
      color: #ffffff;
      font-size: 0.72rem;
      font-weight: 800;
      padding: 2px 6px;
      border-radius: 12px;
    }
    .alert-flash {
      padding: 1rem 1.25rem;
      border-radius: 8px;
      margin-bottom: 1.5rem;
      font-size: 0.92rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .alert-flash.success {
      background: #ecfdf5;
      color: #065f46;
      border: 1px solid #a7f3d0;
    }
    .alert-flash.danger {
      background: #fef2f2;
      color: #991b1b;
      border: 1px solid #fecaca;
    }
    .card-admin {
      background: var(--bg-card, #ffffff);
      border: 1px solid var(--border-light, #e2e8f0);
      border-radius: 14px;
      padding: 1.5rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
      margin-bottom: 1.5rem;
    }
    .admin-table-wrap {
      overflow-x: auto;
      border-radius: 10px;
      border: 1px solid var(--border-light, #e2e8f0);
    }
    .admin-table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
      font-size: 0.88rem;
    }
    .admin-table th {
      background: var(--bg-hover, #f8fafc);
      padding: 12px 14px;
      font-weight: 700;
      color: var(--text-muted, #475569);
      border-bottom: 1px solid var(--border-light, #e2e8f0);
    }
    .admin-table td {
      padding: 12px 14px;
      border-bottom: 1px solid var(--border-light, #f1f5f9);
      color: var(--text-main, #1e293b);
      vertical-align: middle;
    }
    .admin-table tr:hover td {
      background: var(--bg-hover, #f8fafc);
    }
    .thumb-mini {
      width: 48px;
      height: 48px;
      border-radius: 8px;
      object-fit: cover;
      border: 1px solid var(--border-light, #e2e8f0);
    }
    .badge-status {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 6px;
      font-size: 0.75rem;
      font-weight: 700;
    }
    .badge-activo {
      background: #ecfdf5;
      color: #059669;
      border: 1px solid #a7f3d0;
    }
    .badge-inactivo {
      background: #f1f5f9;
      color: #64748b;
      border: 1px solid #cbd5e1;
    }
    .btn-sm {
      padding: 6px 12px;
      font-size: 0.8rem;
      border-radius: 6px;
    }
    .btn-danger-soft {
      background: #fee2e2;
      color: #dc2626;
      border: 1px solid #fca5a5;
    }
    .btn-danger-soft:hover {
      background: #dc2626;
      color: #ffffff;
    }
  </style>
</head>
<body>

  <!-- Barra Superior Institucional del Panel -->
  <header class="site-header">
    <div class="header-topbar">
      <div class="topbar-badge">
        <span>Panel de Control Municipal &bull; San José, Entre Ríos</span>
      </div>
      <div class="topbar-extra" style="display: flex; gap: 1rem; align-items: center;">
        <span style="font-size: 0.78rem; opacity: 0.9;">Sesión activa: <strong><?= htmlspecialchars($_SESSION['admin_nombre'] ?? 'Administrador') ?></strong></span>
        <a href="logout.php" style="color: #fff; text-decoration: underline; font-size: 0.78rem;">Cerrar Sesión</a>
      </div>
    </div>

    <!-- Navegación Principal -->
    <div class="header-main">
      <div class="logo-group">
        <a href="index.php" class="logo-link-wrap" title="Panel de Gestión">
          <img src="../assets/logo-sanjose.png" alt="Municipalidad de San José" class="municipal-logo">
        </a>
        <div class="logo-divider"></div>
        <div class="logo-titles">
          <h1>Hecho en <span>San José</span></h1>
          <div class="logo-subtitle">Panel de Gestión de Productores (ABM)</div>
        </div>
      </div>

      <div class="header-right-group">
        <nav class="admin-nav-pills">
          <a href="index.php" class="admin-nav-item <?= $currentPage === 'index.php' ? 'active' : '' ?>">
            Dashboard
          </a>
          <a href="productores.php" class="admin-nav-item <?= in_array($currentPage, ['productores.php', 'productor-form.php']) ? 'active' : '' ?>">
            Productores (ABM)
          </a>
          <a href="categorias.php" class="admin-nav-item <?= $currentPage === 'categorias.php' ? 'active' : '' ?>">
            Categorías
          </a>
          <a href="productor-form.php" class="admin-nav-item <?= $currentPage === 'productor-form.php' && empty($_GET['id']) ? 'active' : '' ?>" style="color: #0284c7; font-weight: 700;">
            + Nueva Alta
          </a>
          <a href="solicitudes.php" class="admin-nav-item <?= $currentPage === 'solicitudes.php' ? 'active' : '' ?>">
            <span>Solicitudes</span>
            <?php if ($solicitudesPendientesCount > 0): ?>
              <span class="badge-pill"><?= $solicitudesPendientesCount ?></span>
            <?php endif; ?>
          </a>
          <a href="../index.php" target="_blank" class="admin-nav-item" style="color: #059669;" title="Abrir sitio web público en nueva pestaña">
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
