function añadirAlCarrito(idProducto, cantidad) {
    // Validación básica de la entrada
    cantidad = parseInt(cantidad);
    if (isNaN(cantidad) || cantidad <= 0) {
        alert('Por favor, introduce una cantidad válida.');
        return;
    }
  
    // Preparación los datos para enviar
    const datos = new URLSearchParams();
    datos.append('idProducto', idProducto);
    datos.append('cantidad', cantidad);

    fetch('añadir_al_carrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: datos.toString()
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la red o respuesta no válida. Código de estado: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Respuesta del servidor:', data);
        if (data.success) {
            alert('Producto añadido al carrito con éxito.');
        } else {
            console.error('Error del servidor:', data.error);
            alert(`No se pudo añadir el producto al carrito: ${data.error}`);
        }
    })
    .catch(error => {
        console.error('Error completo:', error);
        alert('Hubo un problema al añadir el producto al carrito. Ver la consola para más detalles.');
    });
}