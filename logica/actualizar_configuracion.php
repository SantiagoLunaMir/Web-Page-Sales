<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($password) && $password === $confirm_password) {
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE usuarios SET nombre = '$nombre', correo = '$correo' WHERE id = $user_id";
        if (mysqli_query($conexion, $sql)) {
            $sql_update_password = "UPDATE usuarios SET contrasena = '$password' WHERE id = $user_id";
            mysqli_query($conexion, $sql_update_password);

            $_SESSION['success_message'] = "Los datos se han actualizado correctamente.";
        } else {
            $_SESSION['error_message'] = "Error al actualizar los datos.";
        }
    } else {
        $_SESSION['error_message'] = "Las contraseñas no coinciden.";
    }

    header("Location: ../cuenta.php");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
?>

