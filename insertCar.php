<?php
    session_start();  // Iniciar sesión solo una vez al principio

    // Comprobar si el usuario está logueado y tiene el rol adecuado
    if (!isset($_SESSION['user']) || ($_SESSION['tipo'] !== 'vendedor' && $_SESSION['tipo'] !== 'admin')) {
        // Redireccionar al index.php si no es vendedor ni admin
        header("Location: index.php?error=Usuario no es vendedor");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
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
        form{
            display: flex;
            flex-direction: column;
            width: 500px;
            margin: auto;
        }

        form *{
            margin-bottom: 5px;
        }

        h1{
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

    <h1>Vender Carro</h1>
    <form action="logica/insertCar.php" method="POST" enctype="multipart/form-data">
        <label for="marca">Marca</label>
        <select name="marca" required>
            <option value="">Seleccione una marca</option>
            <option value="Toyota">Toyota</option>
            <option value="Ford">Ford</option>
            <option value="Chevrolet">Chevrolet</option>
            <option value="Honda">Honda</option>
            <option value="Nissan">Nissan</option>
            <option value="BMW">BMW</option>
            <option value="Mercedes">Mercedes</option>
            <option value="Volkswagen">Volkswagen</option>
            <option value="Hyundai">Hyundai</option>
            <option value="Otros">Otros</option>
        </select>
    
    <label for="nombre">Nombre</label>
    <input name="nombre" type="text" required>
    
    <label for="descripcion">Descripción</label>
    <textarea name="descripcion" required></textarea>
    
    <label for="imagen">Imagen</label>
    <input type="file" name="imagen" required>
    
    <label for="activo">Activo</label>
    <select name="activo">
        <option value="1">Sí</option>
        <option value="0">No</option>
    </select>
    
    <label for="estado_n_u">Estado (Nuevo/Usado)</label>
    <select name="estado_n_u">
        <option value="nuevo">Nuevo</option>
        <option value="usado">Usado</option>
    </select>
    
    <label for="precio">Precio</label>
    <input name="precio" type="number" step="0.01" required>

    <button type="submit">Insertar</button>

    <?php
        if(isset($_GET['error'])){
            echo "<span>". $_GET['error'] ."</span>";
        }
    ?>
</form>
    
</body>
</html>