<?php

    // echo"<pre>";
    // var_dump($_GET);
    // echo"</pre>";

// validar por Id valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);
// var_dump($id);

if(!$id){
    header('location: /admin');
}

require '../../includes/config/database.php';

$bd = conectarBB();

//consultar para obtener los datos de la propiedad
$consulta = "SELECT * FROM propiedades WHERE id = ${id}";
$resultado = mysqli_query($bd, $consulta);
$propiedad = mysqli_fetch_assoc($resultado);

//   echo"<pre>";
//     var_dump($propiedad);
//     echo"</pre>";

//consultar para obtener los vendedores

$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($bd, $consulta);

//Arreglo con mensaje de errores

$errores = [];

    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamiento = $propiedad['estacionamiento'];
    $vendedorId = $propiedad['vendedorId'];
    $imagenPropiedad = $propiedad['imagen'];



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*echo "<pre>";
    var_dump($_POST);
    echo "</pre>";*/

     /*echo "<pre>";
    var_dump($_FILES);
    echo "</pre>";*/

   

    $titulo = mysqli_real_escape_string($bd, $_POST['titulo']);
    $precio = mysqli_real_escape_string($bd, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($bd, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($bd, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($bd, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($bd, $_POST['estacionamiento']);
    $vendedorId = mysqli_real_escape_string($bd, $_POST['vendedor']);
    $creado = date('Y/m/d');

    //asignar imagen a una variable

    $imagen = $_FILES['imagen'];


    /*echo "<pre>";
    var_dump($_FILES);
    echo "</pre>";*/


    

    if (!$titulo) {
        $errores[] = "Debes agregar un Titulo de Propiedad";
    }

    if (!$precio) {
        $errores[] = "Debes agregar un Precio a la  Propiedad";
    }

    if (strlen($descripcion) < 50) {
        $errores[] = "La Descripcion es Obligatoria y debe tenes como mínimo 50 caracteres";
    }

    if (!$habitaciones) {
        $errores[] = "Debes agregar la cantidad de Habitaciones";
    }

    if (!$wc) {
        $errores[] = "Debes agregar la cantidad de BaÑOs";
    }

    if (!$estacionamiento) {
        $errores[] = "Debes agregar los lugares de estacionamiento";
    }

    if (!$vendedorId) {
        $errores[] = "Debes seleccionar un Vendedor";
    }

    // if(!$imagen['name'] || $imagen['error']){
    //     $errores[] = 'La Imagen es Obligatoria';
    // }

    //validar por peso 100 kb

    $medida = 1000 * 1000;

    if($imagen['size'] > $medida){
        $errores[] = 'La imagen es muy pesada';
    }


    if (empty($errores)) {

        //Crear carpeta imagen

        $carpetaImagen = '../../imagenes/';

         if(!is_dir($carpetaImagen)){
             mkdir($carpetaImagen);
         }

        $nombreImagen = '';

        // /* SUBIDA DE ARCHIVO IMAGEN */

        if( $imagen ['name'] ){

            //eliminar imagen previa
            unlink($carpetaImagen . $propiedad['imagen']);

            // //generar un nombre único
            $nombreImagen = md5( uniqid( rand(). true)) . ".jpg";

            // //subir la imagen 
            move_uploaded_file($imagen['tmp_name'], $carpetaImagen . $nombreImagen);            

        } else{
            $nombreImagen = $propiedad['imagen'];
        }       

        

        

        // Insertar en la base de datos

        $query = "UPDATE propiedades SET titulo = '${titulo}', precio = ${precio}, imagen = '${nombreImagen}', descripcion = '${descripcion}', habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento}, vendedorId = ${vendedorId} WHERE id = ${id} ";

        // echo($query);

        // exit;


        $resultado = mysqli_query($bd, $query);

        if ($resultado) {
           //redireccionar al usuario después de que se valido su entrada

            header('Location: /admin?resultado=2');

        }
    }




}

require '../../includes/funciones.php';

incluirTemplate('header');

?>

<main class="contenedor seccion">

<h1>Actualizar Propiedad</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
    <?php echo $error; ?>
        </div>
    
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input value="<?php echo $titulo ?>" type="text" id="titulo" name="titulo" placeholder="Titulo de la Propiedad">

            <label for="precio">Precio:</label>
            <input value="<?php echo $precio ?>" type="number" id="precio" name="precio" placeholder="Precio de la Propiedad">

            <label for="imagen">Imagen:</label>
            <input  type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
           
            <img class="imagen-actualizar" src="/imagenes/<?php echo $imagenPropiedad; ?>" alt="">
           
            <label for="descripcion">descripción:</label>
            <textarea name="descripcion" id="descripcion"><?php echo $descripcion ?></textarea>

        </fieldset>

        <fieldset>
            <legend>Información de la Propiedad</legend>

            <label for="habitaciones">Habitacion:</label>
            <input value="<?php echo $habitaciones ?>" type="number" id="habitaciones" name="habitaciones" min="1" max="9">

            <label for="wc">Baños:</label>
            <input value="<?php echo $wc ?>" type="number" id="wc" name="wc" min="1" max="9">

            <label for="estacionamiento">Estacionamiento:</label>
            <input value="<?php echo $estacionamiento ?>" type="number" id="estacionamiento" name="estacionamiento" min="1" max="9">


        </fieldset>

        <fieldset>
            <legend>Vendedores</legend>

            <select  name="vendedor">
               
                <option value="" > --Selecciona-- </option>
                
                <?php while($vendedor = mysqli_fetch_assoc($resultado)) { ?>                
                
                    <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id'];?>"> 
                
                    <?php echo $vendedor ['nombre'] . " " . $vendedor['apellido']; ?> </option>

                <?php } ?>    
            </select>

            

        </fieldset> 


        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>


</main>


<?php incluirTemplate('footer') ?>