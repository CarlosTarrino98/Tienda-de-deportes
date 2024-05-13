<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'No se ha iniciado sesión']);
    exit;
}
 
// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');
// Verificación de conexión
if ($db->connect_error) {
    echo json_encode(['error' => 'Error de conexión a la base de datos: ' . $db->connect_error]);
    exit;
}

$userId = $_SESSION['user_id'];
$carrito = [];

// Consulta a la base de datos para obtener los detalles del carrito
$query = $db->prepare("SELECT producto_id, nombre, cantidad, precio, subtotal FROM carrito WHERE user_id = ?");
$query->bind_param("s", $userId);
$query->execute();
$result = $query->get_result();

while ($row = $result->fetch_assoc()) {
    $carrito[] = $row;
}

$query->close();
$db->close();

echo json_encode($carrito);
?>