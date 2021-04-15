<?php 

    //conectar bd

    require 'includes/app.php';
    $db = conectarBB();

    $errores = [];

    //Autenticar Usuario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        $email = mysqli_real_escape_string($db, filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) ;
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if (!$email) {
            $errores [] = "El Email es Obligatorio o no es Valido";
        }

        if (!$password) {
            $errores [] = "El Password es Obligatorio";
        }

        if(empty($errores)){

            //revisar su un usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '${email}'";
            $resultado = mysqli_query($db, $query);
            
                if ($resultado -> num_rows) {
                //revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                // verificar si el pass el correcto o no

                $auth = password_verify($password, $usuario['password']);

                if ($auth) {
                    //el usuario esta autenticado
                    session_start();
                     
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    
                    header('Location: /admin');
                    
                    //  echo "<pre>";
                    //  var_dump($_SESSION);
                    //  echo "</pre>";


                }else{
                    $errores [] = "El Password es Incorrecto";
                }    
                
            } else {
                $errores[]= "El usuario no Existe";
            }
            
        }

        // echo "<pre>";
        // var_dump($errores);
        // echo "</pre>";
        
    }


    //Incluye el Header
  

     incluirTemplate('header');

?>
    <main class="contenedor seccion contenido-centrado">
        <h1>Inicia Sesión</h1>

        <?php foreach($errores as $error) : ?>
        <div class="alerta error">
        <?php echo $error?>
        </div>

        <?php endforeach;?>

        <form method="POST" class="formulario" autocomplete="off">
            <fieldset>
                <legend>Email y Password</legend>

                <label for="email" >E-mail</label>
                <input type="email" name="email" placeholder="Tu Email" autocomplete="off" >

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Tu Password" autocomplete="off">

            </fieldset>
            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
        </form>



    </main>

    <?php incluirTemplate('footer') ?>