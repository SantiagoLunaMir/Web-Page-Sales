<?php
require './logica/conexion.php';

if (!isset($_GET['id'])) {
    header("Location: http://localhost/proyecto/Web-Page-Sales/index.php?error=No se encontró el elemento");
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM coches WHERE id=" . $id;
$query = mysqli_query($conexion, $sql);

if (!$row = mysqli_fetch_array($query)) {
    header("Location: http://localhost/proyecto/Web-Page-Sales/index.php?error=No se encontró el producto");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Carro</title>
    <link rel="icon" type="image/jpg" href="Logored.jpg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        header {
            width: 100%;
            background-color: #333;
            padding: 1rem 0;
        }
        #logo {
            display: inline-block;
            vertical-align: middle;
        }
        #logo a {
            text-decoration: none;
            color: #fff;
            margin: 0 10px;
        }
        #logo img {
            margin-right: 10px;
        }
        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 800px;
            width: 100%;
            margin: 2rem auto;
        }
        .car-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        .car-details {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .car-details h1 {
            margin: 0;
            color: #333;
        }
        .car-details p {
            margin: 0;
            color: #666;
        }
        .car-details .price {
            color: #e74c3c;
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
<header>
    <nav id="logo">
        <a href="index.html"><img src="Logored.jpg" width="4%" height="3%" alt="Logo de REDCAR"></a>
        <a href="index.html">REDCAR</a>
        <a href="comprar.html">COMPRAR</a>
        <a href="nuevos.html">NUEVOS</a>
        <a href="usados.html">USADOS</a>
        <a href="contacto.html" >CONTACTO</a>
        <a href="login.html"><img src="login.png" width="1.5%" height="0.75%" alt="Login"></a>
    </nav>
</header>

<div class="container">
    <img src="imagenes/<?php echo htmlspecialchars($row['fotografia']); ?>" alt="Imagen del carro" class="car-image">
    <div class="car-details">
        <h1><?php echo htmlspecialchars($row['marca'] . ' ' . htmlspecialchars($row['vehiculo_nombre'])); ?></h1>
        <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
        <p class="price">$<?php echo number_format(htmlspecialchars($row['precio']), 2); ?></p>
        <p><strong>Estado:</strong> <?php echo htmlspecialchars($row['estado']); ?></p>
        <p><strong>Activo:</strong> <?php echo $row['activo'] ? 'Sí' : 'No'; ?></p>
    </div>
</div>
</body>
</html>
