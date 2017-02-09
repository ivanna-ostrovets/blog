<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');

class UserService {
  private $db;

  public function __construct() {
    $this->db = Database::getDB();
  }

  public function checkUniqueEmail($email) {
    $sql = "SELECT name FROM users WHERE email='$email'";

    try {
      return !empty($this->db->query($sql)->fetchColumn());
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function createUser($name, $email, $password, $role = "user") {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, password, role) 
      VALUES ('$name', '$email', '$password_hash', '$role')";

    try {
      $this->db->exec($sql);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function getUserByEmail($email) {
    $sql = "SELECT * FROM users WHERE email='$email'";

    try {
      $user = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

      if (!empty($user)) {
        return $user;
      }
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function getUserById($id) {
    $sql = "SELECT * FROM users WHERE id=$id";

    try {
      return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function logIn($email, $password) {
    $data = $this->getUserByEmail($email);

    session_start();

    if ($data && password_verify($password, $data['password'])) {
      $_SESSION['email'] = $email;
    } else {
      $_SESSION['email'] = '';
      throw new Exception('Invalid email or password.');
    }
  }

  public function checkIfUserLikePost($postId, $userId) {
    $sql = "SELECT COUNT(*) FROM likes WHERE post_id=$postId AND user_id=$userId";

    try {
      return $this->db->query($sql)->fetchColumn() == 0;
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function logOut() {
    session_start();
    session_destroy();
    $_SESSION = array();
  }

  public function getUserId($email) {
    if ($this->isLoggedIn()) {
      $user = $this->getUserByEmail($email);

      return $user['id'];
    }
  }

  public function isLoggedIn() {
    return isset($_SESSION['email']) && !empty($_SESSION['email']);
  }

  public function isAdmin() {
    if ($this->isLoggedIn()) {
      return $this->getUserByEmail($_SESSION['email'])['role'] === "admin";
    }

    return FALSE;
  }

  function __destruct() {
    $this->db = NULL;
  }
}

$userService = new UserService();