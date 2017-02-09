<?php
$urlPart = "";
$urlPartForCheck = "";

if (isset($_GET['category'])) {
  $category = $_GET['category'];

  $urlPart = "category={$category}&";
  $urlPartForCheck = "?category={$category}";
}

$postsNumber = $postService->postCount();
$postsNumber = ceil($postsNumber / 10) * 10;

$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;

$url = $_SERVER['REQUEST_URI'];
$checkUrl = "/index.php" . $urlPartForCheck;
?>

<nav class="text-center">
  <ul class="pagination">
    <li>
      <?php if ($url === "/"
        || $url === $checkUrl
        || $url === $checkUrl . "&offset=0"
        || $url === $checkUrl . "?offset=0"): ?>
        <a href="/index.php?<?= $urlPart ?>offset=<?= $postsNumber - 10 ?>">

      <?php elseif ($offset): ?>
        <a href="/index.php?<?= $urlPart ?>offset=<?= $offset - 10 ?>">

      <?php endif; ?>
          <span>&laquo;</span>
        </a>
    </li>

    <?php for ($i = 0; $i < $postsNumber; $i += 10): ?>
      <li
        <?php if ($offset): ?>
          <?php if ($offset === $i): ?>
            class="active"
          <?php endif; ?>

          <?php if ($offset > 40 && ($i <= $offset - 50 || $i >= $offset + 60)): ?>
            <?php if ($offset < $postsNumber - 50): ?>
              class="hidden"

            <?php else: ?>
              <?php if ($i < $postsNumber - 100): ?>
                class="hidden"
              <?php endif; ?>

            <?php endif; ?>
          <?php endif; ?>

          <?php if ($offset <= 40 && ($i > 90)): ?>
            class="hidden"
          <?php endif; ?>

        <?php elseif ($url === "/"
          || $url === $checkUrl
          || $url === $checkUrl . "&offset=0"
          || $url === $checkUrl . "?offset=0"): ?>

          <?php if ($i === 0): ?>
            class="active"
          <?php endif; ?>

          <?php if ($i > 90): ?>
            class="hidden"
          <?php endif; ?>

        <?php endif; ?>
      >
        <a href="/index.php?<?= $urlPart ?>offset=<?= $i ?>">
          <?= $i / 10 + 1 ?>
        </a>
      </li>
    <?php endfor; ?>

    <li>
      <?php if ($offset): ?>
        <?php if ($offset == $postsNumber - 10): ?>
          <a href="/index.php?<?= $urlPart ?>offset=0">

        <?php else: ?>
          <a href="/index.php?<?= $urlPart ?>offset=0<?= $offset + 10 ?>">

        <?php endif; ?>

      <?php elseif ($url === "/"
        || $url === $checkUrl
        || $url === $checkUrl . "&offset=0"
        || $url === $checkUrl . "?offset=0"): ?>
        <a href="/index.php?<?= $urlPart ?>offset=10">

      <?php endif; ?>
          <span>&raquo;</span>
        </a>
    </li>
  </ul>
</nav>
