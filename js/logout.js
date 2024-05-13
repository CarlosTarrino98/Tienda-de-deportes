document.addEventListener("DOMContentLoaded", function() {
    var logoutButton = document.getElementById("logout-button");
    if (logoutButton) {
        logoutButton.addEventListener("click", function() {
            fetch('logout.php', { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Sesión cerrada con éxito.");
                    window.location.href = 'index.html'; 
                } else {
                    alert("Hubo un problema al cerrar la sesión. Por favor, inténtalo de nuevo.");
                }
            })
            .catch(error => {
                alert("Error en la solicitud al servidor.");
                console.error('Error:', error);
            });
        });
    }else {
        console.log("Botón de logout no encontrado"); 
    }
});