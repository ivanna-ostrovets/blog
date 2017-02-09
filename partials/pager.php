<?php
$urlPart = "";
if (isset($_GET['category'])) {
  $urlPart = "&category={$_GET['category']}";
}

$postsNumber = $postService->postCount();

$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;

$url = $_SERVER['REQUEST_URI'];
?>

<nav class="text-center">
  <ul class="pagination">
    <li>
      <?php if ($url === '/index.php' || $offset === 0): ?>
        <a href="index.php?offset=<?= $postsNumber - 10 . $urlPart ?>">

      <?php elseif ($offset): ?>
        <a href="index.php?offset=<?= $offset - 10 . $urlPart ?>">

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

        <?php elseif ($url === '/index.php' || $url === '/index.php?offset=0'): ?>
          <?php if ($i === 0): ?>
            class="active"
          <?php endif; ?>

          <?php if ($i > 90): ?>
            class="hidden"
          <?php endif; ?>

        <?php endif; ?>
      >
        <a href="index.php?offset=<?= $i . $urlPart ?>">
          <?= $i / 10 + 1 ?>
        </a>
      </li>
    <?php endfor; ?>

    <li>
      <?php if ($offset): ?>
        <?php if ($offset === $postsNumber - 10): ?>
          <a href="index.php?offset=0<?= $urlPart ?>">

        <?php else: ?>
          <a href="index.php?offset=<?= $offset + 10 . $urlPart ?>">

        <?php endif; ?>

      <?php elseif ($url === '/index.php' || $url === '/index.php?offset=0'): ?>
        <a href=" index.php?offset=10<?= $urlPart ?>">

      <?php endif; ?>
          <span>&raquo;</span>
        </a>
    </li>
  </ul>
</nav>
