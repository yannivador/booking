<?php
    require("model/Db.php");
    require("model/Hotel.php");
    require("model/Personne.php");
    require("model/Chambre.php");
    require("model/Booking.php");
    require("model/DbManager.php");

    $conn =  new Db();
    $dbh = $conn->connection();

?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Accueil : Site Booking</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>

	<body>
		<div id="wrapper">
			<h1 class="centre">Accueil : Site Booking</h1>
			<?php require("vue/nav.php"); ?>
			<p>Site de réservation hotel </p>
		</div>
	</body>
</html>