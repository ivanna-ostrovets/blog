<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password == $confirm_password) {
  try {
    $userService->createUser($name, $email, $password, 'user');
    $userService->login($email, $password);
    echo "<p>", $_SESSION['email'], "</p>";
  } catch (Exception $e) {
    header("Location: ../views/register_form.php");
    echo $e->getMessage();
  }
}