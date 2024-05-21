<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["user_id"])) {
        $_SESSION['error_message'] = "ID de usuario no proporcionado.";
        header("Location: ../cuenta.php");
        exit();
    }

    $user_id = intval($_POST["user_id"]);

    try {
        $pdo->beginTransaction();

        $sql_delete_cars = "DELETE FROM coches WHERE vendedor_id = ?";
        $stmt_delete_cars = $pdo->prepare($sql_delete_cars);
        $stmt_delete_cars->execute([$user_id]);

        $sql_delete_user = "DELETE FROM usuarios WHERE id = ?";
        $stmt_delete_user = $pdo->prepare($sql_delete_user);
        $stmt_delete_user->execute([$user_id]);

        $pdo->commit();

        $_SESSION['success_message'] = "Usuario y sus coches asociados eliminados correctamente.";
        header("Location: ../cuenta.php");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error_message'] = "Error al eliminar el usuario: " . $e->getMessage();
        header("Location: ../cuenta.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Método de solicitud no válido.";
    header("Location: ../cuenta.php");
    exit();
}
?>
