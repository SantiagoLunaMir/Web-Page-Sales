<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error_message'] = "Debe iniciar sesión para agregar un comentario.";
        header("Location: ../readCar.php?id=" . $_POST['coche_id']);
        exit();
    }

    // Verificar si se proporcionó un comentario
    if (empty($_POST["comentario"])) {
        $_SESSION['error_message'] = "Debe ingresar un comentario.";
        header("Location: ../readCar.php?id=" . $_POST['coche_id']);
        exit();
    }

    // Obtener los datos del formulario
    $coche_id = $_POST["coche_id"];
    $usuario_id = $_SESSION["user_id"];
    $comentario = $_POST["comentario"];

    // Consulta preparada para insertar el comentario en la base de datos
    $sql = "INSERT INTO comentarios (coche_id, usuario_id, comentario) VALUES (?, ?, ?)";
    $params = [$coche_id, $usuario_id, $comentario];

    try {
        // Preparar la sentencia
        $stmt = $pdo->prepare($sql);

        // Ejecutar la sentencia con los datos
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
