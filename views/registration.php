<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');
?>

<!DOCTYPE html>
<html>
<head>
  <?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/includes.php'; ?>
  <script src="../public/js/ajaxSubmitRegisterForm.js"></script>
</head>
<body>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/nav.php'; ?>

<main class="container register">
  <div class="text-center">
    <h1>Join Blog</h1>
  </div>

  <div class="row alert alert-danger text-center hidden"
       role="alert"
       id="errors">
  </div>

  <form onsubmit="return ajaxSubmitRegisterForm(this)"
        method="post"
        id="register_form"
        class="row well">

    <div class="form-group">
      <label for="name"
             class="control-label">
        Name
      </label>
      <input type="text"
             name="name"
             id="name"
             placeholder="Enter name"
             class="form-control"
             required>
    </div>

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
      <label for="confirm_password"
             class="control-label">
        Confirm Password
      </label>
      <input type="password"
             name="confirm_password"
             id="confirm_password"
             placeholder="Confirm password"
             class="form-control"
             required>
    </div>

    <div class="form-group">
      <button type="submit"
              class="btn btn-primary">
        Create an account
      </button>
    </div>
  </form>
</main>
</body>
</html>
