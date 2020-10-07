<?php
require "includes/DBConnection.inc.php";
require "options/header.opt.php";
?>

<!-- Main -->
<div id="main">

	<?php
	echo "<div style='width: 100%; text-align: center;'>";

	if (isset($_GET['user_id']) && !is_nan($_GET['user_id'])) {

		if (isset($_SESSION['user_id']) && $_GET['user_id'] == $_SESSION['user_id']) {
			echo "<h3><b>I tuoi scatti</b></h3>";
		} else {
			$sql = "SELECT username FROM users WHERE user_id = '" . $_GET['user_id'] . "'";
			$result = mysqli_query($conn, $sql);

			if ($row = mysqli_fetch_assoc($result)) {
				echo "<h3><b>" . $row['username'] . "</b></h3>";
			}
		}
	} else {
		echo "<h3><b>Fischiagram</b></h3>";
	}

	echo "</div>";
	?>

	<style>
		#searchresult #ul .li {
			width: 100%;
			padding: 20px;
			margin: 0;
			background-color: white;
			color: black;
			display: block;
		}

		#searchresult #ul .li a {
			color: inherit;
			color: black;
		}
	</style>

	<!-- SEARCH USER -->
	<div id="search" style="text-align: center;">
		<div id="searchbox">
			<input type="search" id="searchuser" placeholder="Search user" maxlength="20" results>
		</div>

		<div id="searchresult">
			<!-- Here all user results will be displayed -->
		</div>

	</div>

	<div id="photogallery">
		<!-- Here all images will be displayed -->
	</div>

	<!-- The Modal -->
	<div id="fullGallery" class="modal">
		<span class="close">&times;</span>
		<a href="#" id="fullImgLink"><img class="modal-content" id="fullImg"></a>
		<div id="fullText"></div>
	</div>

	<div class="clearfix"></div>

	<link rel="stylesheet" href="assets/css/portfolio.php.css">
	<script src="assets/js/loadnewimages.js"></script>
	<script src="assets/js/searchuser.js"></script>

	<?php
	require "options/footer.opt.php";
