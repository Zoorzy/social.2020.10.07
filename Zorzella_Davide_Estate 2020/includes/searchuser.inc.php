<?php

require "DBConnection.inc.php";

if (isset($_POST['user']) && $_POST['user'] != "") {
  $user = $_POST['user'];

  $sql = "SELECT * FROM users WHERE username LIKE '%" . $user . "%'";

  if ($result = $conn->query($sql)) {
    echo "<div id='ul'>";
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<div class='li'>";
        echo "<a href='portfolio.php?user_id=" . $row['user_id'] . "'>" . $row['username'] . "; " . $row['email'] . "</a>";
        echo "</div>";
      }
    } else {
      echo "<div class='li'>No users found</div>";
    }
    echo "</div>";
  }
}
