<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $mensaje = $_POST["mensaje"];

    $sql = "INSERT INTO mensajes (nombre, email, telefono, mensaje) VALUES (?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conexion, $sql);
    
    mysqli_stmt_bind_param($stmt, "ssss", $nombre, $email, $telefono, $mensaje);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conexion);
        header("Location: ../contacto.php?mensaje=success");
        exit();
    } else {
        echo "Error al enviar el mensaje: " . mysqli_error($conexion);
    }
}
?>
