<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $mensaje = $_POST["mensaje"];

    // Preparar la consulta SQL para insertar los datos en la tabla
    $sql = "INSERT INTO mensajes (nombre, email, telefono, mensaje) VALUES (?, ?, ?, ?)";
    
    // Preparar la sentencia
    $stmt = mysqli_prepare($conexion, $sql);
    
    // Vincular los parámetros
    mysqli_stmt_bind_param($stmt, "ssss", $nombre, $email, $telefono, $mensaje);
    
    // Ejecutar la sentencia
    if (mysqli_stmt_execute($stmt)) {
        // Cerrar la sentencia y la conexión
        mysqli_stmt_close($stmt);
        mysqli_close($conexion);
        // Redirigir a la página de contacto con un parámetro indicando éxito
        header("Location: ../contacto.php?mensaje=success");
        exit();
    } else {
        echo "Error al enviar el mensaje: " . mysqli_error($conexion);
    }
}
?>
