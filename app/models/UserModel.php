<?php
// app/models/UserModel.php

class UserModel {
    private $db;

    public function __construct() {
        // Langsung instansiasi class Database
        $this->db = new Database(); 
    }

    public function register($name, $email, $password) {
        $this->db->query("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, 'member')");
        
        $this->db->bind(':name', $name);
        $this->db->bind(':email', $email);
        $this->db->bind(':password', password_hash($password, PASSWORD_BCRYPT));
        
        return $this->db->execute();
    }

    public function findByEmail($email) {
        $this->db->query("SELECT * FROM users WHERE email = :email LIMIT 1");
        $this->db->bind(':email', $email);
        
        return $this->db->single();
    }
}