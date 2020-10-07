<?php
if (isset($_POST['delete_post'])) {

  include_once "DBConnection.inc.php";
  session_start();

  $post_id = $_POST['id'];
  $image_src = $_POST['image_src'];
  $user_id = $_SESSION['user_id'];

  $sql .= "DELETE FROM posts WHERE user_id = '" . $_SESSION['user_id'] . "' AND id='" . $post_id . "';";

  if (!$conn->query($sql)) {
    header("Location: ../post.php?post_id=" . $post_id . "&delete=error");
    exit();
  } else {
    unlink("../" . $image_src);
    header("Location: ../post.php?post_id=" . $post_id . "&delete=success");
    exit();
  }
} else {
  header("Location: ../portfolio.php");
  exit();
}
