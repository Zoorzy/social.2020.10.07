<?php
require "options/header.opt.php";
require "includes/DBConnection.inc.php";

if (!isset($_GET['user_id'])) {
?>
  <script>
    function addOrUpdateUrlParam(name, value) {
      var href = window.location.href;
      var regex = new RegExp("[&\\?]" + name + "=");
      if (regex.test(href)) {
        regex = new RegExp("([&\\?])" + name + "=\\d+");
        window.location.href = href.replace(regex, "$1" + name + "=" + value);
      } else {
        if (href.slice(-1) == "?")
          window.location.href = href + name + "=" + value;
        else if (href.indexOf("?") > -1)
          window.location.href = href + "&" + name + "=" + value;
        else
          window.location.href = href + "?" + name + "=" + value;
      }
    }
    addOrUpdateUrlParam('user_id', <?php echo $_SESSION['user_id'] ?>);
  </script>
<?php
}
include("includes/errormessages.inc.php");
?>
<div class="row">

  <div class="column middle">

    <?php
    // stampo l'utente selezionato
    include "options/printmainuser.opt.php";
    ?>

  </div>

  <div class="column side">

    <?php
    //stampa tutti gli utenti
    include "options/printotherusers.opt.php";
    ?>

  </div>

</div>
<link rel="stylesheet" href="assets/css/profile.php.css">
<?php
require "options/footer.opt.php";
