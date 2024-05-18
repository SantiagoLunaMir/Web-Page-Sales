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

    // Consulta preparada para eliminar el carro de la base de datos
    $sql = "DELETE FROM coches WHERE id = ?";
    $params = [$id];
    try {
        // Preparar la sentencia
        $stmt = $pdo->prepare($sql);

        // Ejecutar la sentencia con los datos
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
