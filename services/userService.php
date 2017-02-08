<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');

class UserService {
  private $db;

  public function __construct() {
    $this->db = Database::getDB();
  }

  public function checkUniqueEmail($email) {
    $sql = "SELECT name FROM Users WHERE email = '$email'";

    try {
      return $this->db->exec($sql) === FALSE;
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function createUser($name, $email, $password, $role = "user") {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Users (name, email, password, role) 
      VALUES ('$name', '$email', '$password_hash', '$role')";

    try {
      $this->db->exec($sql);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function getUserByEmail($email) {
    $sql = "SELECT name, email, password, role FROM Users WHERE email = '$email'";

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

  public function logOut() {
    session_start();
    session_destroy();
    $_SESSION = array();
  }

  public function isLoggedIn() {
    return isset($_SESSION['email']) && !empty($_SESSION['email']);
  }

  public function isAdmin() {
    if ($this->isLoggedIn()) {
      return $this->getUserByEmail($_SESSION['email'])['role'] == "admin";
    }

    return FALSE;
  }

  function __destruct() {
    $this->db = NULL;
  }
}

$userService = new UserService();