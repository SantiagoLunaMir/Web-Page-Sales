<?php
require 'conexion.php';
session_start(); 
if (!isset($_SESSION['user_id']) || (($_SESSION['user_id'] != $row['vendedor_id']) && ($_SESSION['tipo'] != 'admin'))) {
    header("Location: ../readCar.php?id=" . $id . "&error=Acceso denegado");
    exit;
}

if (!isset($_POST["id"]) || !isset($_POST["marca"]) || !isset($_POST["nombre"]) || !isset($_POST["descripcion"]) 
|| !isset($_POST["activo"]) || !isset($_POST["estado_n_u"]) || !isset($_POST["precio"])) {
    header("Location: updateCar.php?error=Datos incompletos");
    exit;
}

$id = intval($_POST["id"]);
$marca = $_POST["marca"];
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$activo = $_POST["activo"] === '1' ? 1 : 0;
$estado = $_POST["estado_n_u"];
$precio = floatval($_POST["precio"]);

$sql = "UPDATE coches SET marca = ?, nombre = ?, descripcion = ?, activo = ?, estado = ?, precio = ? WHERE id = ?";
$params = [$marca, $nombre, $descripcion, $activo, $estado, $precio, $id];

try {
    $stmt = $pdo->prepare($sql);

    $stmt->execute($params);

    header("Location: ../readCar.php?id=" . $id);
    exit;
} catch (PDOException $e) {
    header("Location: ../readCar.php?id=" . $id . urlencode($e->getMessage()));
    exit;
}
?>
