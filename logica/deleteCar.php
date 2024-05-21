<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["id"])) {
        $_SESSION['error_message'] = "ID no proporcionado.";
        header("Location: ../cuenta.php");
        exit();
    }

    $id = intval($_POST["id"]);

    $sql = "DELETE FROM coches WHERE id = ?";
    $params = [$id];
    try {
        $stmt = $pdo->prepare($sql);

        $stmt->execute($params);

        $_SESSION['success_message'] = "Carro eliminado correctamente.";
        header("Location: ../cuenta.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error al eliminar el carro: " . $e->getMessage();
        header("Location: ../cuenta.php");
        exit();
    }
}
?>
