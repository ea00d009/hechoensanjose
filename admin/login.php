<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • INICIO DE SESIÓN ADMINISTRATIVO
 * ==============================================================================
 */

require_once __DIR__ . '/auth.php';

// Si ya tiene sesión activa, va directo al dashboard
if (!empty($_SESSION['admin_user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$usuario = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf'] ?? '';
    if (!verifyCsrfToken($token)) {
        $error = 'Token de seguridad inválido o expirado. Por favor, intentá nuevamente.';
    } else {
        $usuario  = trim($_POST['usuario'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($usuario) || empty($password)) {
            $error = 'Por favor ingresá tu nombre de usuario y contraseña.';
        } else {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("SELECT * FROM `ps_usuarios_admin` WHERE `usuario` = :usuario LIMIT 1");
            $stmt->execute([':usuario' => $usuario]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                // Prevenir Session Fixation
                session_regenerate_id(true);
                
                // Contraseña válida: iniciar sesión
                $_SESSION['admin_user_id']  = (int)$user['id'];
                $_SESSION['admin_username'] = $user['usuario'];
                $_SESSION['admin_nombre']   = $user['nombre'];

                // Actualizar timestamp de último login
                $updateStmt = $pdo->prepare("UPDATE `ps_usuarios_admin` SET `ultimo_login` = NOW() WHERE `id` = :id");
                $updateStmt->execute([':id' => $user['id']]);

                header('Location: index.php');
                exit;
            } else {
                $error = 'Usuario o contraseña incorrectos. Verificá los datos ingresados.';
            }
        } catch (Throwable $e) {
            error_log("Error en login.php: " . $e->getMessage());
            $error = 'Error de Servidor/Base de Datos: ' . $e->getMessage();
        }
    }
    }
}

$csrf = getCsrfToken();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acceso Administrativo &bull; Hecho en San José</title>
  <link rel="stylesheet" href="../style.css">
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
    .login-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      background: var(--bg-body, #f8fafc);
    }
    .login-card {
      width: 100%;
      max-width: 440px;
      background: var(--bg-card, #ffffff);
      border: 1px solid var(--border-light, #e2e8f0);
      border-radius: 16px;
      padding: 2.5rem 2rem;
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.07);
    }
    .login-logo {
      text-align: center;
      margin-bottom: 1.75rem;
    }
    .login-logo img {
      height: 64px;
      margin-bottom: 0.75rem;
    }
    .login-logo h2 {
      font-size: 1.4rem;
      color: var(--text-main, #0f172a);
      margin: 0;
      font-weight: 800;
    }
    .login-logo p {
      color: var(--text-muted, #64748b);
      font-size: 0.85rem;
      margin-top: 0.35rem;
    }
    .form-group {
      margin-bottom: 1.25rem;
    }
    .form-group label {
      display: block;
      font-size: 0.85rem;
      font-weight: 700;
      color: var(--text-main, #1e293b);
      margin-bottom: 0.35rem;
    }
    .form-input {
      width: 100%;
      padding: 0.75rem 1rem;
      border-radius: 8px;
      border: 1px solid var(--border-light, #cbd5e1);
      font-size: 0.95rem;
      background: var(--bg-card, #ffffff);
      color: var(--text-main, #0f172a);
      box-sizing: border-box;
      transition: border-color 0.2s;
    }
    .form-input:focus {
      outline: none;
      border-color: #0284c7;
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
    }
    .alert-error {
      background: #fef2f2;
      border: 1px solid #fecaca;
      color: #991b1b;
      padding: 0.85rem 1rem;
      border-radius: 8px;
      font-size: 0.88rem;
      margin-bottom: 1.25rem;
      line-height: 1.4;
    }
    .login-hint {
      margin-top: 1.5rem;
      padding-top: 1.25rem;
      border-top: 1px dashed var(--border-light, #e2e8f0);
      font-size: 0.8rem;
      color: var(--text-muted, #64748b);
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <div class="login-card">
      <div class="login-logo">
        <a href="../index.php" title="Volver al portal">
          <img src="../assets/logo-sanjose.png" alt="Municipalidad de San José">
        </a>
        <h2>Panel de Gestión</h2>
        <p>Hecho en San José &bull; Administración de Productores</p>
      </div>

      <?php if (!empty($error)): ?>
        <div class="alert-error">
          <strong>⚠ Error:</strong> <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="login.php" autocomplete="off">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
        <div class="form-group">
          <label for="usuario">Usuario Municipal</label>
          <input 
            type="text" 
            id="usuario" 
            name="usuario" 
            class="form-input" 
            value="<?= htmlspecialchars($usuario) ?>" 
            placeholder="ej: admin" 
            required 
            autofocus
          >
        </div>

        <div class="form-group">
          <label for="password">Contraseña</label>
          <input 
            type="password" 
            id="password" 
            name="password" 
            class="form-input" 
            placeholder="Tu contraseña de acceso" 
            required
          >
        </div>

        <button type="submit" class="btn btn-accent" style="width: 100%; padding: 12px; font-size: 1rem; margin-top: 0.5rem;">
          Ingresar al Panel &rarr;
        </button>
      </form>

      <div class="login-hint">
        <div style="margin-top: 1rem;">
          <a href="../index.php" style="color: #0284c7; text-decoration: underline; font-size: 0.85rem;">&larr; Volver al Portal Público</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
