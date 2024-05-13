fetch("vaciar_carrito.php", {
    method: "POST"
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        console.error('Carrito vaciado con éxito');
    } else {
        console.error('Error al vaciar el carrito.');
    }
})
.catch(error => console.error('Error:', error));