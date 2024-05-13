<?php
session_start();

// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}

// Verificación y obtención de datos del formulario
if (isset($_POST['original_email'])) {
    $originalEmail = $db->real_escape_string($_POST['original_email']);
    $email = $db->real_escape_string($_POST['email']);
    $firstName = $db->real_escape_string($_POST['first_name']);
    $lastName = $db->real_escape_string($_POST['last_name']);
    $alias = $db->real_escape_string($_POST['alias']);
    $phone = $db->real_escape_string($_POST['phone']);
    $address = $db->real_escape_string($_POST['address']);
    $role = $db->real_escape_string($_POST['role']);

    // Preparación de la consulta SQL para actualizar los datos
    $query = "UPDATE users SET email = ?, first_name = ?, last_name = ?, alias = ?, phone = ?, address = ?, role = ? WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssssssss", $email, $firstName, $lastName, $alias, $phone, $address, $role, $originalEmail);

    // Ejecución de la consulta y verificación del resultado
    if ($stmt->execute()) {
        echo "Usuario actualizado con éxito.";
        // Redirección del usuario a página de administración de usuarios
        header("Location: admin-usuarios.html");
    } else {
        echo "Error al actualizar el usuario.";
    }

    $stmt->close();
} else {
    echo "Datos del formulario incompletos.";
}

$db->close();
?>
