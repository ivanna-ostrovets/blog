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

<main class="main">
  <div class="errors"
       id="errors">
  </div>

  <form onsubmit="return ajaxSubmitRegisterForm(this)"
        method="post"
        id="register_form">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text"
             name="name"
             id="name"
             placeholder="Enter name"
             required>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email"
             name="email"
             id="email"
             placeholder="Enter email"
             required>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password"
             name="password"
             id="password"
             placeholder="Enter password"
             required>
    </div>

    <div class="form-group">
      <label for="confirm_password">Confirm Password</label>
      <input type="password"
             name="confirm_password"
             id="confirm_password"
             placeholder="Confirm password"
             required>
    </div>

    <button type="submit">Submit</button>
  </form>
</main>
</body>
</html>
