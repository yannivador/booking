<?php
    class Booking  {
        protected $id;
        protected $debut;
        protected $fin;
        protected $date;
        protected $id_pers;
        protected $id_cham;

        public function __construct(array $data) {
            if (isset($data['id'])) {
                $this->setId($data['id']);
            }
            $this->setDebut($data['debut']);
            $this->setFin($data['fin']);
            $this->setDate($data['date']);
            $this->setIdPers($data['id_pers']);
            $this->setIdCham($data['id_cham']);
            $this->setIdHotel($data['id_hotel']);
        }
        
        // setters
        public function setId($id) {
            if ((is_int($id)) AND ($id > 0)) {
                $this->id = $id;
            }
        }

        public function setDebut($debut) {
            if (is_string($debut)) {
                $this->debut = $debut;
            }
        }

        public function setFin($fin) {
            if (is_string($fin)) {
                $this->fin = $fin;
            }
        }

        public function setDate($date) {
            if (is_string($date)) {
                $this->date = $date;
            }
        }

        public function setIdPers($id_pers) {
            if (is_string($id_pers)) {
                $this->id_pers = $id_pers;
            }
        }

        public function setIdCham($id_cham) {
            if (is_string($id_cham)) {
                $this->id_cham = $id_cham;
            }
        }

        public function setIdHotel($id_hotel) {
            if (is_string($id_hotel)) {
                $this->id_hotel = $id_hotel;
            }
        }

        
        // getter
        public function getId() {
            return $this->id;
        }

        public function getDebut() {
            return $this->debut;
        }

        public function getFin() {
            return $this->fin;
        }

        public function getDate() {
            return $this->date;
        }

        public function getIdPers() {
            return $this->id_pers;
        }

        public function getIdCham() {
            return $this->id_cham;
        }

        public function getIdHotel() {
            return $this->id_hotel;
        }
    }


?>