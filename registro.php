<?php
session_start();

// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '', 'sports_moment_db'); 
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
} 

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y sanear datos del formulario
    $email = filter_var(trim($_POST['new-email']), FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['new-password'], PASSWORD_DEFAULT);  // Utilizo password_hash para almacenar contraseñas de forma segura
    $role = $db->real_escape_string(trim($_POST['role']));
    $firstName = $db->real_escape_string(trim($_POST['first-name']));
    $lastName = $db->real_escape_string(trim($_POST['last-name']));
    $alias = $db->real_escape_string(trim($_POST['alias']));
    $phone = $db->real_escape_string(trim($_POST['phone']));
    $address = $db->real_escape_string(trim($_POST['address']));

    // Verificar el formato del email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Formato de email inválido.";
        exit;
    }

    // Verificar que el email no exista ya en la base de datos
    $checkEmail = $db->query("SELECT id FROM users WHERE email = '$email'");
    if ($checkEmail && $checkEmail->num_rows > 0) {
        echo "El email ya está registrado.";
        $db->close();
        exit;
    }

    // Verificar la longitud de la contraseña
    if (strlen(trim($_POST['new-password'])) < 8) {
        echo "La contraseña es demasiado corta.";
        exit;
    }

    // Validación del teléfono
    if (!empty($phone) && !preg_match('/^\d{9}$/', $phone)) {
        echo "Número de teléfono inválido.";
        exit;
    }
  
    // Validación del alias
    if (!empty($alias) && strlen($alias) < 3) {
        echo "El alias es demasiado corto.";
        exit;
    }

    // Insertar en la base de datos
    $query = "INSERT INTO users (email, password, role, first_name, last_name, alias, phone, address) 
    VALUES ('$email', '$password', '$role', '$firstName', '$lastName', '$alias', '$phone', '$address')";

    //iniciar sesion automaticamente tras el registro
    if ($db->query($query) === TRUE) {
        $_SESSION['user_id'] = $db->insert_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $firstName;
        $_SESSION['user_role'] =  $role;
        
        $_SESSION['welcome_message'] = "Bienvenido, " . $_SESSION['user_name'] . "!! Tu ID es: " . $_SESSION['user_id'] . " y tu rol es: " . $_SESSION['user_role'] . ".";       

        // Redirección a la página principal
        header("Location: index.html"); 
        exit;
    } else {
        echo "Error: " . $db->error;
    }

    // Cerrar la conexión a la base de datos
    $db->close();
}
