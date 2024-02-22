<?php

namespace MVC;

class Router {
    
    private $routesGET = [];
    private $routesPOST = [];

    public function get($url, $function){
        $this->routesGET[$url] = $function;
    }

    public function checkRoute() {
        $url = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];
        
        if($method === 'GET'){
            $function = $this->routesGET[$url] ?? null;
        }

        if($function){
            //Permite llamar una funcion cuando se desconoce el nombre
            call_user_func($function, $this);
        }else{
            echo "Pagina no encontrada";
        }
    }

    public static function view($view){
        ob_start();//Inicia un almacenamiento en memoria
        include __DIR__ . "/views/$view.php";
        $content = ob_get_clean();
        include __DIR__ . "/views/layout.php";
    }

}