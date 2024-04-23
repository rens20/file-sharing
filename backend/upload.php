<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$uploadDir = 'uploads/';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
  $file = $_FILES['file'];
  $fileName = $file['name'];
  $targetPath = $uploadDir . $fileName;

  if (move_uploaded_file($file['tmp_name'], $targetPath)) {
    http_response_code(200);
    echo json_encode(array('message' => 'File uploaded successfully.'));
  } else {
    http_response_code(500);
    echo json_encode(array('message' => 'Error uploading file.'));
  }
} else {
  http_response_code(400);
  echo json_encode(array('message' => 'Invalid request.'));
}
?>
