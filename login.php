<?php
session_start();
$config = include 'config.php';
$storedHashPassword = $config['loginPasswordHash'];
$input = json_decode(file_get_contents('php://input'), true);
$password = isset($input['password']) ? $input['password'] : '';
$response = ['success' => false];
if ($password && password_verify($password, $storedHashPassword)) {
    $_SESSION['authenticated'] = true;
    $response['success'] = true;
}
header('Content-Type: application/json');
echo json_encode($response);
?>
