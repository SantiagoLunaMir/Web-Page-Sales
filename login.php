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
        <section id="login-section">
            <div class="login-container">
                <h2>Iniciar sesión</h2>
                <form action="./logica/login.php" method="POST">
                    
                    <label for="correo">Correo del usuario:</label>
                    <input type="text" name="correo" required><br><br>

                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required><br><br>

                    <input type="submit" value="Iniciar sesión">
                    <?php 
                // Verificar si hay un error y mostrarlo
                if(isset($_GET['error'])) {
                    echo "<p style='color: red;'>{$_GET['error']}</p>";
                }
                ?>
                </form>
                <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>.</p> 
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
