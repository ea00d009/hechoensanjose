<?php
/**
 * ==============================================================================
 * CONTROLLERS: PublicController
 * ==============================================================================
 */
require_once __DIR__ . '/../models/ProductorRepository.php';
require_once __DIR__ . '/../models/CategoriaRepository.php';
require_once __DIR__ . '/../models/GondolaRepository.php';

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
        $gondolaRepo = new GondolaRepository();
        $gondolas = $gondolaRepo->getActivasConProductores();
        require __DIR__ . '/../views/public/gondola.php';
    }

    public function mapa($params = []) {
        $productorRepo = new ProductorRepository();
        $productores = $productorRepo->getActivos();

        // Parámetro objetivo: soporta ruta limpia /mapa/{slug}, ?productor=slug o ?id=X
        $targetParam = $params['slug'] ?? $_GET['productor'] ?? $_GET['slug'] ?? $_GET['id'] ?? null;

        require __DIR__ . '/../views/public/mapa.php';
    }

    public function fichaProductor($params = []) {
        $productorRepo = new ProductorRepository();
        $productores = $productorRepo->getActivos();
        $targetParam = $params['slug'] ?? '';
        $coincidencias = 0;
        foreach ($productores as $productor) {
            // Mismo normalizador usado por la vista del mapa y el botón QR.
            $slug = mb_strtolower(trim($productor['nombre']), 'UTF-8');
            $slug = strtr($slug, ['á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','à'=>'a','è'=>'e','ì'=>'i','ò'=>'o','ù'=>'u','ä'=>'a','ë'=>'e','ï'=>'i','ö'=>'o','ü'=>'u','ñ'=>'n','ç'=>'c','&'=>'y']);
            $slug = trim(preg_replace('/[^a-z0-9]+/i', '-', $slug), '-');
            if ($slug === $targetParam) $coincidencias++;
        }
        if ($coincidencias !== 1) {
            http_response_code(404);
            echo '<h1>Productor no encontrado</h1><p>La ficha no está disponible.</p>';
            return;
        }
        require __DIR__ . '/../views/public/mapa.php';
    }

    public function inscribir() {
        require __DIR__ . '/../views/public/inscribir.php';
    }
}
