<?php 
    require("../model/Db.php");
    require("../model/Hotel.php");
    require("../model/Personne.php");
    require("../model/Chambre.php");
    require("../model/Booking.php");
    require("../model/DbManager.php");
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Liste des hotels</title>
		<link rel="stylesheet" type="text/css" href="../styles.css">
	</head>

	<body>
		<div id="wrapper">
			<h1 class="centre">Liste des hotels</h1>
			<?php require("../vue/nav.php"); ?>
			<?php 
                $conn =  new Db();
                $dbh = $conn->connection();
                $DbM =  new DbManager($dbh);
                $hotels = $DbM->readHotel();
            ?>
			<?php if (!empty($hotels)) : ?>
				<?php foreach($hotels as $hotel) : ?>
					<li>
						<?php echo $hotel['id'] ?>
						<?php echo $hotel['name'] ?>
						<?php echo $hotel['address'] ?>
					</li>
				<?php endforeach ?>
			<?php else : ?>
				<li class="nodata">Aucun hotel enregistré dans la BDD pour le moment
						
				</li>
			<?php endif ?>
		</div>
	</body>
</html>