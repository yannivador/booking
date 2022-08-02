<?php
require("../model/Db.php");
require("../model/Hotel.php");
require("../model/Personne.php");
require("../model/Chambre.php");
require("../model/Booking.php");
require("../model/DbManager.php");

$conn =  new Db();
$dbh = $conn->connection();
$DbM =  new DbManager($dbh);
$hotels = $DbM->readHotels();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<title>Liste des hotels</title>
	<link rel="stylesheet" type="text/css" href="../styles.css">
</head>

<body>
	<header class="main-header">
		<div class="main-header-container">
			<h1 class="centre">Liste des hotels</h1>
			<?php require("../vue/nav.php"); ?>
			<p class="slogan">Nos hotels </p>
		</div>
	</header>
	<div id="wrapper">
		<?php
		
		?>
		<?php if (!empty($hotels)) : ?>
			<ul class="hotel-container">
			<?php $id = 1 ?>
			<?php foreach ($hotels as $hotel) : ?>
				<li class="hotel">
					<?php echo '<img  src="http://localhost/booking/img/hotel' . $id . '.png" alt="hotel" >' ?>
					<div>
						<?php echo '<p>Numero : ' . $hotel['id'] . '</p>'?>
						<?php echo '<p>Nom : ' . $hotel['name'] . '</p>' ?>
						<?php echo '<p>Adresse : ' .$hotel['address'] . '</p>' ?>
					</div>
				</li>
				<?php $id++; ?>
			<?php endforeach ?>
			</ul>
		<?php else : ?>
			<li class="nodata">Aucun hotel enregistré dans la BDD pour le moment

			</li>
		<?php endif ?>
	</div>
	<?php require("../vue/footer.php") ?>
</body>

</html>