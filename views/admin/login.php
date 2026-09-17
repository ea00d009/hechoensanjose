<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • INICIO DE SESIÓN ADMINISTRATIVO
 * ==============================================================================
 */

require_once __DIR__ . '/auth.php';

// El controlador se encarga de procesar el POST y las variables $errorLogin y $usuario
$error = $errorLogin ?? '';
$usuario = $usuario ?? '';
$csrf = getCsrfToken();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acceso Administrativo &bull; Hecho en San José</title>
  
  <!-- Tipografía Google Fonts optimizada -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap">

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
  <link rel="stylesheet" href="../assets/css/admin.css">
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
          <strong>⚠️ Error:</strong> <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="login" autocomplete="off">
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
