<?php
session_start();

// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}

$usuario = null;

// Verificación de si se recibió el ID del usuario
if (isset($_GET['id'])) {
    $id = $db->real_escape_string($_GET['id']);

    // Consulta para obtener la información del usuario
    $query = "SELECT email, first_name, last_name, alias, phone, address, role FROM users WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        $resultado = $stmt->get_result();
        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
        }
    }
    $stmt->close();
}

$db->close();

// Si no se encuentra el usuario, mostrar error
if (!$usuario) {
    die("Usuario no encontrado");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <main>
        <h1>Editar Usuario</h1>
        <form action="actualizar_usuario.php" method="post">
            <input type="hidden" name="original_email" value="<?php echo htmlspecialchars($usuario['email']); ?>">

            <p>
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            </p>
            <p>
                <label>Nombre:</label>
                <input type="text" name="first_name" value="<?php echo htmlspecialchars($usuario['first_name']); ?>" required>
            </p>
            <p>
                <label>Apellidos:</label>
                <input type="text" name="last_name" value="<?php echo htmlspecialchars($usuario['last_name']); ?>" required>
            </p>
            <p>
                <label>Alias:</label>
                <input type="text" name="alias" value="<?php echo htmlspecialchars($usuario['alias']); ?>">
            </p>
            <p>
                <label>Teléfono:</label>
                <input type="tel" name="phone" value="<?php echo htmlspecialchars($usuario['phone']); ?>">
            </p>
            <p>
                <label>Dirección:</label>
                <textarea name="address"><?php echo htmlspecialchars($usuario['address']); ?></textarea>
            </p>
            <p>
                <label>Perfil:</label>
                <select name="role">
                    <option value="admin" <?php echo $usuario['role'] == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                    <option value="cliente" <?php echo $usuario['role'] == 'cliente' ? 'selected' : ''; ?>>Cliente</option>
                </select>
            </p>
            <button type="submit">Actualizar Usuario</button>
        </form>
    </main>
</body>

</html>