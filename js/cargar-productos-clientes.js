document.addEventListener("DOMContentLoaded", function () {
    const contenedorProductos = document.getElementById("productos");

    if (contenedorProductos) {
        fetch("obtener_productos.php")
            .then(response => response.json())
            .then(data => {
                data.forEach(producto => {
                    const divProducto = document.createElement("div");
                    divProducto.classList.add("producto");
                    divProducto.setAttribute('data-id', producto.id);

                    divProducto.innerHTML = `
                        <img src="${producto.imagen}" alt="${producto.nombre}" class="imagen-producto">
                        <p>${producto.nombre} - ${producto.precio}€</p>
                        <div class="cantidad-y-boton">
                            <input type="number" name="cantidad" value="1" min="1" class="input-cantidad">
                            <button type="button" class="btn-anadir-carrito">Añadir al Carrito</button>
                        </div>
                    `;

                    contenedorProductos.appendChild(divProducto);

                     divProducto.querySelector('.btn-anadir-carrito').addEventListener('click', function() {
                        const cantidad = divProducto.querySelector('.input-cantidad').value;
                        console.log('Añadir al carrito: producto.id = ' + producto.id + ', cantidad = ' + cantidad);
                        añadirAlCarrito(producto.id, cantidad);
                }); 
            });
            })
            .catch(error => {
                console.error("Error al cargar los productos:", error);
            });
    } 
});