
<?php

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

//Conectar Base de Datos

$bd = conectarBB();

use App\ActiveRecord;

ActiveRecord::setBD($bd);

