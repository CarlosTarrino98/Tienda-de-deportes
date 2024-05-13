<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'No se ha iniciado sesión.']);
    exit;
}

// Obtener el ID del usuario desde la sesión
$userId = $_SESSION['user_id'];

// Conectar a la base de datos 
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');

// Verificar errores de conexión
if ($db->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos']);
    exit;
}

// Consulta SQL para eliminar todos los registros del carrito para el usuario actual
$query = $db->prepare("DELETE FROM carrito WHERE user_id = ?");
$query->bind_param("i", $userId);
$query->execute();

echo json_encode(['success' => true]);

// Cerrar la conexión a la base de datos
$db->close();
?>
