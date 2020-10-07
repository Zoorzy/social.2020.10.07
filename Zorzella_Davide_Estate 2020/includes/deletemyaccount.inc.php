<?php

if (isset($_POST['deletemyaccount-submit'])) {

  session_start();

  require "DBConnection.inc.php";

  $username = $_SESSION['userUid'];
  $email = $_SESSION['userEmail'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];



  if (empty($email) || empty($password)) {
    header("Location: ../deletemyaccount.php?error=emptyfields");
    exit();
  } else if ($password !== $passwordRepeat) {
    header("Location: ../deletemyaccount.php?error=passwordcheck");
    exit();
  } else {

    $sql = "SELECT * FROM users WHERE username=? AND email=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../deletemyaccount.php?error=sqlerror1");
      exit();
    } else {

      mysqli_stmt_bind_param($stmt, "ss", $username, $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if ($row = mysqli_fetch_assoc($result)) {
        $pwdCheck = password_verify($password, $row['password']);
        if ($pwdCheck == true) {


          if ($conn->connect_errno) {
            echo "Failed to connect to MySQL: " . $conn->connect_error;
            exit();
          }

          $sql = "DELETE FROM profileimg WHERE user_id = '" . $_SESSION['user_id'] . "';";
          /*if (!mysqli_query($conn, $sql)) {
            header("Location: ../deletemyaccount.php?error=sqlerror3");
            exit();
          }*/

          $sql .= "DELETE FROM posts WHERE user_id = '" . $_SESSION['user_id'] . "';";
          /*if (!mysqli_query($conn, $sql)) {
            header("Location: ../deletemyaccount.php?error=sqlerror3");
            exit();
          }*/

          $sql  .= "DELETE FROM users WHERE username = '$username' AND email = '$email'; ";
          /*if (!$conn->query($sql)) {
            header("Location: ../deletemyaccount.php?error=sqlerror4");
            exit();
          }*/


          // Execute multi query
          if ($conn->multi_query($sql)) {
            do {
              // Store first result set
              if ($result = $conn->store_result()) {
                while ($row = $result->fetch_row()) {
                  printf("%s\n", $row[0]);
                }
                $result->free_result();
              }
              // if there are more result-sets, the print a divider
              if ($conn->more_results()) {
                printf("-------------\n");
              }
              //Prepare next result set
            } while ($conn->next_result());
          } else {
            header("Location: ../deletemyaccount.php?error=sqlErrorWithMultipleQuery");
            exit();
          }

          //Delete images
          $dirPath = "../upload/user" . $row['user_id'];
          array_map('unlink', glob("$dirPath/*.*"));
          rmdir($dirPath);

          header("Location: logout.inc.php");
          exit();
        } else {
          header("Location: ../deletemyaccount.php?error=wrongpwd");
          exit();
        }
      } else {
        //non dovrebbe mai uscire un messaggio del genere, essendo il nome preso direttamente dalla sessione in corso
        header("Location: ../deletemyaccount.php?error=nouser");
        exit();
      }
    }
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
} else {
  header("Location: ../index.php");
  exit();
}
