<?php

require "DBConnection.inc.php";
session_start();

$postNewCount = $_POST['postNewCount'];

$sql = "SELECT * FROM posts";
if (isset($_POST['user_id'])) {
  $sql .= " WHERE user_id='" . $_POST['user_id'] . "'";
}
$sql .= " ORDER BY id DESC LIMIT $postNewCount";

if ($result = $conn->query($sql)) {

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $image = $row['image'];
      $user_id = $row['user_id'];
      $image_src = "upload/user" . $user_id . "/" . $image;
?>
      <div class="responsive">
        <div class="gallery">

          <img src="<?php echo $image_src ?>" data-post_id="<?php echo $row['id'] ?>" alt="<?php echo $row['text']; ?>" width="600" height="400">

          <div class="text">
            <p>
              <?php if (isset($row['text']) && $row['text'] != "") {
                echo $row['text'];
              } ?>
            </p>
          </div>

        </div>
      </div>

    <?php } ?>

    <script src="assets/js/textlength.js"></script>
    <script src="assets/js/zoomphotogallery.js"></script>

    <div class="clearfix"></div>

    <?php
    echo "<div style='width: 100%; text-align: center;'>";

    if ($result->num_rows < $postNewCount) {
      echo "<p id='stopLoad'>There are no more images</p>";
    } else {
      echo "<h2>...</h2>";
    }

    echo "</div>";
    ?>

<?php  } else {
    echo "<div style='width: 100%; text-align: center;'>";
    echo "<p id='stopLoad'>Image(s) not found</p>";
    echo "</div>";
  }
}
