<?php

function conectionDB() : mysqli{
    $db = mysqli_connect('localhost', 'root', '', 'udemy_bienesraices');

    if(!$db){
        echo 'Error no se pudo conectar';
        exit;
    }

    return $db;
}