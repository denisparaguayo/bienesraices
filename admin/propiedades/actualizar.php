<?php

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

require '../../includes/app.php';
estaAutenticado();


// validar por Id valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);
// var_dump($id);

if (!$id) {
    header('location: /admin');
}

//consultar para obtener los datos de la propiedad
$propiedad = Propiedad::find($id);



//consultar para obtener los vendedores

$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($bd, $consulta);

//Arreglo con mensaje de errores

$errores = Propiedad::getErrores();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Asignar los Atributos
    $argc = $_POST['propiedad'];

    $propiedad->sincronizar($argc);

    //Validación 
    $errores = $propiedad->validar();

    //!generar un nombre único
    $nombreImagen = md5(uniqid(rand() . true)) . ".jpg";

    //Subida de Archivo
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImagen($nombreImagen);
    }


    if (empty($errores)) {
        //Almacenar la Imagen
        $image->save(CARPETA_IMAGENES . $nombreImagen);


        $propiedad->guardar();
    }
}

incluirTemplate('header');

?>

<main class="contenedor seccion">

    <h1>Actualizar Propiedad</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>

    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">

        <?php include '../../includes/templates/formularios_propiedades.php' ?>


        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>


</main>


<?php incluirTemplate('footer') ?>