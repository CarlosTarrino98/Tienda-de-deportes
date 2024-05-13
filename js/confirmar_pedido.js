document.addEventListener("DOMContentLoaded", function() {
    const procederPagoButton = document.getElementById("procederPagoButton");

    // Verificación de si el botón existe en la página
    if (procederPagoButton) {
        procederPagoButton.addEventListener("click", function(event) {
            // Bloqueo temporal de envío formulario inmediatamente
            event.preventDefault();

            // Alerta al usuario
            alert("¡Gracias por tu pedido!");

            // Envío el formulario después de mostrar la alerta
            const form = document.querySelector("form");
            if (form) {
                form.submit();
            }
        });
    }
});
