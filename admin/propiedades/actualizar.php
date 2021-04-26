<?php


require '../../includes/app.php';
estaAutenticado();

use App\Propiedad;
use App\vendedor;
use Intervention\Image\ImageManagerStatic as Image;

// validar por Id valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);


if (!$id) {
    header('location: /admin');
}

//consultar para obtener los datos de la propiedad
$propiedad = Propiedad::find($id);

//Consulta Para obtener todos los vendedores
$vendedores = Vendedor::all();

//Arreglo con mensaje de errores
$errores = Propiedad::getErrores();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Asignar los Atributos
    $argc = $_POST['propiedad'];

    $propiedad->sincronizar($argc);
    
    //Validación 
    $errores = $propiedad->validar();

    
    /* SUBIDA DE ARCHIVO IMAGEN */         
    //!generar un nombre único
    $nombreImagen = md5(uniqid(rand() . true)) . ".jpg";    
    //*Setea la Imagen
    //*Realiza un rezise a la imagen con Intervention
    if($_FILES['propiedad']['tmp_name']['imagen']){
        $image = Image::make ($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
        $propiedad->setImagen($nombreImagen);
    }


    if (empty($errores)) {

        //Almacenar la Imagen
        if($_FILES['propiedad']['tmp_name']['imagen']){
        $image->save (CARPETA_IMAGENES . $nombreImagen);
        }
        
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