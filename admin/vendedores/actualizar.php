<?php
require '../../includes/app.php';
use App\Vendedor;
//ESTA AUTENTICADO
estaAutenticado();


//Validar que sea ID valido

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id){
    header('Location: /admin');
}

//Obtener el Arreglo del vendedor
$vendedor = Vendedor::find($id);


//Arreglo con mensaje de errores
$errores = Vendedor::getErrores();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //asignar los Valores
    $argc = $_POST['vendedor'];
    
    //Sincronizar Objeto en Memoria con los que el usuario escribió
    $vendedor->sincronizar($argc);
    
    //validacion

    $errores = $vendedor->validar();

    if(empty($errores)){

        $vendedor->guardar();

        debug($vendedor);
    }

}


incluirTemplate('header');

?>

<main class="contenedor seccion">

    <h1>Actualizar Vendedor</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>

    <?php endforeach; ?>

    <form class="formulario" method="POST">
            
        <?php include '../../includes/templates/formulario_vendedores.php' ?>


        <input type="submit" value="Guardar Cambios" class="boton boton-verde">
    </form>


</main>


<?php incluirTemplate('footer') ?>