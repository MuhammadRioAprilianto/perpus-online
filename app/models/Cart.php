<?php

class Cart {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Mengambil semua buku di keranjang milik user tertentu
    public function getCartItems($user_id) {
        $this->db->query("SELECT carts.id as cart_id, books.* FROM carts 
                          JOIN books ON carts.book_id = books.id 
                          WHERE carts.user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    // Menghitung jumlah buku di keranjang
    public function countUserCart($user_id) {
        $this->db->query("SELECT COUNT(*) as total FROM carts WHERE user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->single();
        return $result['total'];
    }

    // Cek apakah buku sudah ada di keranjang
    public function isBookInCart($user_id, $book_id) {
        $this->db->query("SELECT id FROM carts WHERE user_id = :user_id AND book_id = :book_id");
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':book_id', $book_id);
        return $this->db->single();
    }

    // Tambah ke keranjang
    public function addToCart($user_id, $book_id) {
        $this->db->query("INSERT INTO carts (user_id, book_id) VALUES (:user_id, :book_id)");
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':book_id', $book_id);
        return $this->db->execute();
    }

    // Hapus dari keranjang (Validasi user_id juga agar tidak bisa hapus milik orang lain)
    public function removeFromCart($cart_id, $user_id) {
        $this->db->query("DELETE FROM carts WHERE id = :id AND user_id = :user_id");
        $this->db->bind(':id', $cart_id);
        $this->db->bind(':user_id', $user_id);
        return $this->db->execute();
    }
}