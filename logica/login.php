<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];  // Usar correo para el login
    $password = $_POST['password'];

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
            $_SESSION['user_id'] = $row['id']; 
            $_SESSION['user_name'] = $row['nombre'];  
            $_SESSION['user'] = $row['correo'];  
            $_SESSION['tipo'] = $row['tipo'];  
            header("Location: ../index.php"); 
            exit(); 
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}

if (isset($error)) {
    header("Location: ../login.php?error=" . urlencode($error));
    exit();
}
?>
