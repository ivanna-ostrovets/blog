<?php
session_start();

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/categoryService.php');

$categories = $categoryService->getAllCategories();
?>

<!DOCTYPE html>
<html>
<head>
  <?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/includes.php'; ?>
  <script src="//cdn.ckeditor.com/4.5.5/standard/ckeditor.js"></script>
  <script src="../public/js/ajaxSubmitCreatePostForm.js"></script>
</head>
<body>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/nav.php'; ?>

<main class="main">
  <div class="errors"
       id="errors">
  </div>

  <form onsubmit="return ajaxSubmitCreatePostForm(this)"
        method="post"
        id="create_post_form"
        enctype="multipart/form-data">
    <div class="form-group">
      <label for="title">Title</label>
      <input type="text"
             name="title"
             id="title"
             placeholder="Enter title"
             required>
    </div>

    <div class="form-group">
      <label for="image">Image</label>
      <input type="file"
             name="image"
             id="image"
             accept="image/*">
    </div>

    <div class="form-group">
      <label for="category">Category</label>
      <select name="category" id="category">
        <option value="" disabled selected>- Select one -</option>
        <?php foreach ($categories as $key => $value): ?>
          <option value="<?= $key + 1 ?>">
            <?= $value['category'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="content">Content</label>
      <textarea class="ckeditor"
                id="content"
                name="content"
                required>
      </textarea>
      <script>
        CKEDITOR.replace('content');
      </script>
    </div>

    <div class="form-group">
      <label for="teaser">Teaser</label>
      <textarea id="teaser"
                name="teaser"
                required>
      </textarea>
    </div>

    <button type="submit">Submit</button>

    <a href="../index.php">Cancel</a>
  </form>
</main>
</body>
</html>
