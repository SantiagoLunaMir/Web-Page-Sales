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
                <a href="#"><img src="lupa.png" width="1.5%" height="0.75%" alt="Lupa"></a>
                <a href="index.php" style="color: gray; font-size: 1.2vw;">INICIO</a>
                <a href="comprar.html">COMPRAR</a>
                <a href="nuevos.html">NUEVOS</a>
                <a href="usados.html">USADOS</a>
                <a href="#">VENDER</a>
                <a href="contacto.html">CONTACTO</a>
                <?php
                    session_start();
                    if (isset($_SESSION['user'])) {
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

<section id="car-of-the-day">
   <!-- Sección de "Coche del día" con una imagen grande y texto -->
    <div class="car-info">
        <div class="car-text">
            Vehículo del día.
        </div>
        <img src="BMWX1.jpeg" width="50%" height="50%" alt="Vehiculo del Dia">
    </div>
   <!-- Botón para obtener más información u otras acciones -->
</section>

<section id="car-gallery">
    <div class="rowsportal"><!-- Contenedor de reseña y coches laterales -->
        <div class="left50"><!-- Contenedor de 3 coches laterales -->
            <div class="car-gallery-img">
                <img src="blazer.jpeg" alt="Coche imagen 1">
            </div>
            <div class="car-gallery-img">
                <img src="tahoe.jpeg" alt="Coche imagen 2">
            </div>
            <div class="car-gallery-img">
                <img src="claseA.jpeg" alt="Coche imagen 3">
            </div>
        </div>
        <div class="rigth50"><!-- Contenedor de reseña y boton más -->
            <div class="resume-gallery">
                Descubre el mundo motor desde la compra y venta de coches y motocicletas a tu servicio, nuevos, usados, deportivos, chopers, coupes, sedandes, DE TODO.
                No lo dudes más y encuentra tu auto ideal o tu Vehículo de transporte idoeno. 
            </div>
            <div class="button-container">
                <button class="btn-right" href="">MÁS</button>
            </div>
        </div>
    </div>
</section>

<footer> 
    <div class=""><!-- Contenedor de contacto -->
    <?php
        //session_start();
        if (isset($_SESSION['saludo'])) {
            echo "<p>{$_SESSION['saludo']}</p>";
            // Una vez que el saludo se ha mostrado, puedes eliminarlo de la sesión para que no se muestre de nuevo
            unset($_SESSION['saludo']);
        }
    ?>
        <div class="">
            Contacto: ventas@redcar.com o utiliza nuestro teléfono: +52 12345678
        </div>
        </div>
    

    </div>
</footer>

</body>
</html>
