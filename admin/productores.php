<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • LISTADO Y GESTIÓN GENERAL DE PRODUCTORES
 * ==============================================================================
 */

$pageTitle = 'Productores Registrados';
require_once __DIR__ . '/header.php';

$pdo = getDBConnection();

// Filtros
$busqueda  = trim($_GET['q'] ?? '');
$catFiltro = trim($_GET['categoria'] ?? 'todos');
$estado    = trim($_GET['estado'] ?? 'todos');

// Obtener categorías para el filtro
$categorias = $pdo->query("SELECT * FROM `ps_categorias` ORDER BY `orden` ASC")->fetchAll();

// Construir consulta SQL
$sql = "
    SELECT p.*, c.nombre AS categoria_nombre, c.tag_class, c.pin_color 
    FROM `ps_productores` p
    LEFT JOIN `ps_categorias` c ON p.categoria_id = c.id
    WHERE 1=1
";
$params = [];

if ($busqueda !== '') {
    $sql .= " AND (p.nombre LIKE :q OR p.rubro LIKE :q OR p.direccion LIKE :q OR p.descripcion LIKE :q)";
    $params[':q'] = "%{$busqueda}%";
}

if ($catFiltro !== '' && $catFiltro !== 'todos') {
    $sql .= " AND p.categoria_id = :cat";
    $params[':cat'] = $catFiltro;
}

if ($estado === 'activos') {
    $sql .= " AND p.activo = 1";
} elseif ($estado === 'inactivos') {
    $sql .= " AND p.activo = 0";
} elseif ($estado === 'destacados') {
    $sql .= " AND p.destacado = 1";
}

$sql .= " ORDER BY p.id ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$productores = $stmt->fetchAll();

$csrf = getCsrfToken();
?>

  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
      <h2 style="font-size: 1.6rem; color: var(--text-main, #0f172a); margin: 0 0 0.35rem 0; font-weight: 800;">
        Padrón de Productores Locales
      </h2>
      <p style="color: var(--text-muted, #64748b); margin: 0; font-size: 0.9rem;">
        Administración de fichas, coordenadas geográficas, imágenes y estado de publicación.
      </p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
      <a href="exportar-csv.php?tipo=productores" class="btn btn-outline" style="padding: 10px 16px; font-size: 0.92rem; color: #059669; border-color: #059669;">
        ⬇️ Exportar CSV
      </a>
      <a href="productor-form.php" class="btn btn-accent" style="padding: 10px 22px; font-size: 0.92rem;">
        + Agregar Nuevo Productor
      </a>
    </div>
  </div>

<!-- Barra de Filtros y Búsqueda -->
<div class="card-admin" style="padding: 1rem 1.25rem; margin-bottom: 1.5rem;">
  <form method="GET" action="productores.php" style="display: flex; gap: 0.85rem; flex-wrap: wrap; align-items: center;">
    <div style="flex: 1; min-width: 220px;">
      <input 
        type="text" 
        name="q" 
        value="<?= htmlspecialchars($busqueda) ?>" 
        placeholder="Buscar por nombre, rubro o dirección..." 
        class="form-control"
        style="padding: 9px 12px; font-size: 0.88rem; border-radius: 8px; border: 1px solid var(--border-light); width: 100%; box-sizing: border-box; background: var(--bg-card); color: var(--text-main);"
      >
    </div>

    <div>
      <select 
        name="categoria" 
        style="padding: 9px 12px; font-size: 0.88rem; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main); cursor: pointer;"
        onchange="this.form.submit()"
      >
        <option value="todos">Todas las categorías</option>
        <?php foreach ($categorias as $cat): ?>
          <option value="<?= htmlspecialchars($cat['id']) ?>" <?= $catFiltro === $cat['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <select 
        name="estado" 
        style="padding: 9px 12px; font-size: 0.88rem; border-radius: 8px; border: 1px solid var(--border-light); background: var(--bg-card); color: var(--text-main); cursor: pointer;"
        onchange="this.form.submit()"
      >
        <option value="todos" <?= $estado === 'todos' ? 'selected' : '' ?>>Todos los estados</option>
        <option value="activos" <?= $estado === 'activos' ? 'selected' : '' ?>>Solo Activos</option>
        <option value="inactivos" <?= $estado === 'inactivos' ? 'selected' : '' ?>>Solo Pausados</option>
        <option value="destacados" <?= $estado === 'destacados' ? 'selected' : '' ?>>Solo Destacados</option>
      </select>
    </div>

    <button type="submit" class="btn btn-outline" style="padding: 8px 16px; font-size: 0.85rem;">
      Filtrar
    </button>
    <?php if ($busqueda !== '' || $catFiltro !== 'todos' || $estado !== 'todos'): ?>
      <a href="productores.php" style="font-size: 0.85rem; color: #dc2626; text-decoration: underline; margin-left: 6px;">
        Limpiar filtros
      </a>
    <?php endif; ?>
  </form>
</div>

<!-- Tabla de Productores -->
<div class="card-admin" style="padding: 0; overflow: hidden;">
  <div class="admin-table-wrap" style="border: none; border-radius: 0;">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width: 50px;">ID</th>
          <th style="width: 60px;">Foto</th>
          <th>Nombre y Rubro</th>
          <th>Categoría</th>
          <th>Ubicación & Contacto</th>
          <th style="text-align: center;">Destacado</th>
          <th style="text-align: center;">Estado</th>
          <th style="text-align: right; min-width: 140px;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($productores)): ?>
          <tr>
            <td colspan="8" style="text-align: center; padding: 3rem 1rem; color: var(--text-muted);">
              <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 0.5rem; opacity: 0.5;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
              <div style="font-size: 1rem; font-weight: 600;">No se encontraron productores con los filtros seleccionados</div>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($productores as $p): ?>
            <tr>
              <td style="font-weight: 700; color: var(--text-muted); font-size: 0.8rem;">
                #<?= $p['id'] ?>
              </td>
              <td>
                <img 
                  src="../<?= htmlspecialchars($p['imagen']) ?>" 
                  alt="" 
                  class="thumb-mini" 
                  onerror="this.src='../assets/logo-sanjose.png'"
                >
              </td>
              <td>
                <div style="font-weight: 700; color: var(--text-main); font-size: 0.95rem; margin-bottom: 2px;">
                  <?= htmlspecialchars($p['nombre']) ?>
                </div>
                <div style="font-size: 0.82rem; color: var(--text-muted);">
                  <?= htmlspecialchars($p['rubro']) ?>
                </div>
                <?php if (!empty($p['tag_label'])): ?>
                  <span style="font-size: 0.72rem; display: inline-block; padding: 1px 6px; border-radius: 4px; background: var(--bg-hover); color: var(--text-muted); margin-top: 4px;">
                    <?= htmlspecialchars($p['tag_label']) ?>
                  </span>
                <?php endif; ?>
              </td>
              <td>
                <span class="tag-badge <?= htmlspecialchars($p['tag_class'] ?? 'tag-licores') ?>" style="font-size: 0.72rem;">
                  <?= htmlspecialchars($p['categoria_nombre'] ?? $p['categoria_id']) ?>
                </span>
              </td>
              <td style="font-size: 0.82rem;">
                <div style="color: var(--text-main); margin-bottom: 2px;">
                  📍 <?= htmlspecialchars($p['direccion']) ?>
                </div>
                <div style="color: var(--text-muted);">
                  💬 WA: <?= htmlspecialchars($p['whatsapp']) ?>
                </div>
              </td>
              <td style="text-align: center;">
                <form method="POST" action="productor-acciones.php" style="display: inline;">
                  <input type="hidden" name="csrf" value="<?= $csrf ?>">
                  <input type="hidden" name="accion" value="toggle_destacado">
                  <input type="hidden" name="id" value="<?= $p['id'] ?>">
                  <button type="submit" title="Clic para alternar destacado" style="background: none; border: none; cursor: pointer; font-size: 1.2rem; color: <?= $p['destacado'] ? '#d97706' : '#cbd5e1' ?>;">
                    <?= $p['destacado'] ? '★' : '☆' ?>
                  </button>
                </form>
              </td>
              <td style="text-align: center;">
                <form method="POST" action="productor-acciones.php" style="display: inline;">
                  <input type="hidden" name="csrf" value="<?= $csrf ?>">
                  <input type="hidden" name="accion" value="toggle_activo">
                  <input type="hidden" name="id" value="<?= $p['id'] ?>">
                  <button type="submit" title="Clic para alternar publicación" style="background: none; border: none; cursor: pointer;">
                    <?php if ($p['activo']): ?>
                      <span class="badge-status badge-activo">Activo</span>
                    <?php else: ?>
                      <span class="badge-status badge-inactivo">Pausado</span>
                    <?php endif; ?>
                  </button>
                </form>
              </td>
              <td style="text-align: right;">
                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                  <a href="productor-form.php?id=<?= $p['id'] ?>" class="btn btn-outline btn-sm" title="Modificar datos">
                    Editar
                  </a>
                  <a href="../mapa.php?id=<?= $p['id'] ?>" target="_blank" class="btn btn-outline btn-sm" style="color: #0284c7;" title="Ver en mapa">
                    Ver
                  </a>
                  <a href="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=https://sanjose.tur.ar/hechoensanjose/index.php?productor=<?= $p['id'] ?>" target="_blank" class="btn btn-outline btn-sm" style="color: #7e22ce;" title="Ver y descargar Código QR">
                    QR
                  </a>
                  <form method="POST" action="productor-acciones.php" style="display: inline;" onsubmit="return confirm('¿Seguro que deseás eliminar a <?= htmlspecialchars(addslashes($p['nombre'])) ?>? Esta acción no se puede deshacer.');">
                    <input type="hidden" name="csrf" value="<?= $csrf ?>">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <button type="submit" class="btn btn-danger-soft btn-sm" title="Eliminar productor">
                      ✕
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
