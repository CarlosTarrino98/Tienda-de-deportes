// Función para cargar la lista de productos
function cargarListaProductos() { 
    const productosTableBody = document.getElementById("tabla-productos");
    
    fetch("obtener_productos.php")
        .then(response => response.json())
        .then(data => {
            productosTableBody.innerHTML = ""; // Limpieza de la tabla 
            data.forEach(producto => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${producto.nombre}</td>
                    <td>${producto.precio}€</td>
                    <td><img src="${producto.imagen}" alt="${producto.nombre}" width="50px"></td>
                    <td>
                        <button onclick="editarProducto('${producto.id}')">Editar</button>
                        <button onclick="eliminarProducto('${producto.id}',cargarListaProductos)">Eliminar</button>
                    </td>
                `;
                productosTableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error("Error al cargar la lista de productos:", error);
        });
}

// Función para editar producto
function editarProducto(id) {
    window.location.href = `editar-producto.php?id=${id}`;
}

// Función para eliminar producto
function eliminarProducto(id, callbackCargarProductos) {
    if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
        fetch(`eliminar_producto.php?id=${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    callbackCargarProductos(); // Recargar lista de productos
                } else {
                    alert('Error al eliminar el producto');
                }
            })
            .catch(error => {
                console.error("Error al eliminar el producto:", error);
            });
    }
}

document.addEventListener("DOMContentLoaded", function () {
    // Cargar productos al cargar la página
    cargarListaProductos();

    // Listener para el botón de añadir producto
    document.getElementById("boton-añadir-producto").addEventListener("click", function() {
        window.location.href = 'crear-producto.php';
    });
});
