<?php
session_start();
require 'logica/conexion.php';

// Inicializar variables para los filtros
$estado_filtro = isset($_GET['estado']) ? $_GET['estado'] : '';
$marca_filtro = isset($_GET['marca']) ? $_GET['marca'] : '';

// Construir la consulta SQL con los filtros
$sql = "SELECT * FROM coches WHERE 1=1";
if ($estado_filtro) {
    $sql .= " AND estado = '$estado_filtro'";
}
if ($marca_filtro) {
    $sql .= " AND marca = '$marca_filtro'";
}

$result = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REDCAR</title>
    <link rel="stylesheet" href="styles.css"> 
    <link rel="icon" type="image/jpg" href="Logored.jpg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
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
            padding: .1rem;
        }
        #logo {
            display: inline-block;
            vertical-align: middle;
        }
        #logo a {
            text-decoration: none;
            color: #000;
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
            max-width: 1100px;
            width: 100%;
            margin: 2rem auto;
        }
        .filters {
            margin-bottom: 1rem;
        }
        .filters form {
            display: flex;
            justify-content: space-between;
        }
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        .car-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .car-item:hover {
            transform: scale(1.05);
        }
        .car-item img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
        .car-item h2 {
            color: #333;
            font-size: 1.2rem;
        }
        .car-item p {
            color: #666;
        }
        .car-item .price {
            color: #e74c3c;
            font-size: 1.5rem;
            font-weight: bold;
        }
        footer {
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 1rem 0;
            text-align: center;
        }
    </style>
</head>
<body>

<header>
        <nav>
            <div id="logo">
            <a href="index.html"><img src="Logored.jpg" width="4%" height="3%" alt="Logo de REDCAR"></a>
            <a href="index.html">REDCAR</a>
            <a href="catalog.html">CATALOGO</a>
                <a href="contacto.html">CONTACTO</a>
                <?php
                    if (isset($_SESSION['user'])) {
                        if ($_SESSION['tipo'] == 'admin' || $_SESSION['tipo'] == 'vendedor') {
                            echo '<a href="vender.php">VENDER</a>';
                        }
                        echo '<a href="cuenta.php">CUENTA</a>';
                        echo '<a href="logout.php"><img src="logout.png" width="1.5%" height="0.75%" alt="Logout"></a>';
                    } else {
                        echo '<a href="login.php"><img src="login.png" width="1.5%" height="0.75%" alt="Login"></a>';
                    }
                ?>
            </div>
        </nav>
    </header>
    
<main class="container">
    <div class="filters">
        <form method="GET" action="catalog.php">
            <div>
                <label for="estado">Estado:</label>
                <select name="estado" id="estado">
                    <option value="">Todos</option>
                    <option value="nuevo" <?php if ($estado_filtro == 'nuevo') echo 'selected'; ?>>Nuevo</option>
                    <option value="usado" <?php if ($estado_filtro == 'usado') echo 'selected'; ?>>Usado</option>
                </select>
            </div>
            <div>
                <label for="marca">Marca:</label>
                <select name="marca" id="marca">
                    <option value="">Todas</option>
                    <option value="Toyota" <?php if ($marca_filtro == 'Toyota') echo 'selected'; ?>>Toyota</option>
                    <option value="Ford" <?php if ($marca_filtro == 'Ford') echo 'selected'; ?>>Ford</option>
                    <option value="Chevrolet" <?php if ($marca_filtro == 'Chevrolet') echo 'selected'; ?>>Chevrolet</option>
                    <option value="Honda" <?php if ($marca_filtro == 'Honda') echo 'selected'; ?>>Honda</option>
                    <option value="Nissan" <?php if ($marca_filtro == 'Nissan') echo 'selected'; ?>>Nissan</option>
                    <option value="BMW" <?php if ($marca_filtro == 'BMW') echo 'selected'; ?>>BMW</option>
                    <option value="Mercedes" <?php if ($marca_filtro == 'Mercedes') echo 'selected'; ?>>Mercedes</option>
                    <option value="Volkswagen" <?php if ($marca_filtro == 'Volkswagen') echo 'selected'; ?>>Volkswagen</option>
                    <option value="Hyundai" <?php if ($marca_filtro == 'Hyundai') echo 'selected'; ?>>Hyundai</option>
                    <option value="Otros" <?php if ($marca_filtro == 'Otros') echo 'selected'; ?>>Otros</option>
                </select>
            </div>
            <button type="submit">Filtrar</button>
        </form>
    </div>

    <div class="car-grid">
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="car-item" onclick="location.href=\'readCar.php?id=' . $row['id'] . '\'">';
        echo '<img src="imagenes/' . htmlspecialchars($row['fotografia']) . '" alt="Imagen del coche">';
        echo '<h2>' . htmlspecialchars($row['marca'] . ' ' . $row['nombre']) . '</h2>';
        echo '<p>' . htmlspecialchars($row['descripcion']) . '</p>';
        echo '<p class="price">$' . number_format($row['precio'], 2) . '</p>';
        echo '</div>';
    }
    ?>
    </div>
</main>

<footer> 
    <div>
        Contacto: ventas@redcar.com o utiliza nuestro teléfono: +52 12345678
    </div>
</footer>

</body>
</html>
