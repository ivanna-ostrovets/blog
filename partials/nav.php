<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/categoryService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');

$categories = $categoryService->getAllCategories();
$currentCategory = $categoryService->getCurrentCategory()['category'];

$urlPart = "";
$urlPartOffset = "";

if (isset($_GET['category']) && isset($_GET['offset'])) {
  $urlPart = "?category={$_GET['category']}&offset={$_GET['offset']}";
} else {
  if (isset($_GET['offset'])) {
    $urlPart = "?offset={$_GET['offset']}";
    $urlPartOffset = "?offset={$_GET['offset']}";
  } else {
    if (isset($_GET['category'])) {
      $urlPart = "?category={$_GET['category']}";
    }
  }
}

$url = $_SERVER['REQUEST_URI'];
?>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand"
         href="/index.php">
        Blog
      </a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="
          <?php if ($url == "/index.php" . $urlPartOffset): ?>
            active
          <?php endif; ?>
        ">
          <a href="/index.php">Home</a>
        </li>

        <li class="dropdown">
          <a href="/index.php"
             class="dropdown-toggle"
             data-toggle="dropdown"
             role="button"
             aria-haspopup="true"
             aria-expanded="false">
            Categories <span class="caret"></span>
          </a>

          <ul class="dropdown-menu">
            <?php foreach ($categories as $key => $value): ?>
              <li>
                <a
                  href="../index.php?category=<?= $key + 1 ?>"><?= $value['category'] ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </li>
      </ul>

      <ul class="nav navbar-nav category">
        <?php if($currentCategory): ?>
          <li class="
            <?php if ($url == "/index.php" . $urlPart): ?>
              active
            <?php endif; ?>
          ">
            <a href="/index.php<?= $urlPart?>"><?= $currentCategory ?></a>
          </li>
        <?php endif; ?>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <?php if ($userService->isLoggedIn()): ?>
          <?php if ($userService->isAdmin()): ?>
            <li class="
              <?php if ($url == '/views/createPost.php'): ?>
                active
              <?php endif; ?>
            ">
              <a href="/views/createPost.php">Create post</a>
            </li>
          <?php endif; ?>

          <li>
            <a id="log_out"
               onclick="logOut()">
              Log Out
            </a>
          </li>
        <?php else: ?>
          <li class="
            <?php if ($_SERVER['REQUEST_URI'] == '/views/logIn.php'): ?>
              active
            <?php endif; ?>
          ">
            <a href="/views/logIn.php">Log In</a>
          </li>

          <li class="
              <?php if ($_SERVER['REQUEST_URI'] == '/views/registration.php'): ?>
                active
              <?php endif; ?>
              ">
            <a href="../views/registration.php">Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>