<?php
session_start();

if ((!isset($_SESSION['user_id'])) && !(in_array(basename($_SERVER['PHP_SELF']), array("index.php", "login.php", "signup.php", "portfolio.php", "whoami.php")))) {
  header("Location: includes/message.inc.php?message=login_needed");
}

?>

<!DOCTYPE HTML>
<!--
	Alpha by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
  <title>Fischiagram</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="assets/css/main.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="is-preload">
  <div id="page-wrapper">

    <!-- Header -->
    <header id="header">
      <h1><a href="index.php">Fischiagram</a></h1>
      <nav id="nav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li>
            <a href="portfolio.php" class="icon solid fa-angle-down">Portfolio</a>
            <ul>
              <?php
              if (isset($_SESSION['user_id'])) {
              ?>
                <li><a href="portfolio.php?user_id=<?php echo $_SESSION['user_id'] ?>">I tuoi scatti personali</a></li>
              <?php
              }
              ?>
              <li><a href="portfolio.php">Tutti gli scatti</a></li>
            </ul>
          </li>
          <li><a href="whoami.php">Chi sono</a></li>
          <?php
          if (!isset($_SESSION['user_id'])) {
          ?>
            <li><a href="signup.php" class="button">Sign Up</a></li>
            <li><a href="login.php" class="button">Log In</a></li>
          <?php
          } else {
          ?>
            <?php
            echo '<li><a href="profile.php?user_id=' . $_SESSION['user_id'] . '">Profilo</a></li>';
            ?>
            <li><a href="includes/logout.inc.php" class="button">Log Out <?php echo $_SESSION['userUid'] ?> </a></li>
          <?php
          }
          ?>
        </ul>
      </nav>
    </header>