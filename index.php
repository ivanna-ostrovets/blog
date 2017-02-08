<?php
session_start();

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/commentService.php');

$posts = $postService->getPosts(10);
?>

<!DOCTYPE html>
<html>
<head>
  <?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/includes.php'; ?>
  <script src="/public/js/addLike.js"></script>
  <script src="/public/js/deleteLike.js"></script>
</head>
<body>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/nav.php'; ?>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/pager.php'; ?>

<main class="main">
  <?php if (isset($posts)): ?>
    <?php foreach ($posts as $key => $value): ?>
      <div class="post">
        <div class="title">
          <?= $value['title'] ?>
        </div>

        <div class="image">
          <img
            src="<?= $value['image_path'] !== '' ? $value['image_path'] : $postService->defaultImagePath ?>"/>
        </div>

        <?php if ($userService->isAdmin()): ?>
          <a class="button"
             href="/views/editPost.php?id=<?= $value['id'] ?>">
            Edit
          </a>
          <a class="button"
             href="/controllers/deletePost.php?id=<?= $value['id'] ?>">
            Delete
          </a>
        <?php endif; ?>

        <div class="category"><?= $value['category'] ?></div>

        <div class="teaser"><?= $value['teaser'] ?></div>

        <div class="likes"
          <?php if ($userService->isLoggedIn()): ?>
            <?php $userId = $userService->getUserId($_SESSION['email']); ?>
            <?php if (!$userService->checkIfUserLikePost($value['id'])): ?>
              onclick="addLike(<?= $value['id'] ?>, <?= $userId ?>)"
            <?php else: ?>
              onclick="deleteLike(<?= $value['id'] ?>, <?= $userId ?>)"
            <?php endif; ?>
          <?php else: ?>
            data-toggle="tooltip"
            title="Only authorised users can like it."
          <?php endif; ?>>
          <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
          Like
          <?php $likesNumber = $postService->likesCount($value['id']); ?>
          <span id="likes_<?= $value['id'] ?>"><?php print_r($likesNumber) ?></span>
        </div>

        <?php if ($userService->isLoggedIn()): ?>
          <div class="comments">
            <a href="views/showPost.php?id=<?= $value['id'] ?>">
              Add new comment
            </a>
          </div>
        <?php endif; ?>

        <div class="comments">
          <a href="views/showPost.php?id=<?= $value['id'] ?>">
            Comments (<?= $commentService->commentsCount($value['id']) ?>)
          </a>
        </div>

        <a href="views/showPost.php?id=<?= $value['id'] ?>">
          Read more >>
        </a>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div>
      <span>There is no posts yet.</span>
    </div>
  <?php endif; ?>
</main>

<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/pager.php'; ?>
</body>
</html>
