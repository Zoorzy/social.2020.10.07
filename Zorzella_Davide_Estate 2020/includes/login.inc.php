<?php

if (isset($_POST['login-submit'])) {

  require "DBConnection.inc.php";

  $email = $_POST['mailuid'];
  $password = $_POST['pwd'];

  if (empty($email) || empty($password)) {
    header("Location: ../login.php?error=emptyfields");
    exit();
  } else {
    $sql = "SELECT * FROM users WHERE username=? OR email=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../login.php?error=sqlerror");
      exit();
    } else {

      mysqli_stmt_bind_param($stmt, "ss", $email, $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if ($row = mysqli_fetch_assoc($result)) {
        $pwdCheck = password_verify($password, $row['password']);
        if ($pwdCheck == false) {
          header("Location: ../login.php?error=wrongpwd");
          exit();
        } else if ($pwdCheck == true) {
          //LOGIN CON SUCCESSO
          session_start();
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['userUid'] = $row['username'];
          $_SESSION['userEmail'] = $row['email'];
          $_SESSION['descrizione'] = $row['descrizione'];

          header("Location: message.inc.php?message=login_success");
          exit();
        } else {
          header("Location: ../login.php?error=wrongpwd");
          exit();
        }
      } else {
        header("Location: ../login.php?error=nouser");
        exit();
      }
    }
  }
} else {
  header("Location: ../index.php");
  exit();
}
