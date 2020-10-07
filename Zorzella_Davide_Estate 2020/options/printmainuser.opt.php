<?php
if (isset($_GET['user_id'])) $sql = "SELECT * FROM users WHERE user_id='" . $_GET['user_id'] . "'";
else $sql = "SELECT * FROM users WHERE user_id='" . $_SESSION['user_id'] . "'";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {

  $sqlImg = "SELECT * FROM profileimg WHERE user_id='" . $row['user_id'] . "'";
  $resultImg = mysqli_query($conn, $sqlImg);

  while ($rowImg = mysqli_fetch_assoc($resultImg)) {
    echo "<div class='main-user-container not-linked'>";

    if ($rowImg['status'] == 0) {
      echo "<img src='upload/user" . $row['user_id'] . "/profileimg.jpg?'" . mt_rand(0, 255) . ">";
    } else {
      echo "<img src='upload/profiledefault.jpg'>";
    }

    echo "<br>";

    echo "<h2>" . $row['username'] . "</h2>";
    echo "<p>" . $row['descrizione'] . "</p>";
    echo "<p>" . $row['email'] . "</p>";

    echo "<div id='CRUD'>";
    if ($row['user_id'] == $_SESSION['user_id']) {
      //INIZIO MODIFICA ACCOUNT
      //UPLOAD / DELETE IMG PROFILE
      echo "<div class='main-user-container-CRUD'>";
      include("options/uploadimgprofile.opt.php");
      include("options/deleteimgprofile.opt.php");
      echo "</div>";

      //UPLOAD IMG POST
      echo "<div class='main-user-container-CRUD'>";
      include("options/uploadpost.opt.php");
      //include("options/deleteallpost.opt.php");
      echo "</div>";

      //CRUD ACCOUNT (MODIFICA / ELIMINAZIONE)
      echo "<div class='main-user-container-CRUD'>";
      include("options/updatemyaccount.opt.php");
      include("options/deletemyaccount.opt.php");
      echo "</div>";

      //FINE MODIFICA ACCOUNT
    } else {

      echo "<div class='main-user-container-CRUD'>";
      echo "<a class='button' href='portfolio.php?user_id=" . $row['user_id'] . "'>Vai ai post</a>";
      echo "</div>";
      echo "<div class='main-user-container-CRUD'>";
      echo "<a class='button' href='profile.php?user_id=" . $_SESSION['user_id'] . "'>Torna al tuo account</a>";;
      echo "</div>";
    }
    echo "</div>";

    echo "</div>";
?>

    <script>
      //main-user-container-CRUD size dinamica
      var div = document.getElementsByClassName("main-user-container-CRUD");
      var numdiv = div.length;
      window.onload = resize();
      //window.onresize = resize();
      window.onresize = function(event) {
        resize();
      };
      //window.addEventListener('resize', alert("resize"));
      function resize() {
        if ($(window).width() > 800) {
          var width = (String(100 / numdiv) + "%");
          for (var i = 0; i < numdiv; i++) {
            div[i].style.width = width;
          }
        } else {
          var width = (String(100) + "%");
          for (var i = 0; i < numdiv; i++) {
            div[i].style.width = width;
          }
        }
      }
    </script>
<?php
  }
} else {
  echo "<h3>Utente non trovato</h3>";
}
