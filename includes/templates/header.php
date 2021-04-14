<?php

if(!isset($_SESSION)){
    session_start();
}

$auth = $_SESSION['login'] ?? null;

// var_dump($auth);
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raíces</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    
    <header class="header <?php echo $inicio ? 'inicio' :' '?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="../../index.php">
                    <img src="/build/img/logo.svg" alt="Logotipo de Bienes Raíces">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a href="/nosotros.php">Nosotros</a>
                        <a href="/anuncios.php">Anuncios</a>
                        <a href="/blog.php">Blog</a>
                        <a href="/contacto.php">Contacto</a>                        
                        <?php if(!$auth) : ?>
                        <a href="/login.php">Iniciar Sesión</a>;
                        <?php endif; ?>                        
                        <?php if($auth) : ?>
                        <a href="/admin"><span class="crear-admi">*Crear-Editar*</span></a>;
                        <a  href="/cerrar-sesion.php">Cerrar Sesión</a>;
                        <?php endif; ?>                        
                    </nav>
                </div>
                
            </div> <!--.barra-->

            <?php
                if($inicio){
                    echo"<h1> Venta de Casas y Departamentos de Lujo</h1>";
                }
            ?>


        </div>
    </header>