<?php
/**
 * ==============================================================================
 * MODELS: CategoriaRepository
 * ==============================================================================
 */
require_once __DIR__ . '/../core/Database.php';

class CategoriaRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM `ps_categorias` ORDER BY `orden` ASC");
        return $stmt->fetchAll();
    }

    public function getById(string $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM `ps_categorias` WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
