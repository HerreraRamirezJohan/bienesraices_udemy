<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

function includeTemplate(string $nameTemplate, bool $inicio = false){
    include TEMPLATES_URL . "/$nameTemplate.php";
}
function estaAutenticado() : bool {
    session_start();
    if(isset($_SESSION['login'])){
        $auth = $_SESSION['login'];
        
        if($auth)
            return true;
    }
    
    header('Location: /');
}
function debug($var = []){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    exit;
}

function s($html) : string{
    return $s = htmlspecialchars($html);
}

function mostrarNotificacion($codigo){
    $mensaje = "";
    switch($codigo){
        case 1:
            $mensaje = "Creado correctamente!";
            break;
        case 2:
            $mensaje = "Actualizado correctamente!";
            break;
        case 3:
            $mensaje = "Eliminado correctamente!";
            break;
        default:
            $mensaje = false;
    }

    return $mensaje;
}