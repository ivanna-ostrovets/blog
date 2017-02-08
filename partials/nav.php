<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/categoryService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');

$categories = $categoryService->getAllCategories();
$url = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "?"));
?>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand"
         href="/index.php">
        Blog
      </a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active">
          <a href="/index.php" class="
          <?php if ($url == '/index.php'): ?>
              active
          <?php endif; ?>
          ">Home</a>
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

      <ul class="nav navbar-nav navbar-right">
        <?php if ($userService->isLoggedIn()): ?>
          <?php if ($userService->isAdmin()): ?>
            <li>
              <a href="/views/createPost.php" class="
              <?php if ($url == '/views/createPost.php'): ?>
                  active
              <?php endif; ?>
              ">Create post</a>
            </li>
          <?php endif; ?>

          <li>
            <a id="log_out"
               onclick="logOut()">
              Log Out
            </a>
          </li>
        <?php else: ?>
          <li>
            <a href="/views/logIn.php" class="
              <?php if ($_SERVER['REQUEST_URI'] == '/views/logIn.php'): ?>
                  active
              <?php endif; ?>
              ">Log In</a>
          </li>

          <li>
            <a href="../views/registration.php" class="
              <?php if ($_SERVER['REQUEST_URI'] == '/views/registration.php'): ?>
                  active
              <?php endif; ?>
              ">Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>