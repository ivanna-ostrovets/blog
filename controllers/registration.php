<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$errors = array();

if ($userService->checkUniqueEmail($email)) {
  $errors[] = array("message" => "This email already exists.");
}

if (strlen($password) < 6) {
  $errors[] = array("message" => "Password must be at least 6 characters.");
}

if ($password != $confirm_password) {
  $errors[] = array("message" => "Passwords doesn't match.");
}

if (empty($errors)) {
  try {
    $userService->createUser($name, $email, $password, 'user');
  } catch (Exception $e) {
    $errors[] = array("message" => $e->getMessage());
  }
}

if (!empty($errors)) {
  echo json_encode(array('errors' => $errors));
  http_response_code(400);
} else {
  $userService->logIn($email, $password);
}