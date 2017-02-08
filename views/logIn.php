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

<main class="main">
  <div class="errors" id="errors"></div>

  <form onsubmit="return ajaxSubmitLogInForms(this)"
        method="post"
        id="log_in_form">
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

    <button type="submit">Submit</button>
  </form>

  <p>New to Blog? <a href="registration.php">Create an account.</a></p>
</main>
</body>
</html>
