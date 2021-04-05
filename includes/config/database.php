<?php

function conectarBB() : mysqli{
    $bd = mysqli_connect ('localhost','root','','bienes_raices');

    if (!$bd) {
        echo "No se Puede Conectar";
        exit;
    }

    return $bd;
     
}

