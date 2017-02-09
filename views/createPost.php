<?php
session_start();

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/categoryService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');

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

<main class="container create-post">
  <div class="text-center">
    <h1>Create post</h1>
  </div>

  <div class="row alert alert-danger text-center hidden"
       role="alert"
       id="errors">
  </div>

  <form onsubmit="return ajaxSubmitCreatePostForm(this, <?= $postService->getLastPostId() ?>)"
        method="post"
        id="create_post_form"
        enctype="multipart/form-data"
        class="row well">

    <div class="form-group">
      <label for="title"
             class="control-label">
        Title
      </label>
      <input type="text"
             name="title"
             id="title"
             placeholder="Enter title"
             class="form-control"
             required>
    </div>

    <div class="form-group">
      <label for="image"
             class="control-label">
        Image
      </label>
      <input type="file"
             name="image"
             id="image"
             accept="image/*"
             class="form-control">
    </div>

    <div class="form-group">
      <label for="category"
             class="control-label">
        Category
      </label>
      <select name="category"
              id="category"
              class="form-control">
        <option value="" disabled selected>- Select one -</option>
        <?php foreach ($categories as $key => $value): ?>
          <option value="<?= $key + 1 ?>">
            <?= $value['category'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="content"
             class="control-label">
        Content
      </label>
      <textarea class="ckeditor"
                id="content"
                name="content"
                class="form-control"
                required>
      </textarea>
      <script>
        CKEDITOR.replace('content');
      </script>
    </div>

    <div class="form-group">
      <label for="teaser"
             class="control-label">
        Teaser
      </label>
      <textarea id="teaser"
                name="teaser"
                class="form-control"
                required>
      </textarea>
    </div>

    <div class="form-group text-center">
      <button type="submit"
              class="btn btn-success">
        Create
      </button>

      <a href="../index.php"
         class="btn btn-danger">
        Cancel
      </a>
    </div>

  </form>
</main>
</body>
</html>
