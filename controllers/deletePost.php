<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');

$postService->deletePost($_GET['id']);

$urlPart = "";

if (isset($_GET['offset'])) {
  $urlPart .= "?offset={$_GET['offset']}";
}
if (isset($_GET['category'])) {
  $urlPart .= "&category={$_GET['category']}";
}

header("Location: ../index.php{$urlPart}");