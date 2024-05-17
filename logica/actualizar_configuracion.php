<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }

    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validar y actualizar los datos del usuario
    if (!empty($password) && $password === $confirm_password) {
        // Actualizar nombre y correo
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE usuarios SET nombre = '$nombre', correo = '$correo' WHERE id = $user_id";
        if (mysqli_query($conexion, $sql)) {
            // Actualizar contraseña si se proporcionó una nueva
            $sql_update_password = "UPDATE usuarios SET contrasena = '$password' WHERE id = $user_id";
            mysqli_query($conexion, $sql_update_password);

            // Mensaje de éxito
            $_SESSION['success_message'] = "Los datos se han actualizado correctamente.";
        } else {
            $_SESSION['error_message'] = "Error al actualizar los datos.";
        }
    } else {
        $_SESSION['error_message'] = "Las contraseñas no coinciden.";
    }

    // Redireccionar a cuenta.php
    header("Location: ../cuenta.php");
    exit();
} else {
    // Redireccionar si se intenta acceder directamente a este script sin enviar datos de formulario
    header("Location: ../index.php");
    exit();
}
?>

