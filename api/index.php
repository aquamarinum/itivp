<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-API-Key");


require_once 'config/Database.php';
require_once 'config/Auth.php';
require_once 'models/CommentModel.php';
require_once 'controllers/CommentController.php';


try {
  $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $path_parts = explode('/', $path);


  $path_parts = array_values(array_filter($path_parts));


  if (
    count($path_parts) >= 3 &&
    $path_parts[0] === 'ipr2' &&
    $path_parts[1] === 'api' &&
    $path_parts[2] === 'comments'
  ) {

    $controller = new CommentController();
    $controller->processRequest();
  } else {
    http_response_code(404);
    echo json_encode(array("message" => "Endpoint not found. Available endpoint: /ipr2/api/comments"));
  }
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(array("error" => $e->getMessage()));
}
