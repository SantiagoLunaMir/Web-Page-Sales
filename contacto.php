<?php
session_start();
require 'logica/conexion.php';
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
        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 1000px;
            width: 100%;
            margin: 2rem auto;
        }

        .contact-container {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .contact-left, .contact-right {
            flex: 1;
            min-width: 300px;
        }

        .contact-contact {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .contact-txt {
            margin: 1rem 0;
        }

        .contact-email li {
            list-style: none;
        }

        .title-frm {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input[type="text"], input[type="email"], input[type="tel"], textarea {
            width: 100%;
            padding: 0.75rem;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .btn-right-v1 {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            color: #fff;
            background-color: #3498db;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        .btn-right-v1:hover {
            background-color: #2980b9;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-top: 2rem;
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
    <section>
        <div class="container">
            <div class="contact-container">
                <div class="contact-left">
                    <div class="contact-contact">
                        Contacto
                    </div>
                    <div>
                        ¿Tienes alguna pregunta?
                    </div>
                    <div class="contact-txt">
                        Si requieres asistencia durante el proceso de venta o alguna otra información que podamos proveer, estaremos felices de ayudar.
                    </div>
                    <div class="contact-email">
                        E-mail:
                        <div>
                            <li>ventas@redcar.com </li>
                            <li>asistencia@redcar.com</li>
                        </div>
                    </div>
                </div>

                <div class="contact-right">
                    <div class="title-frm">
                        Formulario de Contacto
                    </div>
                    <div>
                        <form action="./logica/procesar_formulario.php" method="POST">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" required>

                            <label for="email">Correo electrónico:</label>
                            <input type="email" id="email" name="email" required>

                            <label for="telefono">Teléfono:</label>
                            <input type="tel" id="telefono" name="telefono">

                            <label for="mensaje">Mensaje:</label>
                            <textarea id="mensaje" name="mensaje" rows="4"></textarea>

                            <input class="btn-right-v1" type="submit" value="Enviar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'success') {
        echo "<div class='success-message'>Mensaje enviado correctamente.</div>";
    }
    ?>

</main>

<footer>
    <div>
        Contacto: ventas@redcar.com o utiliza nuestro teléfono: +52 12345678
    </div>
</footer>

</body>

</html>
