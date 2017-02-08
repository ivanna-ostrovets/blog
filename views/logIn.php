<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');
?>

<!DOCTYPE html>
<html>
<head>
  <?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/includes.php'; ?>
  <script src="../public/js/ajaxSubmitLogInForm.js"></script>
</head>
<body>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/nav.php'; ?>

<main class="main container">
  <form onsubmit="return ajaxSubmitLogInForms(this)"
        method="post"
        id="log_in_form"
        class="form-horizontal log-in-form text-center row">
    <div class="center-block">
      <h1>Sign in to Blog</h1>
    </div>

    <div class="errors" id="errors"></div>

    <div class="form-group row col-sm-offset-3">
      <label for="email"
             class="col-sm-1 control-label">
        Email
      </label>
      <div class="col-sm-5">
        <input type="email"
               name="email"
               id="email"
               placeholder="Enter email"
               class="form-control input-lg"
               required>
      </div>
    </div>

    <div class="form-group row">
      <label for="password"
             class="col-sm-1 control-label">
        Password
      </label>
      <div class="col-sm-5">
        <input type="password"
               name="password"
               id="password"
               placeholder="Enter password"
               class="form-control input-lg"
               required>
      </div>
    </div>

    <div class="form-group row">
      <button type="submit"
              class="col-sm-6 btn btn-primary">
        Sign in
      </button>
    </div>

    <p>New to Blog? <a href="registration.php">Create an account.</a></p>
  </form>
</main>
</body>
</html>
