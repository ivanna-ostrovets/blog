<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/categoryService.php');

$categories = $categoryService->getAllCategories();
?>

<nav>
  <?php foreach ($categories as $key => $value): ?>
    <a href="../index.php?category=<?= $key + 1 ?>"><?= $value['category'] ?></a>
  <?php endforeach; ?>
</nav>
