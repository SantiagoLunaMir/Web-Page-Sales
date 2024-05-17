<?php
require 'conexion.php';

// Verificar la recepción de los datos necesarios
if (!isset($_POST["id"]) || !isset($_POST["marca"]) || !isset($_POST["nombre"]) || !isset($_POST["descripcion"]) 
|| !isset($_POST["activo"]) || !isset($_POST["estado_n_u"]) || !isset($_POST["precio"])) {
    header("Location: http://localhost/proyecto/updateCar.php?error=Datos incompletos");
    exit;
}

$id = intval($_POST["id"]);
$marca = $_POST["marca"];
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$activo = $_POST["activo"] === '1' ? 1 : 0;
$estado = $_POST["estado_n_u"];
$precio = floatval($_POST["precio"]);

// Consulta preparada para actualizar los datos del carro en la base de datos
$sql = "UPDATE coches SET marca = ?, nombre = ?, descripcion = ?, activo = ?, estado = ?, precio = ? WHERE id = ?";
$params = [$marca, $nombre, $descripcion, $activo, $estado, $precio, $id];

try {
    // Preparar la sentencia
    $stmt = $pdo->prepare($sql);

    // Ejecutar la sentencia con los datos
    $stmt->execute($params);

    header("Location: http://localhost/proyecto/readCar.php?id=" . $id);
    exit;
} catch (PDOException $e) {
    header("Location: http://localhost/proyecto/readCar.php?id=" . $id . urlencode($e->getMessage()));
    exit;
}
?>
