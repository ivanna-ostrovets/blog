<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');
?>

<nav>
  <a href="../index.php">Home</a>

  <?php if ($userService->isLoggedIn()): ?>
    <?php if ($userService->isAdmin()): ?>
      <a href="../views/createPost.php">Create post</a>
    <?php endif; ?>

    <a id="log_out" onclick="logOut()">Log Out</a>

  <?php else: ?>
    <a href="../views/logIn.php">Log In</a>
    <?php if ($_SERVER['REQUEST_URI'] != '/views/register_form.php'): ?>
      <a href="../views/registration.php">Register</a>
    <?php endif; ?>
  <?php endif; ?>
</nav>
