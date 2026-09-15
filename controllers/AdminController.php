<?php
/**
 * ==============================================================================
 * CONTROLLERS: AdminController
 * ==============================================================================
 */
require_once __DIR__ . '/../models/ProductorRepository.php';
require_once __DIR__ . '/../models/CategoriaRepository.php';

class AdminController {

    private function checkAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['admin_user_id'])) {
            header('Location: ./login');
            exit;
        }
    }

    public function dashboard() {
        $this->checkAuth();
        require __DIR__ . '/../views/admin/index.php';
    }

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!empty($_SESSION['admin_user_id'])) {
            header('Location: ./');
            exit;
        }
        require __DIR__ . '/../views/admin/login.php';
    }

    public function postLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $errorLogin = '';
        $usuario = trim($_POST['usuario'] ?? '');
        $password = trim($_POST['password'] ?? '');

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
                $_SESSION['admin_user_id']  = (int)$user['id'];
                $_SESSION['admin_username'] = $user['usuario'];
                $_SESSION['admin_nombre']   = $user['nombre'];
                
                $updateStmt = $pdo->prepare("UPDATE `ps_usuarios_admin` SET `ultimo_login` = NOW() WHERE `id` = :id");
                $updateStmt->execute([':id' => $user['id']]);

                // Usamos ruta relativa segura para el router
                header('Location: ./');
                exit;
            } else {
                $errorLogin = 'Usuario o contraseña incorrectos.';
                require __DIR__ . '/../views/admin/login.php';
            }
        } catch (Throwable $e) {
            error_log("Error en postLogin: " . $e->getMessage());
            $errorLogin = 'Error de Base de Datos: ' . $e->getMessage();
            require __DIR__ . '/../views/admin/login.php';
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        header('Location: ./login');
        exit;
    }

    public function productores() {
        $this->checkAuth();
        
        $busqueda  = trim($_GET['q'] ?? '');
        $catFiltro = trim($_GET['categoria'] ?? 'todos');
        $estado    = trim($_GET['estado'] ?? 'todos');

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
}
