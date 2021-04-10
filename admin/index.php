<?php 

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    
    //Importar la base de datos
    require '../includes/config/database.php';
    $bd = conectarBB();


    //Escribir el Query
    $query = "SELECT * FROM propiedades";

    //consultar la base de datos

    $resultadoConsulta = mysqli_query($bd, $query);



    //Muestra un mensaje condicional
    $resultado = $_GET['resultado'] ?? null;


    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){

            //Elimina el Archivo osea LA IMAGEN

            $query = "SELECT imagen FROM propiedades WHERE id = ${id}";

            $resultado = mysqli_query($bd, $query);
            $propiedad = mysqli_fetch_assoc($resultado);

            unlink('../imagenes/' . $propiedad['imagen']);
            
            //Elimina la Propiedad
            $query = "DELETE FROM propiedades WHERE id = ${id}";
            $resultado = mysqli_query($bd, $query);

            if ($resultado) {
                header('location: /admin?resultado=3');
            }
        }
    }

    //Agrega un Template
    require '../includes/funciones.php';

     incluirTemplate('header');

?>
    <main class="contenedor seccion">
        <h1>Administrador de Propiedades</h1>
    <?php if($resultado =='1') :  ?>
        <p class="alerta exito">Anuncio creado Exitosamente &#x2714; </p>
    <?php elseif($resultado =='2') : ?>  
        <p class="alerta exito">Anuncio Actualizado Exitosamente &#x2714; </p>
    <?php elseif($resultado =='3') : ?>  
        <p class="alerta exito">Anuncio Eliminado Exitosamente &#x2714; </p>  
    <?php endif; ?>


        <a href="./propiedades/crear.php" class="boton boton-azul">Crear Nueva Propiedad &#10035;</a>


        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>  <!--Mostrar los resultados-->
            <?php while( $propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
                <tr>
                    <td><?php echo $propiedad['id']?></td>
                    <td><?php echo $propiedad['titulo']?></td>
                    <td><img src="/imagenes/<?php echo $propiedad['imagen']?>" alt="" class="imagen-tabla"></td>
                    <td> Gs. <?php echo $propiedad['precio']?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">
                            <input type="submit" class="boton boton-rojo-block"  value="Eliminar" id="">
                            </form>
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad['id'];?>" class="boton-amarillo-block">Actualizar</a>
                        
                    </td>

                </tr>
            <?php endwhile; ?>    
            </tbody>
        
        </table>
    </main>
              
    <?php
        //cerrar la conexión
        mysqli_close($bd);

        incluirTemplate('footer') 
     ?>