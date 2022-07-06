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

    require('../vue/add_booking.php')
?>
