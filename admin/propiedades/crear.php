<?php
require '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;


//*ESTA AUTENTICADO
estaAutenticado();


//!conectar a la BD
$bd = conectarBB();

//consultar para obtener los vendedores

$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($bd, $consulta);

//Arreglo con mensaje de errores

$errores = Propiedad::getErrores();

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedorId = '';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        //*CREA UNA NUEVA INSTANCIA
        $propiedad = new Propiedad($_POST);
        /* SUBIDA DE ARCHIVO IMAGEN */             
        
        //!generar un nombre único

        $nombreImagen = md5(uniqid(rand() . true)) . ".jpg";

        //*Setea la Imagen
        //*Realiza un rezise a la imagen con Intervention
        if($_FILES['imagen']['tmp_name']){
            $image = Image::make ($_FILES['imagen']['tmp_name']) -> fit (800,600);
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