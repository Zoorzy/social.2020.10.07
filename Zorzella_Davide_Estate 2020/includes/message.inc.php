<?php
session_start();
if (isset($_GET['message'])) {
?>
  <style>
    div {
      width: 50%;
      text-align: center;
      margin: auto;
      background-color: rgba(255, 80, 0, 0.6);
      color: #fff;
      font-size: 25px;
      padding: 20px;
    }
  </style>
  <div>
    <?php
    if ($_GET["message"] == "login_needed") {
      echo "Devi essere loggato per continuare sul sito";
      header("refresh:1; url= ../login.php");
      exit();
    }
    if ($_GET["message"] == "logout") {
      echo "A presto !";
      header("refresh:1; url= ../index.php");
      exit();
    }
    if ($_GET["message"] == "login_success") {
      echo "Benvenuto " . $_SESSION['userUid'] . " !";
      header("refresh:1; url= ../profile.php");
      exit();
    }
    ?>
  </div>
<?php
} else {
  header("Location: ../index.php");
  exit();
}
?>

<p>Redirect in 1 secondi...</p>