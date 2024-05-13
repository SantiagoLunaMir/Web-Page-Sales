<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - REDCAR</title>
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
                <a href="index.html"><img src="Logored.jpg" width="4%" height="3%" alt="Logo de REDCAR"></a>
                <a href="index.html">REDCAR</a>
                <a href="#"><img src="lupa.png" width="1.5%" height="0.75%" alt="Lupa"></a>
                <a href="index.html">INICIO</a>
                <a href="comprar.html">COMPRAR</a>
                <a href="nuevos.html">NUEVOS</a>
                <a href="usados.html">USADOS</a>
                <a href="#">VENDER</a>
                <a href="contacto.html">CONTACTO</a>
                <a href="login.php" style="color: gray; font-size: 1.2vw;">INICIAR SESIÓN</a>
            </div>
        </nav>
    </header>

    <main>
        <section id="login-section">
            <div class="login-container">
                <h2>Iniciar sesión</h2>
                <form action="procesar_login.php" method="POST">
                    <label for="username">Nombre de usuario:</label>
                    <input type="text" id="username" name="username" required><br><br>

                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required><br><br>

                    <input type="submit" value="Iniciar sesión">
                </form>
            </div>
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
