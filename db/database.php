<?php

class Database {
  private static $servername = "localhost";
  private static $dbname = "blogDB";
  private static $datasource;
  private static $username = 'root';
  private static $password = '';
  private static $db;

  private function __construct() {
  }

  public static function createDB() {
    try {
      $dbh = new PDO("mysql:host=" . self::$servername, self::$username, self::$password);

      $dbh->exec("CREATE DATABASE " . self::$dbname . ";")
      or die(print_r($dbh->errorInfo(), TRUE));

      echo 'Database created successfully';
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  public static function getDB() {
    if (!isset(self::$datasource)) {
      self::$datasource = "mysql:host=" . self::$servername . ";dbname=" . self::$dbname;
    }

    if (!isset(self::$db)) {
      try {
        self::$db = new PDO(self::$datasource, self::$username, self::$password);
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
      echo "Db deleted";
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }

    $conn = NULL;
  }
}