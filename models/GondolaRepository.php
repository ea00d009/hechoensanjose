<?php
/**
 * ==============================================================================
 * MODELS: GondolaRepository
 * ==============================================================================
 * Manejo y persistencia de las Góndolas y Puntos de Venta del programa municipal
 * «Hecho en San José».
 */
require_once __DIR__ . '/../core/Database.php';

class GondolaRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    /**
     * Obtiene todas las góndolas activas (para el portal público y API)
     */
    public function getActivas(): array {
        $sql = "
            SELECT * FROM `ps_gondolas`
            WHERE `activo` = 1
            ORDER BY `orden` ASC, `destacado` DESC, `id` ASC
        ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Obtiene góndolas para el panel administrativo con filtros de búsqueda y estado
     */
    public function getAllForAdmin(string $busqueda = '', string $estado = 'todos'): array {
        $sql = "
            SELECT g.*, COUNT(DISTINCT gp.productor_id) AS total_productores
            FROM `ps_gondolas` g
            LEFT JOIN `ps_gondola_productores` gp ON g.id = gp.gondola_id
            WHERE 1=1
        ";
        $params = [];

        if ($busqueda !== '') {
            $sql .= " AND (g.nombre LIKE :q OR g.tipo LIKE :q OR g.direccion LIKE :q OR g.descripcion LIKE :q OR g.productos_destacados LIKE :q)";
            $params[':q'] = "%{$busqueda}%";
        }

        if ($estado === 'activos') {
            $sql .= " AND g.activo = 1";
        } elseif ($estado === 'inactivos') {
            $sql .= " AND g.activo = 0";
        } elseif ($estado === 'destacados') {
            $sql .= " AND g.destacado = 1";
        }

        $sql .= " GROUP BY g.id ORDER BY g.orden ASC, g.id ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Obtiene una góndola por ID
     */
    public function getById(int $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM `ps_gondolas` WHERE `id` = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Inserta una nueva góndola
     */
    public function create(array $data): int {
        $sql = "
            INSERT INTO `ps_gondolas` 
            (`nombre`, `tipo`, `color`, `icono_svg`, `descripcion`, `direccion`, `horario`, `telefono`, `whatsapp`, `productos_destacados`, `lat`, `lng`, `google_maps_url`, `imagen`, `destacado`, `activo`, `orden`)
            VALUES
            (:nombre, :tipo, :color, :icono_svg, :descripcion, :direccion, :horario, :telefono, :whatsapp, :productos_destacados, :lat, :lng, :google_maps_url, :imagen, :destacado, :activo, :orden)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nombre'               => $data['nombre'],
            ':tipo'                 => $data['tipo'] ?? 'Góndola Oficial',
            ':color'                => $data['color'] ?? 'icon-emerald',
            ':icono_svg'            => $data['icono_svg'] ?? null,
            ':descripcion'          => $data['descripcion'],
            ':direccion'            => $data['direccion'],
            ':horario'              => $data['horario'] ?? null,
            ':telefono'             => $data['telefono'] ?? null,
            ':whatsapp'             => $data['whatsapp'] ?? null,
            ':productos_destacados' => $data['productos_destacados'] ?? null,
            ':lat'                  => $data['lat'] ?? null,
            ':lng'                  => $data['lng'] ?? null,
            ':google_maps_url'      => $data['google_maps_url'] ?? null,
            ':imagen'               => $data['imagen'] ?? null,
            ':destacado'            => !empty($data['destacado']) ? 1 : 0,
            ':activo'               => isset($data['activo']) ? (int)$data['activo'] : 1,
            ':orden'                => isset($data['orden']) ? (int)$data['orden'] : 0,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Actualiza una góndola existente
     */
    public function update(int $id, array $data): bool {
        $sql = "
            UPDATE `ps_gondolas` SET
                `nombre`               = :nombre,
                `tipo`                 = :tipo,
                `color`                = :color,
                `icono_svg`            = :icono_svg,
                `descripcion`          = :descripcion,
                `direccion`            = :direccion,
                `horario`              = :horario,
                `telefono`             = :telefono,
                `whatsapp`             = :whatsapp,
                `productos_destacados` = :productos_destacados,
                `lat`                  = :lat,
                `lng`                  = :lng,
                `google_maps_url`      = :google_maps_url,
                `imagen`               = :imagen,
                `destacado`            = :destacado,
                `activo`               = :activo,
                `orden`                = :orden
            WHERE `id` = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'                   => $id,
            ':nombre'               => $data['nombre'],
            ':tipo'                 => $data['tipo'] ?? 'Góndola Oficial',
            ':color'                => $data['color'] ?? 'icon-emerald',
            ':icono_svg'            => $data['icono_svg'] ?? null,
            ':descripcion'          => $data['descripcion'],
            ':direccion'            => $data['direccion'],
            ':horario'              => $data['horario'] ?? null,
            ':telefono'             => $data['telefono'] ?? null,
            ':whatsapp'             => $data['whatsapp'] ?? null,
            ':productos_destacados' => $data['productos_destacados'] ?? null,
            ':lat'                  => $data['lat'] ?? null,
            ':lng'                  => $data['lng'] ?? null,
            ':google_maps_url'      => $data['google_maps_url'] ?? null,
            ':imagen'               => $data['imagen'] ?? null,
            ':destacado'            => !empty($data['destacado']) ? 1 : 0,
            ':activo'               => isset($data['activo']) ? (int)$data['activo'] : 1,
            ':orden'                => isset($data['orden']) ? (int)$data['orden'] : 0,
        ]);
    }

    /**
     * Alterna estado activo (publicado / oculto)
     */
    public function toggleActivo(int $id): void {
        $stmt = $this->pdo->prepare("UPDATE `ps_gondolas` SET `activo` = IF(`activo`=1, 0, 1) WHERE `id` = :id");
        $stmt->execute([':id' => $id]);
    }

    /**
     * Alterna estado destacado
     */
    public function toggleDestacado(int $id): void {
        $stmt = $this->pdo->prepare("UPDATE `ps_gondolas` SET `destacado` = IF(`destacado`=1, 0, 1) WHERE `id` = :id");
        $stmt->execute([':id' => $id]);
    }

    /**
     * Elimina una góndola
     */
    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM `ps_gondolas` WHERE `id` = :id");
        $stmt->execute([':id' => $id]);
    }

    /**
     * Métricas numéricas para el dashboard administrativo
     */
    public function getMetrics(): array {
        $total = (int)$this->pdo->query("SELECT COUNT(*) FROM `ps_gondolas`")->fetchColumn();
        $activas = (int)$this->pdo->query("SELECT COUNT(*) FROM `ps_gondolas` WHERE `activo` = 1")->fetchColumn();
        $destacadas = (int)$this->pdo->query("SELECT COUNT(*) FROM `ps_gondolas` WHERE `destacado` = 1")->fetchColumn();

        return [
            'total'      => $total,
            'activas'    => $activas,
            'destacadas' => $destacadas
        ];
    }

    /**
     * Obtiene los productores activos asociados a una góndola específica
     */
    public function getProductoresByGondola(int $gondolaId): array {
        $sql = "
            SELECT 
                p.id, p.nombre, p.rubro, p.categoria_id, p.tag_label, p.tag_class,
                p.pin_color, p.imagen, p.icono_svg, p.whatsapp, p.direccion
            FROM `ps_productores` p
            INNER JOIN `ps_gondola_productores` gp ON p.id = gp.productor_id
            WHERE gp.gondola_id = :gid AND p.activo = 1
            ORDER BY p.destacado DESC, p.nombre ASC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':gid' => $gondolaId]);
        return $stmt->fetchAll();
    }

    /**
     * Obtiene todas las góndolas activas enriquecidas con la lista de productores asignados
     */
    public function getActivasConProductores(): array {
        $gondolas = $this->getActivas();
        foreach ($gondolas as &$g) {
            $g['productores'] = $this->getProductoresByGondola((int)$g['id']);
            $g['total_productores'] = count($g['productores']);
        }
        return $gondolas;
    }

    /**
     * Obtiene los IDs de góndolas asociadas a un productor
     */
    public function getGondolaIdsForProductor(int $productorId): array {
        $stmt = $this->pdo->prepare("SELECT `gondola_id` FROM `ps_gondola_productores` WHERE `productor_id` = :pid");
        $stmt->execute([':pid' => $productorId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
    }

    /**
     * Obtiene los IDs de productores asociados a una góndola
     */
    public function getProductorIdsForGondola(int $gondolaId): array {
        $stmt = $this->pdo->prepare("SELECT `productor_id` FROM `ps_gondola_productores` WHERE `gondola_id` = :gid");
        $stmt->execute([':gid' => $gondolaId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
    }

    /**
     * Sincroniza las góndolas asignadas a un productor
     */
    public function syncGondolasForProductor(int $productorId, array $gondolaIds): void {
        $this->pdo->beginTransaction();
        try {
            $del = $this->pdo->prepare("DELETE FROM `ps_gondola_productores` WHERE `productor_id` = :pid");
            $del->execute([':pid' => $productorId]);

            if (!empty($gondolaIds)) {
                $ins = $this->pdo->prepare("INSERT IGNORE INTO `ps_gondola_productores` (`gondola_id`, `productor_id`) VALUES (:gid, :pid)");
                foreach ($gondolaIds as $gid) {
                    $gidInt = (int)$gid;
                    if ($gidInt > 0) {
                        $ins->execute([':gid' => $gidInt, ':pid' => $productorId]);
                    }
                }
            }
            $this->pdo->commit();
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Sincroniza los productores asignados a una góndola
     */
    public function syncProductoresForGondola(int $gondolaId, array $productorIds): void {
        $this->pdo->beginTransaction();
        try {
            $del = $this->pdo->prepare("DELETE FROM `ps_gondola_productores` WHERE `gondola_id` = :gid");
            $del->execute([':gid' => $gondolaId]);

            if (!empty($productorIds)) {
                $ins = $this->pdo->prepare("INSERT IGNORE INTO `ps_gondola_productores` (`gondola_id`, `productor_id`) VALUES (:gid, :pid)");
                foreach ($productorIds as $pid) {
                    $pidInt = (int)$pid;
                    if ($pidInt > 0) {
                        $ins->execute([':gid' => $gondolaId, ':pid' => $pidInt]);
                    }
                }
            }
            $this->pdo->commit();
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
