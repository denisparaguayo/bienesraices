<?php 
    require '../../includes/config/database.php';

    $bd = conectarBB();

    require '../../includes/funciones.php';

     incluirTemplate('header');

?>

    <main class="contenedor seccion">
    
    
    <a href="/admin" class="boton boton-verde">Volver</a>

    <form class="formulario">
        <fieldset>
            <legend>Información General</legend>
                
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" placeholder="Titulo de la Propiedad">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" placeholder="Precio de la Propiedad">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png">

                <label for="descripcion">descripción:</label>
                <textarea id="descripcion"></textarea>               
        
        </fieldset>

        <fieldset>
            <legend>Información de la Propiedad</legend>

                <label for="habitacion">Habitacion:</label>
                <input type="number" id="habitacion" min="1" max="9">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" min="1" max="9">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" min="1" max="9">


        </fieldset>

        <fieldset>
            <legend>Vendedores</legend>

            <select>
            <option value="1">Denis</option>
            <option value="2">Tiky</option>
            </select>

        </fieldset>   


        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
    
    
    </main>


    <?php incluirTemplate('footer') ?>