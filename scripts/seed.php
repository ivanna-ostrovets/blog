<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');

Database::createDB();

require_once '../services/userService.php';
require_once '../services/categoryService.php';
require_once '../services/postService.php';

//Creates table for users
$sql = "CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  role VARCHAR(255)
  )";
Database::createTable($sql);

//Creates administrator account
$userService->createUser('admin', 'admin@gmail.com', 'password', 'admin');
$userService->logIn('admin@gmail.com', 'password');

//Creates table for categories
$sql = "CREATE TABLE categories (
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
$sql = "CREATE TABLE posts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  category INT,
  teaser TEXT NOT NULL,
  content TEXT NOT NULL,
  image_path VARCHAR(255),
  FOREIGN KEY (category) REFERENCES categories(id)
)";
Database::createTable($sql);

$sql = "CREATE TABLE comments (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED,
  post_id INT UNSIGNED,
  comment TEXT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (post_id) REFERENCES posts(id)
)";
Database::createTable($sql);

$sql = "CREATE TABLE likes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED,
  post_id INT UNSIGNED,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (post_id) REFERENCES posts(id)
)";
Database::createTable($sql);

$text = "Lorem ipsum dolor sit amet, ei omnis fugit postea sea, alia solet est cu,
at prima tantas consetetur sea. Ad lorem fugit quaeque sit, sale graeci electram vim ea.
Utroque constituto qui te, ferri indoctum posidonium at vim. Mel stet ferri ex,
omnis volumus blandit et cum, at mei soleat intellegebat. Porro persius phaedrum
ne mea, ne veri ludus nam. Ferri aliquip vel eu, sea dolorum salutatus ei, ad
sit vide eripuit adipiscing. An liber vitae soluta pro, id definiebas complectitur usu,
sed id nonumy efficiantur.

Eam ea laudem deleniti voluptatibus, no vel periculis deseruisse. Quo no
maiestatis scribentur, vim magna iriure aliquip et. An partem nostrum scribentur
pro. Pro labore option impetus at, apeirian urbanitas ne sea. Nam nibh dolores
accumsan in, per ex libris verear interesset, nisl complectitur qui cu. Mei posse
vituperata et. Ne vel praesent petentium mnesarchum, ea erant aliquip ceteros eum,
commune vituperata per eu.";

$teaser = "Lorem ipsum dolor sit amet, ei omnis fugit postea sea, alia solet est cu,
at prima tantas consetetur sea. Ad lorem fugit quaeque sit, sale graeci electram vim ea.";

$titles = array(
  "Apply these 7 secret techniques to improve news",
  "Believing these 7 myths about news keeps you from growing",
  "Don’t waste time! 7 facts until you reach your news",
  "How 7 things will change the way you approach news",
  "News awards: 7 reasons why they don’t work & what you can do about it",
  "News doesn’t have to be hard. Read these 7 tips",
  "News is your worst enemy. 7 ways to defeat it",
  "News on a budget: 7 tips from the great depression",
  "Knowing these 7 secrets will make your news look amazing",
  "Master the art of news with these 7 tips",
  "My life, my job, my career: how 7 simple news helped me succeed",
  "Take advantage of news - read these 7 tips",
  "The next 7 things you should do for news success"
);

for ($i = 0; $i < 100; $i += 1) {
  $postService->createPost($titles[array_rand($titles, 1)], rand(1, 4), $teaser, $text, "");
}