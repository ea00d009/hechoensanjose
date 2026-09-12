<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • ACCIONES RÁPIDAS DE PRODUCTOR (TOGGLE / ELIMINACIÓN)
 * ==============================================================================
 */

require_once __DIR__ . '/auth.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: productores.php');
    exit;
}

$csrf   = $_POST['csrf'] ?? '';
$accion = $_POST['accion'] ?? '';
$id     = (int)($_POST['id'] ?? 0);

if (!verifyCsrfToken($csrf)) {
    setFlash('danger', 'Token de seguridad inválido o expirado. Intentá nuevamente.');
    header('Location: productores.php');
    exit;
}

if ($id <= 0) {
    setFlash('danger', 'ID de productor inválido.');
    header('Location: productores.php');
    exit;
}

$pdo = getDBConnection();

try {
    if ($accion === 'toggle_activo') {
        $stmt = $pdo->prepare("UPDATE `ps_productores` SET `activo` = IF(`activo`=1, 0, 1) WHERE `id` = :id");
        $stmt->execute([':id' => $id]);
        setFlash('success', 'Estado de publicación actualizado con éxito.');

    } elseif ($accion === 'toggle_destacado') {
        $stmt = $pdo->prepare("UPDATE `ps_productores` SET `destacado` = IF(`destacado`=1, 0, 1) WHERE `id` = :id");
        $stmt->execute([':id' => $id]);
        setFlash('success', 'Estado de destacado actualizado con éxito.');

    } elseif ($accion === 'eliminar') {
        // Obtener nombre e imagen antes de borrar
        $infoStmt = $pdo->prepare("SELECT `nombre`, `imagen` FROM `ps_productores` WHERE `id` = :id");
        $infoStmt->execute([':id' => $id]);
        $prod = $infoStmt->fetch();

        if ($prod) {
            $stmt = $pdo->prepare("DELETE FROM `ps_productores` WHERE `id` = :id");
            $stmt->execute([':id' => $id]);
            setFlash('success', 'El productor "' . $prod['nombre'] . '" fue eliminado correctamente.');
        } else {
            setFlash('danger', 'El productor seleccionado no existe.');
        }
    }
} catch (Throwable $e) {
    error_log("Error en productor-acciones: " . $e->getMessage());
    setFlash('danger', 'Ocurrió un error interno al procesar la acción. Por favor, intentá más tarde.');
}

$referer = $_SERVER['HTTP_REFERER'] ?? 'productores.php';
header('Location: ' . $referer);
exit;
