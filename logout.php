<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    session_unset();
    session_destroy();

    echo json_encode(["success" => true]);
} else {
    // Manejo de caso de método no permitido
    http_response_code(405); 
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
}
?>