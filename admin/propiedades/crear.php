<?php
require '../../includes/config/database.php';

$bd = conectarBB();

//Arreglo con mensaje de errores

$errores = [];



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
    //echo "<pre>";
    //var_dump($errores);
    //echo "</pre>";



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
            <input type="text" id="titulo" name="titulo" placeholder="Titulo de la Propiedad">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio de la Propiedad">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png">

            <label for="descripcion">descripción:</label>
            <textarea name="descripcion" id="descripcion"></textarea>

        </fieldset>

        <fieldset>
            <legend>Información de la Propiedad</legend>

            <label for="habitaciones">Habitacion:</label>
            <input type="number" id="habitaciones" name="habitaciones" min="1" max="9">

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" min="1" max="9">

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" min="1" max="9">


        </fieldset>

        <fieldset>
            <legend>Vendedores</legend>

            <select name="vendedor">
                <option value="">-->Selecciona un Vendedor<--< /option>
                <option value="1">Denis</option>
                <option value="2">Tiky</option>
            </select>

        </fieldset>


        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>


</main>


<?php incluirTemplate('footer') ?>