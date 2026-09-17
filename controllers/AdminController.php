<?php
/**
 * ==============================================================================
 * CONTROLLERS: AdminController
 * ==============================================================================
 */
require_once __DIR__ . '/../models/ProductorRepository.php';
require_once __DIR__ . '/../models/CategoriaRepository.php';
require_once __DIR__ . '/../models/GondolaRepository.php';

class AdminController {

    private function checkAuth() {
        require_once __DIR__ . '/../views/admin/auth.php';
        requireAdmin();
    }

    public function dashboard() {
        $this->checkAuth();
        if (parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) !== adminUrl()) {
            header('Location: ' . adminUrl());
            exit;
        }
        require __DIR__ . '/../views/admin/index.php';
    }

    public function login() {
        require_once __DIR__ . '/../views/admin/auth.php';
        if (!empty($_SESSION['admin_user_id'])) {
            header('Location: ' . adminUrl());
            exit;
        }
        require __DIR__ . '/../views/admin/login.php';
    }

    public function postLogin() {
        require_once __DIR__ . '/../views/admin/auth.php';
        
        $errorLogin = '';
        $usuario = is_string($_POST['usuario'] ?? null) ? trim($_POST['usuario']) : '';
        $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';

        if (!verifyCsrfToken($_POST['csrf'] ?? null)) {
            http_response_code(403);
            $errorLogin = 'La sesión del formulario venció. Volvé a intentar con este formulario.';
            require __DIR__ . '/../views/admin/login.php';
            return;
        }

        if (empty($usuario) || empty($password)) {
            $errorLogin = 'Por favor ingresá tu nombre de usuario y contraseña.';
            require __DIR__ . '/../views/admin/login.php';
            return;
        }

        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("SELECT * FROM `ps_usuarios_admin` WHERE `usuario` = :usuario LIMIT 1");
            $stmt->execute([':usuario' => $usuario]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                $_SESSION['admin_user_id']  = (int)$user['id'];
                $_SESSION['admin_username'] = $user['usuario'];
                $_SESSION['admin_nombre']   = $user['nombre'];
                
                $updateStmt = $pdo->prepare("UPDATE `ps_usuarios_admin` SET `ultimo_login` = NOW() WHERE `id` = :id");
                $updateStmt->execute([':id' => $user['id']]);

                // Usamos ruta relativa segura para el router
                header('Location: ' . adminUrl());
                exit;
            } else {
                $errorLogin = 'Usuario o contraseña incorrectos.';
                require __DIR__ . '/../views/admin/login.php';
            }
        } catch (Throwable $e) {
            error_log("Error en postLogin: " . $e->getMessage());
            $errorLogin = 'No se pudo iniciar sesión. Intentá nuevamente más tarde.';
            require __DIR__ . '/../views/admin/login.php';
        }
    }

    public function logout() {
        require_once __DIR__ . '/../views/admin/auth.php';
        $_SESSION = [];
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        session_destroy();
        header('Location: ' . adminUrl('login'));
        exit;
    }

    public function productores() {
        $this->checkAuth();
        
        $busqueda  = is_string($_GET['q'] ?? null) ? trim($_GET['q']) : '';
        $catFiltro = is_string($_GET['categoria'] ?? null) ? trim($_GET['categoria']) : 'todos';
        $estado    = is_string($_GET['estado'] ?? null) ? trim($_GET['estado']) : 'todos';

        $repoProd = new ProductorRepository();
        $repoCat  = new CategoriaRepository();

        $categorias = $repoCat->getAll();
        $productores = $repoProd->getAllForAdmin($busqueda, $catFiltro, $estado);

        // Generar un token CSRF si no existe (normalmente iría en checkAuth o Router)
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $csrf = $_SESSION['csrf_token'];

        require __DIR__ . '/../views/admin/productores.php';
    }

    public function categorias() {
        $this->checkAuth();
        require __DIR__ . '/../views/admin/categorias.php';
    }

    public function gondolas() {
        $this->checkAuth();

        $busqueda = is_string($_GET['q'] ?? null) ? trim($_GET['q']) : '';
        $estado   = is_string($_GET['estado'] ?? null) ? trim($_GET['estado']) : 'todos';

        $repoGondola = new GondolaRepository();
        $gondolas = $repoGondola->getAllForAdmin($busqueda, $estado);
        $metrics  = $repoGondola->getMetrics();

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $csrf = $_SESSION['csrf_token'];

        require __DIR__ . '/../views/admin/gondolas.php';
    }

    public function gondolaForm() {
        $this->checkAuth();
        require __DIR__ . '/../views/admin/gondola-form.php';
    }

    public function gondolaAcciones() {
        $this->checkAuth();
        require __DIR__ . '/../views/admin/gondola-acciones.php';
    }
}
