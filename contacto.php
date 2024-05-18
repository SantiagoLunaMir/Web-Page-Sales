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
        <div>
            <div class="contact-container">
                <div class="contact-left">
                    <div class="contact-contact">
                        Contacto.
                    </div>
                    <div>
                        ¿Tienes alguna pregunta?
                    </div>
                    <div class="contact-txt">
                        Si requieres asistencia durante el proceso de venta o alguna otra información que podamos
                        proveer, estaremos felices de ayudar.
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
                            <input type="text" id="nombre" name="nombre" required><br><br>

                            <label for="email">Correo electrónico:</label>
                            <input type="email" id="email" name="email" required><br><br>

                            <label for="telefono">Teléfono:</label>
                            <input type="tel" id="telefono" name="telefono"><br><br>

                            <label for="mensaje">Mensaje:</label><br>
                            <textarea id="mensaje" name="mensaje" rows="4" cols="50"></textarea><br><br>

                            <input class="btn-right-v1" type="submit" value="Enviar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'success') {
        echo "<div>Mensaje enviado correctamente.</div>";
    }
    ?>

    <footer>
        <div>
            Contacto: ventas@redcar.com o utiliza nuestro teléfono: +52 12345678
        </div>
    </footer>

</body>

</html>
