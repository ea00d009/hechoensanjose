<?php
/**
 * ==============================================================================
 * CONTROLLERS: PublicController
 * ==============================================================================
 */
require_once __DIR__ . '/../models/ProductorRepository.php';
require_once __DIR__ . '/../models/CategoriaRepository.php';

class PublicController {
    public function home() {
        $productorRepo = new ProductorRepository();
        $totalProductores = count($productorRepo->getActivos());
        $displayCount = $totalProductores > 0 ? $totalProductores : 13;
        
        require __DIR__ . '/../views/public/home.php';
    }

    public function catalogo() {
        $productorRepo = new ProductorRepository();
        $categoriaRepo = new CategoriaRepository();
        
        $categorias = $categoriaRepo->getAll();
        $productores = $productorRepo->getActivos();
        
        require __DIR__ . '/../views/public/catalogo.php';
    }

    public function gondola() {
        require __DIR__ . '/../views/public/gondola.php';
    }

    public function mapa($params = []) {
        $productorRepo = new ProductorRepository();
        $productores = $productorRepo->getActivos();

        // Parámetro objetivo: soporta ruta limpia /mapa/{slug}, ?productor=slug o ?id=X
        $targetParam = $params['slug'] ?? $_GET['productor'] ?? $_GET['slug'] ?? $_GET['id'] ?? null;

        require __DIR__ . '/../views/public/mapa.php';
    }

    public function inscribir() {
        require __DIR__ . '/../views/public/inscribir.php';
    }

    public function informe() {
        require __DIR__ . '/../views/public/informe.php';
    }
}
