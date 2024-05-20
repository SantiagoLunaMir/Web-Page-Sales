<?php
session_start();

// Comprobar si el usuario está logueado y tiene el rol adecuado
if (!isset($_SESSION['user']) || ($_SESSION['tipo'] !== 'vendedor' && $_SESSION['tipo'] !== 'admin')) {
    // Redireccionar al index.php si no es vendedor ni admin
    header("Location: index.php?error=Usuario no es vendedor");
    exit;
}
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
        /* Estilos generales */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        main {
            width: 100%;
            padding: 2rem;
            max-width: 1400px;
        }

        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin: 2rem auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 2rem;
        }

        form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        form label {
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        form select,
        form input[type="text"],
        form input[type="number"],
        form input[type="file"],
        form textarea {
            width: 100%;
            padding: 0.75rem;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        form button {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            color: #fff;
            background-color: #bb1c2c;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #2980b9;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 1rem;
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

    <main>
        <div class="container">
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
                if (isset($_GET['error'])) {
                    echo "<div class='error-message'>" . $_GET['error'] . "</div>";
                }
                ?>
            </form>
        </div>
    </main>
</body>

</html>
