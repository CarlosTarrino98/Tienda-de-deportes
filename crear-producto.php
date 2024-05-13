<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <main>
        <h1>Crear Nuevo Producto</h1>
        <form action="guardar_producto.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </p>
            <p>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" required>
            </p>
            <p>
                <label for="imagen">Imagen del Producto:</label>
                <input type="file" id="imagen" name="imagen">
            </p>
            <button type="submit">Guardar Producto</button>
        </form>
    </main>
</body>
</html>

