<?php
require '../../includes/config/database.php';

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
    //echo "<pre>";
    //var_dump($_POST);
    //echo "</pre>";

    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamiento = $_POST['estacionamiento'];
    $vendedorId = $_POST['vendedor'];

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
        $errores[] = "Debes agregar la cantidad de Banos";
    }

    if (!$estacionamiento) {
        $errores[] = "Debes agregar los lugares de estacionamiento";
    }

    if (!$vendedorId) {
        $errores[] = "Debes seleccionar un Vendedor";
    }


    if (empty($errores)) {

        // Insertar en la base de datos

        $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedorId) VAlUES ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedorId')";


        $resultado = mysqli_query($bd, $query);

        if ($resultado) {
            echo "Insertado Correctamente";
        }
    }




}

require '../../includes/funciones.php';

incluirTemplate('header');

?>

<main class="contenedor seccion">


    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
    <?php echo $error; ?>
        </div>
    
    <?php endforeach; ?>

    <form class="formulario" method="POST" action="/admin/propiedades/crear.php">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input value="<?php echo $titulo ?>" type="text" id="titulo" name="titulo" placeholder="Titulo de la Propiedad">

            <label for="precio">Precio:</label>
            <input value="<?php echo $precio ?>" type="number" id="precio" name="precio" placeholder="Precio de la Propiedad">

            <label for="imagen">Imagen:</label>
            <input  type="file" id="imagen" accept="image/jpeg, image/png">

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

            <select  name="vendedor" id="vendedor">
               
                <option value="" > --Selecciona-- </option>
                
                <?php while($vendedor = mysqli_fetch_assoc($resultado)) : ?>                
                
                    <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value=" <?php echo $vendedor['id'];?>"> 
                
                    <?php echo $vendedor ['nombre'] . " " . $vendedor['apellido']; ?> </option>

                <?php endwhile; ?>    
            </select>

            

        </fieldset> 


        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>


</main>


<?php incluirTemplate('footer') ?>