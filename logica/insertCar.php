<?php
session_start();
require 'conexion.php';

// Comprobar si el usuario está logueado y tiene el rol adecuado
if (!isset($_SESSION['user_id']) || ($_SESSION['tipo'] !== 'vendedor' && $_SESSION['tipo'] !== 'admin')) {
    // Redireccionar al index.php si no es vendedor ni admin
    header("Location: ../index.php?error=no es vendedor");
    exit;
}

// Verificar la recepción de los datos necesarios
if (!isset($_POST["marca"]) || !isset($_POST["nombre"]) || !isset($_POST["descripcion"]) 
    || !isset($_POST["activo"]) || !isset($_POST["estado_n_u"]) || !isset($_POST["precio"])
    || !isset($_FILES["imagen"]) || $_FILES["imagen"]["name"] == "") {
    header("Location: ../insertCar.php?error=Datos incompletos");
    exit;
}

$marca = $_POST["marca"];
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$activo = $_POST["activo"] === '1' ? 1 : 0;
$estado = $_POST["estado_n_u"];
$precio = $_POST["precio"];
$imagen = $_FILES['imagen']['name'];
$tipo = $_FILES['imagen']['type'];
$path = $_FILES['imagen']['tmp_name'];
$vendedor_id = $_SESSION['user_id'];  // ID del vendedor desde la sesión

// Lista de tipos de imagen permitidos
$tipos_permitidos = ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/svg+xml', 'image/webp'];

if (!in_array($tipo, $tipos_permitidos)) {
    header("Location: ../insertCar.php?error=Formato de imagen incorrecto");
    exit;
}

// Consulta preparada para inserción de datos en la base de datos
$sql = "INSERT INTO coches (marca, nombre, descripcion, fotografia, activo, estado, precio, vendedor_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$marca, $nombre, $descripcion, $imagen, $activo, $estado, $precio, $vendedor_id]);
    $ultimoId = $pdo->lastInsertId();

    if ($imagen && move_uploaded_file($path, "../imagenes/" . $imagen)) {
        header("Location: ../readCar.php?id=" . $ultimoId);
        exit;
    } else {
        throw new Exception("Error al mover la imagen.");
    }
} catch (Exception $e) {
    echo "Error al añadir el coche a la base de datos: " . $e->getMessage();
    // Aquí podrías redirigir a una página de error o manejar el error de otra manera
    exit;
}
?>
