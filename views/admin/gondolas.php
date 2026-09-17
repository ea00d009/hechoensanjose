<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • PADRÓN Y GESTIÓN DE GÓNDOLAS OFICIALES (ABM)
 * ==============================================================================
 * Iniciativa Municipal: Exhibidores exclusivos ubicados en los principales
 * comercios, supermercados y centros turísticos de San José.
 */
$pageTitle = 'Góndolas Oficiales';
require_once __DIR__ . '/header.php';

// Si no viene instanciado desde el controlador (acceso directo a gondolas.php), cargar datos
if (!isset($gondolas)) {
    require_once __DIR__ . '/../../models/GondolaRepository.php';
    $busqueda = trim($_GET['q'] ?? '');
    $estado   = trim($_GET['estado'] ?? 'todos');

    $repoGondola = new GondolaRepository();
    $gondolas = $repoGondola->getAllForAdmin($busqueda, $estado);
    $metrics  = $repoGondola->getMetrics();
    $csrf     = getCsrfToken();
} else {
    $csrf = $_SESSION['csrf_token'] ?? getCsrfToken();
}
?>

  <!-- Cabecera de la sección -->
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
      <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(5, 150, 105, 0.1); color: #059669; font-size: 0.78rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; margin-bottom: 0.4rem; text-transform: uppercase;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
        Iniciativa Municipal &bull; Espacio exclusivo para el trabajo local
      </div>
      <h2 style="font-size: 1.6rem; color: var(--text-main, #0f172a); margin: 0 0 0.35rem 0; font-weight: 800;">
        Padrón de Góndolas «Hecho en San José»
      </h2>
      <p style="color: var(--text-muted, #64748b); margin: 0; font-size: 0.9rem;">
        Administración de exhibidores oficiales, identificación institucional, puntos de venta y geolocalización.
      </p>
    </div>
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
      <a href="../gondola" target="_blank" class="btn btn-outline" style="padding: 10px 16px; font-size: 0.92rem; color: #0284c7; border-color: #0284c7;" title="Ver página pública de góndolas">
        🌐 Ver en Web &nearr;
      </a>
      <a href="exportar-csv.php?tipo=gondolas" class="btn btn-outline" style="padding: 10px 16px; font-size: 0.92rem; color: #059669; border-color: #059669;">
        ⬇️ Exportar CSV
      </a>
      <a href="gondola-form.php" class="btn btn-accent" style="padding: 10px 22px; font-size: 0.92rem;">
        + Nueva Góndola
      </a>
    </div>
  </div>

  <!-- Métricas Rápidas de Góndolas -->
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div class="card-admin" style="display: flex; align-items: center; gap: 1rem; padding: 1rem 1.25rem;">
      <div style="width: 44px; height: 44px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
      </div>
      <div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--text-main, #0f172a);"><?= $metrics['total'] ?? count($gondolas) ?></div>
        <div style="font-size: 0.8rem; color: var(--text-muted, #64748b); font-weight: 600;">Góndolas Registradas</div>
      </div>
    </div>

    <div class="card-admin" style="display: flex; align-items: center; gap: 1rem; padding: 1rem 1.25rem;">
      <div style="width: 44px; height: 44px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
      </div>
      <div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #059669;"><?= $metrics['activas'] ?? 0 ?></div>
        <div style="font-size: 0.8rem; color: var(--text-muted, #64748b); font-weight: 600;">Habilitadas en Portal</div>
      </div>
    </div>

    <div class="card-admin" style="display: flex; align-items: center; gap: 1rem; padding: 1rem 1.25rem;">
      <div style="width: 44px; height: 44px; border-radius: 10px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      </div>
      <div>
        <div style="font-size: 1.5rem; font-weight: 800; color: #d97706;"><?= $metrics['destacadas'] ?? 0 ?></div>
        <div style="font-size: 0.8rem; color: var(--text-muted, #64748b); font-weight: 600;">Puntos Destacados</div>
      </div>
    </div>
  </div>

  <!-- Barra de Filtros y Búsqueda -->
  <div class="card-admin" style="padding: 1rem 1.25rem; margin-bottom: 1.5rem;">
    <form method="GET" action="gondolas.php" style="display: flex; gap: 0.85rem; flex-wrap: wrap; align-items: center;">
      <div style="flex: 1; min-width: 220px;">
        <input 
          type="text" 
          name="q" 
          value="<?= htmlspecialchars($busqueda ?? '') ?>" 
          placeholder="Buscar comercio, dirección o productos..." 
          class="form-control"
          style="padding: 9px 12px; font-size: 0.88rem; border-radius: 8px; border: 1px solid var(--border-light); width: 100%; box-sizing: border-box; background: var(--bg-card); color: var(--text-main);"
        >
      </div>

      <div>
        <select 
          name="estado" 
          style="padding: 9px 12px; font-size: 0.88rem; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main); cursor: pointer;"
          onchange="this.form.submit()"
        >
          <option value="todos" <?= ($estado ?? '') === 'todos' ? 'selected' : '' ?>>Todos los estados</option>
          <option value="activos" <?= ($estado ?? '') === 'activos' ? 'selected' : '' ?>>Solo Habilitadas</option>
          <option value="inactivos" <?= ($estado ?? '') === 'inactivos' ? 'selected' : '' ?>>Solo Pausadas</option>
          <option value="destacados" <?= ($estado ?? '') === 'destacados' ? 'selected' : '' ?>>Solo Destacadas</option>
        </select>
      </div>

      <button type="submit" class="btn btn-outline" style="padding: 8px 16px; font-size: 0.85rem;">
        Filtrar
      </button>
      <?php if (($busqueda ?? '') !== '' || ($estado ?? 'todos') !== 'todos'): ?>
        <a href="gondolas.php" style="font-size: 0.85rem; color: #dc2626; text-decoration: underline; margin-left: 6px;">
          Limpiar filtros
        </a>
      <?php endif; ?>
    </form>
  </div>

  <!-- Tabla de Góndolas -->
  <div class="card-admin" style="padding: 0; overflow: hidden;">
    <div class="admin-table-wrap" style="border: none; border-radius: 0;">
      <table class="admin-table">
        <thead>
          <tr>
            <th style="width: 45px;">Ord</th>
            <th style="width: 140px;">Distintivo / Tipo</th>
            <th>Comercio & Exhibición</th>
            <th>Ubicación & Horario</th>
            <th>GPS / Coordenadas</th>
            <th style="text-align: center; width: 70px;">Destacado</th>
            <th style="text-align: center; width: 80px;">Estado</th>
            <th style="text-align: right; min-width: 130px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($gondolas)): ?>
            <tr>
              <td colspan="8" style="text-align: center; padding: 3rem 1rem; color: var(--text-muted);">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 0.5rem; opacity: 0.5;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <div style="font-size: 1rem; font-weight: 600;">No se encontraron góndolas con los filtros seleccionados</div>
                <div style="font-size: 0.85rem; margin-top: 0.35rem;">Podés agregar una nueva con el botón "+ Nueva Góndola".</div>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($gondolas as $g): ?>
              <tr>
                <td style="font-weight: 700; color: var(--text-muted); font-size: 0.82rem;">
                  <?= (int)$g['orden'] > 0 ? (int)$g['orden'] : '#' . $g['id'] ?>
                </td>
                <td>
                  <?php
                    $colorBadgeStyle = 'background: rgba(5, 150, 105, 0.12); color: #059669;';
                    if ($g['color'] === 'icon-blue') {
                        $colorBadgeStyle = 'background: rgba(0, 150, 199, 0.12); color: #0096c7;';
                    } elseif ($g['color'] === 'icon-amber') {
                        $colorBadgeStyle = 'background: rgba(217, 119, 6, 0.12); color: #d97706;';
                    } elseif ($g['color'] === 'icon-accent') {
                        $colorBadgeStyle = 'background: rgba(229, 66, 96, 0.12); color: #e54260;';
                    }
                  ?>
                  <span style="font-size: 0.76rem; font-weight: 700; display: inline-block; padding: 3px 8px; border-radius: 6px; <?= $colorBadgeStyle ?>">
                    <?= htmlspecialchars($g['tipo']) ?>
                  </span>
                </td>
                <td>
                  <div style="font-weight: 700; color: var(--text-main); font-size: 0.95rem; margin-bottom: 2px;">
                    <?= htmlspecialchars($g['nombre']) ?>
                  </div>
                  <div style="font-size: 0.82rem; color: var(--text-muted); line-height: 1.35; max-width: 380px;">
                    <?= htmlspecialchars($g['descripcion']) ?>
                  </div>
                  <?php if (!empty($g['productos_destacados'])): ?>
                    <div style="margin-top: 4px; font-size: 0.74rem; color: #059669;">
                      <strong>Productos:</strong> <?= htmlspecialchars($g['productos_destacados']) ?>
                    </div>
                  <?php endif; ?>
                  <div style="margin-top: 6px; display: flex; align-items: center; gap: 6px;">
                    <span style="font-size: 0.74rem; font-weight: 700; padding: 2px 8px; border-radius: 12px; background: rgba(2, 132, 199, 0.1); color: #0284c7;">
                      👨‍🌾 <?= (int)($g['total_productores'] ?? 0) ?> productores asignados
                    </span>
                  </div>
                </td>
                <td style="font-size: 0.82rem;">
                  <div style="color: var(--text-main); margin-bottom: 3px; font-weight: 600;">
                    📍 <?= htmlspecialchars($g['direccion']) ?>
                  </div>
                  <?php if (!empty($g['horario'])): ?>
                    <div style="color: var(--text-muted); margin-bottom: 2px;">
                      🕒 <?= htmlspecialchars($g['horario']) ?>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($g['whatsapp'])): ?>
                    <div style="color: #059669;">
                      💬 WA: <?= htmlspecialchars($g['whatsapp']) ?>
                    </div>
                  <?php endif; ?>
                </td>
                <td style="font-size: 0.8rem;">
                  <?php if (!empty($g['google_maps_url'])): ?>
                    <a href="<?= htmlspecialchars($g['google_maps_url']) ?>" target="_blank" rel="noopener" class="btn btn-outline btn-sm" style="color: #0284c7; padding: 3px 8px; font-size: 0.75rem;" title="Abrir en Google Maps">
                      🗺️ GPS &nearr;
                    </a>
                  <?php elseif (!empty($g['lat']) && !empty($g['lng'])): ?>
                    <a href="https://www.google.com/maps/search/?api=1&query=<?= $g['lat'] ?>,<?= $g['lng'] ?>" target="_blank" rel="noopener" class="btn btn-outline btn-sm" style="color: #0284c7; padding: 3px 8px; font-size: 0.75rem;">
                      📍 Ver Coords
                    </a>
                  <?php else: ?>
                    <span style="color: var(--text-muted); font-size: 0.75rem;">Sin GPS</span>
                  <?php endif; ?>
                </td>
                <td style="text-align: center;">
                  <form method="POST" action="gondola-acciones.php" style="display: inline;">
                    <input type="hidden" name="csrf" value="<?= $csrf ?>">
                    <input type="hidden" name="accion" value="toggle_destacado">
                    <input type="hidden" name="id" value="<?= $g['id'] ?>">
                    <button type="submit" title="Clic para alternar destacado" style="background: none; border: none; cursor: pointer; font-size: 1.2rem; color: <?= $g['destacado'] ? '#d97706' : '#cbd5e1' ?>;">
                      <?= $g['destacado'] ? '★' : '☆' ?>
                    </button>
                  </form>
                </td>
                <td style="text-align: center;">
                  <form method="POST" action="gondola-acciones.php" style="display: inline;">
                    <input type="hidden" name="csrf" value="<?= $csrf ?>">
                    <input type="hidden" name="accion" value="toggle_activo">
                    <input type="hidden" name="id" value="<?= $g['id'] ?>">
                    <button type="submit" title="Clic para alternar habilitación" style="background: none; border: none; cursor: pointer;">
                      <?php if ($g['activo']): ?>
                        <span class="badge-status badge-activo">Habilitada</span>
                      <?php else: ?>
                        <span class="badge-status badge-inactivo">Pausada</span>
                      <?php endif; ?>
                    </button>
                  </form>
                </td>
                <td style="text-align: right;">
                  <div style="display: flex; gap: 6px; justify-content: flex-end;">
                    <a href="gondola-form.php?id=<?= $g['id'] ?>" class="btn btn-outline btn-sm" title="Modificar punto de venta">
                      Editar
                    </a>
                    <form method="POST" action="gondola-acciones.php" style="display: inline;" onsubmit="return confirm('¿Seguro que deseás eliminar la góndola de «<?= htmlspecialchars(addslashes($g['nombre'])) ?>»? Esta acción no se puede deshacer.');">
                      <input type="hidden" name="csrf" value="<?= $csrf ?>">
                      <input type="hidden" name="accion" value="eliminar">
                      <input type="hidden" name="id" value="<?= $g['id'] ?>">
                      <button type="submit" class="btn btn-danger-soft btn-sm" title="Eliminar góndola">
                        ✖
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

<?php require_once __DIR__ . '/footer.php'; ?>
