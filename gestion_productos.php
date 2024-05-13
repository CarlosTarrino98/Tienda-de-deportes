<?php
session_start();

$conexion = new mysqli('localhost', 'root', '', 'sports_moment_db'); 

// Verificación de la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Agregar un nuevo producto
// Variables para los datos del producto
$nombre = $_POST["nombre"];
$precio = $_POST["precio"];

// Variables para la imagen
$nombreImagen = $_FILES["imagen"]["name"]; // Nombre original de la imagen
$nombreTemporal = $_FILES["imagen"]["tmp_name"]; // Nombre temporal en el servidor

// Ruta donde se guardará la imagen en el servidor 
$rutaImagen = "img/imagenes-de-productos/" . $nombreImagen;

// Movimiento de la imagen desde la ubicación temporal al directorio fijo
if (move_uploaded_file($nombreTemporal, $rutaImagen)) {
    // mensaje de confirmación
    echo "Imagen cargada con éxito.<br>";
    
    // Insercción de los datos del producto en la base de datos
    $sql = "INSERT INTO productos (nombre, precio, imagen) VALUES ('$nombre', '$precio', '$rutaImagen')";

    if ($conexion->query($sql) === TRUE) {
        // mensaje de confirmación
        header("Location: admin-productos.html"); 
        exit;
    } else {
        echo "Error al agregar el producto: " . $conexion->error;
    }
} else {
    echo "Error al cargar la imagen.";
}

// Cierre de conexión
$conexion->close();
?>
