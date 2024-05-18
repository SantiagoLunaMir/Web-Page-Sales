<?php
session_start();
require 'logica/conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener los datos actuales del usuario
$user_id = $_SESSION['user_id'];
$sql = "SELECT nombre, correo, tipo FROM usuarios WHERE id = $user_id";
$result = mysqli_query($conexion, $sql);
$user = mysqli_fetch_assoc($result);

// Función para obtener el número de productos de un vendedor
function get_product_count($conexion, $vendedor_id) {
    $sql = "SELECT COUNT(*) as product_count FROM coches WHERE vendedor_id = $vendedor_id";
    $result = mysqli_query($conexion, $sql);
    $data = mysqli_fetch_assoc($result);
    return $data['product_count'];
}

?>

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
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required><br><br>

                <label for="correo">Correo:</label>
                <input type="email" name="correo" value="<?php echo htmlspecialchars($user['correo']); ?>" required><br><br>

                <label for="password">Nueva Contraseña:</label>
                <input type="password" name="password"><br><br>

                <label for="confirm_password">Confirmar Contraseña:</label>
                <input type="password" name="confirm_password"><br><br>

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
