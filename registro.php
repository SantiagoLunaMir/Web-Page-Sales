<?php
    session_start();
    if(isset($_SESSION['usuario'])){
        //sesion activa
        header("Location: http://localhost/Proyecto_Web/index.php");
        return;
    }

    $error_message = 'Error al procesar'; // Inicializa la variable de mensaje de error

    if(isset($_GET['error'])) {
        $error_message = $_GET['error'];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - REDCAR</title>
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
            margin: 0;
        }

        header nav {
            background-color: #ffffff;
            color: #fff;
            padding: 10px;
            border-bottom: 3px solid #000000;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #logo {
            display: flex;
            align-items: center;
        }

        #logo a {
            text-decoration: none;
            color: #000;
            margin-left: 1vw;
            margin-right: 1vw;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }

        nav ul li {
            margin-left: 1vw;
            margin-right: 1vw;
        }

        nav ul li a {
            text-decoration: none;
            color: #000;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        #register-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }

        #register-section h2 {
            margin-bottom: 1rem;
            color: #333;
        }

        #register-section form {
            display: flex;
            flex-direction: column;
        }

        #register-section label {
            margin-bottom: 0.5rem;
            color: #666;
        }

        #register-section input[type="text"],
        #register-section input[type="email"],
        #register-section input[type="password"] {
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        #register-section input[type="submit"] {
            padding: 0.5rem;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #register-section input[type="submit"]:hover {
            background-color: #2980b9;
        }

        #register-section p {
            margin-top: 1rem;
            color: #666;
        }

        #register-section a {
            color: #3498db;
        }

        footer {
            background-color: #fff;
            width: 100%;
            padding: 1rem 0;
            text-align: center;
            border-top: 3px solid #000000;
        }

        .contact-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .contact-info {
            color: #666;
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
    <section id="register-section">
        <h2>Registro de Usuario</h2>
        <?php 
            // Mostrar mensajes de error
            if(!empty($error_message)) {
                echo "<p style='color: red;'>$error_message</p>";
            }
        ?>
        <form action="./logica/registro.php" method="POST">
            <label for="username">Nombre de usuario:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <p>Selecciona tu rol:</p>
            <input type="radio" id="comprador" name="rol" value="comprador" checked>
            <label for="comprador">Comprador</label><br>
            <input type="radio" id="vendedor" name="rol" value="vendedor">
            <label for="vendedor">Vendedor</label><br><br>

            <input type="submit" value="Registrarse">
        </form>
    </section>
</main>

<footer> 
    <div class="contact-container">
        <div class="contact-info">
            Contacto: ventas@redcar.com o utiliza nuestro teléfono: +52 12345678
        </div>
    </div>
</footer>

</body>
</html>
