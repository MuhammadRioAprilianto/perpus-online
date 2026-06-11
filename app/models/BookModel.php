<?php
class BookModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllBooks() {
        $this->db->query("SELECT * FROM books ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function getBookById($id) {
        $this->db->query("SELECT * FROM books WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function createBook($title, $author, $cover_image, $stock) {
        $this->db->query("INSERT INTO books (title, author, cover_image, stock) VALUES (:title, :author, :cover_image, :stock)");
        $this->db->bind(':title', $title);
        $this->db->bind(':author', $author);
        $this->db->bind(':cover_image', $cover_image); // Nama file lokal
        $this->db->bind(':stock', $stock);
        return $this->db->execute();
    }

    public function updateBook($id, $title, $author, $cover_image, $stock) {
        $this->db->query("UPDATE books SET title = :title, author = :author, cover_image = :cover_image, stock = :stock WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->bind(':title', $title);
        $this->db->bind(':author', $author);
        $this->db->bind(':cover_image', $cover_image);
        $this->db->bind(':stock', $stock);
        return $this->db->execute();
    }

    public function deleteBook($id) {
        $this->db->query("DELETE FROM books WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}