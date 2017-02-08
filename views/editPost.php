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

<main class="main">
  <?php if ($userService->isAdmin()): ?>
    <div class="errors"
         id="errors">
    </div>

    <form onsubmit="return ajaxSubmitEditPost(this, getUrLParameter('id'))"
          method="post"
          id="create_post_form"
          enctype="multipart/form-data">
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text"
               name="title"
               id="title"
               placeholder="Enter title"
               value="<?= $post[0]['title'] ?>"
               required>
      </div>

      <?php if ($post[0]['imagePath'] !== ''): ?>
        <div class="image" id="image_preview"><img
            src="<?= $post[0]['imagePath'] ?>"/></div>

        <div class="form-group">
          <button type="button"
                  name="delete_image"
                  onclick="deleteImage(this)">
            Delete old image
          </button>
        </div>
      <?php endif; ?>

      <div class="form-group
        <?php if ($post[0]['imagePath'] !== ''): ?>
          hidden"
        <?php endif; ?>
           id="new_image">
        <label for="image">Choose new image</label>
        <input type="file"
               name="image"
               id="image"
               accept="image/*">
      </div>

      <div class="form-group">
        <label for="category">Category</label>
        <select name="category"
                id="category">
          <option value="" disabled>- Select one -</option>
          <?php foreach ($categories as $key => $value): ?>
            <option
              <?php if ($post[0]['category'] == $key + 1): ?>
                selected
              <?php endif; ?>
              value="<?= $key + 1 ?>">
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
        <?= $post[0]['content'] ?>
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
        <?= $post[0]['teaser'] ?>
        </textarea>
      </div>

      <button type="submit">Submit</button>

      <a href="showPost.php?id=<?= $post[0]['id'] ?>">Cancel</a>
    </form>
  <?php else: ?>
    <div class="no-posts">
      <span>You do not have access to view this page.</span>
    </div>
  <?php endif; ?>
</main>

<footer>
</footer>
</body>
</html>
