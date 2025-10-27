<?php
class Database
{
  private $host = "localhost";
  private $port = "3307";
  private $db_name = "api_db";
  private $username = "root";
  private $password = "";
  public $conn;

  public function getConnection()
  {
    $this->conn = null;
    try {
      $this->conn = new PDO(
        "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
        $this->username,
        $this->password
      );
      $this->conn->exec("set names utf8");
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $exception) {
      echo "Connection error: " . $exception->getMessage();
    }
    return $this->conn;
  }
}
