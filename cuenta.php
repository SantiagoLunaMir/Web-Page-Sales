<?php
session_start();
require 'logica/conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_comentario"])) {
    require 'logica/eliminar_comentario.php';
    exit();
}

// Obtener los datos actuales del usuario
$user_id = $_SESSION['user_id'];
$sql = "SELECT nombre, correo, tipo FROM usuarios WHERE id = $user_id";
$result = mysqli_query($conexion, $sql);
$user = mysqli_fetch_assoc($result);

// Función para obtener el número de productos de un vendedor
function get_product_count($conexion, $vendedor_id)
{
    $sql = "SELECT COUNT(*) as product_count FROM coches WHERE vendedor_id = $vendedor_id";
    $result = mysqli_query($conexion, $sql);
    $data = mysqli_fetch_assoc($result);
    return $data['product_count'];
}

// Consulta SQL para seleccionar los mensajes de la base de datos
$sql_messages = "SELECT id, nombre, email, mensaje FROM mensajes";
$result_messages = mysqli_query($conexion, $sql_messages);

// Verificar si la consulta tuvo éxito
if ($result_messages) {
    // Crear un array para almacenar los mensajes
    $messages = array();

    // Recorrer los resultados y guardarlos en el array $messages
    while ($row = mysqli_fetch_assoc($result_messages)) {
        $messages[] = $row;
    }
} else {
    // Si la consulta falla, mostrar un mensaje de error
    echo "Error al obtener los mensajes: " . mysqli_error($conexion);
    // Puedes manejar el error de otra manera si lo prefieres
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Usuario - REDCAR</title>
    <!--<link rel="stylesheet" href="styles.css">-->
    <link rel="icon" type="image/jpg" href="Logored.jpg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        /* Estilos para el contenedor del logo y texto */
        #logo {
            display: inline-block;
            vertical-align: middle;
        }

        /* Estilos para el logo */
        #logo img {
            vertical-align: middle; 
            margin-right: 10px; 
        }

        /* Barra de navegación */
        header nav {
            vertical-align: middle;
        }
        nav {
            background-color: #ffffff;
            color: #fff;
            padding: 10px;
            border-bottom: 3px solid #000000;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        nav a {
            text-decoration: none; 
            color: #000; 
            margin-right: 1vw; 
            margin-left: 1vw;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline-block;
        }

        nav ul li a {
            text-decoration: none;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        } 
        main {
            width: 100%;
            padding: 2rem;
            max-width: 1400px;
        }
        .settings-container, .admin-container, .vendedor-container, .user-comments-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        .settings-container h2, .admin-container h2, .vendedor-container h2, .user-comments-container h2 {
            text-align: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        input[type="text"], input[type="email"], input[type="password"], textarea {
            width: 100%;
            padding: 0.75rem;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }
        input[type="submit"], button {
            align-self: flex-end;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            color: #fff;
            background-color: #bb1c2c;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #3498db;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #bb1c2c ;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        @media (max-width: 768px) {
            nav a {
                margin: 5px 0;
            }
            .settings-container, .admin-container, .vendedor-container, .user-comments-container {
                padding: 1rem;
            }
            table th, table td {
                padding: 0.5rem;
            }
            table {
                font-size: 0.9rem;
            }
            form input[type="submit"], form button {
                align-self: center;
                width: 100%;
            }
        }
        @media (max-width: 480px) {
            nav {
                flex-direction: column;
                align-items: center;
            }
            nav a {
                margin: 5px 0;
            }
            .settings-container, .admin-container, .vendedor-container, .user-comments-container {
                width: 100%;
                padding: 1rem;
                margin: 0.5rem 0;
            }
            table th, table td {
                padding: 0.5rem;
            }
            table {
                font-size: 0.8rem;
            }
            form input[type="submit"], form button {
                align-self: center;
                width: 100%;
            }
        }
    </style>
</head>
<body>

<header>
    <nav id="logo">
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
    </nav>
</header>

<main>
    <section id="user-settings">
        <div class="settings-container">
            <h2>Configuración de Usuario</h2>
            <?php if (isset($_SESSION['success_message'])): ?>
                <p style="color: green;"><?php echo $_SESSION['success_message']; ?></p>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['error_message'])): ?>
                <p style="color: red;"><?php echo $_SESSION['error_message']; ?></p>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
            <form action="./logica/actualizar_configuracion.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>

                <label for="correo">Correo:</label>
                <input type="email" name="correo" value="<?php echo htmlspecialchars($user['correo']); ?>" required>

                <label for="password">Nueva Contraseña:</label>
                <input type="password" name="password">

                <label for="confirm_password">Confirmar Contraseña:</label>
                <input type="password" name="confirm_password">

                <input type="submit" value="Guardar cambios">
            </form>
            <form action="./logica/eliminar_cuenta.php" method="POST">
                <input type="submit" value="Eliminar cuenta">
            </form>
            <form action="logout.php" method="POST">
                <input type="submit" value="Cerrar sesión">
            </form>
        </div>
    </section>

    <?php if ($_SESSION['tipo'] == 'admin'): ?>
        <section id="admin-users">
            <div class="admin-container">
                <h2>Administración de Usuarios</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Tipo</th>
                            <th>Productos Asociados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_users = "SELECT id, nombre, correo, tipo FROM usuarios";
                        $result_users = mysqli_query($conexion, $sql_users);
                        while ($user_row = mysqli_fetch_assoc($result_users)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user_row['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($user_row['correo']); ?></td>
                                <td><?php echo htmlspecialchars($user_row['tipo']); ?></td>
                                <td>
                                    <?php
                                    if ($user_row['tipo'] == 'vendedor') {
                                        echo get_product_count($conexion, $user_row['id']);
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <form action="./logica/eliminar_usuario.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="user_id" value="<?php echo $user_row['id']; ?>">
                                        <input type="submit" value="Eliminar">
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    <?php elseif ($_SESSION['tipo'] == 'vendedor'): ?>
        <section id="vendedor-productos">
            <div class="vendedor-container">
                <h2>Mis Productos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Marca</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Fotografía</th>
                            <th>Activo</th>
                            <th>Estado</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_coches = "SELECT id, marca, nombre, descripcion, fotografia, activo, estado, precio FROM coches WHERE vendedor_id = $user_id";
                        $result_coches = mysqli_query($conexion, $sql_coches);
                        while ($car = mysqli_fetch_assoc($result_coches)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($car['marca']); ?></td>
                                <td><?php echo htmlspecialchars($car['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($car['descripcion']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($car['fotografia']); ?>" alt="Fotografía" width="100"></td>
                                <td><?php echo $car['activo'] ? 'Sí' : 'No'; ?></td>
                                <td><?php echo htmlspecialchars($car['estado']); ?></td>
                                <td><?php echo htmlspecialchars($car['precio']); ?></td>
                                <td>
                                    <form action="./logica/deleteCar.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $car['id']; ?>">
                                        <input type="submit" value="Eliminar">
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($_SESSION['tipo'] == 'admin' && !empty($messages)): ?>
        <section id="admin-messages">
            <div class="admin-container">
                <h2>Mensajes de Usuarios</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Mensaje</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $message): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($message['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($message['email']); ?></td>
                                <td><?php echo htmlspecialchars($message['mensaje']); ?></td>
                                <td>
                                    <form action="logica/eliminar_mensaje.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                        <button type="submit" name="delete_message">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    <?php endif; ?>

    <section id="user-comments">
        <div class="user-comments-container">
            <h2>Mis Comentarios</h2>
            <table>
                <thead>
                    <tr>
                        <th>Coche</th>
                        <th>Comentario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_user_comments = "SELECT comentarios.id AS comentario_id, coches.marca, coches.nombre AS nombre_coche, comentarios.comentario
                                    FROM comentarios
                                    INNER JOIN coches ON comentarios.coche_id = coches.id
                                    WHERE comentarios.usuario_id = $user_id";
                    $result_user_comments = mysqli_query($conexion, $sql_user_comments);
                    while ($user_comment = mysqli_fetch_assoc($result_user_comments)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user_comment['marca'] . ' ' . $user_comment['nombre_coche']); ?></td>
                            <td><?php echo htmlspecialchars($user_comment['comentario']); ?></td>
                            <td>
                                <form action="./logica/eliminar_comentario.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="comentario_id" value="<?php echo $user_comment['comentario_id']; ?>">
                                    <button type="submit" name="delete_comment">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
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