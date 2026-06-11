<?php
class LoanModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function createLoanRequest($user_id, $book_id) {
        $this->db->query("INSERT INTO loans (user_id, book_id, status, request_time) VALUES (:user_id, :book_id, 'pending', NOW())");
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':book_id', $book_id);
        return $this->db->execute();
    }

    public function updateLoanStatus($loan_id, $status, $due_date = null) {
        $this->db->query("UPDATE loans SET status = :status, due_date = :due_date WHERE id = :loan_id");
        $this->db->bind(':loan_id', $loan_id);
        $this->db->bind(':status', $status);
        $this->db->bind(':due_date', $due_date);
        return $this->db->execute();
    }

    public function getAllLoans() {
        $this->db->query("SELECT l.*, u.username, b.title FROM loans l JOIN users u ON l.user_id = u.id JOIN books b ON l.book_id = b.id ORDER BY l.request_time DESC");
        return $this->db->resultSet();
    }

    public function getExpiredPendingLoans($minutes = 15) {
        $this->db->query("SELECT * FROM loans WHERE status = 'pending' AND request_time < NOW() - INTERVAL :minutes MINUTE");
        $this->db->bind(':minutes', $minutes);
        return $this->db->resultSet();
    }
}