<?php
session_start();

// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}

// Verificación de si se recibió el ID
if(isset($_GET['id'])) {
    $id = $db->real_escape_string($_GET['id']);

    // Preparación y ejecución de la consulta
    $query = "DELETE FROM users WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $id);

    if($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false]);
}

// Cierre de conexión a la base de datos
$db->close();
?>

