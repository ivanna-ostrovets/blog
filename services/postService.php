<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');

class PostService {
  private $db;
  public $defaultImagePath;

  public function __construct() {
    $this->db = Database::getDB();
    $this->defaultImagePath = '/public/img/default.jpg';
  }

  public function createPost($title, $category, $teaser, $content, $imagePath) {
    $sql = "INSERT INTO posts (title, category, teaser, content, image_path) 
      VALUES ('$title', $category, '$teaser', '$content', '$imagePath')";

    try {
      $this->db->exec($sql);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function deletePost($id) {
    $post = $this->getPostById($id, FALSE);
    $imagePath = $post[0]['image_path'];
    $sql = "DELETE FROM posts WHERE id=$id";

    try {
      $this->db->exec($sql);

      if ($imagePath !== '') {
        $documentRoot = $_SERVER['DOCUMENT_ROOT'];
        chmod($documentRoot . '/public/posts_images/', 0600);
        unlink($documentRoot . $imagePath);
      }
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function editPost($id, $title, $category, $teaser, $content, $imagePath) {
    $sql = "UPDATE posts SET title='$title', category=$category, teaser='$teaser', 
    content='$content'";

    if ($imagePath === 0) {
      $sql .= "";
    } else {
      $sql .= ", image_path='$imagePath'";
    }

    $sql .= " WHERE id=$id";

    try {
      $this->db->exec($sql);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function getPosts($limit) {
    $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
    $category = isset($_GET['category']) ? $_GET['category'] : 0;

    $sql = "SELECT posts.*, categories.category FROM posts 
    JOIN categories ON categories.id=posts.category";

    if ($category) {
      $sql .= " WHERE posts.category=$category";
    }

    $sql .= " ORDER BY posts.id DESC LIMIT $limit OFFSET $offset";

    try {
      $posts = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

      if (!empty($posts)) {
        return $posts;
      }
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function getPostById($id, $withCategories = TRUE) {
    if ($withCategories) {
      $sql = "SELECT posts.*, categories.category FROM posts 
      JOIN categories ON categories.id=posts.category";
    } else {
      $sql = "SELECT * FROM posts";
    }

    $sql .= " WHERE posts.id=$id";

    try {
      $post = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

      if (!empty($post)) {
        return $post;
      }
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function deleteImage($postId) {
    $sql = "UPDATE posts SET image_path='' WHERE id=$postId";

    try {
      $this->db->exec($sql);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function addLike($postId, $userId) {
    $sql = "INSERT INTO likes (post_id, user_id) VALUES ($postId, $userId)";

    try {
      $this->db->exec($sql);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function deleteLike($postId, $userId) {
    $sql = "DELETE FROM likes WHERE post_id=$postId AND user_id=$userId";

    try {
      $this->db->exec($sql);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function likesCount($postId) {
    $sql = "SELECT COUNT(*) FROM likes WHERE post_id=$postId";

    try {
      $likesNumber = $this->db->query($sql)->fetchColumn();

      return $likesNumber;
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function postCount() {
    $category = isset($_GET['category']) ? $_GET['category'] : 0;

    $sql = "SELECT COUNT(*) FROM posts";

    if ($category) {
      $sql .= " WHERE category = '$category'";
    }

    try {
      $postsNumber = $this->db->query($sql)->fetchColumn();

      return $postsNumber;
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  function __destruct() {
    $this->db = NULL;
  }
}

$postService = new PostService();