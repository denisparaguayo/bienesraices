<?php 


    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('Location: /');
    }
        //Importar la Conexion

    
        require 'includes/app.php';
    $bd = conectarBB();

    //Consultar

    $query = "SELECT * FROM propiedades WHERE id = ${id}";

    //Obtener Resultado

    $resultado = mysqli_query($bd, $query);

    if($resultado->num_rows === 0 ){
        header('Location: /');
    }

    $propiedad = mysqli_fetch_assoc($resultado);




    

     incluirTemplate('header');

?>

    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad['titulo']?></h1>

        <img loading="lazy" src="/imagenes/<?php echo $propiedad['imagen']?>" alt="imagen de la propiedad">
        

        <div class="resumen-propiedad">
        <p class="precio-verde"> $<?php echo $propiedad['precio']?> </p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad['wc']?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad['estacionamiento']?></p>
                </li>
                <li>
                    <img class="icono"  loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad['habitaciones']?></p>
                </li>
            </ul>

            <p><?php echo $propiedad['descripcion']?></p>
        </div>
    </main>

    <?php
    mysqli_close($bd);
    
    incluirTemplate('footer') 
    
    ?>