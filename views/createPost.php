<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/categoryService.php');

$categories = $categoryService->getAllCategories();
?>

<!DOCTYPE html>
<html>
<head>s
  <?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/includes.php'; ?>
  <script src="//cdn.ckeditor.com/4.5.5/standard/ckeditor.js"></script>
</head>
<body>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/nav.php'; ?>

<main class="main">
  <form action="../controllers/createPost.php" method="post" id="create_post_form">
    <div class="form-group">
      <label>Title</label>
      <input type="text" name="title" id="title" placeholder="Enter title">
    </div>

    <div class="form-group">
      <label>Miniature</label>
      <input type="file" name="miniature" id="miniature">
    </div>

    <div class="form-group">
      <label>Category</label>
      <select name="category" form="create_post_form">
        <?php foreach ($categories as $key => $value): ?>
          <option value="<?= $key ?>">
            <?= $value['category'] ?>
          </option>;
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label>Content</label>
      <textarea class="ckeditor" id="content" name="content">
      <script>
        CKEDITOR.replace('content');
      </script>
      </textarea>
    </div>

    <div class="form-group">
      <label>Teaser</label>
      <textarea id="teaser" name="teaser"></textarea>
    </div>

    <input type="submit" value="Submit">
    <a href="../index.php">Cancel</a>
  </form>
</main>

<footer>
</footer>
</body>
</html>
