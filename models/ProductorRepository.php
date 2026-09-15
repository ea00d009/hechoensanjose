<?php
/**
 * ==============================================================================
 * MODELS: ProductorRepository
 * ==============================================================================
 */
require_once __DIR__ . '/../core/Database.php';

class ProductorRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    /**
     * Obtiene todos los productores activos (para la API y vista pública)
     */
    public function getActivos(string $categoria = null, bool $soloDestacados = false): array {
        $sql = "
            SELECT 
                p.id, p.nombre, p.rubro, p.categoria_id AS categoria,
                COALESCE(p.tag_label, c.tag_label) AS tagLabel,
                COALESCE(p.tag_class, c.tag_class) AS tagClass,
                COALESCE(p.pin_color, c.pin_color) AS pinColor,
                p.imagen, COALESCE(p.icono_svg, c.icono_svg) AS iconoSvg,
                p.lat, p.lng, p.direccion, p.telefono, p.whatsapp, p.horario, p.descripcion, p.destacado
            FROM `ps_productores` p
            LEFT JOIN `ps_categorias` c ON p.categoria_id = c.id
            WHERE p.activo = 1
        ";

        $params = [];

        if ($categoria && $categoria !== 'todos') {
            $sql .= " AND p.categoria_id = :categoria";
            $params[':categoria'] = $categoria;
        }

        if ($soloDestacados) {
            $sql .= " AND p.destacado = 1";
        }

        $sql .= " ORDER BY p.destacado DESC, p.id ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Obtiene productores con filtros (para el panel de administración)
     */
    public function getAllForAdmin(string $busqueda = '', string $categoria = 'todos', string $estado = 'todos'): array {
        $sql = "
            SELECT p.*, c.nombre AS categoria_nombre, c.tag_class, c.pin_color 
            FROM `ps_productores` p
            LEFT JOIN `ps_categorias` c ON p.categoria_id = c.id
            WHERE 1=1
        ";
        
        $params = [];

        if ($busqueda !== '') {
            $sql .= " AND (p.nombre LIKE :q OR p.rubro LIKE :q OR p.direccion LIKE :q OR p.descripcion LIKE :q)";
            $params[':q'] = "%{$busqueda}%";
        }

        if ($categoria !== 'todos' && $categoria !== '') {
            $sql .= " AND p.categoria_id = :cat";
            $params[':cat'] = $categoria;
        }

        if ($estado === 'activos') {
            $sql .= " AND p.activo = 1";
        } elseif ($estado === 'inactivos') {
            $sql .= " AND p.activo = 0";
        } elseif ($estado === 'destacados') {
            $sql .= " AND p.destacado = 1";
        }

        $sql .= " ORDER BY p.id ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById(int $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM `ps_productores` WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function toggleActivo(int $id): void {
        $stmt = $this->pdo->prepare("UPDATE `ps_productores` SET activo = NOT activo WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function toggleDestacado(int $id): void {
        $stmt = $this->pdo->prepare("UPDATE `ps_productores` SET destacado = NOT destacado WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM `ps_productores` WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
