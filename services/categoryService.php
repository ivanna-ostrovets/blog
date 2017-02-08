<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');

class CategoryService {
  private $db;

  public function __construct() {
    $this->db = Database::getDB();
  }

  public function createCategory($category) {
    $sql = "INSERT INTO categories (category) VALUES ('$category')";

    try {
      $this->db->exec($sql);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function deleteCategory($category) {
    $sql = "DELETE FROM categories WHERE caregory='$category'";

    try {
      $this->db->exec($sql);
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  public function getAllCategories() {
    $sql = "SELECT category FROM categories";

    try {
      $categories = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

      if (!empty($categories)) {
        return $categories;
      }
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }

  function __destruct() {
    $this->db = NULL;
  }
}

$categoryService = new CategoryService();