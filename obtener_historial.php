<?php
session_start();

// Verificación de si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: acceso.html'); 
    exit;
}

// Conexión a la base de datos 
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');

// Verificación de errores de conexión
if ($db->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos']);
    exit;
}

// Consulta SQL para obtener el historial de pedidos
$query = $db->prepare("SELECT fecha_pedido, nombre_producto, cantidad, precio, subtotal FROM historico_pedidos");
$query->execute();
$resultado = $query->get_result();

// Inicialización de un array para almacenar el historial de pedidos
$historial = [];

// Recorrer los resultados y agregarlos al array
while ($fila = $resultado->fetch_assoc()) {
    $historial[] = $fila;
}

header('Content-Type: application/json');
echo json_encode(['success' => true, 'historial' => $historial]);

// Cerrar la conexión a la base de datos
$db->close();
?>
