<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • DASHBOARD DE GESTIÓN MUNICIPAL
 * ==============================================================================
 */

$pageTitle = 'Dashboard';
require_once __DIR__ . '/header.php';

$pdo = getDBConnection();

// Métricas generales
$totalProductores = (int)$pdo->query("SELECT COUNT(*) FROM `ps_productores`")->fetchColumn();
$totalActivos     = (int)$pdo->query("SELECT COUNT(*) FROM `ps_productores` WHERE `activo` = 1")->fetchColumn();
$totalDestacados  = (int)$pdo->query("SELECT COUNT(*) FROM `ps_productores` WHERE `destacado` = 1")->fetchColumn();
$totalSolicitudes = (int)$pdo->query("SELECT COUNT(*) FROM `ps_solicitudes_inscripcion` WHERE `estado` = 'pendiente'")->fetchColumn();

// Últimos productores modificados
$ultimosProductores = $pdo->query("
    SELECT p.*, c.nombre AS categoria_nombre 
    FROM `ps_productores` p
    LEFT JOIN `ps_categorias` c ON p.categoria_id = c.id
    ORDER BY p.actualizado_en DESC, p.id DESC 
    LIMIT 5
")->fetchAll();

// Estadísticas por categoría para el gráfico
$statsPorCategoria = $pdo->query("
    SELECT c.nombre, COUNT(p.id) as cantidad, c.pin_color 
    FROM `ps_categorias` c 
    LEFT JOIN `ps_productores` p ON c.id = p.categoria_id 
    GROUP BY c.id 
    ORDER BY cantidad DESC
")->fetchAll();

// Últimas solicitudes recibidas
$ultimasSolicitudes = $pdo->query("
    SELECT * FROM `ps_solicitudes_inscripcion` 
    ORDER BY `creado_en` DESC 
    LIMIT 5
")->fetchAll();
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
  <div>
    <h2 style="font-size: 1.7rem; color: var(--text-main, #0f172a); margin: 0 0 0.35rem 0; font-weight: 800;">
      Resumen del Programa Productivo
    </h2>
    <p style="color: var(--text-muted, #64748b); margin: 0; font-size: 0.95rem;">
      Gestión centralizada del mapa interactivo, catálogo y puntos de venta oficiales.
    </p>
  </div>
  <div style="display: flex; gap: 0.75rem;">
    <a href="productor-form.php" class="btn btn-accent" style="padding: 10px 20px; font-size: 0.9rem;">
      + Cargar Nuevo Productor
    </a>
    <a href="../mapa.php" target="_blank" class="btn btn-outline" style="padding: 10px 18px; font-size: 0.9rem;">
      Ver Mapa &nearr;
    </a>
  </div>
</div>

<!-- Grilla de Métricas -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
  
  <div class="card-admin" style="display: flex; align-items: center; gap: 1.25rem;">
    <div style="width: 52px; height: 52px; border-radius: 12px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center;">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
    </div>
    <div>
      <div style="font-size: 1.8rem; font-weight: 800; color: var(--text-main, #0f172a);"><?= $totalProductores ?></div>
      <div style="font-size: 0.85rem; color: var(--text-muted, #64748b); font-weight: 600;">Productores Registrados</div>
    </div>
  </div>

  <div class="card-admin" style="display: flex; align-items: center; gap: 1.25rem;">
    <div style="width: 52px; height: 52px; border-radius: 12px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center;">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
    </div>
    <div>
      <div style="font-size: 1.8rem; font-weight: 800; color: #059669;"><?= $totalActivos ?></div>
      <div style="font-size: 0.85rem; color: var(--text-muted, #64748b); font-weight: 600;">Activos en Mapa y Catálogo</div>
    </div>
  </div>

  <div class="card-admin" style="display: flex; align-items: center; gap: 1.25rem;">
    <div style="width: 52px; height: 52px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center;">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
    </div>
    <div>
      <div style="font-size: 1.8rem; font-weight: 800; color: #d97706;"><?= $totalDestacados ?></div>
      <div style="font-size: 0.85rem; color: var(--text-muted, #64748b); font-weight: 600;">Establecimientos Destacados</div>
    </div>
  </div>

  <div class="card-admin" style="display: flex; align-items: center; gap: 1.25rem;">
    <div style="width: 52px; height: 52px; border-radius: 12px; background: <?= $totalSolicitudes > 0 ? '#fee2e2' : '#f1f5f9' ?>; color: <?= $totalSolicitudes > 0 ? '#dc2626' : '#64748b' ?>; display: flex; align-items: center; justify-content: center;">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
    </div>
    <div>
      <div style="font-size: 1.8rem; font-weight: 800; color: <?= $totalSolicitudes > 0 ? '#dc2626' : 'var(--text-main, #0f172a)' ?>;"><?= $totalSolicitudes ?></div>
      <div style="font-size: 0.85rem; color: var(--text-muted, #64748b); font-weight: 600;">Solicitudes Pendientes</div>
    </div>
  </div>

</div>

<!-- Gráficos -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem; align-items: stretch;">
  <div class="card-admin" style="padding: 1.5rem;">
    <h3 style="font-size: 1.15rem; color: var(--text-main); margin: 0 0 1rem 0; font-weight: 700;">Productores por Categoría</h3>
    <div style="position: relative; height: 300px; width: 100%;">
      <canvas id="chartCategorias"></canvas>
    </div>
  </div>
  <div class="card-admin" style="padding: 1.5rem;">
    <h3 style="font-size: 1.15rem; color: var(--text-main); margin: 0 0 1rem 0; font-weight: 700;">Estado del Padrón</h3>
    <div style="position: relative; height: 300px; width: 100%; display: flex; justify-content: center;">
      <canvas id="chartEstados"></canvas>
    </div>
  </div>
</div>

<!-- Dos Columnas de Actividad -->
<div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 1.5rem; align-items: start;">
  
  <!-- Productores Recientes -->
  <div class="card-admin">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
      <h3 style="font-size: 1.15rem; color: var(--text-main, #0f172a); margin: 0; font-weight: 700;">
        Productores Actualizados Recientemente
      </h3>
      <a href="productores.php" style="font-size: 0.85rem; color: #0284c7; font-weight: 600; text-decoration: underline;">
        Ver todos los <?= $totalProductores ?> &rarr;
      </a>
    </div>

    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Productor</th>
            <th>Rubro</th>
            <th>Estado</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($ultimosProductores)): ?>
            <tr><td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-muted);">No hay productores registrados.</td></tr>
          <?php else: ?>
            <?php foreach ($ultimosProductores as $p): ?>
              <tr>
                <td>
                  <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="../<?= htmlspecialchars($p['imagen']) ?>" alt="" class="thumb-mini" onerror="this.src='../assets/logo-sanjose.png'">
                    <div>
                      <strong style="color: var(--text-main); font-size: 0.92rem;"><?= htmlspecialchars($p['nombre']) ?></strong>
                      <?php if ($p['destacado']): ?>
                        <span style="color: #d97706; font-size: 0.75rem; margin-left: 4px;" title="Destacado">★</span>
                      <?php endif; ?>
                    </div>
                  </div>
                </td>
                <td style="color: var(--text-muted); font-size: 0.85rem;">
                  <?= htmlspecialchars($p['rubro']) ?>
                </td>
                <td>
                  <?php if ($p['activo']): ?>
                    <span class="badge-status badge-activo">Activo</span>
                  <?php else: ?>
                    <span class="badge-status badge-inactivo">Pausado</span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="productor-form.php?id=<?= $p['id'] ?>" class="btn btn-outline btn-sm">Editar</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Solicitudes Recientes -->
  <div class="card-admin">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
      <h3 style="font-size: 1.15rem; color: var(--text-main, #0f172a); margin: 0; font-weight: 700;">
        Solicitudes de Registro
      </h3>
      <a href="solicitudes.php" style="font-size: 0.85rem; color: #0284c7; font-weight: 600; text-decoration: underline;">
        Ver bandeja (<?= $totalSolicitudes ?>) &rarr;
      </a>
    </div>

    <?php if (empty($ultimasSolicitudes)): ?>
      <div style="text-align: center; padding: 2.5rem 1rem; color: var(--text-muted); font-size: 0.9rem;">
        No hay solicitudes recibidas por el momento.
      </div>
    <?php else: ?>
      <div style="display: flex; flex-direction: column; gap: 0.75rem;">
        <?php foreach ($ultimasSolicitudes as $sol): ?>
          <div style="padding: 1rem; border-radius: 10px; border: 1px solid var(--border-light); background: var(--bg-hover, #f8fafc);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px;">
              <strong style="color: var(--text-main); font-size: 0.92rem;"><?= htmlspecialchars($sol['nombre_emprendimiento']) ?></strong>
              <span style="font-size: 0.72rem; padding: 2px 6px; border-radius: 4px; font-weight: 700; background: <?= $sol['estado'] === 'pendiente' ? '#fee2e2; color: #dc2626;' : '#e0f2fe; color: #0284c7;' ?>">
                <?= ucfirst($sol['estado']) ?>
              </span>
            </div>
            <div style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 8px;">
              Titular: <?= htmlspecialchars($sol['nombre_titular']) ?> &bull; WhatsApp: <?= htmlspecialchars($sol['whatsapp']) ?>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 6px;">
              <a href="solicitudes.php" class="btn btn-outline btn-sm">Ver Detalle</a>
              <?php if ($sol['estado'] === 'pendiente'): ?>
                <a href="productor-form.php?from_solicitud=<?= $sol['id'] ?>" class="btn btn-accent btn-sm">Aprobar</a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.body.classList.contains('dark-theme');
    const textColor = isDark ? '#f8fafc' : '#0f172a';
    const gridColor = isDark ? '#334155' : '#e2e8f0';

    Chart.defaults.color = textColor;
    Chart.defaults.font.family = "'Inter', system-ui, sans-serif";

    // Datos Categorías
    const catLabels = <?= json_encode(array_column($statsPorCategoria, 'nombre')) ?>;
    const catData = <?= json_encode(array_column($statsPorCategoria, 'cantidad')) ?>;
    const catColors = <?= json_encode(array_column($statsPorCategoria, 'pin_color')) ?>;

    new Chart(document.getElementById('chartCategorias'), {
      type: 'bar',
      data: {
        labels: catLabels,
        datasets: [{
          label: 'Productores',
          data: catData,
          backgroundColor: catColors,
          borderRadius: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: { 
            beginAtZero: true,
            ticks: { stepSize: 1 },
            grid: { color: gridColor }
          },
          x: {
            grid: { display: false }
          }
        }
      }
    });

    // Datos Estados
    new Chart(document.getElementById('chartEstados'), {
      type: 'doughnut',
      data: {
        labels: ['Activos', 'Inactivos'],
        datasets: [{
          data: [<?= $totalActivos ?>, <?= $totalProductores - $totalActivos ?>],
          backgroundColor: ['#10b981', '#94a3b8'],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
          legend: { position: 'bottom' }
        }
      }
    });
  });
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
