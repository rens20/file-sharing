<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, PUT, DELETE');

include_once 'config/database.php';
include_once 'objects/file.php';

$database = new Database();
$db = $database->getConnection();

$file = new File($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $files = $file->getFiles();
  http_response_code(200);
  echo json_encode(array('files' => $files));
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
  $id = $_GET['id'];
  $data = json_decode(file_get_contents('php://input'));
  $newName = $data->newName;

  if ($file->renameFile($id, $newName)) {
    http_response_code(200);
    echo json_encode(array('message' => 'File renamed successfully.'));
  } else {
    http_response_code(400);
    echo json_encode(array('message' => 'Unable to rename file.'));
  }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
  $id = $_GET['id'];

  if ($file->deleteFile($id)) {
    http_response_code(200);
    echo json_encode(array('message' => 'File deleted successfully.'));
  } else {
    http_response_code(400);
    echo json_encode(array('message' => 'Unable to delete file.'));
  }
} else {
  http_response_code(405);
  echo json_encode(array('message' => 'Method Not Allowed.'));
}
?>
