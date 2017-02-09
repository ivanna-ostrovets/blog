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
  <script src="/public/js/toggleLike.js"></script>
</head>
<body>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/nav.php'; ?>
<?php if (isset($posts)): ?>
  <?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/pager.php'; ?>
<?php endif; ?>

<main class="container-fluid">
  <?php if (isset($posts)): ?>
    <?php foreach ($posts as $key => $value): ?>
      <div class="panel panel-default post">
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-10">
              <h3 class="title-row">
                <span class="title"><?= $value['title'] ?></span>

                <span class="label label-default">
                  <?= $value['category'] ?>
                </span>

                <small class="comments">
                  Comments (<?= $commentService->commentsCount($value['id']) ?>)
                </small>
              </h3>

              <div class="teaser"><?= $value['teaser'] ?></div>
            </div>

            <div class="col-sm-2">
              <img
                src="<?= $value['image_path'] !== '' ? $value['image_path'] : $postService->defaultImagePath ?>"
                class="image img-rounded pull-right"/>
            </div>
          </div>

          <div class="row buttons">
            <div class="col-sm-12">
              <?php if ($userService->isAdmin()): ?>
                <a class="btn btn-primary edit"
                   href="/views/editPost.php?id=<?= $value['id'] ?>">
                  Edit
                </a>

                <a class="btn btn-danger delete"
                   href="/controllers/deletePost.php?id=<?= $value['id'] ?>">
                  Delete
                </a>
              <?php endif; ?>

              <div class="likes">
                <?php $userId = $userService->getUserId($_SESSION['email']); ?>
                <button onclick="toggleLike(<?php echo $value['id'], ", ", $userId ?>)"
                        class="btn btn-default
                  <?php if ($userService->isLoggedIn()): ?>
                    <?php if ($userService->checkIfUserLikePost($value['id'], $userId)): ?>
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
                  <?php $likesNumber = $postService->likesCount($value['id']); ?>
                  <span id="likes_<?= $value['id'] ?>"><?= $likesNumber ?></span>
                </button>
              </div>

              <div class="btn btn-info read-more pull-right">
                <a href="views/showPost.php?id=<?= $value['id'] ?>">
                  Read more >>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-info text-center" role="alert">
      There is no posts yet.
    </div>
  <?php endif; ?>
</main>

<?php if (isset($posts)): ?>
  <?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/pager.php'; ?>
<?php endif; ?>
</body>
</html>
