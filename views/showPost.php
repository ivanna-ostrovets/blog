<?php
session_start();

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/commentService.php');

$postId = $_GET['id'];
$post = $postService->getPostById($postId);
$comments = $commentService->getComments($postId);
?>

<!DOCTYPE html>
<html>
<head>
  <?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/includes.php'; ?>
  <script src="../public/js/ajaxAddComment.js"></script>
  <script src="/public/js/addLike.js"></script>
  <script src="/public/js/deleteLike.js"></script>
</head>
<body>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/nav.php'; ?>

<main class="main">
  <?php if (isset($post[0])): ?>
    <div>
      <div class="image">
        <img
          src="<?= $post[0]['image_path'] !== '' ? $post[0]['image_path'] : $postService->defaultImagePath ?>"/>
      </div>

      <h1 class="title-show"><?= $post[0]['title'] ?></h1>

      <div class="category"><?= $post[0]['category'] ?></div>

      <div class="text-show"><?= $post[0]['content'] ?></div>

      <div class="likes"
        <?php if ($userService->isLoggedIn()): ?>
          <?php if (!$userService->checkIfUserLikePost($value['id'])): ?>
            onclick="addLike(<?= $value['id'] ?>, <?= $userId ?>)"
          <?php else: ?>
            onclick="deleteLike(<?= $value['id'] ?>, <?= $userId ?>)"
          <?php endif; ?>
          data-toggle="tooltip"
          title="Only authorised users can like it."
        <?php endif; ?>>
        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
        Like
        <span id="likes_<?= $value['id'] ?>"><?= $value['likes'] ?></span>
      </div>

      <?php if ($userService->isAdmin()): ?>
        <a class="button"
           href="../views/editPost.php?id=<?= $post[0]['id'] ?>">
          Edit
        </a>

        <a class="button"
           href="../controllers/deletePost.php?id=<?= $post[0]['id'] ?>">
          Delete
        </a>
      <?php endif; ?>
      <a class="button" href="../index.php">Back</a>
    </div>
  <?php else: ?>
    <div>
      <span>There is no such post yet.</span>
    </div>
  <?php endif; ?>

  <?php if ($userService->isLoggedIn()): ?>
    <div id="add_comment_form">
      <form
        onsubmit="return ajaxAddComment(this,
        <?= $post[0]['id'] ?>,
        <?= $userService->getUserId($_SESSION['email']) ?>)"
        method="post"
        id="log_in_form">
        <div class="form-group">
          <label for="comment">Add comment</label>
          <textarea name="comment"
                    id="comment"
                    placeholder="Enter your comment"
                    required>
        </textarea>
        </div>

        <button type="submit">Submit</button>
      </form>
    </div>
  <?php endif; ?>

  <?php if (isset($comments)): ?>
    <div id="comments">
      <?php foreach ($comments as $key => $value):
        $user = $userService->getUserById($value['userId']);
        ?>
        <div class="comment">
          <div class="name">
            <?= $user['name'] ?>
          </div>

          <div class="email">
            <?= $user['email'] ?>
          </div>

          <div class="comment">
            <?= $value['comment'] ?>
          </div>

          <?php if ($userService->isAdmin()): ?>
            <a class="button"
               href="/controllers/deleteComment.php?comment_id=<?= $value['id'] ?>&post_id=<?= $postId ?>">
              Delete
            </a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</main>

</body>
</html>
