document.addEventListener("DOMContentLoaded", function() {
    fetch('check_role.php')
    .then(response => response.json())
    .then(data => {
        if (!data.isAdmin) {
            var adminOptions = document.querySelectorAll('.admin-option');
            adminOptions.forEach(function(option) {
                option.style.display = 'none';
            });
        }
    })
    .catch(error => console.error('Error:', error));
});
