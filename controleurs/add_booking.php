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
	$hotels = $Dbm->readHotels();

    if (isset($_POST['validation'])) {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';

		// Vérifications des dates
		if ($_POST['debut'] >= $_POST['fin']) {
			header("Location: add_booking.php?msg=Veuillez choisir un intervalle de date valide");
		}
		else {
			// ------- 1. Attribution d'une chambre -------

			$numero_chambre = $Dbm->attributChambre($_POST['hotel'], $_POST['debut'], $_POST['fin']);
			// Vérification si l'hotel est complet
			if ($numero_chambre == false) {
				header("Location: add_booking.php?msg=L'hotel est complet");
				exit();
			}

			// ------- 2. Ajout d'une personne dans la base -------
			// Structure du tableau pour création de l'objet "Personne"
			$tab2 = [
				'index' => '', 
				'name' => $_POST['nom'], 
				'email' => $_POST['email']
			];

			$personne = new Personne($tab2); // Création objet personne

			// Insertion dans BDD
			$lastIdPers = $Dbm->insertPersonne($personne->getName(), $personne->getEmail());

			// ------- 3. Création Booking  -------

			//Structure du tableau pour création de l'objet booking
			$tab_booking = [
				'index' => '', 
				'debut' => $_POST['debut'], 
				'fin' => $_POST['fin'],
				'date' => $_POST['date'],
				'id_pers' => $lastIdPers,
				'id_cham' => $Dbm->readIdBynum_chamAndid_hotel($numero_chambre, 1), 
				'id_hotel' => $_POST['hotel']
			];

			// Création objet booking
			$booking_obj = new Booking($tab_booking);
		

			// Insertion de la réservation dans la table booking
			$msg = $Dbm->insertBooking(
				$booking_obj->getDebut(), 
				$booking_obj->getFin(), 
				$booking_obj->getDate(), 
				$booking_obj->getIdPers(), 
				$booking_obj->getIdCham(),
				$booking_obj->getIdHotel()
			);

			if ($msg == 1) {
				header("Location: add_booking.php?msg=Votre réservation est confirmé !");
			}
			else {
				header("Location: add_booking.php?msg=erreur lors de la réservation..");
			}
		}
    }

    require('../vue/add_booking.php');
