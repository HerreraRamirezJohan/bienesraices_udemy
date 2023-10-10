<?php
require 'app.php';

function includeTemplate(string $nameTemplate, bool $inicio = false){
    include TEMPLATES_URL . "/$nameTemplate.php";
}