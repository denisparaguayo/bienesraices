<?php
require '../../includes/app.php';

use App\Propiedad;



estaAutenticado();


$bd = conectarBB();

//consultar para obtener los vendedores

$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($bd, $consulta);

//Arreglo con mensaje de errores

$errores = [];

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedorId = '';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    $propiedad = new Propiedad($_POST);

    $propiedad -> guardar();



    $titulo = mysqli_real_escape_string($bd, $_POST['titulo']);
    $precio = mysqli_real_escape_string($bd, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($bd, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($bd, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($bd, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($bd, $_POST['estacionamiento']);
    $vendedorId = mysqli_real_escape_string($bd, $_POST['vendedorId']);
    $creado = date('Y/m/d');

    //asignar imagen a una variable

    $imagen = $_FILES['imagen'];


    /*echo "<pre>";
    var_dump($_FILES);
    echo "</pre>";*/




    if (!$titulo) {
        $errores[] = "Debes agregar un Titulo de Propiedad &#9888;";
    }

    if (!$precio) {
        $errores[] = "Debes agregar un Precio a la  Propiedad &#9888;";
    }

    if (strlen($descripcion) < 50) {
        $errores[] = "La Descripcion es Obligatoria y debe tenes como mínimo 50 caracteres &#9888;";
    }

    if (!$habitaciones) {
        $errores[] = "Debes agregar la cantidad de Habitaciones &#9888;";
    }

    if (!$wc) {
        $errores[] = "Debes agregar la cantidad de BaÑOs &#9888;";
    }

    if (!$estacionamiento) {
        $errores[] = "Debes agregar los lugares de estacionamiento &#9888;";
    }

    if (!$vendedorId) {
        $errores[] = "Debes seleccionar un Vendedor &#9888;";
    }

    if (!$imagen['name'] || $imagen['error']) {
        $errores[] = 'La Imagen es Obligatoria &#9888;';
    }

    //validar por peso 100 kb

    $medida = 1000 * 1000;

    if ($imagen['size'] > $medida) {
        $errores[] = 'La imagen es muy pesada &#9888;';
    }


    if (empty($errores)) {


        /* SUBIDA DE ARCHIVO IMAGEN */

        /*Crear carpeta imagen*/

        $carpetaImagen = '../../imagenes/';

        if (!is_dir($carpetaImagen)) {
            mkdir($carpetaImagen);
        }

        //generar un nombre único

        $nombreImagen = md5(uniqid(rand() . true)) . ".jpg";

        //subir la imagen

        move_uploaded_file($imagen['tmp_name'], $carpetaImagen . $nombreImagen);

                

        

        if ($resultado) {
            //redireccionar al usuario después de que se valido su entrada

            header('Location: /admin?resultado=1');
        }
    }
}



incluirTemplate('header');

?>

<main class="contenedor seccion">

    <h1>Crear Propiedad</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>

    <?php endforeach; ?>

    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input value="<?php echo $titulo ?>" type="text" id="titulo" name="titulo" placeholder="Titulo de la Propiedad">

            <label for="precio">Precio:</label>
            <input value="<?php echo $precio ?>" type="number" id="precio" name="precio" placeholder="Precio de la Propiedad">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

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

            <select name="vendedorId">

                <option value=""> --Selecciona-- </option>

                <?php while ($vendedor = mysqli_fetch_assoc($resultado)) { ?>

                    <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>">

                        <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?> </option>

                <?php } ?>
            </select>



        </fieldset>


        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>


</main>


<?php incluirTemplate('footer') ?>