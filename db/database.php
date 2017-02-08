<?php

class Database {
  private static $servername = "localhost";
  private static $dbname = "blog";
  private static $username = 'root';
  private static $password = '';
  private static $db;

  private function __construct() {
  }

  public static function createDB() {
    try {
      $dbh = new PDO("mysql:host=" . self::$servername, self::$username, self::$password);

      $dbh->exec("CREATE DATABASE " . self::$dbname . " charset=utf8;")
      or die(print_r($dbh->errorInfo(), TRUE));
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  public static function getDB() {
    if (!isset(self::$db)) {
      try {
        self::$db = new PDO(
          "mysql:host=" . self::$servername . ";dbname=" . self::$dbname,
          self::$username,
          self::$password
        );

        self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
    }

    return self::$db;
  }

  public static function dropDB() {
    $sql = "DROP DATABASE " . self::$dbname . ";";

    try {
      $conn = self::getDB();
      $conn->exec($sql);

      session_start();
      session_destroy();
      $_SESSION = array();

      $imagesFolder = $_SERVER['DOCUMENT_ROOT'] . '/public/posts_images/';
      chmod($imagesFolder, 0600);

      array_map('unlink', glob($imagesFolder . '*'));

      echo "Db deleted";
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }

    $conn = NULL;
  }

  public static function createTable($sql) {
    try {
      $conn = self::getDB();
      $conn->exec($sql);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }

    $conn = NULL;
  }
}