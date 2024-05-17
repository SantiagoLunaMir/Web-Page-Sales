<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Usuario - REDCAR</title>
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
        <section id="user-settings">
            <div class="settings-container">
                <h2>Configuración de Usuario</h2>
                <!-- Mostrar mensaje de éxito si existe -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <p style="color: green;"><?php echo $_SESSION['success_message']; ?></p>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>
                <!-- Mostrar mensaje de error si existe -->
                <?php if (isset($_SESSION['error_message'])): ?>
                    <p style="color: red;"><?php echo $_SESSION['error_message']; ?></p>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>
                <form action="./logica/actualizar_configuracion.php" method="POST">
                    <!-- Campos de entrada -->
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" value="" required><br><br>

                    <label for="correo">Correo:</label>
                    <input type="email" name="correo" value="" required><br><br>

                    <label for="password">Nueva Contraseña:</label>
                    <input type="password" name="password" required><br><br>

                    <label for="confirm_password">Confirmar Contraseña:</label>
                    <input type="password" name="confirm_password" required><br><br>

                    <input type="submit" value="Guardar cambios">
                </form>
                <!-- Botón para eliminar la cuenta -->
                <form action="./logica/eliminar_cuenta.php" method="POST">
                    <input type="submit" value="Eliminar cuenta">
                </form>
                <!-- Botón para cerrar sesión -->
                <form action="logout.php" method="POST">
                    <input type="submit" value="Cerrar sesión">
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
