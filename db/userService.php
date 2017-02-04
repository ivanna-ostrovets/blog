<?php

require_once 'database.php';

class UserService {
  private $db;

  public function __construct() {
    $this->db = Database::getDB();
  }

  public function createUser($name, $email, $password, $role = "user") {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "Invalid email!";
      return FALSE;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Users (name, email, password, role) VALUES ('$name', '$email', '$password_hash', '$role')";

    try {
      $this->db->exec($sql);
      echo "New record created successfully.<br>";
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function login($email, $password) {
    $sql = "SELECT name, email, password, role FROM Users WHERE email='$email'";

    try {
      $data = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);

      if ($data && password_verify($password, $data['password'])) {
        echo "User's data selected.<br>";
        return $data;
      }
      else {
        return "Invalid login or password!";
      }
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  function __destruct() {
    $this->db = NULL;
  }
}