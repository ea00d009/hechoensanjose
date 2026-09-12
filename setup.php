<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • INSTALADOR Y MIGRACIÓN AUTOMÁTICA DE BASE DE DATOS
 * ==============================================================================
 * Ejecutable desde navegador o desde CLI: php setup.php
 */

// Candado de seguridad: Evitar reinstalación si ya existe el archivo .env
$envPathLocal = __DIR__ . '/config/.env';
if (file_exists($envPathLocal) && filesize($envPathLocal) > 0) {
    if (php_sapi_name() === 'cli') {
        echo "========================================================\n";
        echo " [BLOQUEADO] La plataforma ya está instalada.\n";
        echo " Para reinstalar, elimina el archivo config/.env\n";
        echo "========================================================\n";
        exit(1);
    } else {
        http_response_code(403);
        die("<div style='font-family: sans-serif; max-width: 600px; margin: 40px auto; padding: 20px; border: 1px solid #fecaca; background: #fef2f2; color: #991b1b; border-radius: 8px;'>
            <h3 style='margin-top: 0;'>Acceso Denegado</h3>
            <p>La plataforma ya se encuentra instalada. Por razones de seguridad, el instalador ha sido deshabilitado para evitar sobrescribir la base de datos.</p>
            <p>Si necesita reinstalar, elimine manualmente el archivo <code>config/.env</code> del servidor.</p>
            <a href='index.php' style='color: #0284c7; font-weight: bold; text-decoration: none;'>&larr; Volver al Portal</a>
        </div>");
    }
}

require_once __DIR__ . '/config/db.php';

$isCli = (php_sapi_name() === 'cli');

// Obtener credenciales (pueden sobreescribirse por POST o CLI)
$host = $_POST['host'] ?? DB_HOST;
$port = $_POST['port'] ?? DB_PORT;
$user = $_POST['user'] ?? DB_USER;
$pass = $_POST['pass'] ?? DB_PASS;
$dbname = $_POST['dbname'] ?? DB_NAME;

$mensaje = '';
$error = '';
$instalado = false;

if ($isCli || $_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['auto'])) {
    try {
        // Conectar a la base de datos específica proporcionada (ya creada en el hosting)
        $dsnDb = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
        $pdo = new PDO($dsnDb, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        // 4. Leer y ejecutar el script SQL completo
        $sqlFile = __DIR__ . '/sql/database.sql';
        if (!file_exists($sqlFile)) {
            throw new Exception("No se encontró el archivo de migración: {$sqlFile}");
        }

        $sqlContent = file_get_contents($sqlFile);
        $pdo->exec("SET NAMES utf8mb4");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $pdo->exec($sqlContent);
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

        // 5. Verificar inserciones
        $countProd = $pdo->query("SELECT COUNT(*) FROM `ps_productores`")->fetchColumn();
        $countCat = $pdo->query("SELECT COUNT(*) FROM `ps_categorias`")->fetchColumn();
        $countAdmin = $pdo->query("SELECT COUNT(*) FROM `ps_usuarios_admin`")->fetchColumn();

        // 6. Guardar o actualizar archivo .env local si las credenciales cambiaron
        $envPath = __DIR__ . '/config/.env';
        $envData = "DB_HOST={$host}\nDB_PORT={$port}\nDB_NAME={$dbname}\nDB_USER={$user}\nDB_PASS={$pass}\n";
        file_put_contents($envPath, $envData);

        $instalado = true;
        $mensaje = "¡Base de datos instalada exitosamente! Se registraron {$countCat} categorías, {$countProd} productores auténticos y {$countAdmin} usuario administrador.";

        if ($isCli) {
            echo "========================================================\n";
            echo " [OK] " . $mensaje . "\n";
            echo " Credenciales del panel admin:\n";
            echo "   Usuario: admin\n";
            echo "   Clave:   admin2706\n";
            echo "========================================================\n";
            exit(0);
        }

    } catch (Throwable $e) {
        $error = $e->getMessage();
        if ($isCli) {
            echo "========================================================\n";
            echo " [ERROR] Falló la instalación: " . $error . "\n";
            echo " Verifique que el servicio de MySQL esté iniciado y las\n";
            echo " credenciales sean correctas.\n";
            echo "========================================================\n";
            exit(1);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instalador de Base de Datos &bull; Hecho en San José</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .setup-container {
      max-width: 650px;
      margin: 3rem auto;
      padding: 2.5rem;
      background: var(--bg-card, #ffffff);
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
      border: 1px solid var(--border-light, #e2e8f0);
    }
    .setup-header {
      text-align: center;
      margin-bottom: 2rem;
    }
    .setup-header img {
      height: 60px;
      margin-bottom: 1rem;
    }
    .alert {
      padding: 1rem 1.25rem;
      border-radius: 8px;
      margin-bottom: 1.5rem;
      font-size: 0.95rem;
      line-height: 1.5;
    }
    .alert-success {
      background: #ecfdf5;
      color: #065f46;
      border: 1px solid #a7f3d0;
    }
    .alert-danger {
      background: #fef2f2;
      color: #991b1b;
      border: 1px solid #fecaca;
    }
    .form-group {
      margin-bottom: 1.25rem;
    }
    .form-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 0.35rem;
      font-size: 0.88rem;
    }
    .form-control {
      width: 100%;
      padding: 0.75rem 1rem;
      border-radius: 8px;
      border: 1px solid var(--border-light, #cbd5e1);
      font-size: 0.95rem;
      box-sizing: border-box;
      background: var(--bg-card, #fff);
      color: var(--text-main, #1e293b);
    }
  </style>
</head>
<body style="background: var(--bg-body, #f8fafc);">
  <div class="setup-container">
    <div class="setup-header">
      <img src="assets/logo-sanjose.png" alt="San José">
      <h2>Hecho en San José</h2>
      <p style="color: var(--text-muted, #64748b);">Instalación y sincronización de Base de Datos MySQL</p>
    </div>

    <?php if ($instalado): ?>
      <div class="alert alert-success">
        <strong>✓ ¡Instalación completada con éxito!</strong><br>
        <?= htmlspecialchars($mensaje) ?>
      </div>

      <div style="background: #f1f5f9; padding: 1.25rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <h4 style="margin-top: 0; margin-bottom: 0.5rem; font-size: 1rem;">Acceso al Panel de Administrador:</h4>
        <ul style="margin: 0; padding-left: 1.2rem; font-size: 0.9rem; color: #334155;">
          <li><strong>Usuario:</strong> <code>admin</code></li>
          <li><strong>Contraseña inicial:</strong> <code>admin2706</code></li>
          <li><strong>URL de gestión:</strong> <a href="admin/login.php" style="color: #0284c7; font-weight: 600;">admin/login.php</a></li>
        </ul>
      </div>

      <div style="display: flex; gap: 1rem; justify-content: center;">
        <a href="admin/login.php" class="btn btn-accent" style="padding: 10px 24px;">Ir al Panel de Administración &rarr;</a>
        <a href="index.php" class="btn btn-outline" style="padding: 10px 24px;">Ver Sitio Público</a>
      </div>

    <?php else: ?>

      <?php if ($error): ?>
        <div class="alert alert-danger">
          <strong>⚠ Error al conectar o crear la base de datos:</strong><br>
          <?= htmlspecialchars($error) ?>
          <p style="margin-top: 0.5rem; font-size: 0.85rem; opacity: 0.9;">
            Por favor verifica si el servicio MySQL está encendido y la contraseña ingresada es la correcta.
          </p>
        </div>
      <?php endif; ?>

      <form method="POST" action="setup.php">
        <div class="form-group">
          <label>Servidor MySQL (Host):</label>
          <input type="text" name="host" class="form-control" value="<?= htmlspecialchars($host) ?>" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
          <div class="form-group">
            <label>Puerto:</label>
            <input type="text" name="port" class="form-control" value="<?= htmlspecialchars($port) ?>" required>
          </div>
          <div class="form-group">
            <label>Nombre de la BD:</label>
            <input type="text" name="dbname" class="form-control" value="<?= htmlspecialchars($dbname) ?>" required>
          </div>
        </div>

        <div class="form-group">
          <label>Usuario MySQL:</label>
          <input type="text" name="user" class="form-control" value="<?= htmlspecialchars($user) ?>" required>
        </div>

        <div class="form-group">
          <label>Contraseña MySQL (dejar vacío si no tiene):</label>
          <input type="password" name="pass" class="form-control" value="<?= htmlspecialchars($pass) ?>" placeholder="Contraseña de tu MySQL local">
        </div>

        <button type="submit" class="btn btn-accent" style="width: 100%; padding: 12px; font-size: 1rem; margin-top: 0.5rem;">
          Crear / Actualizar Base de Datos Ahora &rarr;
        </button>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>
