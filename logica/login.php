<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];  // Usar correo para el login
    $password = $_POST['password'];

    // Usar consultas preparadas para prevenir inyección SQL
    $stmt = $conexion->prepare("SELECT id, nombre, correo, contrasena, tipo FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['contrasena'];
        echo "  ";
        echo $password;
        if ($password === $row['contrasena']) {
            // Las credenciales son válidas, iniciar sesión
            $_SESSION['user_id'] = $row['id'];  // Guardar id de usuario
            $_SESSION['user_name'] = $row['nombre'];  // Guardar nombre de usuario
            $_SESSION['user'] = $row['correo'];  // Guardar correo en sesión
            $_SESSION['tipo'] = $row['tipo'];  // Guardar tipo de usuario
            header("Location: ../index.php"); // Redirigir a la página principal
            exit(); 
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
