<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');
?>

<!DOCTYPE html>
<html>
<head>
  <?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/includes.php'; ?>
  <script src="../public/js/getUrLParameter.js"></script>
  <script src="../public/js/ajaxSubmitLogInForm.js"></script>
</head>
<body>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/nav.php'; ?>

<main class="container log-in">
  <div class="text-center">
    <h1>Sign in to Blog</h1>
  </div>

  <div class="row alert alert-danger text-center hidden"
       role="alert"
       id="errors">
  </div>

  <form onsubmit="return ajaxSubmitLogInForms(this)"
        method="post"
        id="log_in_form"
        class="row well">

    <div class="form-group">
      <label for="email"
             class="control-label">
        Email
      </label>
      <input type="email"
             name="email"
             id="email"
             placeholder="Enter email"
             class="form-control"
             required>
    </div>

    <div class="form-group">
      <label for="password"
             class="control-label">
        Password
      </label>
      <input type="password"
             name="password"
             id="password"
             placeholder="Enter password"
             class="form-control"
             required>
    </div>

    <div class="form-group">
      <button type="submit"
              class="btn btn-primary">
        Sign in
      </button>
    </div>
  </form>

  <div class="well text-center row">
    <p class="new-to-blog">
      New to Blog? <a href="registration.php">Create an account.</a>
    </p>
  </div>
</main>
</body>
</html>
