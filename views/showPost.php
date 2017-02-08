<?php
session_start();

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');

$post = $postService->getPostById($_GET['id']);
?>

<!DOCTYPE html>
<html>
<head>
  <?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/includes.php'; ?>
</head>
<body>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/nav.php'; ?>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/sidebarNav.php'; ?>

<main class="main">
  <?php if (isset($post[0])):?>
    <div>
      <div class="image">
        <img src="<?= $post[0]['imagePath'] !== '' ? $post[0]['imagePath'] : $postService->defaultImagePath ?>" />
      </div>
      <h1 class="title-show"><?= $post[0]['title'] ?></h1>
      <div class="category"><?= $post[0]['category'] ?></div>
      <div class="text-show"><?= $post[0]['content'] ?></div>
      <?php if ($userService->isAdmin()): ?>
        <a class="button" href="../views/editPost.php?id=<?= $post[0]['id'] ?>">Edit</a>
        <a class="button" href="../controllers/deletePost.php?id=<?= $post[0]['id'] ?>">Delete</a>
      <?php endif; ?>
      <a class="button" href="../index.php">Back</a>
    </div>
  <?php else: ?>
    <div>
      <span>There is no such post yet.</span>
    </div>
  <?php endif; ?>
</main>
</body>
</html>
