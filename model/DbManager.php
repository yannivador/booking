<?php 
    class DbManager {
        protected $_db;

        public function __construct($db) {
            $this->setDb($db);
        }

        public function setDb(PDO $dbh) {
            $this->_db = $dbh;
        }

        public function afficheTableau($tab) {
            echo '<pre>';
            print_r($tab);
            echo '</pre>';
        }

        // CRUD
        public function readHotel() {
            $stmt = $this->_db->prepare('SELECT * FROM hotel'); // requete
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // echo '<pre>';
                // print_r($row);
                // echo '</pre>';
                $hotel[$row['id']]['id'] = $row['id'];
                $hotel[$row['id']]['name'] = $row['name']; 
                $hotel[$row['id']]['address'] = $row['address']; 
            }
            return $hotel;
        }

        public function readNbHotel($id_hotel) {
            $stmt = $this->_db->prepare('SELECT COUNT(*) AS nb_cham FROM `chambre` WHERE id_hotel = :id_hotel;'); // requete
            $stmt->bindParam('id_hotel', $id_hotel);
            $stmt->execute();
            $nb_cham = $stmt->fetch(PDO::FETCH_ASSOC);
            $errors = $stmt->errorInfo();
            if ($errors[0] != '00000') {
                return $stmt->errorInfo();
            }
            else {
                return $nb_cham['nb_cham'];
            }
        }

        public function readChambreByHotel($id_hotel) {
            $stmt = $this->_db->prepare('SELECT * FROM chambre WHERE id_hotel = :id_hotel');
            $stmt->bindParam('id_hotel', $id_hotel);
            $stmt->execute();
            $errors = $stmt->errorInfo();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $chambres[$row['id']] = $row['numero'];
            }
            if ($errors[0] != '00000') {
                return $stmt->errorInfo();
            }
            else {
                return $chambres;
            }
        }

        public function readChambresOccupees($debut, $fin, $id_hotel) {
            $stmt = $this->_db->prepare('SELECT id_cham FROM `booking` WHERE debut >= :debut AND fin <= :fin AND id_hotel = :id_hotel;');
            $stmt->bindParam('debut', $debut);
            $stmt->bindParam('fin', $fin);
            $stmt->bindParam('id_hotel', $id_hotel);
            $stmt->execute();
            $errors = $stmt->errorInfo();
            $chambre_occupee = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $chambres_occupees[] = $row['id_cham'];
            }
            if ($errors[0] != '00000') {
                return $stmt->errorInfo();
            }
            else {
                return $chambres_occupees;
            }
        }


        public function readBooking() {
            $stmt = $this->_db->prepare('SELECT * FROM booking'); // requete
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // echo '<pre>';
                // print_r($row);
                // echo '</pre>';
                $booking[$row['id']]['id'] = $row['id'];
                $booking[$row['id']]['debut'] = $row['debut'];
                $booking[$row['id']]['fin'] = $row['fin'];
                $booking[$row['id']]['date'] = $row['date'];
                $booking[$row['id']]['pers'] = $row['id_pers'];
                $booking[$row['id']]['numero_cham'] = $row['id_cham'];
                $booking[$row['id']]['id_hotel'] = $row['id_hotel'];
            }
            // $this->afficheTableau($booking);
            if (isset($booking)) {
                return $booking;
            }
            else {
                false;
            }
        }

        public function insertBooking($debut, $fin, $date, $id_pers, $id_cham, $id_hotel) {
            $requete = "INSERT INTO `booking` (`id`, `debut`, `fin`, `date`, `id_pers`, `id_cham`, `id_hotel`) VALUES (NULL, :debut, :fin, :date, :id_pers, :id_cham, :id_hotel);";
            $stmt = $this->_db->prepare($requete);
            $stmt->bindParam('debut', $debut);
            $stmt->bindParam('fin', $fin);
            $stmt->bindParam('date', $date);
            $stmt->bindParam('id_pers', $id_pers);
            $stmt->bindParam('id_cham', $id_cham);
            $stmt->bindParam('id_hotel', $id_hotel);
            $stmt->execute();

            $errors = $stmt->errorInfo();
            if ($errors[0] != '00000') {
                return $stmt->errorInfo();
            }
            else {
                return "Votre réservation est confirmé.";
            }
        }

        // insertBooking
        // 

        public function insertPersonne($nom, $email) {
            $requete = "INSERT INTO `personne` (`id`, `nom`, `email`) VALUES (NULL, :nom, :email);";
            $stmt = $this->_db->prepare($requete);
            $stmt->bindParam('nom', $nom);
            $stmt->bindParam('email', $email);
            // print($requete);
            $stmt->execute();
            $new_id = $this->_db->lastInsertId();
            $errors = $stmt->errorInfo();
            if ($errors[0] != '00000') {
                return $stmt->errorInfo();
            }
            else {
                return $new_id;
            }
        }


        public function attributChambre($id_hotel, $debut, $fin) {
            $list_cham_hotel = $this->readChambreByHotel($id_hotel); // Liste des chambres dans un hotel
            $id_cham_hotel_occupees = $this->readChambresOccupees($debut, $fin, $id_hotel); // liste des id de chambres d'un hotel
            foreach ($id_cham_hotel_occupees as $id_cham) {
                $list_cham_occupees[] = $this->num_chamByid($id_cham); // conversion id en numéro de chmabre
            }
            
            echo '<p>Liste des chambres : </p>';
            foreach ($list_cham_hotel as $chambre) {
                echo ' - ' . $chambre;
            }
            echo '<p>Liste des chambres occupées entre le ' .$debut.  ' et le ' .$fin. ' : </p>';
            foreach ($list_cham_occupees as $chambre_occupee) {
                echo ' - ' . $chambre_occupee;
            }
            echo '<br>';
            if (count($list_cham_hotel) == count($list_cham_occupees)) {
                return 0;
            }
            else {
                foreach ($list_cham_hotel as $chambre_hotel) {
                    if (!in_array($chambre_hotel, $list_cham_occupees)) {
                        // echo "La chambre ". $chambre_hotel . " n'est pas occupée. On attribut donc cette chambre.";
                        return $chambre_hotel;
                        break;
                    }
                }
            }
        }


        public function nameByid($id) {
            $requete = "SELECT nom FROM personne WHERE id = :id";
            $stmt = $this->_db->prepare($requete);
            // $stmt->bindParam('table_name', $table_name);
            $stmt->bindParam('id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $errors = $stmt->errorInfo();
            if ($errors[0] != '00000') {
                return $stmt->errorInfo();
            }
            else {
                return $row['nom'];
            }
        }

        public function num_chamByid($id) {
            $requete = "SELECT numero FROM chambre WHERE id = :id";
            $stmt = $this->_db->prepare($requete);
            // $stmt->bindParam('table_name', $table_name);
            $stmt->bindParam('id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $errors = $stmt->errorInfo();
            if ($errors[0] != '00000') {
                return $stmt->errorInfo();
            }
            else {
                return $row['numero'];
            }
        }

        public function idBynum_chamAndid_hotel($numero, $id_hotel) {
            $requete = 'SELECT id FROM chambre WHERE numero = :numero AND id_hotel = :id_hotel';
            $stmt = $this->_db->prepare($requete);
            // $stmt->bindParam('table_name', $table_name);
            $stmt->bindParam('numero', $numero);
            $stmt->bindParam('id_hotel', $id_hotel);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $errors = $stmt->errorInfo();
            if ($errors[0] != '00000') {
                return $stmt->errorInfo();
            }
            else {
                return $row['id'];
            }
        }

        public function hotelByid($id) {
            $requete = "SELECT name FROM `hotel` WHERE id = :id";
            $stmt = $this->_db->prepare($requete);
            // $stmt->bindParam('table_name', $table_name);
            $stmt->bindParam('id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $errors = $stmt->errorInfo();
            if ($errors[0] != '00000') {
                return $stmt->errorInfo();
            }
            else {
                return $row['name'];
            }
        }

        
    }
 ?>
