<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');

if ($db->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productoId = $_POST['productoId'];
    $userId = $_SESSION['user_id'];  // Obtención del user_id desde la sesión

    $query = $db->prepare("DELETE FROM carrito WHERE producto_id = ? AND user_id = ?");
    $query->bind_param("ii", $productoId, $userId);
    $query->execute();

    echo json_encode(['success' => true]);
    $db->close();
} 
?>
