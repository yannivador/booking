<?php
	require("../model/Db.php");
	require("../model/Hotel.php");
	require("../model/Personne.php");
	require("../model/Chambre.php");
	require("../model/Booking.php");
	require("../model/DbManager.php");

	$conn =  new Db();
	$dbh = $conn->connection();
	$Dbm = new DbManager($dbh);
	$hotels = $Dbm->readHotel();
	$Dbm->cham_reserv();

    if (isset($_POST['validation'])) {
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';

		// ------- attribution id_chamb -------

		// Attribution d'une chambre
		// $numero_chambre = $Dbm->attributChambre($_POST['hotel']);
		$numero_chambre = $Dbm->attributChambre($_POST['hotel'], $_POST['debut'], $_POST['fin']);
		// Vérification si l'hotel est complet
		if ($numero_chambre == false) {
			print("L'hotel est complet");
			exit();
		}

		// ------- attribution id_pers -------
		// Structure du tableau pour création d'objet
		$tab2 = [
			'index' => '', 
			'name' => $_POST['nom'], 
			'email' => $_POST['email']
		];

		$personne = new Personne($tab2); // Création objet personne

		// Insertion dans BDD
		// La fonction renvoi l'id de la derniere insertion pour insertion dans la table booking
		$lastIdPers = $Dbm->insertPersonne($personne->getName(), $personne->getEmail());

		// ------- Création Booking  -------

		//Structure du tableau pour création d'objet
		$tab_booking = [
			'index' => '', 
			'debut' => $_POST['debut'], 
			'fin' => $_POST['fin'],
			'date' => $_POST['date'],
			'id_pers' => $lastIdPers,
			'id_cham' => $Dbm->idBynum_chamAndid_hotel($numero_chambre, 1),
			'id_hotel' => $_POST['hotel']
		];

		

		// Création objet booking
		$booking_obj = new Booking($tab_booking);
		// Insertion de la réservation dans la table booking
		print($Dbm->insertBooking(
			$booking_obj->getDebut(), 
			$booking_obj->getFin(), 
			$booking_obj->getDate(), 
			$booking_obj->getIdPers(), 
			$booking_obj->getIdCham(),
			$booking_obj->getIdHotel()
		));

    }

    // require('vue/add_booking.php')
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Réservation</title>
		<link rel="stylesheet" type="text/css" href="../styles.css">
	</head>

	<body>
		<div id="wrapper">
			<h1 class="centre">Pré-réservation</h1>
			<?php require("../vue/nav.php"); ?>
			<p class="slogan">Réserver une chambre en quelques clics </p>
			<form action="add_booking.php" method="POST" name="form" class="formu">
				<fieldset>
					<p class="clearfix">
						<label for="debut" class="fl-l w25 left">Date de début :</label>  
						<input type="date" name="debut" class="fl-l w50">
					</p>
                    <p class="clearfix">
						<label for="fin" class="fl-l w25 left">Date de fin :</label>  
						<input type="date" name="fin" class="fl-l w50">
					</p>
                    <p class="clearfix">
						<label for="hotel" class="fl-l w25">Hotel : </label>
						<?php if (!empty($hotels)) : ?>
						<select name="hotel" class="fl-l w25">
							<?php foreach($hotels as $hotel) : ?>
								<option value="<?php echo $hotel['id'] ?>"><?php echo $hotel['name'] ?></option>
							<?php endforeach ?>
						</select>
						<?php else : ?>
							<li class="nodata">Aucun hotel enregistré dans la BDD pour le moment
									
							</li>
						<?php endif ?>
					</p>

                    <p class="clearfix">
						<label for="nom" class="fl-l w25 left">Votre Nom :</label>  
						<input type="text" name="nom" placeholder="votre nom" autocomplete="on" class="fl-l w50">
					</p>
					
					<p class="clearfix">
						<label for="email" class="fl-l w25">Votre e-mail</label>
						<input type="email" name="email" placeholder="votre Email" autocomplete="on" class="fl-l w50">
					</p>

					<input type="hidden" id="date" name="date" value="14/06/2022" />
					
					<p class="centre" id="envoyer">
						<input class="bt" type="submit" name="validation" value="Rechercher">
					</p>
				</fieldset>
			</form>
			<div>
				<ul>
				<?php foreach($hotels as $hotel) : ?>
					<li><?php echo $hotel['name'] . ' - Nombre de chambre : ' . $Dbm->readNbHotel($hotel['id']) ?> </li>
				<?php endforeach ?>
				</ul>
			</div>
			<?php 
				print("<h2>Liste des réservations</h2>");
				$reservations = $Dbm->readBooking();
			?>
			<?php if (!empty($reservations)) : ?>
				<table border="1">
					<tr>
						<th>Numéro de réservation</th>
						<th>Debut</th>
						<th>Fin</th>
						<th>Date</th>
						<th>Personne</th>
						<th>Chambre</th>
						<th>Hotel</th>
					</tr>
					<?php foreach($reservations as $reservation) : ?>
						<tr>
							<td><?php echo $reservation['id'] ?></td>
							<td><?php echo $reservation['debut'] ?></td>
							<td><?php echo $reservation['fin'] ?></td>
							<td><?php echo $reservation['date'] ?></td>
							<td><?php echo $Dbm->nameByid($reservation['pers']) ?></td>
							<td><?php echo $Dbm->num_chamByid($reservation['numero_cham']) ?></td>
							<td><?php echo $Dbm->hotelByid($reservation['id_hotel']) ?></td>
						</tr>
					
					<?php endforeach ?>
				</table>
			<?php else : ?>
				<li class="nodata">Aucune réservation pour le moment
						
				</li>
			<?php endif ?>
			
		</div>
	</body>
</html>