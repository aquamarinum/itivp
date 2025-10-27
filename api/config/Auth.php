<?php
class Auth
{
  private $conn;
  private $db;

  public function __construct()
  {
    $this->db = new Database();
    $this->conn = $this->db->getConnection();
  }

  public function validateApiKey($apiKey)
  {
    if (empty($apiKey)) {
      return false;
    }

    $query = "SELECT api_key FROM api_keys WHERE is_active = TRUE";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      if (password_verify($apiKey, $row['api_key'])) {
        return true;
      }
    }

    return false;
  }

  public function authenticate()
  {
    $headers = getallheaders();
    $apiKey = '';


    if (isset($headers['X-API-Key'])) {
      $apiKey = $headers['X-API-Key'];
    } elseif (isset($headers['x-api-key'])) {
      $apiKey = $headers['x-api-key'];
    }

    if (!$this->validateApiKey($apiKey)) {
      http_response_code(401);
      echo json_encode(array("message" => "Unauthorized. Invalid or missing API key."));

      exit;
    }

    return true;
  }
}
