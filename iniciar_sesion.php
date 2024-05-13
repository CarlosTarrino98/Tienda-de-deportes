<?php
session_start();
 
// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}
 
// Verificación de si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    
    // Validación del email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Formato de correo electrónico no válido.";
        exit;
    }

    $password = trim($_POST['password']);

    // Búsqueda del usuario por email
    $query = $db->prepare("SELECT id, password, first_name, email, role FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
 
    $result = $query->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verificación de la contraseña
        if (password_verify($password, $user['password'])) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['first_name'];
            $_SESSION['user_role'] = $user['role'];

            // Mensaje de bienvenida
            $_SESSION['welcome_message'] = "Bienvenido, " . $_SESSION['user_name'] . "!! Tu ID es: " . $_SESSION['user_id'] . " y tu rol es: " . $_SESSION['user_role'] . ".";       

            // Redirección a la página principal
            if (!headers_sent()) {
                header("Location: index.html");
                exit;
            }
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $db->close();
}
?>
