<?php 

// importar la conexión
require 'includes/config/database.php';
$bd = conectarBB();


// crear un email y password
$email = 'correo@correo.com';
$password = '123456';
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

//query para crear usuario

$query = "INSERT INTO usuarios (email, password) VALUE ('${email}', '${passwordHash}');";

echo $query; 


// agregar a la base de datos

mysqli_query($bd, $query);




?>