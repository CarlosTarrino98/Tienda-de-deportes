document.addEventListener("DOMContentLoaded", function () {
    const usuariosTableBody = document.getElementById("tabla-usuarios");

    // Función para cargar la lista de usuarios
    function cargarListaUsuarios() {
        fetch("obtener_usuarios.php")
            .then(response => response.json())
            .then(data => {
                usuariosTableBody.innerHTML = ""; // Limpieza de la tabla existente
                data.forEach(usuario => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${usuario.email}</td>
                        <td>${usuario.first_name}</td>
                        <td>${usuario.last_name}</td>
                        <td>${usuario.alias}</td>
                        <td>${usuario.phone}</td>
                        <td>${usuario.address}</td>
                        <td>${usuario.role}</td>
                        <td>
                            <a href='editar_usuario.php?id=${usuario.email}'>Editar</a> |
                            <a href='#' class='eliminar-usuario' data-id='${usuario.email}'>Eliminar</a>
                        </td>                        
                    `;                       
                    usuariosTableBody.appendChild(row);
                });

                const rowAñadir = document.createElement("tr");
                rowAñadir.innerHTML = `
                    <td colspan="7">Añadir Nuevo Usuario</td>
                    <td><button id="boton-añadir-usuario">Añadir</button></td>
                `;
                usuariosTableBody.appendChild(rowAñadir);

                document.getElementById("boton-añadir-usuario").addEventListener("click", function() {
                    window.location.href = 'crear-usuario.php';
                });
            })
            .catch(error => {
                console.error("Error al cargar la lista de usuarios:", error);
            });
    }

    document.addEventListener("DOMContentLoaded", function () {
        const usuariosTableBody = document.getElementById("tabla-usuarios");
        cargarListaUsuarios();
    });

    // Llamada a la función para cargar la lista de usuarios al cargar la página
    cargarListaUsuarios();

    // Event listener para eliminar usuarios
    usuariosTableBody.addEventListener('click', function (e) {
        if (e.target.classList.contains('eliminar-usuario')) {
            e.preventDefault();
            const usuarioId = e.target.getAttribute('data-id');
            if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                eliminarUsuario(usuarioId,  cargarListaUsuarios); 
            }
        }
    });
});

function eliminarUsuario(id, callbackCargarUsuarios) {
    fetch(`eliminar_usuario.php?id=${id}`, { method: 'DELETE' })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                callbackCargarUsuarios(); // Recarga de la lista de usuarios
            } else {
                alert('Error al eliminar el usuario');
            }
        })
        .catch(error => {
            console.error("Error al eliminar el usuario:", error);
        });
}