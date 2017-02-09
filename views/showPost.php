<?php
session_start();

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/commentService.php');

$postId = $_GET['id'];
$post = $postService->getPostById($postId);
?>

<!DOCTYPE html>
<html>
<head>
  <?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/includes.php'; ?>
  <script src="../public/js/ajaxAddComment.js"></script>
  <script src="/public/js/toggleLike.js"></script>
</head>
<body>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/nav.php'; ?>

<main class="container post-show-container">
  <?php if (isset($post[0])):
    $comments = $commentService->getComments($postId);
    ?>
    <div class="panel panel-default post-show row">
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-9">
            <h1 class="title-show">
              <?= $post[0]['title'] ?>
            </h1>

            <div class="category">
              Category: <?= $post[0]['category'] ?>
            </div>
          </div>

          <div class="col-sm-3">
            <img
              src="<?= $post[0]['image_path'] !== '' ? $post[0]['image_path'] : $postService->defaultImagePath ?>"
              class="image img-rounded pull-right"/>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12 text-show">
            <?= $post[0]['content'] ?>
          </div>
        </div>

        <div class="row buttons">
          <div class="col-sm-12">
            <?php if ($userService->isAdmin()): ?>
              <a class="btn btn-primary edit"
                 href="../views/editPost.php?id=<?= $post[0]['id'] ?>">
                Edit
              </a>

              <a class="btn btn-danger delete"
                 href="../controllers/deletePost.php?id=<?= $post[0]['id'] ?>">
                Delete
              </a>
            <?php endif; ?>

            <div class="likes">
              <?php $userId = $userService->getUserId($_SESSION['email']); ?>
              <button onclick="toggleLike(<?php echo $postId, ", ", $userId ?>)"
                      class="btn btn-default
                <?php if ($userService->isLoggedIn()): ?>
                  <?php if ($userService->checkIfUserLikePost($postId, $userId)): ?>
                    "
                  <?php else: ?>
                    btn-success"
                  <?php endif; ?>
                <?php else: ?>
                  disabled
                  data-toggle="tooltip"
                  title="Please log in to like this post"
                <?php endif; ?>
              >
                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                <?php $likesNumber = $postService->likesCount($postId); ?>
                <span id="likes_<?= $postId ?>"><?= $likesNumber ?></span>
              </button>
            </div>

            <a href="../index.php"
               class="btn btn-info back pull-right">
              Back
            </a>
          </div>
        </div>
      </div>
    </div>

    <?php if ($userService->isLoggedIn()): ?>
    <form
      onsubmit="return ajaxAddComment(this,
      <?= $post[0]['id'] ?>,
      <?= $userService->getUserId($_SESSION['email']) ?>)"
      method="post"
      class="row add-comment-form">

      <div class="form-group">
        <label for="new_comment"
               class="control-label">
          Add comment
        </label>
        <textarea name="comment"
                  id="new_comment"
                  placeholder="Enter your comment"
                  required
                  class="form-control">
          </textarea>
      </div>

      <div class="form-group">
        <button type="submit"
                class="btn btn-primary">
          Add comment
        </button>
      </div>
    </form>
  <?php endif; ?>

    <div class="row">
      <p class="comments-count">
        <?php $commentsNumber = $commentService->commentsCount($post[0]['id']) ?>
        <?= $commentsNumber ?>
        <?php if ($commentsNumber == 1): ?>
          comment
        <?php else: ?>
          comments
        <?php endif; ?>
      </p>
    </div>

    <?php if (isset($comments)): ?>
      <?php foreach ($comments as $key => $value):
      $user = $userService->getUserById($value['user_id']);
      ?>
        <div class="panel panel-default comment row">
          <div class="panel-body">
            <div class="row comment-header">
              <div class="col-sm-12">
                <h4 class="comment-title">
                  <span class="name">
                    <?= $user['name'] ?>
                  </span>

                  <small class="email">
                    <?= $user['email'] ?>
                  </small>
                </h4>

                <?php if ($userService->isAdmin()): ?>
                  <a class="btn btn-danger pull-right delete"
                     href="/controllers/deleteComment.php?comment_id=<?= $value['id'] ?>&post_id=<?= $postId ?>">
                    Delete
                  </a>
                <?php endif; ?>
              </div>
            </div>

            <div class="row comment-text">
              <div class="col-sm-12">
                <?= $value['comment'] ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

  <?php else: ?>
    <div class="alert alert-info text-center" role="alert">
      There is no such post yet.
    </div>

  <?php endif; ?>
</main>

</body>
</html>
