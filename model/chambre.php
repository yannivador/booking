<?php
    class Chambre  {
        protected $id;
        protected $numero;
        protected $id_hotel;

        public function __construct(array $data) {
            if (isset($data['id'])) {
                $this->setId($data['id']);
            }
            $this->setNumero($data['numero']);
            $this->setIdHotel($data['id_hotel']);
        }
        
        // setters
        public function setId($id) {
            if ((is_int($id)) AND ($id > 0)) {
                $this->id = $id;
            }
        }

        public function setNumero($numero) {
            if (is_string($numero)) {
                $this->numero = $numero;
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

        public function getNumero() {
            return $this->numero;
        }

        public function getIdHotel() {
            return $this->id_hotel;
        }
    }


?>