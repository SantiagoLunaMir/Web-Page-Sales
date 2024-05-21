<?php
    session_start();
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
    <title>Editar Carro</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/jpg" href="Logored.jpg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        form {
            display: flex;
            flex-direction: column;
            width: 500px;
            margin: auto;
        }
        form * {
            margin-bottom: 5px;
        }
        h1 {
            text-align: center;
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

<h1>Editar Carro</h1>
<form action="logica/updateCar.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <label for="marca">Marca</label>
    <select name="marca" required>
        <option value="">Seleccione una marca</option>
        <?php
        $marcas = ["Toyota", "Ford", "Chevrolet", "Honda", "Nissan", "BMW", "Mercedes", "Volkswagen", "Hyundai", "Otros"];
        foreach ($marcas as $marca) {
            $selected = $row['marca'] == $marca ? 'selected' : '';
            echo "<option value='$marca' $selected>$marca</option>";
        }
        ?>
    </select>

    <label for="nombre">Nombre</label>
    <input name="nombre" type="text" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>

    <label for="descripcion">Descripción</label>
    <textarea name="descripcion" required><?php echo htmlspecialchars($row['descripcion']); ?></textarea>

    <label for="precio">Precio</label>
    <input name="precio" type="number" value="<?php echo htmlspecialchars($row['precio']); ?>" step="0.01" required>

    <label for="activo">Activo</label>
    <select name="activo">
        <option value="1" <?php echo $row['activo'] ? 'selected' : ''; ?>>Sí</option>
        <option value="0" <?php echo !$row['activo'] ? 'selected' : ''; ?>>No</option>
    </select>

    <label for="estado_n_u">Estado (Nuevo/Usado)</label>
    <select name="estado_n_u">
        <option value="nuevo" <?php echo $row['estado'] == 'nuevo' ? 'selected' : ''; ?>>Nuevo</option>
        <option value="usado" <?php echo $row['estado'] == 'usado' ? 'selected' : ''; ?>>Usado</option>
    </select>

    <button type="submit">Actualizar</button>
</form>
</body>
</html>
