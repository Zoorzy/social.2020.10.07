<?php
session_start();

if (isset($_POST['update-submit'])) {

  require "DBConnection.inc.php";

  $newusername = $_POST['uid'];
  $newemail = $_POST['mail'];
  $descrizione = $_POST['descrizione'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];

  $currentusername = $_SESSION['userUid'];
  $currentemail = $_SESSION['userEmail'];


  if (empty($newusername) || empty($newemail)) {
    header("Location: ../updatemyaccount.php?error=emptyfields&uid=$newusername&mail=$newemail");
    exit();
  } else if (!filter_var($newemail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $newusername)) {
    header("Location: ../updatemyaccount.php?error=invalidmailuid");
    exit();
  } else if (!filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../updatemyaccount.php?error=invalidmail&uid=$newusername");
    exit();
  } else if (!preg_match("/^[a-zA-Z0-9]*$/", $newusername)) {
    header("Location: ../updatemyaccount.php?error=invaliduid&mail=$newemail");
    exit();
  } else if ($password !== $passwordRepeat) {
    header("Location: ../updatemyaccount.php?error=passwordcheck&uid=$newusername&mail=$newemail");
    exit();
  } else if (strlen($descrizione) > 100) {
    header("Location: ../updatemyaccount.php?error=descrizionetoolong&uid=$newusername&mail=$newemail");
    exit();
  } else {

    //username already exists check
    $sql = "SELECT username FROM users WHERE username=? AND user_id<>'" . $_SESSION['user_id'] . "'";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../updatemyaccount.php?error=sqlerror1");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $newusername);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        header("Location: ../updatemyaccount.php?error=usertaken&mail=$newemail");
        exit();
      } else {
        //email already exists check
        $sql = "SELECT email FROM users WHERE email=? AND user_id<>'" . $_SESSION['user_id'] . "'";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../updatemyaccount.php?error=sqlerror2");
          exit();
        } else {
          mysqli_stmt_bind_param($stmt, "s", $newemail);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $resultCheck = mysqli_stmt_num_rows($stmt);
          if ($resultCheck > 0) {
            header("Location: ../updatemyaccount.php?error=emailtaken&uid=$newusername");
            exit();
          } else {

            function update($stmt, $sql, $param)
            {
              mysqli_stmt_prepare($stmt, $sql)  or die($stmt->error);

              mysqli_stmt_bind_param($stmt, "s", $param);
              mysqli_stmt_execute($stmt);
            }

            $stmt = mysqli_stmt_init($conn);

            if ($newusername != $currentusername) {
              $sql = "UPDATE users SET username = (?) WHERE user_id='" . $_SESSION['user_id'] . "'";
              update($stmt, $sql, $newusername);
            }
            if ($newemail != $currentemail) {
              $sql = "UPDATE users SET email = (?) WHERE user_id='" . $_SESSION['user_id'] . "'";
              update($stmt, $sql, $newemail);
            }
            if (!empty($password)) {
              $hashedpwd = password_hash($password, PASSWORD_DEFAULT);
              $sql = "UPDATE users SET password = (?) WHERE user_id='" . $_SESSION['user_id'] . "'";
              update($stmt, $sql, $hashedpwd);
            }
            $sql = "UPDATE users SET descrizione = (?) WHERE user_id='" . $_SESSION['user_id'] . "'";
            update($stmt, $sql, $descrizione);
          }
        }
      }
    }
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);

  $_SESSION['userUid'] = $newusername;
  $_SESSION['userEmail'] = $newemail;
  $_SESSION['descrizione'] = $descrizione;
  
  header("Location: ../profile.php?error=noerror");
  //header("Location: ../includes/logout.inc.php");
} else {
  header("Location: ../signup.php");
  exit();
}
