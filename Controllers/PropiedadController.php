<?php

namespace Controller;
use MVC\Router;

class PropiedadController {
    public static function index(Router $router){
        $router->view('propiedades/index');
    }
    public static function create(){
        echo 'View Crear';
    }
    public static function update(){
        echo 'view Update';
    }
}