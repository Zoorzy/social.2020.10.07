<?php
require "options/header.opt.php";
?>

<link rel="stylesheet" href="assets/css/form.css">

<style>
  #img-post-upload {
    text-align: right;
    margin: auto;
    display: table;
  }

  img {
    width: 100%;
    height: 100%;
  }
</style>

<main>
  <div id="main-user-post-upload">
    <form id="uploadimgpost" action="includes/uploadpost.inc.php" method="POST" enctype="multipart/form-data">

      <div style="text-align:right; margin:0px auto 0px auto; display:table; ">
        <input type="button" value="Browse..." onclick="document.getElementById('fileToUpload').click();" />
        <input type="file" name="fileToUpload" id="fileToUpload" style="display: none;">
      </div>
      <br>
      <div id="img-post-upload">
        <img id="blah" src="#" alt="your image" />
      </div>
      <br>

      <div>
        <!--<input type="text" name="nome" id="nome" placeholder="nome immagine">
        <input type="text" name="soggetto" placeholder="soggetto">
        <input type="text" name="tags" placeholder="tags (separati da spazio)">
        <input type="text" name="data" id="data" placeholder="data"> //DATA DA OTTIMIZZARE-->
        <textarea name="text" id="text" placeholder="Aggiungi del testo qui..." maxchar="500"></textarea>

        <script>
          //var d = new Date();
          //document.getElementById("data").value = d;
        </script>
        <!--
        <hr>
        <select id="stagioni">
          <option>primavera</option>
          <option>estate</option>
          <option>autunno</option>
          <option>inverno</option>
        </select>
        <br>
        <select id="luogo">
          <option>mare</option>
          <option>montagna</option>
          <option>collina</option>
        </select>
        <hr>
-->
      </div>

      <br>
      <div style='text-align: center;'>
        <input type="submit" value="Upload Image" name="upload">
      </div>
      <br>

      <?php
      echo "<div style='text-align: center;'>";
      include("includes/errormessages.inc.php");
      echo "</div>";
      ?>

    </form>
  </div>
</main>


<script>
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

  $("#fileToUpload").change(function() {
    readURL(this);
  });
</script>

<!-- <script>
  function selLuogo() {
    var sel = document.getElementById('stagioni');
    var opt = sel.options[sel.selectedIndex];
    if (opt.text != "estate") {
      document.getElementById("luogo").style.borderColor = "#ff0000";
      document.getElementById("luogo").disabled = true;
    } else {
      document.getElementById("luogo").disabled = false;
      document.getElementById("luogo").style.borderColor = "transparent";
    }
  }

  $(document).ready(function() {
    $("#stagioni").change(
      function() {
        selLuogo();
      }
    );
  });

  selLuogo();
</script>-->
<?php
require "options/footer.opt.php";
