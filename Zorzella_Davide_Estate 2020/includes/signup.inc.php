<?php

if (isset($_POST['signup-submit'])) {

  require "DBConnection.inc.php";

  $username = $_POST['uid'];
  $email = $_POST['mail'];
  $descrizione =  $_POST['descrizione'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];


  if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
    header("Location: ../signup.php?error=emptyfields&uid=$username&mail=$email");
    exit();
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../signup.php?error=invalidmailuid");
    exit();
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../signup.php?error=invalidmail&uid=$username");
    exit();
  } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../signup.php?error=invaliduid&mail=$email");
    exit();
  } else if ($password !== $passwordRepeat) {
    header("Location: ../signup.php?error=passwordcheck&uid=$username&mail=$email");
    exit();
  } else if (sizeof($descrizione) > 100) {
    header("Location: ../signup.php?error=descrizionetoolong&uid=$username&mail=$email");
    exit();
  } else {
    $sql = "SELECT username FROM users WHERE username=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../signup.php?error=sqlerror");
      exit();
    } else {
      //username already exists check
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        header("Location: ../signup.php?error=usertaken&mail=$email");
        exit();
      } else {
        $sql = "SELECT email FROM users WHERE email=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../signup.php?error=sqlerror");
          exit();
        } else {
          //email already exists check
          mysqli_stmt_bind_param($stmt, "s", $email);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $resultCheck = mysqli_stmt_num_rows($stmt);
          if ($resultCheck > 0) {
            header("Location: ../signup.php?error=emailtaken&uid=$username");
            exit();
          } else {

            $sql = "INSERT INTO users (username, email, password, descrizione) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              header("Location: ../signup.php?error=sqlerror");
              exit();
            } else {
              $hashedpwd = password_hash($password, PASSWORD_DEFAULT);

              mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedpwd, $descrizione);
              mysqli_stmt_execute($stmt);


              $sql = "SELECT * FROM users WHERE username='$username'";
              $result = mysqli_query($conn, $sql);

              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $user_id = $row['user_id'];
                  $sql = "INSERT INTO profileimg (user_id, status) VALUES  ('$user_id', 1);";
                  mysqli_query($conn, $sql);
                }
              } else {
                echo "you have an error";
              }

              mkdir("../upload/user" . $user_id);

              //LOGIN DIRETTO DOPO REGISTRAZIONE
              session_start();
              $_SESSION['user_id'] = $user_id;
              $_SESSION['userUid'] = $username;
              $_SESSION['userEmail'] = $email;
              $_SESSION['descrizione'] = $descrizione;

              header("Location: ../index.php?login=success&message=login_success");
              exit();

              //header("Location: ../signup.php?signup=success");
              //header("Location: profile.php");
              //header("Location: login.inc.php");
              exit();
            }
          }
        }
      }
    }
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
} else {
  header("Location: ../signup.php");
  exit();
}
