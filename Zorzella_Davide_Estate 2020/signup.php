<?php
require "options/header.opt.php";
?>
<link rel="stylesheet" href="assets/css/form.css">
<main>
  <form action="includes/signup.inc.php" method="post">
    <input type="text" name="uid" placeholder="username" value="<?php if (isset($_GET['uid'])) echo $_GET['uid']; ?>">
    <input type="text" name="mail" placeholder="email" value="<?php if (isset($_GET['mail'])) echo $_GET['mail']; ?>">
    <script>
      function aggiornacharmax() {
        var descrizione = document.getElementById("descrizione").value;
        if (descrizione.length <= 100) {
          document.getElementById("maxChar").innerHTML = (100 - descrizione.length);
        }
      }
    </script>
    <input type="text" name="descrizione" id="descrizione" placeholder="descizione (facoltativa, max 100 char)" maxlength="100" onkeyup="aggiornacharmax()">
    Caratteri disponibili: <span id="maxChar"><script>aggiornacharmax()</script></span>

    <input type="password" name="pwd" placeholder="password">
    <input type="password" name="pwd-repeat" placeholder="Conferma password">
    <button type="submit" name="signup-submit" class="button">Sign Up</button>
  </form>

  <span>Already have an account? </span><a href="login.php">Log In</a> <span> now</span>
</main>


<?php
if (isset($_GET['error'])) {
  echo "<br>Error= " . $_GET['error'] . "<br>";
} else if (isset($_GET['signup'])) {
  echo "<br>Sign Up= " . $_GET['signup'] . "<br>";
}
?>

<?php
require "options/footer.opt.php";
