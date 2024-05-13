<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'No se ha iniciado sesión']);
    exit;
}

$db = new mysqli('localhost', 'root', '', 'sports_moment_db');
if ($db->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos']);
    exit;
}
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $productoId = $_POST['idProducto'];
    $cantidad = $_POST['cantidad'];

    // Obtención de precio y nombre del producto
    $query = $db->prepare("SELECT precio, nombre FROM productos WHERE id = ?");
    $query->bind_param("i", $productoId);
    $query->execute();
    $resultado = $query->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        $precio = $fila['precio'];
        $nombre = $fila['nombre'];
        $subtotal = $precio * $cantidad;

        // Revisión de existencia del producto en el carrito
        $consultaCarrito = $db->prepare("SELECT cantidad FROM carrito WHERE producto_id = ? AND user_id = ?");
        $consultaCarrito->bind_param("ii", $productoId, $userId);
        $consultaCarrito->execute();
        $resultadoCarrito = $consultaCarrito->get_result();

        if ($resultadoCarrito->num_rows > 0) {
            // Actualización de cantidad y subtotal en el carrito
            $filaCarrito = $resultadoCarrito->fetch_assoc();
            $nuevaCantidad = $filaCarrito['cantidad'] + $cantidad;
            $nuevoSubtotal = $precio * $nuevaCantidad;
            $actualizarCarrito = $db->prepare("UPDATE carrito SET cantidad = ?, subtotal = ? WHERE producto_id = ? AND user_id = ?");
            $actualizarCarrito->bind_param("idii", $nuevaCantidad, $nuevoSubtotal, $productoId, $userId);
            $actualizarCarrito->execute();
        } else {
            // Insercción del nuevo producto en el carrito
            $insertarCarrito = $db->prepare("INSERT INTO carrito (producto_id, cantidad, precio, subtotal, user_id, nombre) VALUES (?, ?, ?, ?, ?, ?)");
            $insertarCarrito->bind_param("iiddis", $productoId, $cantidad, $precio, $subtotal, $userId, $nombre);
            $insertarCarrito->execute();
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Producto no encontrado']);
        exit;
    }

    echo json_encode(['success' => true]);
    $db->close();
}
?>