<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    $sql = "DELETE FROM usuarios WHERE id = $user_id";

    if (mysqli_query($conexion, $sql)) {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

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
