<?php

    class User {
        private $db;
        
        public function __construct() {
            $this -> db = new Database;
        }

        // Find user by email
        public function findUserByEmail($email) {
            $this -> db -> query('SELECT * FROM users WHERE email = :email');
            $this -> db -> bind(':email', $email);

            $row = $this -> db -> single();

            // Check row - If greater than zero, then there is no email found
            if($this -> db -> rowCount() > 0 ) {
                return true;
            } else {
                return false;
            }
        }

    }

?>