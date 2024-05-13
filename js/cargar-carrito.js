document.addEventListener("DOMContentLoaded", function() {
    const carritoContenido = document.getElementById("carrito-contenido");

    // Verificación de si el elemento existe en la página
    if (carritoContenido) {
        cargarCarrito();
    }
});

function cargarCarrito() {
    fetch("obtener_carrito.php") 
        .then(response => response.json())
        .then(carrito => {
            actualizarCarrito(carrito);
        })
        .catch(error => {
            console.error('Error al cargar el carrito:', error);
        });
}

function actualizarCarrito(carrito) {
    const carritoContenido = document.getElementById("carrito-contenido");
    carritoContenido.innerHTML = '';

    let total = 0;
    carrito.forEach(item => {
        console.log(item); 

        // Conversión del precio y subtotal a números
        const precio = item.precio ? parseFloat(item.precio) : 0;
        const subtotal = item.subtotal ? parseFloat(item.subtotal) : 0;

        // Verificación de los valores convertidos
        console.log(`Precio: ${precio}, Subtotal: ${subtotal}`);

        // Verificación de precio y subtotal
        if (isNaN(precio) || isNaN(subtotal)) {
            console.error('Error: precio o subtotal no son números válidos.');
            return; 
        }

        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>${item.nombre}</td>
            <td>${item.cantidad}</td>
            <td>${precio.toFixed(2)}€</td>
            <td>${subtotal.toFixed(2)}€</td>
            <td>
                <button onclick="editarCantidad(${item.producto_id})">Editar</button>
                <button onclick="eliminarDelCarrito(${item.producto_id})">Eliminar</button>
            </td>
        `;

        carritoContenido.appendChild(fila);
        total += subtotal;
    });

    // Actualización del total
    const totalElement = document.getElementById('Total-valor');
    if (totalElement) {
        totalElement.textContent = `Total: ${total.toFixed(2)}€`;
    }
}


function editarCantidad(productoId) {
    const nuevaCantidad = prompt("Introduce la nueva cantidad:");
    if (nuevaCantidad !== null && nuevaCantidad > 0) {
        fetch('editar_cantidad_carrito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `productoId=${productoId}&cantidadNueva=${nuevaCantidad}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarCarrito(); 
            } else {
                alert('No se pudo actualizar la cantidad del producto.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}


function eliminarDelCarrito(productoId) {
    if (confirm("¿Estás seguro de que quieres eliminar este producto del carrito?")) {
        fetch('eliminar_del_carrito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `productoId=${productoId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarCarrito(); 
            } else {
                alert('No se pudo eliminar el producto del carrito.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}