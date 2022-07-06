<?php
    class Hotel  {
        protected $id;
        protected $name;
        protected $address;

        public function __construct(array $data) {
            if (isset($data['id'])) {
                $this->setId($data['id']);
            }
            $this->setName($data['name']);
            $this->setAddress($data['address']);
        }
        
        // setters
        public function setId($id) {
            if ((is_int($id)) AND ($id > 0)) {
                $this->id = $id;
            }
        }

        public function setName($name) {
            if (is_string($name)) {
                $this->name = $name;
            }
        }

        public function setAddress($address) {
            if (is_string($address)) {
                $this->address = $address;
            }
        }

        // getter
        public function getId() {
            return $this->id;
        }

        public function getName() {
            return $this->name;
        }

        public function getAddress() {
            return $this->address;
        }

        
        
    }


?>