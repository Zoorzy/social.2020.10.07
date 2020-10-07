<?php
require "options/header.opt.php";
?>
<link rel="stylesheet" href="assets/css/form.css">
<main>
  <form action="includes/login.inc.php" method="post">
    <input type="text" name="mailuid" placeholder="Username/E-Mail...">
    <input type="password" name="pwd" placeholder="Password">
    <button type="submit" name="login-submit" class="button">Login</button>
  </form>

  <a href="signup.php">Sign Up for free</a>
</main>


<?php
if (isset($_GET['error'])) {
  echo "<br>Error= " . $_GET['error'] . "<br>";
} else if (isset($_GET['login'])) {
  echo "<br>Log In= " . $_GET['login'] . "<br>";
}
?>
<?php
require "options/footer.opt.php";
?>