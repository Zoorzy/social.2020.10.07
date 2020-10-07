<?php
session_start();

if (isset($_POST['submit']) && isset($_SESSION['user_id'])) {

  include_once "DBConnection.inc.php";

  $id = $_SESSION['user_id'];

  $fileName = "profileimg.jpg";

  $fileDestination = '../upload/user' . $id . '/' . $fileName;

  unlink($fileDestination);

  $sql = "UPDATE profileimg SET status='1' WHERE user_id='$id'";
  mysqli_query($conn, $sql);

  header("Location: ../profile.php?error=noerror");
} else {
  header("Location: ../index.php");
}
