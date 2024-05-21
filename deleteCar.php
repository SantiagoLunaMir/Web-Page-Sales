<?php
require './logica/conexion.php';
session_start(); 

if (!isset($_GET['id'])) {
    header("Location: http://localhost/proyecto/Web-Page-Sales/index.php?error=No se encontró el elemento a eliminar");
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM coches WHERE id=" . $id;
$query = mysqli_query($conexion, $sql);

if (!$row = mysqli_fetch_array($query)) {
    header("Location: http://localhost/proyecto/Web-Page-Sales/index.php?error=No se encontró el producto");
    exit;
}

if (!isset($_SESSION['user_id']) || (($_SESSION['user_id'] != $row['vendedor_id']) && ($_SESSION['tipo'] != 'admin'))) {
    header("Location: http://localhost/proyecto/readCar.php?id=" . $id . "&error=Acceso denegado");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Carro</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/jpg" href="Logored.jpg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 100%;
            margin: auto;
        }
        form * {
            margin-bottom: 15px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        p {
            text-align: center;
            color: #666;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
            color: #333;
        }
        ul li {
            background: #f4f4f9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #e74c3c;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #c0392b;
        }
        .cancel-btn {
            text-align: center;
            display: block;
            margin-top: 15px;
            color: #333;
            text-decoration: none;
            transition: color 0.3s;
        }
        .cancel-btn:hover {
            color: #e74c3c;
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

<h1>Eliminar Carro</h1>
<p>¿Estás seguro de que deseas eliminar el siguiente carro?</p>
<ul>
    <li><strong>Marca:</strong> <?php echo htmlspecialchars($row['marca']); ?></li>
    <li><strong>Nombre:</strong> <?php echo htmlspecialchars($row['nombre']); ?></li>
    <li><strong>Descripción:</strong> <?php echo htmlspecialchars($row['descripcion']); ?></li>
    <li><strong>Precio:</strong> <?php echo htmlspecialchars($row['precio']); ?></li>
</ul>
<form action="logica/deleteCar.php" method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
    <button type="submit">Eliminar</button>
    <a href="http://localhost/proyecto/Web-Page-Sales/index.php" class="cancel-btn">Cancelar</a>
</form>
</body>
</html>
