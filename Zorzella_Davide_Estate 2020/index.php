<?php
require "options/header.opt.php";
?>

<!-- Banner -->
<section id="banner">
	<script>
		var i = 0;

		//Immagini di sfondo, gestito in modo dinamico
		var images = [
			"images/bgindex1.jpg",
			"images/bgindex2.jpg",
			"images/bgindex3.jpg",
			"images/bgindex4.jpg"
		];

		function changeImg() {
			$('.dot').removeClass('grigio');

			if (!isNaN(arguments[0])) {
				i = arguments[0];
				clearInterval(refreshID);
				refreshID = setInterval(function() {
					changeImg();
				}, 3000);
			}
			banner.style.backgroundImage = "url(" + images[i] + ")";

			$('.dot').eq(i).addClass('grigio');

			i++;
			if (i >= images.length) {
				i = 0;
			}
		}

		var banner = document.querySelector('#banner');
		banner.style.backgroundAttachment = "fixed";
		banner.style.backgroundPosition = "center center";
		banner.style.backgroundRepeat = "no-repeat";
		banner.style.backgroundSize = "cover";

		changeImg();
		var refreshID = setInterval(function() {
			changeImg();
		}, 3000);
		window.onload(refreshId);
	</script>
	<?php
	if (!isset($_SESSION['user_id'])) {
	?>
		<h2>Fischiagram</h2>
		<p>Zoorzy_</p>
		<ul class="actions special">
			<li><a href="signup.php" class="button primary">Sign Up</a></li>
			<li><a href="login.php" class="button primary">Log In</a></li>
		</ul>
	<?php
	} else {
	?>
		<h2><?php echo $_SESSION['userUid'] ?></h2>
		<p><?php echo ($_SESSION['descrizione'] != "") ?  $_SESSION['descrizione'] : "<a href='includes/updatemyaccount.inc.php'>Aggiungi una descrizione al tuo profilo</a> per vederla visualizzata qui" ?></p>
		<ul class="actions special">
			<li><a href="profile.php" class="button primary">Profilo</a></li>
			<li><a href="portfolio.php?user_id=<?php echo $_SESSION['user_id'] ?>" class="button primary">I tuoi scatti</a></li>
		</ul>
	<?php
	}
	?>
</section>

<div class="pulsanti" id="imagesdots" style="text-align: center"></div>
<script>
	var imagesdots = document.getElementById("imagesdots");
	for (var j = 0; j < images.length; j++) {
		imagesdots.appendChild(document.createElement("span"));
	}
	$('.pulsanti>span').addClass('dot');
	$('.pulsanti>span:first').addClass('grigio');


	$(document).ready(function() {
		var current_img = 0;
		for (var j = 0; j < images.length; j++) {
			$('.pulsanti>span').eq(j).data('num', j);
		}

		//cambio immagine in base alla pressione dei bottoni grigi sottostanti le immagini
		$('.dot').click(function() {

			//cliccando su un bottone sotto le foto aggiorna la current_img e il bottone colorato di conseguenza
			current_img = $(this).data('num');
			changeImg(current_img);
		});
	});
</script>
<style>
	.pulsanti {
		width: 100%;
		height: 10px;
	}

	.dot {
		cursor: pointer;
		height: 10px;
		width: 10px;
		margin: 8px;
		background-color: #ccc;
		border-radius: 50%;
		display: inline-block;
	}

	.grigio {
		background-color: #1c1818;
		opacity: 0.8;
	}
</style>


<!-- Main -->
<section id="main" class="container">

	<section class="box special">
		<header class="major">
			<h2>Fischiagram<br /></h2>
			<p>altrimenti a cosa ti servirebbe avere un telefono :)<br /></p>
		</header>
		<span class="image featured"><img src="images/logo.png" alt="" height="300"/></span>
	</section>

	<section class="box special features">
		<div class="features-row">
			<section>
				<span class="icon solid major fa-bolt accent2"></span>
				<h3>Esperienza</h3>
				<p>Naviga in modo dinamico e personalizzato</p>
			</section>
			<section>
				<span class="icon solid major fa-cloud accent4"></span>
				<h3>Post</h3>
				<p>Pubblica le foto delle tue eperienze</p>
			</section>
		</div>
		<div class="features-row">
			<section>
				<span class="icon solid major fa-chart-area accent3"></span>
				<h3>Statistiche</h3>
				<p>Interagisci con i post dei tuoi amici</p>
			</section>
			<section>
				<span class="icon solid major fa-lock accent5"></span>
				<h3>Sicurezza</h3>
				<p>Di questo ce ne occupiamo noi, non temere. <br /> Con gli ultimi metodi evitiamo costantemente SQL Injection e attacchi alla tua password</p>
			</section>
		</div>
	</section>

	<div style="width: 100%; text-align:center;">
		<h2>Crediti</h2>
	</div>
	<div class="row">

		<div class="col-6 col-12-narrower">

			<section class="box special">
				<span class="image featured"><img src="https://html5up.net/uploads/images/ethereal.jpg" alt="" height="100" /></span>
				<h3>HTML5UP</h3>

				<ul class="actions special">
					<li><a href="https://html5up.net/alpha" target="_blank" class="button alt">Vai al sito</a></li>
				</ul>
			</section>

		</div>
		<div class="col-6 col-12-narrower">

			<section class="box special">
				<span class="image featured"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/02/Stack_Overflow_logo.svg/1200px-Stack_Overflow_logo.svg.png" alt="" height="100" /></span>
				<h3>Stack Overflow</h3>

				<ul class="actions special">
					<li><a href="https://stackoverflow.com" target="_blank" class="button alt">Vai al sito</a></li>
				</ul>
			</section>

		</div>
		<div class="col-6 col-12-narrower">

			<section class="box special">
				<span class="image featured"><img src="https://codewithawa.com/assets/featured_images/ajax_crud.png.2017-10-06.1507315208.png" alt="" height="100" /></span>
				<h3>CODE WITH AWA</h3>

				<ul class="actions special">
					<li><a href="http://codewithawa.com/posts/like-dislike-system-with-php-and--mysql" target="_blank" class="button alt">Vai al sito</a></li>
				</ul>
			</section>

		</div>


	</div>

</section>

<?php
require "options/footer.opt.php";
?>