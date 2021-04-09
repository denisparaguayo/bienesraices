<?php

//Importar la Conexion

require __DIR__ . '/../config/database.php';

$bd = conectarBB();

//Consultar

$query = "SELECT * FROM propiedades LIMIT ${limite}";

//Obtener Resultado

$resultado = mysqli_query($bd, $query);

?>





<div class="contenedor-anuncios">
    <?php while ($propiedad = mysqli_fetch_assoc($resultado)):?>
            <div class="anuncio">
                
                <img loading="lazy" src="/imagenes/<?php echo $propiedad['imagen']?>" alt="anuncio">
              

                <div class="contenido-anuncio">
                    <h3><?php echo $propiedad['titulo']?></h3>
                    <p><?php echo $propiedad['descripcion']?></p>
                    <p class="precio">$<?php echo $propiedad['precio']?></p>

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
                            <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                            <p><?php echo $propiedad['habitaciones']?></p>
                        </li>
                    </ul>

                    <a href="anuncio.php" class="boton-amarillo-block">
                        Ver Propiedad
                    </a>
                </div><!--.contenido-anuncio-->
            </div><!--anuncio-->
    <?php endwhile; ?>        
</div> <!--.contenedor-anuncios-->



<?php

//cerrar la conexion

?>