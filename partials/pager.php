<div class="pager">
  <?php for ($i = 0; $i < $postService->postCount(); $i += 10):
    $urlPart = "";
    if (isset($_GET['category'])) {
      $urlPart = "&category={$_GET['category']}";
    } ?>

    <a href="index.php?offset=<?= $i . $urlPart?>" class="pages">
      <?= $i + 1 ?> - <?= $i + 10 ?>
    </a>

  <?php endfor; ?>
</div>
