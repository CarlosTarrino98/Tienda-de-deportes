<?php
session_start();

// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}

// Verificación de que se haya enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $db->real_escape_string($_POST['nombre']);
    $precio = $db->real_escape_string($_POST['precio']);

    // Manejo de la carga de la imagen
    $rutaImagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $archivoTemporal = $_FILES['imagen']['tmp_name'];
        $nombreArchivo = basename($_FILES['imagen']['name']);
        $rutaDestino = "img/imagenes-de-productos/" . $nombreArchivo; // Ruta actualizada

        if (move_uploaded_file($archivoTemporal, $rutaDestino)) {
            $rutaImagen = $rutaDestino;
        }
    }

    // Preparación de la consulta SQL para inserción de los datos
    $sql = "INSERT INTO productos (nombre, precio, imagen) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);

    if ($stmt === false) {
        die("Error en la consulta: " . $db->error);
    }

    $stmt->bind_param("sds", $nombre, $precio, $rutaImagen);
    if ($stmt->execute()) {
        echo "Producto creado con éxito.";
        // Redirección a la página de administración de productos
        header("Location: admin-productos.html");
        exit();
    } else {
        echo "Error al crear el producto: " . $stmt->error;
    }

    $stmt->close();
}

$db->close();
?>
