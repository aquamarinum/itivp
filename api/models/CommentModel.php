<?php
class CommentModel
{
  private $conn;
  private $table = "comments";

  public $id;
  public $post_id;
  public $author_name;
  public $content;
  public $created_at;

  public function __construct($db)
  {
    $this->conn = $db;
  }


  public function read()
  {
    $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }


  public function readOne()
  {
    $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
      $this->post_id = $row['post_id'];
      $this->author_name = $row['author_name'];
      $this->content = $row['content'];
      $this->created_at = $row['created_at'];
      return true;
    }
    return false;
  }


  public function create()
  {
    $query = "INSERT INTO " . $this->table . " 
                 SET post_id=:post_id, author_name=:author_name, content=:content";

    $stmt = $this->conn->prepare($query);


    $this->post_id = htmlspecialchars(strip_tags($this->post_id));
    $this->author_name = htmlspecialchars(strip_tags($this->author_name));
    $this->content = htmlspecialchars(strip_tags($this->content));


    $stmt->bindParam(":post_id", $this->post_id);
    $stmt->bindParam(":author_name", $this->author_name);
    $stmt->bindParam(":content", $this->content);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }


  public function update()
  {
    $query = "UPDATE " . $this->table . " 
                 SET post_id=:post_id, author_name=:author_name, content=:content 
                 WHERE id=:id";

    $stmt = $this->conn->prepare($query);


    $this->post_id = htmlspecialchars(strip_tags($this->post_id));
    $this->author_name = htmlspecialchars(strip_tags($this->author_name));
    $this->content = htmlspecialchars(strip_tags($this->content));
    $this->id = htmlspecialchars(strip_tags($this->id));


    $stmt->bindParam(":post_id", $this->post_id);
    $stmt->bindParam(":author_name", $this->author_name);
    $stmt->bindParam(":content", $this->content);
    $stmt->bindParam(":id", $this->id);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }


  public function delete()
  {
    $query = "DELETE FROM " . $this->table . " WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $this->id = htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(1, $this->id);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
}
