<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • UTILIDADES DE AUTENTICACIÓN Y SESIÓN DEL PANEL
 * ==============================================================================
 */

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_strict_mode', '1');
    ini_set('session.cookie_samesite', 'Lax');
    // ini_set('session.cookie_secure', '1'); // Descomentar en producción si usa HTTPS
    session_start();
}

require_once __DIR__ . '/../config/db.php';

/**
 * Exige que el usuario esté autenticado. Si no, redirige a login.php
 */
function requireAdmin(): void {
    if (empty($_SESSION['admin_user_id'])) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Obtiene o genera un token CSRF para proteger formularios POST
 */
function getCsrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verifica la validez del token CSRF recibido por POST
 */
function verifyCsrfToken(?string $token): bool {
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Almacena un mensaje flash en sesión para mostrarlo en la siguiente vista
 */
function setFlash(string $type, string $message): void {
    $_SESSION['flash_message'] = [
        'type'    => $type, // 'success', 'danger', 'info', 'warning'
        'message' => $message
    ];
}

/**
 * Recupera y limpia el mensaje flash actual
 */
function getFlash(): ?array {
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $flash;
    }
    return null;
}
