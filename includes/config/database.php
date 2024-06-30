<?php

function conectionDB() : mysqli{
    $db = new mysqli('localhost', 'poyo', 'Poyo_mariadb13501j#', 'udemy_bienesraices');

    if(!$db){
        echo 'Error no se pudo conectar';
        exit;
    }

    return $db;
}