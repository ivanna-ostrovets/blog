<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');
?>

<nav>
  <?php if ($userService->isLoggedIn()): ?>
    <?php $data = $userService->getUserByEmail($_SESSION['email']); ?>
    <span>Hello, <?php $data['name']?></span>
  <?php else: ?>
    <?php if ($_SERVER['REQUEST_URI'] != '/views/register_form.php'): ?>
      <a href="../views/registration.php">Register</a>
    <?php endif; ?>
    <a href="../views/createPost.php">Create post</a>
  <?php endif; ?>
</nav>
