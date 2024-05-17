<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["id"])) {
        header("Location: http://localhost/proyecto/index.php?error=ID no proporcionado");
        exit;
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

        header("Location: http://localhost/proyecto/index.php?success=Carro eliminado correctamente");
        exit;
    } catch (PDOException $e) {
        header("Location: http://localhost/proyecto/readCar.php?id=" . $id . urlencode($e->getMessage()));
        exit;
    }
}
?>
