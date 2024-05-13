<?php
session_start();

// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}

// Verificación y obtención de datos del formulario
if (isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['password'])) {
    $email = $db->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $firstName = $db->real_escape_string($_POST['first_name']);
    $lastName = $db->real_escape_string($_POST['last_name']);
    $alias = $db->real_escape_string($_POST['alias']);
    $phone = $db->real_escape_string($_POST['phone']);
    $address = $db->real_escape_string($_POST['address']);
    $role = $db->real_escape_string($_POST['role']);

    // Preparación de la consulta SQL para insertar los datos
    $query = "INSERT INTO users (email, password, first_name, last_name, alias, phone, address, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssssssss", $email, $password, $firstName, $lastName, $alias, $phone, $address, $role);

    // Ejecución de la consulta y verificación del resultado
    if ($stmt->execute()) {
        echo "Usuario creado con éxito.";
        // Redirección a la página de administración de usuarios
        header("Location: admin-usuarios.html");
        exit();
    } else {
        echo "Error al crear el usuario: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Datos del formulario incompletos.";
}

$db->close();
?>
