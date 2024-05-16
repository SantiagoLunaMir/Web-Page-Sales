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
</head>
<body>

<header>
    <nav>
        <div id="logo">
            <a href="index.html"><img src="Logored.jpg" width="4%" height="3%" alt="Logo de REDCAR"></a>
            <a href="index.html">REDCAR</a>
            <a href="#"><img src="lupa.png" width="1.5%" height="0.75%" alt="Lupa"></a>
            <a href="index.html" >INICIO</a>
            <a href="comprar.html">COMPRAR</a>
            <a href="nuevos.html">NUEVOS</a>
            <a href="usados.html">USADOS</a>
            <a href="#">VENDER</a>
            <a href="contacto.html">CONTACTO</a>
            <?php
                //session_start();
                if (isset($_SESSION['user'])) {
                // Si el usuario ha iniciado sesión, muestra la imagen de logout
                    echo '<a href="logout.php"><img src="logout.png" width="1.5%" height="0.75%" alt="Logout"></a>';
                } else {
                // Si el usuario no ha iniciado sesión, muestra la imagen de login
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
            <label for="username">Nombre de usuario:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            
            <label for="email">Correo electrónico:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <p>Selecciona tu rol:</p><!--Aqui realemnte son los permisos 1 administrador, 2 vendedor, 3 comprador-->
            <input type="radio" id="comprador" name="rol" value="comprador" checked>
            <label for="comprador">Comprador</label><br>
            <input type="radio" id="vendedor" name="rol" value="vendedor">
            <label for="vendedor">Vendedor</label><br><br>

            <input type="submit" value="Registrarse">
        </form>
    </section>
</main>

<footer> 
    <div>
        <div>
            Contacto: ventas@redcar.com o utiliza nuestro teléfono: +52 12345678
        </div>
    </div>
</footer>

</body>
</html>

