<?php
session_start();

$response = ['isAdmin' => false];

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    $response['isAdmin'] = true;
}

echo json_encode($response);
?>
 