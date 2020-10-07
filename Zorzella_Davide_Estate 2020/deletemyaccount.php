<?php
require "options/header.opt.php";

require "includes/DBConnection.inc.php";
?>

<link rel="stylesheet" href="assets/css/form.css">
<main>
  <form action="includes/deletemyaccount.inc.php" method="post">
    <h2>Delete My Account</h2>
    <?php
    echo "<h3>" . $_SESSION['userUid'] . "</h3>";
    echo $_SESSION['userEmail'];
    ?>
    <input type="password" name="pwd" placeholder="password">
    <input type="password" name="pwd-repeat" placeholder="conferma password">
    <input type="submit" name="deletemyaccount-submit" value="Elimina Account">
    <?php
    if (isset($_GET['error'])) {
      echo "<br>Error= " . $_GET['error'] . "<br>";
    } ?>
  </form>
</main>

<?php
require "options/footer.opt.php";
?>