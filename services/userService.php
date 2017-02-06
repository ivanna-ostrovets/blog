<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');

class UserService {
  private $db;

  public function __construct() {
    $this->db = Database::getDB();
  }

  public function createUser($name, $email, $password, $role = "user") {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return FALSE;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Users (name, email, password, role) 
      VALUES ('$name', '$email', '$password_hash', '$role')";

    try {
      $this->db->exec($sql);
    } catch (PDOException $e) {
      if ($e->errorInfo[1] == 1062) {
        throw new Exception('This email already exists.');
      }
      else {
        echo $sql . "<br>" . $e->getMessage();
      }
    }
  }

  public function deleteUser($id) {
    $sql = "DELETE FROM Users WHERE id = '$id'";

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

  public function login($email, $password) {
    $data = $this->getUserByEmail($email);

    if ($data && password_verify($password, $data['password'])) {
      session_start();
      $_SESSION['email'] = $email;
//      header("Location: ../index.php");
    }
    else {
      session_start();
      $_SESSION['email'] = '';
      return "Invalid login or password!";
    }
  }

  public function logout() {
    session_destroy();
    unset($_SESSION);
    session_regenerate_id(true);
  }

  public function isLoggedIn() {
    return isset($_SESSION['email']) && $_SESSION['email'] != '';
  }

  public function isAdmin() {
    if ($this->isLoggedIn()) {
      return $this->getUserByEmail($_SESSION['email'])['role'] == "admin";
    }
  }

  function __destruct() {
    $this->db = NULL;
  }
}

$userService = new UserService();