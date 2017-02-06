<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');

class PostService {
  private $db;

  public function __construct() {
    $this->db = Database::getDB();
  }

  public function createPost($title, $category, $teaser, $content, $miniature) {
    $sql = "INSERT INTO Posts (title, category, teaser, content, miniature) 
      VALUES ('$title', '$category', '$teaser', '$content', '$miniature')";

    try {
      $this->db->exec($sql);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function deletePost($id) {
    $sql = "DELETE FROM Posts WHERE id = '$id'";

    try {
      $this->db->exec($sql);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  function __destruct() {
    $this->db = NULL;
  }
}

$postService = new PostService();