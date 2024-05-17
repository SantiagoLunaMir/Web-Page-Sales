<?php
    require 'conexion.php';

    // Verificar la recepción de los datos necesarios
    if (!isset($_POST["marca"]) || !isset($_POST["nombre"]) || !isset($_POST["descripcion"]) 
    || !isset($_POST["activo"]) || !isset($_POST["estado_n_u"]) || !isset($_POST["precio"])
    || !isset($_FILES["imagen"]) || $_FILES["imagen"]["name"] == "") {
        header("Location: http://localhost/proyecto/insertCar.php?error=Datos incompletos");
        exit;
    }

    $marca = $_POST["marca"];
    $vehiculo_nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $activo = $_POST["activo"] === '1' ? 1 : 0; // Asegurarse que activo sea 1 o 0
    $estado = $_POST["estado_n_u"];
    $precio = $_POST["precio"];

    // Datos del archivo de imagen
    $imagen = $_FILES['imagen']['name'];
    $tipo = $_FILES['imagen']['type'];
    $path = $_FILES['imagen']['tmp_name'];

    // Lista de tipos de imagen permitidos
    $tipos_permitidos = ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/svg+xml', 'image/webp'];

    // Verifica si el tipo de la imagen está en la lista de tipos permitidos
    if (!in_array($tipo, $tipos_permitidos)) {
        header("Location: http://localhost/proyecto/insertCar.php?error=Formato de imagen incorrecto");
        exit;
    }

    // Consulta preparada para inserción de datos en la base de datos
    $sql = "INSERT INTO coches (marca, vehiculo_nombre, descripcion, fotografia, activo, estado, precio) VALUES (?, ?, ?, ?, ?, ?, ?)";

    try {
        // Preparar la sentencia
        $stmt = $pdo->prepare($sql);

        // Ejecutar la sentencia con los datos
        $stmt->execute([$marca, $vehiculo_nombre, $descripcion, $imagen, $activo, $estado, $precio]);

        // Verificar si la imagen ha sido subida y moverla a la carpeta deseada
        if ($imagen && move_uploaded_file($path, "../imagenes/" . $imagen)) {
            echo "El coche y la imagen han sido añadidos correctamente.";
            header("Location: http://localhost/proyecto/insertCar.php?error=todo Good");
            exit;
        } else {
            throw new Exception("Error al mover la imagen.");
        }
    } catch (Exception $e) {
        echo "Error al añadir el coche a la base de datos: " . $e->getMessage();
        header("Location: http://localhost/miniProyecto/productsAdmin.php?error=" . $e->getMessage());
        exit;
    }
?>
