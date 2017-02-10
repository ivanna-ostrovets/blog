<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');

$postService->deletePost($_GET['id']);

$urlParam = "";
$postsNumber = $postService->postCount();
$offset = "";
$category = "";

if (isset($_GET['offset'])) {
  $offset = $_GET['offset'];

  if ($postsNumber == $offset) {
    $offset = (int) $offset - 10;
  }
}
if (isset($_GET['category'])) {
  $category = $_GET['category'];
}

if (!empty($offset) && !empty($category)) {
  $urlParam .= "?offset={$offset}&category={$category}";
} else if (!empty($offset)) {
  $urlParam .= "?offset={$offset}";
}
else if (!empty($category)) {
  $urlParam .= "?category={$category}";
}

header("Location: ../index.php{$urlParam}");