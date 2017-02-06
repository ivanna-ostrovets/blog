<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');

$title = $_POST['title'];
$teaser = $_POST['teaser'];
$content = $_POST['content'];
$miniature = $_POST['miniature'];
$category = $_POST['category'];

$postService->createPost($title, $category, $teaser, $content, $miniature);