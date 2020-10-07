<?php
$sql = "SELECT * FROM users ORDER BY user_id DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 1) {

  //stampa 5 utenti diversi dall'utente selezionato e loggato
  for ($i = 0; $i < 5 && $i < mysqli_num_rows($result) -1; $i++) {

    $row = mysqli_fetch_assoc($result);
    $id = $row['user_id'];


    //if (($id != $_SESSION['user_id']) && (isset($_GET['user_id']) && $id != $_GET['user_id'])) {
    if ($id != $_SESSION['user_id']) {

      $sqlImg = "SELECT * FROM profileimg WHERE user_id='$id'";
      $resultImg = mysqli_query($conn, $sqlImg);

      $rowImg = mysqli_fetch_assoc($resultImg);
?>
      <div class='users-container' <?php echo (isset($_GET['user_id']) && $id == $_GET['user_id']) ? 'id="userselected"' : 'onclick="window.location=\'profile.php?user_id=' . $id . '\'"' ?>>
  <?php
      if ($rowImg['status'] == 0) {
        echo "<img src='upload/user" . $id . "/profileimg.jpg?'" . mt_rand() . ">";
      } else {
        echo "<img src='upload/profiledefault.jpg'>";
      }
      echo "<span>" . $row['username'] . "</span><br />";
      echo "<span class='users-container-descr'>" . $row['descrizione'] . "</span>";
      //echo "<p>" . $row['email'] . "</p>";
      echo "</div>";
    } else $i--;
  }
} else {
  echo "There are no users yet";
}
