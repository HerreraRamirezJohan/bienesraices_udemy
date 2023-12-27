<?php

function conectionDB() : mysqli{
    $db = new mysqli('localhost', 'root', '', 'udemy_bienesraices');

    if(!$db){
        echo 'Error no se pudo conectar';
        exit;
    }

    return $db;
}