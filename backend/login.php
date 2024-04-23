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

if ($user->login($data->password)) {
  http_response_code(200);
  echo json_encode(array('message' => 'Login successful.'));
} else {
  http_response_code(401);
  echo json_encode(array('message' => 'Invalid credentials.'));
}
?>
