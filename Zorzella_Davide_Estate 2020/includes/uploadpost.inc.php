<?php
include_once "DBConnection.inc.php";
session_start();

if (isset($_FILES["fileToUpload"]) && isset($_POST["upload"])) {

  //data from the image
  $fileName = $_FILES['fileToUpload']['name'];
  $fileSize = $_FILES['fileToUpload']['size'];
  $fileError = $_FILES['fileToUpload']['error'];
  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));


  //get all the data from the form submitted
  //$image = $_FILES["fileToUpload"]["name"];
  $text = $_POST["text"];

  $allowed = array('jpg');

  if (in_array(strtolower($fileActualExt), $allowed)) {

    //the path to store the uploaded image
    do {
      $fileName = sha1(basename($fileName)) . ".jpg";
    } while (file_exists("../upload/user" . $_SESSION['user_id'] . "/" . $fileName));
    //PER EVITARE LOOP INFINITI, DOVREI
    //FARE LA SHA1 DELLA SHA1, FINCHè NON è LIBERA 
    $target = "../upload/user" . $_SESSION['user_id'] . "/" . $fileName;


    if ($fileError === 0) {

      if ($fileSize < 10000000) {

        //PROBLEMI CON IL RESIZE
        require "imageresize.inc.php";

        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO posts (image, text, user_id) VALUES ('$fileName', '$text', '$user_id')";
        mysqli_query($conn, $sql);

        echo $file_name . " " . $target;
        if (move_uploaded_file($file_name, $target)) {
          header("Location: ../profile.php?error=noerror");
          exit();
        } else {
          header("Location: ../uploadpost.php?error=filenotuploaded");
          exit();
        }
      } else {
        header("Location: ../uploadpost.php?error=filetoolarge");
        exit();
      }
    } else {
      header("Location: ../uploadpost.php?error=filenotuploaded");
      exit();
    }
  } else {
    header("Location: ../uploadpost.php?error=fileformaterror");
    exit();
  }
} else {
  header("Location: ../uploadpost.php?error=nofilefound");
  exit();
}
