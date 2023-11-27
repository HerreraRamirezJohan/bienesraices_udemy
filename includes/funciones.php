<?php
require 'app.php';

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
    
    return false;
}