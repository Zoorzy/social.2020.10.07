<?php
require "options/header.opt.php";

require "includes/DBConnection.inc.php";

$sql = "SELECT * FROM users WHERE user_id='" . $_SESSION['user_id'] . "'";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
?>
  <link rel="stylesheet" href="assets/css/form.css">
  <main>
    <form action="includes/updatemyaccount.inc.php" method="post">
      <input type="text" name="uid" placeholder="username" value="<?php echo (isset($_GET['uid'])) ? $_GET['uid'] : $row['username'] ?>">
      <input type="text" name="mail" placeholder="email" value="<?php echo (isset($_GET['mail'])) ? $_GET['mail'] : $row['email'] ?>">
      <script>
        function aggiornacharmax() {
          var descrizione = document.getElementById("descrizione").value;
          if (descrizione.length <= 100) {
            document.getElementById("maxChar").innerHTML = (100 - descrizione.length);
          }
        }
      </script>
      <input type="text" name="descrizione" id="descrizione" placeholder="descizione (facoltativa, max 100 char)" maxlength="100" onkeyup="aggiornacharmax()" value="<?php if (isset($row['descrizione'])) echo $row['descrizione'] ?>">
      Caratteri disponibili:
      <span id="maxChar">
        <script>
          aggiornacharmax()
        </script>
      </span>
      <input type="password" name="pwd" placeholder="nuova password">
      <input type="password" name="pwd-repeat" placeholder="Conferma nuova password">
      <button type="submit" name="update-submit" class="button">Update</button>
    </form>
  </main>


  <?php
  if (isset($_GET['error'])) {
    echo "<br>Error= " . $_GET['error'] . "<br>";
  }
  ?>

<?php
}
require "options/footer.opt.php";
