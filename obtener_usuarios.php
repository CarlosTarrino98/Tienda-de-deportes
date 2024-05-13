<?php
session_start();

// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');

// Verificar la conexión
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}

// Consulta para obtener la lista de usuarios
$query = "SELECT id, email, password, role, first_name, last_name, alias, phone, address FROM users";

$resultados = array();

if ($result = $db->query($query)) {
    while ($fila = $result->fetch_assoc()) {
        $resultados[] = $fila;
    }
    $result->free();
}

// Cerrar la conexión a la base de datos
$db->close();

// Devolver la lista de usuarios como respuesta JSON
echo json_encode($resultados);
?>

