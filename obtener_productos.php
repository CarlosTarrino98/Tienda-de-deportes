<?php
session_start();

// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');

// Verificar la conexión
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}

// Consulta para obtener los productos
$query = "SELECT id, nombre, precio, imagen FROM productos";

$productos = array();

if ($result = $db->query($query)) {
    while($fila = $result->fetch_assoc()) {
        $productos[] = $fila;
    }
    $result->free();
} 

// Cerrar la conexión
$db->close();

// Establecer encabezado como JSON
header('Content-Type: application/json');
// Devolver los datos en formato JSON
echo json_encode($productos);
?>
