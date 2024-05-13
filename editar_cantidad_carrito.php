<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');

if ($db->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productoId = $_POST['productoId'];
    $cantidadNueva = $_POST['cantidadNueva'];
    $userId = $_SESSION['user_id'];  // Obtención del user_id desde la sesión

    // Obtención del precio del producto
    $queryPrecio = $db->prepare("SELECT precio FROM productos WHERE id = ?");
    $queryPrecio->bind_param("i", $productoId);
    $queryPrecio->execute();
    $resultadoPrecio = $queryPrecio->get_result();
    
    if ($filaPrecio = $resultadoPrecio->fetch_assoc()) {
        $precio = $filaPrecio['precio'];
        $nuevoSubtotal = $precio * $cantidadNueva;
        
        // Actualización de la cantidad y el subtotal en el carrito
        $queryActualizar = $db->prepare("UPDATE carrito SET cantidad = ?, subtotal = ? WHERE producto_id = ? AND user_id = ?");
        $queryActualizar->bind_param("idis", $cantidadNueva, $nuevoSubtotal, $productoId, $userId);
        $queryActualizar->execute();
        
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Producto no encontrado']);
    }
    
    $db->close();
}
?>
