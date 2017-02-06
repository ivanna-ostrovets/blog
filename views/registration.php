<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/userService.php');
?>

<!DOCTYPE html>
<html>
<head>
  <?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/includes.php'; ?>
</head>
<body>
<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . '/partials/nav.php'; ?>

<script>
  function submitFormAjax() {
    var xmlhttp = window.XMLHttpRequest ?
      new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");

    var name = document.querySelector('#name').value;
    var email = document.querySelector('#email').value;
    var password = document.querySelector('#password').value;
    var confirm_password = document.querySelector('#confirm_password').value;

    xmlhttp.open("POST", "/controllers/register.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("name=" + name + "&email=" + email + "&password=" + password + "&confirm_password=" + confirm_password);

    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        window.location.replace("/index.php");
      }
    };

    return false;
  }
</script>

<main class="main">
  <!--  <form onsubmit="return submitFormAjax()" method="post" id="register_form">-->
  <form action="../controllers/registration.php" method="post" id="register_form">
    <div class="form-group">
      <label>Name</label>
      <input type="text" name="name" id="name" placeholder="Enter name">
    </div>

    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" id="email" placeholder="Enter email">
    </div>

    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" id="password"
             placeholder="Enter password">
    </div>

    <div class="form-group">
      <label>Confirm Password</label>
      <input type="password" name="confirm_password" id="confirm_password"
             placeholder="Confirm password">
    </div>

    <input type="submit" value="Register">
    <a href="../index.php">Cancel</a>
  </form>
</main>

<footer>
</footer>
</body>
</html>
