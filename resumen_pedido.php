<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

// Función para obtener los datos del carrito desde la base de datos
function obtenerCarrito($userId) { 
    // Conexión a la base de datos 
    $db = new mysqli('localhost', 'root', '', 'sports_moment_db');

    // Verificar si hay errores de conexión
    if ($db->connect_error) {
        return [];
    }

    // Consulta SQL para obtener los datos del carrito
    $query = $db->prepare("SELECT producto_id, nombre, cantidad, precio, subtotal FROM carrito WHERE user_id = ?");
    $query->bind_param("i", $userId);
    $query->execute();
    $resultado = $query->get_result();

    // Inicialización de un array para almacenar los datos del carrito
    $carrito = [];

    // agregar los resultados al array
    while ($fila = $resultado->fetch_assoc()) {
        $carrito[] = $fila;
    }

    // Cierra la conexión a la base de datos
    $db->close();

    return $carrito;
}

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    echo 'No se ha iniciado sesión.';
    exit;
}

// Obtener el ID del usuario desde la sesión
$userId = $_SESSION['user_id'];

// Obtener los datos del carrito del usuario
$carrito = obtenerCarrito($userId);

// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');

// Verificar si hay errores de conexión
if ($db->connect_error) {
    echo 'Error de conexión a la base de datos.';
    exit;
}

// Iterar sobre los elementos del carrito y guardar cada artículo en la tabla historico_pedidos
foreach ($carrito as $item) {
    $productoId = $item['producto_id'];
    $nombreProducto = $item['nombre'];
    $cantidad = $item['cantidad'];
    $precio = $item['precio'];
    $subtotal = $item['subtotal'];
    
    // Preparar la consulta de inserción
    $query = $db->prepare("INSERT INTO historico_pedidos (fecha_pedido, user_id, producto_id, nombre_producto, cantidad, precio, subtotal) VALUES (NOW(), ?, ?, ?, ?, ?, ?)");
    $query->bind_param("iisidd", $userId, $productoId, $nombreProducto, $cantidad, $precio, $subtotal);
    $query->execute();
}

// Cerrar la conexión a la base de datos
$db->close();
?>

<!-- Página de resumen del pedido -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen del Pedido</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html"><img src="img/inicio.png" alt="Inicio" class="nav-icon"><span>Inicio</span></a></li>
                <li><a href="produtos.html"><img src="img/productos.png" alt="Productos" class="nav-icon"><span>Productos</span></a></li>
                <li><a href="carrito.html"><img src="img/carrito.png" alt="Carrito" class="nav-icon"><span>Carrito</span></a></li>
                <li><a href="historico.html"><img src="img/historial.png" alt="Historial de pedidos" class="nav-icon"><span>Historial de <br>pedidos</span></a></li>
                <li><a href="cuenta.html"><img src="img/acceso.png" alt="Acceso" class="nav-icon"><span>Acceso</span></a></li>

                <li class="admin-option"><a href="admin-productos.html"><img src="img/control-de-productos.png" alt="Control de productos" class="nav-icon"><span>Control de <br>productos</span></a></li>
                <li class="admin-option"><a href="admin-usuarios.html"><img src="img/control-de-usuarios.png" alt="Control de usuarios" class="nav-icon"><span>Control de <br>usuarios</span></a></li>

                <li id="logout-button"><img src="img/cerrar-sesion.png" alt="Cerrar sesion" class="cerrar-sesion"><span>Salir</span></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Resumen del pedido</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre del producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="carrito-contenido">
                <?php foreach ($carrito as $item): ?>
                    <tr>
                        <td><?php echo $item['nombre']; ?></td>
                        <td><?php echo $item['cantidad']; ?></td>
                        <td><?php echo number_format($item['precio'], 2) . '€'; ?></td>
                        <td><?php echo number_format($item['subtotal'], 2) . '€'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot> 
                <tr>
                    <td id="Total-valor" colspan="5"></td>
                </tr>
            </tfoot>
        </table>
        <p>Consulta tu <a href="historico.html">historial de pedidos</a> aqui</p>
    </main> 
    <footer>
        <p><b>&copy; 2024 Sport's Moment</p></b>
        <p><b>Dirección:</b> Calle Falsa 123, Ciudad Ficticia, CP 45678</p>
        <p><b>Horario:</b> Lunes a Sábado de 08:00 a 20:00</p>
        <p><b>Contacto:</b> info@sportsmoment.com | Tel: +34 123 456 789</p>
    </footer>
    <script src="js/vaciar_carrito.js"></script>
    <script src="js/check_session.js"></script>
    <script src="js/logout.js"></script>   
    <script src="js/check_role.js"></script></body>
</html>
