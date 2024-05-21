<?php
session_start();
require 'logica/conexion.php';

$sql = "SELECT * FROM coches ORDER BY RAND() LIMIT 1";
$result = mysqli_query($conexion, $sql);
$car_of_the_day = mysqli_fetch_assoc($result);
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

<section id="car-of-the-day">
    <div class="car-info">
        <div class="car-text">
            Vehículo del día.
        </div>
        <?php if ($car_of_the_day): ?>
            <img src="imagenes/<?php echo htmlspecialchars($car_of_the_day['fotografia']); ?>" width="50%" height="60%" alt="Vehículo del Día">
        <?php else: ?>
            <p>No hay vehículos disponibles.</p>
        <?php endif; ?>
    </div>
</section>

<section id="car-gallery">
    <div class="rowsportal">
        <div class="left50">
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
        <div class="rigth50">
            <div class="resume-gallery">
                Descubre el mundo motor desde la compra y venta de coches y motocicletas a tu servicio, nuevos, usados, deportivos, chopers, coupes, sedandes, DE TODO.
                No lo dudes más y encuentra tu auto ideal o tu Vehículo de transporte idoeno. 
            </div>
            <div class="button-container">
                <a class="btn-right" href="catalog.php">MÁS</a>
            </div>
        </div>
    </div>
</section>

<footer> 
    <div class="">
        <div class="">
            Contacto: ventas@redcar.com o utiliza nuestro teléfono: +52 12345678
        </div>
        </div>
    

    </div>
</footer>

</body>
</html>
