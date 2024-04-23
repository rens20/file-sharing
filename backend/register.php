<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once 'config/database.php';
include_once 'objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents('php://input'));

$user->username = $data->username;
$user->email = $data->email;
$user->password = password_hash($data->password, PASSWORD_DEFAULT);

if ($user->create()) {
  http_response_code(200);
  echo json_encode(array('message' => 'User registered successfully.'));
} else {
  http_response_code(400);
  echo json_encode(array('message' => 'Unable to register user.'));
}
?>
