<?php
require '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;


//*ESTA AUTENTICADO
estaAutenticado();


//!conectar a la BD
$bd = conectarBB();

$propiedad = new Propiedad;

//consultar para obtener los vendedores

$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($bd, $consulta);

//Arreglo con mensaje de errores

$errores = Propiedad::getErrores();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    
    
        //*CREA UNA NUEVA INSTANCIA
        $propiedad = new Propiedad($_POST['propiedad']);
        /* SUBIDA DE ARCHIVO IMAGEN */             
        
        //!generar un nombre único
        $nombreImagen = md5(uniqid(rand() . true)) . ".jpg";

        //*Setea la Imagen
        //*Realiza un rezise a la imagen con Intervention
        if($_FILES['propiedad']['tmp_name']['imagen']){
            $image = Image::make ($_FILES['propiedad']['tmp_name']['imagen']) -> fit (800,600);
            $propiedad->setImagen($nombreImagen);
        }
        

        //*Validar
        $errores = $propiedad->validar();

        
    if (empty($errores)) {
        
        //Crear la Carpeta para subir imagenes
        if(!is_dir(CARPETA_IMAGENES)){
            mkdir(CARPETA_IMAGENES);
        }
        
        //Guarda la Imagen en el servidor
        $image->save(CARPETA_IMAGENES . $nombreImagen);
        
        //Guarda en la Base de Datos
        $resultado = $propiedad -> guardar();
        
        //*Mensaje de Exito 
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
            
        <?php include '../../includes/templates/formularios_propiedades.php' ?>


        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>


</main>


<?php incluirTemplate('footer') ?>