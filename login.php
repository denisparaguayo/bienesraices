<?php 
    //Autenticar Usuario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        var_dump($_POST);
    }


    //Incluye el Header
    require 'includes/funciones.php';

     incluirTemplate('header');

?>
    <main class="contenedor seccion contenido-centrado">
        <h1>Inicia Sesión</h1>

        <form method="POST" class="formulario">
            <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-mail</label>
                <input type="email" placeholder="Tu Email" id="email">

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Tu Password">

            </fieldset>
            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
        </form>



    </main>

    <?php incluirTemplate('footer') ?>