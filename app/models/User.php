<?php

    class User {
        private $db;
        
        public function __construct() {
            $this -> db = new Database;
        }

        // Register User 
        public function register($data) {
            $this -> db -> query('INSERT INTO users(name, email, password) VALUES (:name, :email, :password)');
            // Bind the values
            $this -> db -> bind(':name', $data['name']);
            $this -> db -> bind(':email', $data['email']);
            $this -> db -> bind(':password', $data['password']);

            // Execute 
            if($this -> db -> execute()) {
                return true;
            } else {
                return false;
            }
        }

        // Find user by email
        public function findUserByEmail($email) {
            $this -> db -> query('SELECT * FROM users WHERE email = :email');
            // bind the values from the email
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