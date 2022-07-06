<?php
    class Personne  {
        protected $id;
        protected $name;
        protected $email;

        public function __construct(array $data) {
            if (isset($data['id'])) {
                $this->setId($data['id']);
            }
            $this->setName($data['name']);
            $this->setEmail($data['email']);
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

        public function setEmail($email) {
            if (is_string($email)) {
                $this->email = $email;
            }
        }

        // getter
        public function getId() {
            return $this->id;
        }

        public function getName() {
            return $this->name;
        }

        public function getEmail() {
            return $this->email;
        }
    }


?>