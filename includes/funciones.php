<?php
require 'app.php';

function includeTemplate($nameTemplate, $inicio = false){
    include TEMPLATES_URL . "/$nameTemplate.php";
}