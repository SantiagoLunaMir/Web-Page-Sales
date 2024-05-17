<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }

    // Obtener el ID del usuario
    $user_id = $_SESSION['user_id'];

    // Eliminar la cuenta del usuario
    $sql = "DELETE FROM usuarios WHERE id = $user_id";

    if (mysqli_query($conexion, $sql)) {
        // Destruir todas las variables de sesión.
        $_SESSION = array();

        // Si se desea destruir la sesión completamente, borra también la cookie de sesión.
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finalmente, destruir la sesión.
        session_destroy();

        // Redireccionar a la página de inicio
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error al eliminar la cuenta.";
        header("Location: ../cuenta.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
