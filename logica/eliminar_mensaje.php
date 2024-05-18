<?php
session_start();
require 'conexion.php';

// Verificar si el usuario está autenticado y es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Verificar si se recibió un ID de mensaje para eliminar
if (isset($_POST['message_id'])) {
    $message_id = $_POST['message_id'];
    
    // Consulta para eliminar el mensaje de la base de datos
    $sql_delete = "DELETE FROM mensajes WHERE id = $message_id";
    if (mysqli_query($conexion, $sql_delete)) {
        $_SESSION['success_message'] = "El mensaje ha sido eliminado correctamente.";
    } else {
        $_SESSION['error_message'] = "Hubo un problema al eliminar el mensaje. Por favor, inténtalo de nuevo.";
    }
}

// Redirigir de nuevo a la página de administración de mensajes
header("Location: ../cuenta.php");
exit();
?>
