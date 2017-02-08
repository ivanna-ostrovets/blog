<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');

class commentService {
  private $db;

  public function __construct() {
    $this->db = Database::getDB();
  }

  public function createComment($userId, $postId, $comment) {
    $sql = "INSERT INTO comments (user_id, post_id, comment) 
      VALUES ('$userId', $postId, '$comment')";

    try {
      $this->db->exec($sql);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function deleteComment($id) {
    $sql = "DELETE FROM comments WHERE id=$id";

    try {
      $this->db->exec($sql);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function editComment($userId, $id, $newText) {
    $comment = $this->$this->getCommentById($id);

    if ($comment[0]['userId'] === $userId) {
      $sql = "UPDATE comments SET comment='$newText' WHERE id=$id";

      try {
        $this->db->exec($sql);
      } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
    }
  }

  public function getComments($postId) {
    $sql = "SELECT * FROM comments WHERE post_id=$postId";

    try {
      $comments = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

      if (!empty($comments)) {
        return $comments;
      }
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function getCommentById($id) {
    $sql = "SELECT * FROM comments WHERE id=$id";

    try {
      $comment = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

      if (!empty($comment)) {
        return $comment;
      }
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function commentsCount($postId) {
    $sql = "SELECT COUNT(id) FROM comments WHERE post_id=$postId";

    try {
      $commentsNumber = $this->db->query($sql)->fetchColumn();

      return $commentsNumber;
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  function __destruct() {
    $this->db = NULL;
  }
}

$commentService = new commentService();