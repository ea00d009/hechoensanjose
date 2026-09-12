<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • BANDEJA DE SOLICITUDES DE INSCRIPCIÓN
 * ==============================================================================
 */

require_once __DIR__ . '/auth.php';
requireAdmin();

$pdo = getDBConnection();

// Procesar cambio de estado rápido (desestimar / restaurar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf'] ?? '';
    if (verifyCsrfToken($csrf)) {
        $sid = (int)($_POST['solicitud_id'] ?? 0);
        $nuevoEstado = $_POST['nuevo_estado'] ?? '';
        if ($sid > 0 && in_array($nuevoEstado, ['pendiente', 'desestimada'])) {
            $stmt = $pdo->prepare("UPDATE `ps_solicitudes_inscripcion` SET `estado` = :est WHERE `id` = :id");
            $stmt->execute([':est' => $nuevoEstado, ':id' => $sid]);
            setFlash('success', 'El estado de la solicitud #' . $sid . ' fue actualizado a "' . $nuevoEstado . '".');
            header('Location: solicitudes.php');
            exit;
        }
    }
}

$filtroEstado = $_GET['estado'] ?? 'pendiente';

$sql = "SELECT * FROM `ps_solicitudes_inscripcion` WHERE 1=1";
$params = [];

if ($filtroEstado !== 'todas') {
    $sql .= " AND `estado` = :est";
    $params[':est'] = $filtroEstado;
}

$sql .= " ORDER BY `creado_en` DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$solicitudes = $stmt->fetchAll();

$csrf = getCsrfToken();

$pageTitle = 'Solicitudes de Inscripción';
require_once __DIR__ . '/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
  <div>
    <h2 style="font-size: 1.6rem; color: var(--text-main, #0f172a); margin: 0 0 0.35rem 0; font-weight: 800;">
      Bandeja de Solicitudes de Inscripción
    </h2>
    <p style="color: var(--text-muted, #64748b); margin: 0; font-size: 0.9rem;">
      Emprendedores y productores que completaron el formulario digital público en inscribir.php.
    </p>
  </div>
  <div>
    <a href="exportar-csv.php?tipo=solicitudes" class="btn btn-outline" style="padding: 10px 16px; font-size: 0.92rem; color: #059669; border-color: #059669;">
      ⬇️ Exportar CSV
    </a>
  </div>
</div>

<!-- Filtro por Estado -->
<div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">
  <a href="solicitudes.php?estado=pendiente" class="admin-nav-item <?= $filtroEstado === 'pendiente' ? 'active' : '' ?>">
    Pendientes de Revisión
  </a>
  <a href="solicitudes.php?estado=aprobada" class="admin-nav-item <?= $filtroEstado === 'aprobada' ? 'active' : '' ?>">
    Aprobadas (En Padrón)
  </a>
  <a href="solicitudes.php?estado=desestimada" class="admin-nav-item <?= $filtroEstado === 'desestimada' ? 'active' : '' ?>">
    Desestimadas
  </a>
  <a href="solicitudes.php?estado=todas" class="admin-nav-item <?= $filtroEstado === 'todas' ? 'active' : '' ?>">
    Todas las solicitudes
  </a>
</div>

<?php if (empty($solicitudes)): ?>
  <div class="card-admin" style="text-align: center; padding: 4rem 1rem; color: var(--text-muted);">
    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 1rem; opacity: 0.5;"><path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h9"/><path d="M22 17v6"/><path d="M19 20h6"/></svg>
    <h3 style="font-size: 1.1rem; color: var(--text-main); margin-bottom: 0.5rem;">No hay solicitudes en esta sección</h3>
    <p style="font-size: 0.88rem; margin: 0;">Las nuevas inscripciones que completen los vecinos en inscribir.php aparecerán acá en tiempo real.</p>
  </div>
<?php else: ?>
  <div style="display: flex; flex-direction: column; gap: 1.25rem;">
    <?php foreach ($solicitudes as $sol): ?>
      <div class="card-admin" style="margin-bottom: 0; border-left: 4px solid <?= $sol['estado'] === 'pendiente' ? '#f59e0b' : ($sol['estado'] === 'aprobada' ? '#10b981' : '#94a3b8') ?>;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.75rem;">
          <div>
            <span style="font-size: 0.78rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">
              Solicitud #<?= $sol['id'] ?> &bull; <?= date('d/m/Y H:i', strtotime($sol['creado_en'])) ?>
            </span>
            <h3 style="font-size: 1.3rem; color: var(--text-main); margin: 4px 0 2px 0; font-weight: 800;">
              <?= htmlspecialchars($sol['nombre_emprendimiento']) ?>
            </h3>
            <div style="font-size: 0.9rem; color: #0284c7; font-weight: 600;">
              <?= htmlspecialchars($sol['rubro']) ?>
            </div>
          </div>

          <div style="display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 0.8rem; padding: 4px 10px; border-radius: 6px; font-weight: 700; text-transform: uppercase; background: <?= $sol['estado'] === 'pendiente' ? '#fef3c7; color: #b45309;' : ($sol['estado'] === 'aprobada' ? '#ecfdf5; color: #059669;' : '#f1f5f9; color: #64748b;') ?>">
              <?= ucfirst($sol['estado']) ?>
            </span>
          </div>
        </div>

        <!-- Detalles de Contacto y Dirección -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; padding: 1rem; border-radius: 8px; background: var(--bg-hover); margin-bottom: 1rem; font-size: 0.88rem;">
          <div>
            <div style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">Titular Responsable</div>
            <div style="color: var(--text-main); font-weight: 600;"><?= htmlspecialchars($sol['nombre_titular']) ?></div>
          </div>
          <div>
            <div style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">Contacto WhatsApp</div>
            <div>
              <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $sol['whatsapp']) ?>?text=<?= urlencode('Hola ' . $sol['nombre_titular'] . ', nos comunicamos desde la Secretaría de Educación, Cultura y Turismo de San José en relación a tu solicitud de inscripción al programa Hecho en San José.') ?>" target="_blank" style="color: #059669; font-weight: 700; text-decoration: underline;">
                💬 <?= htmlspecialchars($sol['whatsapp']) ?> &nearr;
              </a>
            </div>
          </div>
          <div>
            <div style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">Correo Electrónico</div>
            <div style="color: var(--text-main);"><?= htmlspecialchars($sol['email'] ?: 'No informado') ?></div>
          </div>
          <div>
            <div style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">Dirección / Taller</div>
            <div style="color: var(--text-main); font-weight: 600;">📍 <?= htmlspecialchars($sol['direccion']) ?></div>
          </div>
        </div>

        <!-- Descripción -->
        <div style="margin-bottom: 1.25rem;">
          <div style="color: var(--text-muted); font-size: 0.8rem; font-weight: 700; margin-bottom: 4px;">Descripción de productos y materias primas locales:</div>
          <div style="font-size: 0.92rem; color: var(--text-main); line-height: 1.5; background: var(--bg-card); padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid var(--border-light);">
            <?= nl2br(htmlspecialchars($sol['descripcion'])) ?>
          </div>
        </div>

        <!-- Módulos de Interés -->
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1.25rem;">
          <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; display: flex; align-items: center; margin-right: 4px;">Le interesa:</span>
          <?php if ($sol['interes_catalogo']): ?>
            <span style="font-size: 0.72rem; padding: 2px 8px; border-radius: 12px; background: #e0f2fe; color: #0284c7; font-weight: 600;">🛍️ Catálogo Web</span>
          <?php endif; ?>
          <?php if ($sol['interes_mapa']): ?>
            <span style="font-size: 0.72rem; padding: 2px 8px; border-radius: 12px; background: #ecfdf5; color: #059669; font-weight: 600;">📍 Mapa Productivo</span>
          <?php endif; ?>
          <?php if ($sol['interes_gondola']): ?>
            <span style="font-size: 0.72rem; padding: 2px 8px; border-radius: 12px; background: #fef3c7; color: #b45309; font-weight: 600;">🛒 Góndolas</span>
          <?php endif; ?>
          <?php if ($sol['interes_ferias']): ?>
            <span style="font-size: 0.72rem; padding: 2px 8px; border-radius: 12px; background: #f3e8ff; color: #7e22ce; font-weight: 600;">🎪 Ferias</span>
          <?php endif; ?>
        </div>

        <!-- Acciones del Administrador -->
        <div style="border-top: 1px solid var(--border-light); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
          <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $sol['whatsapp']) ?>?text=<?= urlencode('Hola ' . $sol['nombre_titular'] . ', nos comunicamos desde la Secretaría de Turismo de la Municipalidad de San José.') ?>" target="_blank" class="btn btn-outline btn-sm" style="color: #059669;">
            Enviar WhatsApp &nearr;
          </a>

          <div style="display: flex; gap: 0.5rem;">
            <?php if ($sol['estado'] === 'pendiente'): ?>
              <form method="POST" action="solicitudes.php" style="display: inline;" onsubmit="return confirm('¿Marcar como desestimada esta solicitud?');">
                <input type="hidden" name="csrf" value="<?= $csrf ?>">
                <input type="hidden" name="solicitud_id" value="<?= $sol['id'] ?>">
                <input type="hidden" name="nuevo_estado" value="desestimada">
                <button type="submit" class="btn btn-danger-soft btn-sm">
                  Desestimar
                </button>
              </form>

              <a href="productor-form.php?from_solicitud=<?= $sol['id'] ?>" class="btn btn-accent btn-sm" style="padding: 8px 16px; font-weight: 700;">
                ✓ Aprobar y Convertir en Productor
              </a>
            <?php elseif ($sol['estado'] === 'desestimada'): ?>
              <form method="POST" action="solicitudes.php" style="display: inline;">
                <input type="hidden" name="csrf" value="<?= $csrf ?>">
                <input type="hidden" name="solicitud_id" value="<?= $sol['id'] ?>">
                <input type="hidden" name="nuevo_estado" value="pendiente">
                <button type="submit" class="btn btn-outline btn-sm">
                  Restaurar a Pendiente
                </button>
              </form>
            <?php endif; ?>
          </div>
        </div>

      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
