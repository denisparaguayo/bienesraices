<?php

function conectarBB() : msqli{
    $bd = mysqli_connect ('localhost','root','','bienes_raices');

    if (!$bd) {
        echo "Error no se Pudo conectar";
        exit;
    }

    return $bd; 
     
}

