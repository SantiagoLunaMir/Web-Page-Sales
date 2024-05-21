<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error_message'] = "Debe iniciar sesión para agregar un comentario.";
        header("Location: ../readCar.php?id=" . $_POST['coche_id']);
        exit();
    }

    if (empty($_POST["comentario"])) {
        $_SESSION['error_message'] = "Debe ingresar un comentario.";
        header("Location: ../readCar.php?id=" . $_POST['coche_id']);
        exit();
    }

    $coche_id = $_POST["coche_id"];
    $usuario_id = $_SESSION["user_id"];
    $comentario = $_POST["comentario"];

    $sql = "INSERT INTO comentarios (coche_id, usuario_id, comentario) VALUES (?, ?, ?)";
    $params = [$coche_id, $usuario_id, $comentario];

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->execute($params);

        $_SESSION['success_message'] = "Comentario agregado correctamente.";
        header("Location: ../readCar.php?id=" . $coche_id);
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error al agregar el comentario: " . $e->getMessage();
        header("Location: ../readCar.php?id=" . $coche_id);
        exit();
    }
}
?>
