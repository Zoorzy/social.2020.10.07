<?php
session_start();

include_once "DBConnection.inc.php";

$id = $_SESSION['user_id'];

if (isset($_FILES['fileToUpload'])) {

  $fileName = $_FILES['fileToUpload']['name'];
  $fileTmpName = $_FILES['fileToUpload']['tmp_name'];
  $fileSize = $_FILES['fileToUpload']['size'];
  $fileError = $_FILES['fileToUpload']['error'];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('jpg'/*, 'jpeg', 'png'*/);

  if (in_array(strtolower($fileActualExt), $allowed)) {

    if ($fileError === 0) {

      if ($fileSize < 5000000) {

        require "imageresize.inc.php";

        $fileNameNew = "profileimg.". $fileActualExt;

        $dir = "../upload/user" . $id . "/";
        !is_dir($dir)? mkdir($dir):"";
        $fileDestination = $dir . $fileNameNew;
        
        move_uploaded_file($file_name, $fileDestination);

        $sql = "UPDATE profileimg SET status='0' WHERE user_id='$id'";
        mysqli_query($conn, $sql);

        header("Location: ../profile.php?error=noerror");
      } else {
        header("Location: ../profile.php?error=filetoolarge");
      }
    } else {
      header("Location: ../profile.php?error=filenotuploaded");
    }
  } else {
    header("Location: ../profile.php?error=fileformaterror");
  }
} else {
  header("Location: ../profile.php?error=nofilefound");
}
