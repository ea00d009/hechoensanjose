<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • GESTIÓN DE CATEGORÍAS
 * ==============================================================================
 */

require_once __DIR__ . '/auth.php';
requireAdmin();

$pdo = getDBConnection();

// Procesar acciones (alta, edición, borrado)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!verifyCsrfToken($_POST['csrf'] ?? '')) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Token de seguridad inválido.'];
        header('Location: categorias.php');
        exit;
    }

    $action = $_POST['action'];
    $id = trim($_POST['id'] ?? '');

    if ($action === 'delete') {
        // Validar si hay productores con esta categoría
        $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM `ps_productores` WHERE `categoria_id` = :id");
        $stmtCheck->execute([':id' => $id]);
        if ($stmtCheck->fetchColumn() > 0) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'No se puede eliminar la categoría porque hay productores usándola.'];
        } else {
            $stmtDel = $pdo->prepare("DELETE FROM `ps_categorias` WHERE `id` = :id");
            $stmtDel->execute([':id' => $id]);
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Categoría eliminada exitosamente.'];
        }
        header('Location: categorias.php');
        exit;
    }

    $nombre = trim($_POST['nombre'] ?? '');
    $tag_label = trim($_POST['tag_label'] ?? '');
    $tag_class = trim($_POST['tag_class'] ?? '');
    $pin_color = trim($_POST['pin_color'] ?? '');
    $orden = (int)($_POST['orden'] ?? 0);
    
    // SVG Handling (Evitar Wordfence bloqueando textarea con HTML)
    $icono_svg = '';
    
    // Si estamos editando, recuperar el SVG existente de la BD para no perderlo
    if ($action === 'edit') {
        $original_id = trim($_POST['original_id'] ?? '');
        $stmtExisting = $pdo->prepare("SELECT `icono_svg` FROM `ps_categorias` WHERE `id` = :id");
        $stmtExisting->execute([':id' => $original_id]);
        $icono_svg = $stmtExisting->fetchColumn() ?: '';
    }

    if (isset($_FILES['icono_archivo']) && $_FILES['icono_archivo']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['icono_archivo']['tmp_name'];
        $file_ext = strtolower(pathinfo($_FILES['icono_archivo']['name'], PATHINFO_EXTENSION));
        if ($file_ext === 'svg') {
            $icono_svg = file_get_contents($file_tmp);
        }
    }
    
    // Default SVG if completely empty on Add
    if ($action === 'add' && empty($icono_svg)) {
        $icono_svg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>';
    }

    if (empty($id) || empty($nombre) || empty($tag_label) || empty($tag_class) || empty($pin_color)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Por favor completa todos los campos requeridos.'];
    } else {
        try {
            if ($action === 'add') {
                $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM `ps_categorias` WHERE `id` = :id");
                $stmtCheck->execute([':id' => $id]);
                if ($stmtCheck->fetchColumn() > 0) {
                    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'El ID de categoría ya existe. Elige otro.'];
                } else {
                    $stmt = $pdo->prepare("INSERT INTO `ps_categorias` (`id`, `nombre`, `tag_label`, `tag_class`, `pin_color`, `icono_svg`, `orden`) VALUES (:id, :nombre, :tag_label, :tag_class, :pin_color, :icono_svg, :orden)");
                    $stmt->execute([
                        ':id' => $id,
                        ':nombre' => $nombre,
                        ':tag_label' => $tag_label,
                        ':tag_class' => $tag_class,
                        ':pin_color' => $pin_color,
                        ':icono_svg' => $icono_svg,
                        ':orden' => $orden
                    ]);
                    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Categoría agregada exitosamente.'];
                    header('Location: categorias.php');
                    exit;
                }
            } elseif ($action === 'edit') {
                $original_id = trim($_POST['original_id'] ?? '');
                
                // Si el ID cambió, actualizar a los productores
                if ($id !== $original_id) {
                    $pdo->beginTransaction();
                    $stmt = $pdo->prepare("INSERT INTO `ps_categorias` (`id`, `nombre`, `tag_label`, `tag_class`, `pin_color`, `icono_svg`, `orden`) VALUES (:id, :nombre, :tag_label, :tag_class, :pin_color, :icono_svg, :orden)");
                    $stmt->execute([
                        ':id' => $id,
                        ':nombre' => $nombre,
                        ':tag_label' => $tag_label,
                        ':tag_class' => $tag_class,
                        ':pin_color' => $pin_color,
                        ':icono_svg' => $icono_svg,
                        ':orden' => $orden
                    ]);
                    $pdo->prepare("UPDATE `ps_productores` SET `categoria_id` = :new_id WHERE `categoria_id` = :old_id")->execute([':new_id' => $id, ':old_id' => $original_id]);
                    $pdo->prepare("DELETE FROM `ps_categorias` WHERE `id` = :old_id")->execute([':old_id' => $original_id]);
                    $pdo->commit();
                } else {
                    $stmt = $pdo->prepare("UPDATE `ps_categorias` SET `nombre` = :nombre, `tag_label` = :tag_label, `tag_class` = :tag_class, `pin_color` = :pin_color, `icono_svg` = :icono_svg, `orden` = :orden WHERE `id` = :id");
                    $stmt->execute([
                        ':id' => $id,
                        ':nombre' => $nombre,
                        ':tag_label' => $tag_label,
                        ':tag_class' => $tag_class,
                        ':pin_color' => $pin_color,
                        ':icono_svg' => $icono_svg,
                        ':orden' => $orden
                    ]);
                }
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Categoría actualizada exitosamente.'];
                header('Location: categorias.php');
                exit;
            }
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Error al guardar la categoría: ' . $e->getMessage()];
        }
    }
}

// Cargar categoría para edición
$editCat = null;
if (isset($_GET['edit'])) {
    $stmtEdit = $pdo->prepare("SELECT * FROM `ps_categorias` WHERE `id` = :id");
    $stmtEdit->execute([':id' => $_GET['edit']]);
    $editCat = $stmtEdit->fetch();
}

$isEditing = $editCat !== null && $editCat !== false;

// Obtener categorías existentes
$categorias = $pdo->query("SELECT * FROM `ps_categorias` ORDER BY `orden` ASC")->fetchAll();

$pageTitle = 'Gestión de Categorías';
require_once __DIR__ . '/header.php';
?>

<div class="admin-page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
  <div>
    <h2 style="margin: 0; font-size: 1.5rem; color: var(--text-main);">Categorías Oficiales</h2>
    <p style="margin: 0.25rem 0 0 0; color: var(--text-muted); font-size: 0.9rem;">
      Administra los rubros y categorías que aparecerán en el mapa y catálogo.
    </p>
  </div>
</div>

<div class="admin-grid" style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; align-items: start;">
    <!-- Columna Izquierda: Formulario -->
    <div class="admin-card" style="background: var(--bg-card); padding: 1.5rem; border-radius: 12px; border: 1px solid var(--border-light); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <h3 style="margin-top: 0; margin-bottom: 1.25rem; font-size: 1.1rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">
            <?= $isEditing ? 'Editar Categoría' : 'Agregar Nueva Categoría' ?>
        </h3>
        
        <form method="POST" action="categorias.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?= $isEditing ? 'edit' : 'add' ?>">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(getCsrfToken()) ?>">
            <?php if ($isEditing): ?>
                <input type="hidden" name="original_id" value="<?= htmlspecialchars($editCat['id']) ?>">
            <?php endif; ?>
            
            <div class="form-group" style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.35rem;">ID (Identificador Único)</label>
                <input type="text" id="cat_id" name="id" value="<?= $isEditing ? htmlspecialchars($editCat['id']) : '' ?>" class="form-control" placeholder="ej: conservas, panaderia" required style="width: 100%; padding: 0.6rem; border-radius: 6px; border: 1px solid var(--border-light); background: var(--bg-body); color: var(--text-main);">
                <small style="color: var(--text-muted); font-size: 0.75rem; display: block; margin-top: 4px;">Sin espacios ni caracteres especiales.</small>
            </div>

            <div class="form-group" style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.35rem;">Nombre Completo</label>
                <input type="text" name="nombre" value="<?= $isEditing ? htmlspecialchars($editCat['nombre']) : '' ?>" class="form-control" placeholder="ej: Panadería & Pastelería" required style="width: 100%; padding: 0.6rem; border-radius: 6px; border: 1px solid var(--border-light); background: var(--bg-body); color: var(--text-main);">
            </div>

            <div class="form-group" style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.35rem;">Etiqueta (Tag Label)</label>
                <input type="text" name="tag_label" value="<?= $isEditing ? htmlspecialchars($editCat['tag_label']) : '' ?>" class="form-control" placeholder="ej: Sabores Locales" required style="width: 100%; padding: 0.6rem; border-radius: 6px; border: 1px solid var(--border-light); background: var(--bg-body); color: var(--text-main);">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.35rem;">Clase CSS (Automático)</label>
                    <input type="text" id="cat_tag_class" name="tag_class" value="<?= $isEditing ? htmlspecialchars($editCat['tag_class']) : '' ?>" class="form-control" placeholder="ej: tag-miel" required readonly style="width: 100%; padding: 0.6rem; border-radius: 6px; border: 1px solid var(--border-light); background: #f1f5f9; color: var(--text-muted);">
                </div>
                <div class="form-group">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.35rem;">Color Principal</label>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="color" name="pin_color" value="<?= $isEditing ? htmlspecialchars($editCat['pin_color']) : '#d97706' ?>" style="width: 40px; height: 38px; padding: 0; border: 1px solid var(--border-light); border-radius: 6px; cursor: pointer; background: var(--bg-body);">
                        <small style="color: var(--text-muted); font-size: 0.75rem;">Haz clic para elegir</small>
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.35rem;">Icono (Archivo SVG)</label>
                <input type="file" name="icono_archivo" accept=".svg" style="width: 100%; padding: 0.4rem; border-radius: 6px; border: 1px solid var(--border-light); background: var(--bg-body); color: var(--text-main); font-size: 0.85rem; margin-bottom: 0.5rem;">
                <?php if ($isEditing && !empty($editCat['icono_svg'])): ?>
                    <small style="color: var(--text-muted); font-size: 0.75rem;">Si no subes un archivo, se mantendrá el ícono actual.</small>
                <?php endif; ?>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.35rem;">Orden</label>
                <input type="number" name="orden" value="<?= $isEditing ? htmlspecialchars($editCat['orden']) : '0' ?>" class="form-control" required style="width: 100%; padding: 0.6rem; border-radius: 6px; border: 1px solid var(--border-light); background: var(--bg-body); color: var(--text-main);">
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn btn-accent" style="flex: 1; padding: 0.75rem; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; background: #0284c7; color: white;">
                    <?= $isEditing ? 'Guardar Cambios' : 'Agregar Categoría' ?>
                </button>
                <?php if ($isEditing): ?>
                    <a href="categorias.php" class="btn btn-outline" style="padding: 0.75rem; border-radius: 6px; font-weight: 600; text-align: center;">Cancelar</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Columna Derecha: Listado -->
    <div class="admin-card" style="background: var(--bg-card); padding: 1.5rem; border-radius: 12px; border: 1px solid var(--border-light); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <h3 style="margin-top: 0; margin-bottom: 1.25rem; font-size: 1.1rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">Categorías Existentes</h3>
        
        <div class="table-responsive">
            <table class="admin-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-light); color: var(--text-muted); font-size: 0.85rem;">
                        <th style="padding: 0.75rem 0.5rem;">Icono</th>
                        <th style="padding: 0.75rem 0.5rem;">Nombre</th>
                        <th style="padding: 0.75rem 0.5rem;">Etiqueta (Color)</th>
                        <th style="padding: 0.75rem 0.5rem; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categorias)): ?>
                    <tr>
                        <td colspan="4" style="padding: 1rem; text-align: center; color: var(--text-muted);">No hay categorías registradas.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($categorias as $cat): ?>
                        <tr style="border-bottom: 1px solid var(--border-light);">
                            <td style="padding: 0.75rem 0.5rem;">
                                <div style="width: 32px; height: 32px; border-radius: 8px; background: <?= htmlspecialchars($cat['pin_color']) ?>; display: flex; align-items: center; justify-content: center; color: white;">
                                    <?= $cat['icono_svg'] // SVG se imprime directo ?>
                                </div>
                            </td>
                            <td style="padding: 0.75rem 0.5rem;">
                                <div style="color: var(--text-main); font-weight: 600; font-size: 0.9rem;"><?= htmlspecialchars($cat['nombre']) ?></div>
                                <div style="font-family: monospace; font-size: 0.75rem; color: var(--text-muted);">ID: <?= htmlspecialchars($cat['id']) ?></div>
                            </td>
                            <td style="padding: 0.75rem 0.5rem;">
                                <span style="display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; background: <?= htmlspecialchars($cat['pin_color']) ?>20; color: <?= htmlspecialchars($cat['pin_color']) ?>; border: 1px solid <?= htmlspecialchars($cat['pin_color']) ?>40;">
                                    <?= htmlspecialchars($cat['tag_label']) ?>
                                </span>
                            </td>
                            <td style="padding: 0.75rem 0.5rem; text-align: center;">
                                <div style="display: flex; gap: 4px; justify-content: center;">
                                    <a href="categorias.php?edit=<?= htmlspecialchars($cat['id']) ?>" class="btn btn-outline btn-sm" style="padding: 4px 8px; font-size: 0.75rem;">Editar</a>
                                    
                                    <form method="POST" action="categorias.php" style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría? Si hay productores asociados, la acción será rechazada.');">
                                        <input type="hidden" name="csrf" value="<?= htmlspecialchars(getCsrfToken()) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($cat['id']) ?>">
                                        <button type="submit" class="btn btn-danger-soft btn-sm" style="padding: 4px 8px; font-size: 0.75rem; border: none; background: #fee2e2; color: #dc2626; border-radius: 6px; cursor: pointer;">Eliminar</button>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const idInput = document.getElementById('cat_id');
    const classInput = document.getElementById('cat_tag_class');

    if (idInput && classInput) {
        idInput.addEventListener('input', function() {
            // Solo auto-completar si no se está editando (para no cambiar clases de categorías existentes a menos que cambien su ID)
            const slug = this.value.toLowerCase().replace(/[^a-z0-9]/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
            if (slug) {
                classInput.value = 'tag-' + slug;
            } else {
                classInput.value = '';
            }
        });
    }
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
