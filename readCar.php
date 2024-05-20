<?php
session_start();
/*http://localhost/proyecto/readCar.php?id=2*/
require './logica/conexion.php';

if (!isset($_GET['id'])) {
    header("Location: http://localhost/proyecto/index.php?error=No se encontró el elemento");
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM coches WHERE id=" . $id;
$query = mysqli_query($conexion, $sql);

if (!$row = mysqli_fetch_array($query)) {
    header("Location: http://localhost/proyecto/index.php?error=No se encontró el producto");
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
        /* Estilos para el contenedor del logo y texto */
        #logo {
            display: inline-block;
            vertical-align: middle;
        }

        /* Estilos para el logo */
        #logo img {
            vertical-align: middle; 
            margin-right: 10px; 
        }

        /* Barra de navegación */
        header nav {
            vertical-align: middle;
        }
        nav {
            background-color: #ffffff;
            color: #fff;
            padding: 10px;
            border-bottom: 3px solid #000000;
        }
        nav a {
            text-decoration: none; 
            color: #000; 
            margin-right: 1vw; 
            margin-left: 1vw;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline-block;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
        }
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

        nav {
            background-color: #fff; /* Cambiar a blanco */
        }

        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 800px;
            width: 100%;
            margin: 1rem auto;
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
        .action-buttons {
            margin-top: 1rem;
            display: flex;
            gap: 10px;
        }
        .action-buttons button {
            padding: 10px 15px;
            font-size: 1rem;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-button {
            background-color: #3498db;
        }
        .delete-button {
            background-color: #e74c3c;
        }
        .edit-button:hover {
            background-color: #2980b9;
        }
        .delete-button:hover {
            background-color: #c0392b;
        }



        .containerForm {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 800px;
            width: 100%;
            margin: 1rem auto;
        }

        .containerForm form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .containerForm button {
            align-self: flex-end;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            color: #fff;
            background-color: #3498db;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .containerForm button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
<header>
        <nav>
            <div id="logo">
            <a href="index.php"><img src="Logored.jpg" width="4%" height="3%" alt="Logo de REDCAR"></a>
            <a href="index.php">REDCAR</a>
            <a href="catalog.php">CATALOGO</a>
            <a href="contacto.php">CONTACTO</a>
            <?php
                if (isset($_SESSION['user'])) {
                    if ($_SESSION['tipo'] == 'admin' || $_SESSION['tipo'] == 'vendedor') {
                        echo '<a href="insertCar.php">VENDER</a>';
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

    <div class="container">
    <!-- Detalles del coche aquí -->
    <img src="imagenes/<?php echo htmlspecialchars($row['fotografia']); ?>" alt="Imagen del carro" class="car-image">
    <div class="car-details">
        <h1><?php echo htmlspecialchars($row['marca'] . ' ' . $row['nombre']); ?></h1>
        <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
        <p class="price">$<?php echo number_format($row['precio'], 2); ?></p>
        <p><strong>Estado:</strong> <?php echo htmlspecialchars($row['estado']); ?></p>
        <p><strong>Activo:</strong> <?php echo $row['activo'] ? 'Sí' : 'No'; ?></p>
        <?php
            if (isset($_GET['error'])) {
                echo "<p style='color: red; text-align: center;'>" . htmlspecialchars($_GET['error']) . "</p>";
            }
        ?>
        
        <?php
        // Verifica si el usuario es el vendedor del coche o un administrador
        if (isset($_SESSION['user_id']) && (($_SESSION['user_id'] == $row['vendedor_id']) || ($_SESSION['tipo'] == 'admin'))) {
            echo '<div class="action-buttons">';
            echo '<button class="edit-button" onclick="location.href=\'updateCar.php?id=' . $id . '\'">Editar</button>';
            echo '<button class="delete-button" onclick="location.href=\'deleteCar.php?id=' . $id . '\'">Eliminar</button>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<!-- Agregar formulario para comentarios -->
<div class="containerForm">
    <h2>Agregar Comentario</h2>
    <br>
    <?php
    if (isset($_SESSION['user'])) {
        echo '<form action="./logica/insertar_comentario.php" method="POST">';
        echo '<input type="hidden" name="coche_id" value="' . $id . '">';
        echo '<textarea name="comentario" placeholder="Agrega un comentario..." required></textarea>';
        echo '<button type="submit">Enviar Comentario</button>';
        echo '</form>';
    } else {
        echo '<p>Necesitas una cuenta para agregar un comentario.</p>';
    }
    ?>
</div>

<!-- Mostrar comentarios -->
<div class="container">
    <?php
    // Consulta para obtener los comentarios del coche
    $sql_comentarios = "SELECT comentarios.*, usuarios.nombre AS nombre_usuario FROM comentarios
                        INNER JOIN usuarios ON comentarios.usuario_id = usuarios.id
                        WHERE comentarios.coche_id = $id";
    $result_comentarios = mysqli_query($conexion, $sql_comentarios);

    if (mysqli_num_rows($result_comentarios) > 0) {
        echo "<h2>Comentarios:</h2>";
        echo "<br>";
        echo "<ul>";
        while ($comentario = mysqli_fetch_assoc($result_comentarios)) {
            echo "<li><strong>{$comentario['nombre_usuario']}:</strong> {$comentario['comentario']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No hay comentarios aún.</p>";
    }
    ?>
</div>
</body>
</html>