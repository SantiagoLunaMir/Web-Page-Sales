<?php
    require 'conexion.php';
  
    if(!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["email"])){
        header("Location: http://localhost/proyecto_Web/registro.php?error=Datos incompletos");
        return;
    }
 
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $rol  = $_POST['rol'];

    // Asignación de valor de rol
    if ($rol == 'vendedor') {
        $rol_valor = 2;
    } elseif ($rol == 'comprador') {
        $rol_valor = 3;
    }

    // Cifrar contraseña, se tendría que modificar la sentencia en sql pasandole $password_hash
    //$password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Consulta SQL corregida con variables adecuadas
    $sql = "INSERT INTO usuarios (user, pass, Correo, Permisos) VALUES ('$username', '$password', '$email', '$rol_valor')";

    try{
        mysqli_query($conexion, $sql);
        header("Location: http://localhost/Proyecto_Web/index.php");//Hacer un saludo si tiene ya una cuenta y sus estado
    }catch(Exception $e){
        header("Location: http://localhost/Proyecto_Web/registro.php?error=" . $e->getMessage());
    }
?>
