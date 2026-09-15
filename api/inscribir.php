<?php
/**
 * ==============================================================================
 * API ENDPOINT: Inscripción de Productores (Acceso directo o via rewrite)
 * ==============================================================================
 */
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../controllers/ApiController.php';

$api = new ApiController();
$api->postInscribir();
