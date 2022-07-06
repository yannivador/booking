<?php 
    class Db {
        static function connection() {
                try {
                $dbh = new PDO('mysql:host=localhost;dbname=booking_test', 'root', '');
                // echo 'Connexion OK';
            }
            catch(Exception $e) {
                echo 'Message erreur SQL : ' .$e->getMessage(). '<br />';
                exit;
            }
            return $dbh;
        }
    }
?>