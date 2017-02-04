<?php
require 'database.php';
require 'userService.php';

Database::createDB();

$sql = "CREATE TABLE Users (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
  name VARCHAR(200) NOT NULL,
  email VARCHAR(50),
  password VARCHAR(200),
  role VARCHAR(15)
  )";
Database::createTable($sql);

$userService = new UserService();
$userService->createUser('admin', 'admin@gmail.com', 'password', 'admin');
