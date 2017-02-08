<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');

$email = $_POST['email'];
$password = $_POST['password'];

$errors = array();

if (empty($errors)) {
  try {
    $userService->logIn($email, $password);
  } catch (Exception $e) {
    $errors[] = array("message" => $e->getMessage());
  }
}

if (!empty($errors)) {
  echo json_encode(array('errors' => $errors));
  http_response_code(400);
}