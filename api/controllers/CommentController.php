<?php
class CommentController
{
  private $commentModel;
  private $auth;

  public function __construct()
  {
    $database = new Database();
    $db = $database->getConnection();
    $this->commentModel = new CommentModel($db);
    $this->auth = new Auth();
  }

  public function processRequest()
  {
    $this->auth->authenticate();

    $method = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path_parts = explode('/', $path);

    $path_parts = array_values(array_filter($path_parts));


    $id = isset($path_parts[3]) ? $path_parts[3] : null;

    switch ($method) {
      case 'GET':
        if ($id) {
          $this->getComment($id);
        } else {
          $this->getAllComments();
        }
        break;
      case 'POST':
        $this->createComment();
        break;
      case 'PUT':
        if ($id) {
          $this->updateComment($id);
        } else {
          $this->sendError(400, "Missing ID");
        }
        break;
      case 'DELETE':
        if ($id) {
          $this->deleteComment($id);
        } else {
          $this->sendError(400, "Missing ID");
        }
        break;
      default:
        $this->sendError(405, "Method not allowed");
        break;
    }
  }

  private function getAllComments()
  {
    $stmt = $this->commentModel->read();
    $num = $stmt->rowCount();

    if ($num > 0) {
      $comments_arr = array();
      $comments_arr["data"] = array();

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $comment_item = array(
          "id" => $id,
          "post_id" => $post_id,
          "author_name" => $author_name,
          "content" => $content,
          "created_at" => $created_at
        );
        array_push($comments_arr["data"], $comment_item);
      }

      $this->sendResponse(200, $comments_arr);
    } else {
      $this->sendResponse(404, array("message" => "No comments found."));
    }
  }

  private function getComment($id)
  {
    $this->commentModel->id = $id;

    if ($this->commentModel->readOne()) {
      $comment_arr = array(
        "id" => $this->commentModel->id,
        "post_id" => $this->commentModel->post_id,
        "author_name" => $this->commentModel->author_name,
        "content" => $this->commentModel->content,
        "created_at" => $this->commentModel->created_at
      );
      $this->sendResponse(200, $comment_arr);
    } else {
      $this->sendError(404, "Comment not found");
    }
  }

  private function createComment()
  {
    $data = json_decode(file_get_contents("php://input"));

    if (
      !empty($data->post_id) &&
      !empty($data->author_name) &&
      !empty($data->content)
    ) {
      $this->commentModel->post_id = $data->post_id;
      $this->commentModel->author_name = $data->author_name;
      $this->commentModel->content = $data->content;

      if ($this->commentModel->create()) {
        $this->sendResponse(201, array("message" => "Comment created.")));
      } else {
        $this->sendError(500, "Unable to create comment.");
      }
    } else {
      $this->sendError(400, "Unable to create comment. Data is incomplete.");
    }
  }

  private function updateComment($id)
  {
    $data = json_decode(file_get_contents("php://input"));

    if (
      !empty($data->post_id) &&
      !empty($data->author_name) &&
      !empty($data->content)
    ) {
      $this->commentModel->id = $id;
      $this->commentModel->post_id = $data->post_id;
      $this->commentModel->author_name = $data->author_name;
      $this->commentModel->content = $data->content;

      if ($this->commentModel->update()) {
        $this->sendResponse(200, array("message" => "Comment updated."));
      } else {
        $this->sendError(500, "Unable to update comment.");
      }
    } else {
      $this->sendError(400, "Unable to update comment. Data is incomplete.");
    }
  }

  private function deleteComment($id)
  {
    $this->commentModel->id = $id;

    if ($this->commentModel->delete()) {
      $this->sendResponse(200, array("message" => "Comment deleted."));
    } else {
      $this->sendError(500, "Unable to delete comment.");
    }
  }

  private function sendResponse($statusCode, $data)
  {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
  }

  private function sendError($statusCode, $message)
  {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode(array("error" => $message));
  }
}
