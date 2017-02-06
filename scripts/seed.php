<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');

Database::createDB();

require_once '../services/userService.php';
require_once '../services/categoryService.php';
require_once '../services/postService.php';

//Creates table for users
$sql = "CREATE TABLE Users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  role VARCHAR(255)
  )";
Database::createTable($sql);

//Creates administrator account
$userService->createUser('admin', 'admin@gmail.com', 'password', 'admin');
$userService->login('admin@gmail.com', 'password');
echo "<br>email: ", $_SESSION['email'], "<br>";
echo "<br>isLoggedIn: ", $userService->isLoggedIn(), "<br>";
print_r($userService->getUserByEmail($_SESSION['email']));
echo "<br>isAdmin:", $userService->isAdmin(), "<br>";
$userService->logout();
echo "<br>isLoggedIn: ", $userService->isLoggedIn(), "<br>";

//Creates table for categories
$sql = "CREATE TABLE Categories (
  id INT AUTO_INCREMENT PRIMARY KEY, 
  category VARCHAR(255) NOT NULL
  )";
Database::createTable($sql);

//Creates some basic categories
$categoryService->createCategory("Sport");
$categoryService->createCategory("Games");
$categoryService->createCategory("Science");
$categoryService->createCategory("Politics");

//Creates table for posts
$sql = "CREATE TABLE Posts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  category INT,
  teaser TEXT NOT NULL,
  content TEXT NOT NULL,
  miniature BLOB,
  FOREIGN KEY (category) REFERENCES Categories(id)
);";
Database::createTable($sql);

