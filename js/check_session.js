document.addEventListener("DOMContentLoaded", function() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "check_session.php", true);
    xhr.onload = function() {
        if (xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.loggedIn) {
                document.getElementById("logout-button").style.display = 'block';
            }
        } 
    };
    xhr.send();
});
 