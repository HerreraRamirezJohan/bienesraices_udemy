<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controller\PropiedadController;

$router = new Router();


$router->get('/', [PropiedadController::class, 'index']);
$router->get('/propiedad/crear', [PropiedadController::class, 'create']);
$router->get('/propiedad/actualizar', [PropiedadController::class, 'update']);

$router->checkRoute();