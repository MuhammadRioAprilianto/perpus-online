<?php
class UserModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register($username, $password) {
        $this->db->query("INSERT INTO users (username, password, role) VALUES (:username, :password, 'user')");
        $this->db->bind(':username', $username);
        $this->db->bind(':password', password_hash($password, PASSWORD_BCRYPT));
        return $this->db->execute();
    }

    public function findByUsername($username) {
        $this->db->query("SELECT * FROM users WHERE username = :username LIMIT 1");
        $this->db->bind(':username', $username);
        return $this->db->single();
    }
}