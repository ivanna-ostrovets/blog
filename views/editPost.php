<?php
session_start();

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/categoryService.php');

$categories = $categoryService->getAllCategories();
$post = $postService->getPostById($_GET['id'], FALSE);
?>

<!DOCTYPE html>
<html>
<head>
  <?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/includes.php'; ?>
  <link rel="stylesheet" href="../public/css/main.css">
  <script src="//cdn.ckeditor.com/4.5.5/standard/ckeditor.js"></script>
  <script src="../public/js/getUrLParameter.js"></script>
  <script src="../public/js/deleteImage.js"></script>
  <script src="../public/js/ajaxSubmitEditPost.js"></script>
</head>
<body>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/nav.php'; ?>

<main class="container edit-post">
  <?php if ($userService->isAdmin()): ?>
    <div class="text-center">
      <h1>Edit post</h1>
    </div>

    <div class="row alert alert-danger text-center hidden"
         role="alert"
         id="errors">
    </div>

    <form onsubmit="return ajaxSubmitEditPost(this, getUrLParameter('id'))"
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
               value="<?= $post[0]['title'] ?>"
               required>
      </div>

      <?php if ($post[0]['image_path'] !== ''): ?>
        <div class="form-group" id="image_preview">
          <img src="<?= $post[0]['image_path'] ?>"
               class="img-thumbnail"/>
        </div>

        <div class="form-group">
          <button type="button"
                  name="delete_image"
                  onclick="deleteImage(this)"
                  class="btn btn-info">
            Delete old image
          </button>
        </div>
      <?php endif; ?>

      <div class="form-group
        <?php if ($post[0]['image_path'] !== ''): ?>
          hidden"
        <?php endif; ?>
           id="new_image">
        <label for="image"
               class="control-label">
          Choose new image
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
          <option value="" disabled>- Select one -</option>
          <?php foreach ($categories as $key => $value): ?>
            <option
              <?php if ($post[0]['category'] === $key + 1): ?>
                selected
              <?php endif; ?>
              value="<?= $key + 1 ?>">
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
        <?= $post[0]['content'] ?>
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
        <?= $post[0]['teaser'] ?>
        </textarea>
      </div>

      <div class="form-group text-center">
        <button type="submit"
                class="btn btn-success">
          Submit
        </button>

        <a href="showPost.php?id=<?= $post[0]['id'] ?>"
           class="btn btn-danger">
          Cancel
        </a>
      </div>
    </form>
  <?php else: ?>
    <div class="row alert alert-danger text-center"
         role="alert"
         id="errors">
      <p>You do not have access to view this page.</p>
    </div>
  <?php endif; ?>
</main>

<footer>
</footer>
</body>
</html>
