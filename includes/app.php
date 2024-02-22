<?php

require_once 'funciones.php';
require_once 'config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

$db = conectionDB();
use Model\ActiveRecord;

ActiveRecord::setDB($db);