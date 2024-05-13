document.addEventListener('DOMContentLoaded', function() {
// incorporación de eventos al formulario y realización de las validaciones de los datos
document.getElementById("form-registro").addEventListener("submit", function(event){
    var email = document.getElementById("new-email").value;
    var password = document.getElementById("new-password").value;
    var confirmPassword = document.getElementById("confirm-password").value;
    var firstName = document.getElementById("first-name").value;
    var lastName = document.getElementById("last-name").value;
    var phone = document.getElementById("phone").value;
    var alias = document.getElementById("alias").value;
    var address = document.getElementById("address").value;

    // Validación de email
    if (!email.match(/^\S+@\S+\.\S+$/)) {
        alert("Por favor, introduce un email válido.");
        event.preventDefault();
        return;
    }

    // Validación de longitud de contraseña
    if (password.length < 8) {
        alert("La contraseña debe tener al menos 8 caracteres.");
        event.preventDefault();
        return;
    }

    // Verificación de coincidencia de contraseñas
    if (password !== confirmPassword) {
        alert("Las contraseñas no coinciden.");
        event.preventDefault();
        return;
    }

    // Validación de nombre y apellido
    if (!firstName || !lastName) {
        alert("Por favor, introduce tu nombre y apellido.");
        event.preventDefault();
        return;
    }

    // Validación de teléfono 
    if (phone && !phone.match(/^\d{9}$/)) {
        alert("Por favor, introduce un número de teléfono válido.");
        event.preventDefault();
        return;
    }

    // Validación de alias 
    if (alias && alias.length < 3) {
        alert("El alias debe tener al menos 3 caracteres.");
        event.preventDefault();
        return;
    }
});

document.getElementById("form-inicio-sesion").addEventListener("submit", function(event) {
    var email = document.getElementById("login-email").value;
    var password = document.getElementById("login-password").value;

    // Validación de email
    if (!email.match(/^\S+@\S+\.\S+$/)) {
        alert("Por favor, introduce un email válido.");
        event.preventDefault();
        return;
    }

    // Validación de que la contraseña no esté vacía
    if (!password) {
        alert("Por favor, introduce tu contraseña.");
        event.preventDefault();
        return;
    }
});
});
