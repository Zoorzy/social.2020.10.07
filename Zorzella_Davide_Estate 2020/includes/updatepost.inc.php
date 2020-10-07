<?php
if (isset($_POST['update_post'])) {

  include_once "DBConnection.inc.php";
  session_start();

  $text = $_POST["text"];
  $user_id = $_SESSION['user_id'];

  $sql = "UPDATE posts SET text=? WHERE id='" . $_POST['id'] . "' AND user_id='" . $_SESSION['user_id'] . "'";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../post.php?post_id=" . $_POST['id'] . "&update=error");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $_POST['text']);
    if (mysqli_stmt_execute($stmt)) {
      header("Location: ../post.php?post_id=" . $_POST['id'] . "&update=success");
      exit();
    } else {
      header("Location: ../post.php?post_id=" . $_POST['id'] . "&update=error");
      exit();
    }
  }
} else {
  header("Location: ../portfolio.php");
  exit();
}
