<?php

function conectarBB() : mysqli{
    $bd = new mysqli('localhost','root','','bienes_raices');

    if (!$bd) {
        echo "No se Puede Conectar";
        exit;
    }

    return $bd;
     
}

