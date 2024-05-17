<?php 
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "coches";

    // Conexión con mysqli
    $conexion = mysqli_connect($host, $user, $pass, $bd);
<<<<<<< HEAD

    if (!$conexion) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }
    
    try {
        // Conexión usando PDO
=======
    if (!$conexion) {
        die("Error de conexión con mysqli: " . mysqli_connect_error());
    }

    // Conexión con PDO
    try {
>>>>>>> mike
        $pdo = new PDO("mysql:host=$host;dbname=$bd;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("No se pudo conectar a la base de datos $bd :" . $e->getMessage());
    }
<<<<<<< HEAD
?>
=======
?>
>>>>>>> mike
