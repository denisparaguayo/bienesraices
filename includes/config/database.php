<?php

function conectarBB(){
    $bd = mysqli_connect ('localhost','root','','bienes_raices');

    if ($bd) {
        echo "se conecto";
    }
     else{
        echo "no se conecto";
    }
}

