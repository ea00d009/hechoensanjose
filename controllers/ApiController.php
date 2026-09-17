<?php
/**
 * ==============================================================================
 * CONTROLLERS: ApiController
 * ==============================================================================
 */
require_once __DIR__ . '/../models/ProductorRepository.php';
require_once __DIR__ . '/../models/GondolaRepository.php';

class ApiController {
    public function getProductores() {
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, OPTIONS');
        }

        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        try {
            $categoria = $_GET['categoria'] ?? null;
            if ($categoria !== null && !is_string($categoria)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'La categoría indicada no es válida.'], JSON_UNESCAPED_UNICODE);
                return;
            }
            $soloDestacados = isset($_GET['destacados']) && $_GET['destacados'] === '1';

            $repo = new ProductorRepository();
            $rows = $repo->getActivos($categoria, $soloDestacados);

            $productores = [];
            foreach ($rows as $row) {
                $nombre = $row['nombre'] ?? '';
                $slug = mb_strtolower(trim($nombre), 'UTF-8');
                $slug = strtr($slug, ['á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','à'=>'a','è'=>'e','ì'=>'i','ò'=>'o','ù'=>'u','ä'=>'a','ë'=>'e','ï'=>'i','ö'=>'o','ü'=>'u','ñ'=>'n','ç'=>'c','&'=>'y']);
                $slug = trim(preg_replace('/[^a-z0-9]+/i', '-', $slug), '-');

                $productores[] = [
                    'id'          => (int)$row['id'],
                    'slug'        => $slug,
                    'nombre'      => htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'),
                    'rubro'       => htmlspecialchars($row['rubro'] ?? '', ENT_QUOTES, 'UTF-8'),
                    'categoria'   => htmlspecialchars($row['categoria'] ?? '', ENT_QUOTES, 'UTF-8'),
                    'tagLabel'    => htmlspecialchars($row['tagLabel'] ?? '', ENT_QUOTES, 'UTF-8'),
                    'tagClass'    => htmlspecialchars($row['tagClass'] ?? '', ENT_QUOTES, 'UTF-8'),
                    'pinColor'    => htmlspecialchars($row['pinColor'] ?? '', ENT_QUOTES, 'UTF-8'),
                    'imagen'      => htmlspecialchars($row['imagen'] ?? '', ENT_QUOTES, 'UTF-8'),
                    'iconoSvg'    => $row['iconoSvg'], 
                    'coords'      => [(float)$row['lat'], (float)$row['lng']],
                    'direccion'   => htmlspecialchars($row['direccion'] ?? '', ENT_QUOTES, 'UTF-8'),
                    'telefono'    => htmlspecialchars($row['telefono'] ?: '', ENT_QUOTES, 'UTF-8'),
                    'whatsapp'    => htmlspecialchars($row['whatsapp'] ?? '', ENT_QUOTES, 'UTF-8'),
                    'horario'     => htmlspecialchars($row['horario'] ?: '', ENT_QUOTES, 'UTF-8'),
                    'descripcion' => htmlspecialchars($row['descripcion'] ?? '', ENT_QUOTES, 'UTF-8'),
                    'destacado'   => (bool)$row['destacado'],
                    'gondolas'    => !empty($row['gondolas_nombres']) ? explode('||', $row['gondolas_nombres']) : []
                ];
            }

            echo json_encode([
                'success'     => true,
                'total'       => count($productores),
                'productores' => $productores
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        } catch (Throwable $e) {
            error_log("Error API Productores: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error'   => 'No se pudo conectar a la base de datos MySQL o hubo un error en la consulta.'
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Procesa la solicitud de inscripción de un emprendimiento
     */
    public function postInscribir() {
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: POST, OPTIONS');
        }

        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'error'   => 'Método no permitido. Solo se acepta POST.'
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        // Si los datos vienen como JSON crudo (Content-Type: application/json)
        $input = $_POST;
        if (empty($input)) {
            $rawInput = file_get_contents('php://input');
            if (!empty($rawInput)) {
                $decoded = json_decode($rawInput, true);
                if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded) || substr(ltrim($rawInput), 0, 1) !== '{') {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'error' => 'Los datos de la solicitud no tienen un formato válido.'], JSON_UNESCAPED_UNICODE);
                    return;
                }
                $input = $decoded;
            }
        }

        // Validar tipos y límites antes de llamar a trim o consultar la base.
        $limites = [
            'nombre_titular' => 150, 'dni_cuit' => 30, 'whatsapp' => 50,
            'email' => 150, 'nombre_emprendimiento' => 150, 'rubro' => 100,
            'direccion' => 255, 'descripcion' => 10000
        ];
        foreach ($limites as $campo => $maximo) {
            if (isset($input[$campo]) && (!is_string($input[$campo]) || !mb_check_encoding($input[$campo], 'UTF-8') || mb_strlen($input[$campo], 'UTF-8') > $maximo)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Revisá el campo "' . str_replace('_', ' ', $campo) . '": debe ser texto y no superar los ' . $maximo . ' caracteres.'], JSON_UNESCAPED_UNICODE);
                return;
            }
        }
        foreach (['interes_catalogo', 'interes_mapa', 'interes_gondola', 'interes_ferias'] as $campo) {
            if (isset($input[$campo]) && !in_array($input[$campo], ['0', '1', 0, 1, false, true], true)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Las opciones de interés no son válidas.'], JSON_UNESCAPED_UNICODE);
                return;
            }
        }

        $nombreTitular        = trim($input['nombre_titular'] ?? '');
        $dniCuit              = trim($input['dni_cuit'] ?? '');
        $whatsapp             = trim($input['whatsapp'] ?? '');
        $email                = trim($input['email'] ?? '');
        $nombreEmprendimiento = trim($input['nombre_emprendimiento'] ?? '');
        $rubro                = trim($input['rubro'] ?? '');
        $direccion            = trim($input['direccion'] ?? '');
        $descripcion          = trim($input['descripcion'] ?? '');

        $interesCatalogo      = !empty($input['interes_catalogo']) ? 1 : 0;
        $interesMapa          = !empty($input['interes_mapa']) ? 1 : 0;
        $interesGondola       = !empty($input['interes_gondola']) ? 1 : 0;
        $interesFerias        = !empty($input['interes_ferias']) ? 1 : 0;

        // Validaciones de campos obligatorios
        if (empty($nombreTitular) || empty($whatsapp) || empty($nombreEmprendimiento) || empty($rubro) || empty($direccion) || empty($descripcion)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error'   => 'Por favor completá todos los campos obligatorios requeridos (*).'
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Ingresá un correo electrónico válido o dejá ese campo vacío.'], JSON_UNESCAPED_UNICODE);
            return;
        }
        $digitosWhatsapp = preg_replace('/\D/', '', $whatsapp);
        if (!preg_match('/^\+?[0-9\s().-]+$/', $whatsapp) || strlen($digitosWhatsapp) < 6 || strlen($digitosWhatsapp) > 15) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Ingresá un número de WhatsApp válido, con código de área.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        try {
            require_once __DIR__ . '/../core/Database.php';
            $pdo = Database::getConnection();

            // Incluir el DNI/CUIT en notas_admin si fue ingresado
            $notasAdmin = null;
            if (!empty($dniCuit)) {
                $notasAdmin = "DNI/CUIT informado: " . $dniCuit;
            }

            $sql = "
                INSERT INTO `ps_solicitudes_inscripcion` (
                    `nombre_emprendimiento`, `nombre_titular`, `whatsapp`, `email`,
                    `rubro`, `direccion`, `descripcion`,
                    `interes_catalogo`, `interes_mapa`, `interes_gondola`, `interes_ferias`,
                    `estado`, `notas_admin`
                ) VALUES (
                    :nombre_emprendimiento, :nombre_titular, :whatsapp, :email,
                    :rubro, :direccion, :descripcion,
                    :interes_catalogo, :interes_mapa, :interes_gondola, :interes_ferias,
                    'pendiente', :notas_admin
                )
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nombre_emprendimiento' => $nombreEmprendimiento,
                ':nombre_titular'        => $nombreTitular,
                ':whatsapp'             => $whatsapp,
                ':email'                => $email ?: null,
                ':rubro'                => $rubro,
                ':direccion'            => $direccion,
                ':descripcion'          => $descripcion,
                ':interes_catalogo'     => $interesCatalogo,
                ':interes_mapa'         => $interesMapa,
                ':interes_gondola'      => $interesGondola,
                ':interes_ferias'       => $interesFerias,
                ':notas_admin'          => $notasAdmin
            ]);

            $idGenerado = (int)$pdo->lastInsertId();

            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => '¡Tu solicitud de inscripción fue enviada con éxito!',
                'id'      => $idGenerado
            ], JSON_UNESCAPED_UNICODE);

        } catch (Throwable $e) {
            error_log("Error al guardar solicitud de inscripción: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error'   => 'No se pudo registrar la solicitud. Por favor intentá nuevamente más tarde.'
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getGondolas() {
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, OPTIONS');
        }

        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        try {
            $repo = new GondolaRepository();
            $gondolas = $repo->getActivas();

            echo json_encode([
                'success'  => true,
                'total'    => count($gondolas),
                'gondolas' => $gondolas
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (Throwable $e) {
            error_log('Error API Góndolas: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error'   => 'No se pudieron obtener las góndolas. Por favor intentá nuevamente más tarde.'
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}
