<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/commentService.php');

$comment = $_POST['comment'];
$postId = $_GET['post_id'];
$userId = $_GET['user_id'];

$errors = array();

if (empty($errors)) {
  try {
    $commentService->createComment($userId, $postId, $comment);
  } catch (Exception $e) {
    $errors[] = array("message" => $e->getMessage());
  }
}

if (!empty($errors)) {
  echo json_encode(array('errors' => $errors));
  http_response_code(400);
}