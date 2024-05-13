document.addEventListener("DOMContentLoaded", function() {
    const historialTabla = document.getElementById("historial-tabla");

    // Obtención de datos del historial de pedidos
    fetch("obtener_historial.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarHistorial(data.historial);
            } else {
                console.error('Error al obtener el historial de pedidos.');
            }
        })
        .catch(error => console.error('Error:', error));
});

function mostrarHistorial(historial) {
    const tbody = document.querySelector("#historial-tabla tbody");
    tbody.innerHTML = '';

    historial.forEach(item => {
        const fila = document.createElement('tr');
        const precioNumerico = parseFloat(item.precio);
        const subtotalNumerico = parseFloat(item.subtotal);

        fila.innerHTML = `
            <td>${item.fecha_pedido}</td>
            <td>${item.nombre_producto}</td>
            <td>${item.cantidad}</td>
            <td>${precioNumerico.toFixed(2)}€</td>
            <td>${subtotalNumerico.toFixed(2)}€</td>
        `;


        tbody.appendChild(fila);
    });
}
