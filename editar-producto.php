<?php
session_start();

// Verificacion de si se pasó un ID de producto
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Se requiere un ID de producto");
}

$idProducto = $_GET['id'];

// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}

// Consulta para obtener los datos del producto
$sql = "SELECT nombre, precio, imagen FROM productos WHERE id = ?";
$stmt = $db->prepare($sql);
if ($stmt === false) {
    die("Error en la consulta: " . $db->error);
}

$stmt->bind_param("i", $idProducto);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Producto no encontrado");
}

$producto = $result->fetch_assoc();
$stmt->close();
$db->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <main>
        <h1>Editar Producto</h1>
        <form action="actualizar_producto.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $idProducto; ?>">
            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
            </p>
            <p>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" step="0.01" required>
            </p>
            <p>
                <label for="imagen">Imagen Actual:</label>
                <?php if ($producto['imagen']): ?>
                    <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" width="100px">
                <?php endif; ?>
                <label for="imagen">Cambiar Imagen:</label>
                <input type="file" id="imagen" name="imagen">
            </p>
            <button type="submit">Actualizar Producto</button>
        </form>
    </main>
</body>
</html>
