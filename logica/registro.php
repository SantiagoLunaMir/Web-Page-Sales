<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["email"])) {
        header("Location: http://localhost/proyecto_Web/registro.php?error=Datos incompletos");
        exit();
    }

    $username = mysqli_real_escape_string($conexion, $_POST["username"]);
    $password = mysqli_real_escape_string($conexion, $_POST["password"]);
    $email = mysqli_real_escape_string($conexion, $_POST["email"]);
    $rol = $_POST['rol'];

    if ($rol == 'vendedor') {
        $rol_valor = 'vendedor';
    } else {
        $rol_valor = 'comprador'; //valor por defecto para comprador
    }

    $sql = "INSERT INTO usuarios (nombre, correo, contrasena, tipo) VALUES ('$username', '$email', '$password', '$rol_valor')";

    try {
        if (mysqli_query($conexion, $sql)) {
            header("Location: http://localhost/Proyecto_Web/login.php");
        } else {
            throw new Exception(mysqli_error($conexion));
        }
    } catch (Exception $e) {
        header("Location: http://localhost/Proyecto_Web/registro.php?error=" . urlencode($e->getMessage()));
    }
}
?>
