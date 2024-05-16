<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $password = $_POST['password'];

    // Consulta SQL para verificar las credenciales
    $sql = "SELECT * FROM usuarios WHERE user = '$user'";
    $result = mysqli_query($conexion, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($password === $row['pass']) { // Comparar la contraseña en texto plano
            // Las credenciales son válidas, iniciar sesión
            $_SESSION['user'] = $user;
            $_SESSION['rol'] = $row['Permisos'];
            $_SESSION['saludo'] = "¡Hola, $user! Bienvenido, ¿Por dónde empezamos?.";
            header("Location: ../index.php"); // Redirigir a la página principal
            exit(); // Asegurarse de que no se ejecute más código después de la redirección
        } else {
            // Contraseña incorrecta
            $error = "Contraseña incorrecta";
        }
    } else {
        // Usuario no encontrado
        $error = "Usuario no encontrado";
    }
}

// Si se produjo un error, mostrar el mensaje de error en la página de inicio de sesión
if (isset($error)) {
    header("Location: ../login.php?error=" . urlencode($error));
    exit();
}
?>
