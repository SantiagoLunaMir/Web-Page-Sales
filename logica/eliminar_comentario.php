<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_comment"])) {
    $comentario_id = $_POST["comentario_id"];

    $sql = "DELETE FROM comentarios WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    
    mysqli_stmt_bind_param($stmt, "i", $comentario_id);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conexion);
        $_SESSION['success_message'] = "Comentario eliminado correctamente.";
        // Redireccionar solo si se elimina correctamente
        header("Location: ../cuenta.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error al eliminar el comentario: " . mysqli_error($conexion);
        // No redireccionar en caso de error
    }
}

// No es necesario redireccionar aquí
// header("Location: cuenta.php");
// exit();
?>

