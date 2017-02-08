<nav class="text-center">
  <ul class="pagination">
    <?php
    $urlPart = "";
    if (isset($_GET['category'])) {
      $urlPart = "&category={$_GET['category']}";
    }

    $postsNumber = $postService->postCount();
    ?>

    <li>
      <?php if ($_SERVER['REQUEST_URI'] === '/index.php' || (int) $_GET['offset'] === 0): ?>
        <a href="index.php?offset=<?= $postsNumber - 10 . $urlPart ?>">
      <?php elseif (isset($_GET['offset'])): ?>
        <a href="index.php?offset=<?= (int) $_GET['offset'] - 10 . $urlPart ?>">
      <?php endif; ?>
          <span>&laquo;</span>
        </a>
    </li>

    <?php for ($i = 0; $i < $postsNumber; $i += 10): ?>
      <li
        <?php if (isset($_GET['offset'])): ?>
          <?php if ((int) $_GET['offset'] === $i): ?>
            class="active"
          <?php endif; ?>
        <?php elseif ($_SERVER['REQUEST_URI'] === '/index.php'): ?>
          <?php if ($i === 0): ?>
            class="active"
          <?php endif; ?>
        <?php endif; ?>
      >
        <a href="index.php?offset=<?= $i . $urlPart ?>">
          <?= $i / 10 + 1 ?>
        </a>
      </li>
    <?php endfor; ?>

    <li>
      <?php if (isset($_GET['offset']) && (int) $_GET['offset'] === $postsNumber - 10 && (int) $_GET['offset'] < 100): ?>
        <a href="index.php?offset=0<?= $urlPart ?>">
      <?php elseif (isset($_GET['offset'])): ?>
        <a href="index.php?offset=<?= (int) $_GET['offset'] + 10 . $urlPart ?>">
      <?php elseif ($_SERVER['REQUEST_URI'] === '/index.php'): ?>
        <a href="index.php?offset=10<?= $urlPart ?>">
      <?php endif; ?>
          <span>&raquo;</span>
        </a>
    </li>
  </ul>
</nav>
