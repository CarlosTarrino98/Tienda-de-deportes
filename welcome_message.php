<?php
session_start();

header('Content-Type: application/json');

if (isset($_SESSION['welcome_message'])) {
    echo json_encode(['message' => $_SESSION['welcome_message']]);
    unset($_SESSION['welcome_message']); 
} else {
    echo json_encode(['message' => '']);
}
?> 
