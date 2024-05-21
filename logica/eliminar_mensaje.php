<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['user_id']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['message_id'])) {
    $message_id = $_POST['message_id'];
    
    $sql_delete = "DELETE FROM mensajes WHERE id = $message_id";
    if (mysqli_query($conexion, $sql_delete)) {
        $_SESSION['success_message'] = "El mensaje ha sido eliminado correctamente.";
    } else {
        $_SESSION['error_message'] = "Hubo un problema al eliminar el mensaje. Por favor, inténtalo de nuevo.";
    }
}

header("Location: ../cuenta.php");
exit();
?>
