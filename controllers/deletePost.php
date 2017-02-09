<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');

$postService->deletePost($_GET['id']);

$urlParam = "?";
$postsNumber = $postService->postCount();

if (isset($_GET['offset'])) {
  $offset = (int) $_GET['offset'];

  if ($postsNumber == $offset) {
    $newOffset = $offset - 10;
    $urlParam .= "offset={$newOffset}&";
  } else {
    $urlParam .= "offset={$offset}&";
  }
}
if (isset($_GET['category'])) {
  $urlParam .= "category={$_GET['category']}";
}

header("Location: ../index.php{$urlParam}");