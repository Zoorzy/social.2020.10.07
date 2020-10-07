<?php
if (isset($_GET['error'])) {
  if ($_GET['error'] == "filenotimage") {
    $log = "Il file non è un formato immagine valido";
  } else if ($_GET['error'] == "fileexists") {
    $log = "Un file chiamato così esiste già. Rinominarlo e ricaricatelo";
  } else if ($_GET['error'] == "filetoolarge") {
    $log = "Il file caricato è troppo pesante";
  } else if ($_GET['error'] == "fileformaterror") {
    $log = "Ci spiace, solo i file JPG sono consentiti";
  } else if ($_GET['error'] == "filenotuploaded") {
    $log = "Ci spiace, per qualche motivo il file non è stato caricato correttamente";
  } else if ($_GET['error'] == "nofilefound") {
    $log = "Non abbiamo trovato il file caricato. riprova";
  } else if ($_GET['error'] == "noerror") {
    $log = "operazione completata con successo";
  } else {
    $log = "errore generico";
  }

  echo "<div style='text-align: center;'>";
  echo $log;
  echo "</div>";
}
?>
<script>
  //Stackoverflow è bellissimo
  function removeParam(parameter) {
    var url = document.location.href;
    var urlparts = url.split('?');

    if (urlparts.length >= 2) {
      var urlBase = urlparts.shift();
      var queryString = urlparts.join("?");

      var prefix = encodeURIComponent(parameter) + '=';
      var pars = queryString.split(/[&;]/g);
      for (var i = pars.length; i-- > 0;)
        if (pars[i].lastIndexOf(prefix, 0) !== -1)
          pars.splice(i, 1);
      url = urlBase + '?' + pars.join('&');
      window.history.pushState('', document.title, url); // added this line to push the new url directly to url bar .

    }
    return url;
  }
  //If page get reloaded ...
  if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
    window.location = removeParam("error");
  }
</script>