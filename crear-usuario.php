<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <main>
        <h1>Crear Nuevo Usuario</h1>
        <form action="guardar_usuario.php" method="post">
            <p>
                <label>Email:</label>
                <input type="email" name="email" placeholder="Email" required>
            </p>
            <p>
                <label>Contraseña:</label>
                <input type="password" name="password" placeholder="Contraseña" required>
            </p>
            <p>
                <label>Nombre:</label>
                <input type="text" name="first_name" placeholder="Nombre" required>
            </p>
            <p>
                <label>Apellidos:</label>
                <input type="text" name="last_name" placeholder="Apellidos" required>
            </p>
            <p>
                <label>Alias:</label>
                <input type="text" name="alias" placeholder="Alias">
            </p>
            <p>
                <label>Teléfono:</label>
                <input type="tel" name="phone" placeholder="Teléfono">
            </p>
            <p>
                <label>Dirección:</label>
                <textarea name="address" placeholder="Dirección"></textarea>
            </p>
            <p>
                <label>Perfil:</label>
                <select name="role">
                    <option value="admin">Administrador</option>
                    <option value="cliente">Cliente</option>
                </select>
            </p>
            <button type="submit">Guardar Usuario</button>
        </form>
    </main>
</body>
</html>
