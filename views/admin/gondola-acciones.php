<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • ACCIONES RÁPIDAS DE GÓNDOLA (TOGGLE / ELIMINACIÓN)
 * ==============================================================================
 */

require_once __DIR__ . '/auth.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: gondolas.php');
    exit;
}

$csrf   = $_POST['csrf'] ?? '';
$accion = $_POST['accion'] ?? '';
$id     = (int)($_POST['id'] ?? 0);

if (!verifyCsrfToken($csrf)) {
    setFlash('danger', 'Token de seguridad inválido o expirado. Intentá nuevamente.');
    header('Location: gondolas.php');
    exit;
}

if ($id <= 0) {
    setFlash('danger', 'ID de góndola inválido.');
    header('Location: gondolas.php');
    exit;
}

require_once __DIR__ . '/../../models/GondolaRepository.php';
$repo = new GondolaRepository();

try {
    if ($accion === 'toggle_activo') {
        $repo->toggleActivo($id);
        setFlash('success', 'Estado de publicación de la góndola actualizado con éxito.');

    } elseif ($accion === 'toggle_destacado') {
        $repo->toggleDestacado($id);
        setFlash('success', 'Estado de punto destacado actualizado con éxito.');

    } elseif ($accion === 'eliminar') {
        $gondola = $repo->getById($id);
        if ($gondola) {
            $repo->delete($id);
            setFlash('success', 'La góndola en «' . $gondola['nombre'] . '» fue eliminada correctamente.');
        } else {
            setFlash('danger', 'La góndola seleccionada no existe.');
        }
    } else {
        setFlash('warning', 'Acción no reconocida.');
    }
} catch (Throwable $e) {
    error_log("Error en gondola-acciones: " . $e->getMessage());
    setFlash('danger', 'Ocurrió un error al procesar la acción: ' . $e->getMessage());
}

$referer = $_SERVER['HTTP_REFERER'] ?? 'gondolas.php';
header('Location: ' . $referer);
exit;
