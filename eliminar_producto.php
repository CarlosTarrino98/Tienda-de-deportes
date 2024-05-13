<?php
session_start();

// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}

// Verificación de que se haya enviado el ID del producto
if (isset($_GET['id'])) {
    $idProducto = $_GET['id'];

    // Preparación de la consulta SQL para eliminar el producto
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $db->prepare($sql);

    if ($stmt === false) {
        die("Error en la consulta: " . $db->error);
    }

    $stmt->bind_param("i", $idProducto);

    // Ejecución de la consulta y verificación del resultado
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Producto eliminado con éxito"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar el producto"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "ID del producto no proporcionado"]);
}

$db->close();
?>
