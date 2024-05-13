document.addEventListener("DOMContentLoaded", function() {
    fetch('welcome_message.php')
    .then(response => response.json())
    .then(data => {
        console.log("Mensaje recibido:", data.message); // Depuración
        if (data.message) {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});
