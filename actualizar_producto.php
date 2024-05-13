<?php
session_start();

// Conexión a la base de datos
$db = new mysqli('localhost', 'root', '', 'sports_moment_db');
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}

// Verificación de que se haya enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $idProducto = $_POST['id'];
    $nombre = $db->real_escape_string($_POST['nombre']);
    $precio = $db->real_escape_string($_POST['precio']);

    // Manejo de la carga de la nueva imagen
    $rutaImagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $archivoTemporal = $_FILES['imagen']['tmp_name'];
        $nombreArchivo = basename($_FILES['imagen']['name']);
        $rutaDestino = "img/imagenes-de-productos/" . $nombreArchivo;

        if (move_uploaded_file($archivoTemporal, $rutaDestino)) {
            $rutaImagen = $rutaDestino;
        }
    }

    // Preparación de la consulta SQL para actualizar los datos
    if ($rutaImagen) {
        $sql = "UPDATE productos SET nombre = ?, precio = ?, imagen = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sdsi", $nombre, $precio, $rutaImagen, $idProducto);
    } else {
        $sql = "UPDATE productos SET nombre = ?, precio = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sdi", $nombre, $precio, $idProducto);
    }

    // Ejecución de la consulta y verificación del resultado
    if ($stmt->execute()) {
        echo "Producto actualizado con éxito.";
        // Redirección a la página de administración de productos
        header("Location: admin-productos.html");
        exit();
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Datos del formulario incompletos o incorrectos.";
}

$db->close();
?>
