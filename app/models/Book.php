<?php

class Book {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Mengambil semua buku beserta nama kategorinya
    public function getAllBooks() {
        $this->db->query("SELECT books.*, categories.name as category_name 
                          FROM books 
                          LEFT JOIN categories ON books.category_id = categories.id 
                          ORDER BY books.created_at DESC");
        return $this->db->resultSet();
    }

    // Mengambil semua kategori untuk dropdown di form
    public function getCategories() {
        $this->db->query("SELECT * FROM categories ORDER BY name ASC");
        return $this->db->resultSet();
    }

    // Menambah buku baru
    public function addBook($data) {
        $this->db->query("INSERT INTO books (title, author, category_id, cover_image, stock) 
                          VALUES (:title, :author, :category_id, :cover_image, :stock)");
        
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':author', $data['author']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':cover_image', $data['cover_image']);
        $this->db->bind(':stock', $data['stock']);
        
        return $this->db->execute();
    }

    // Menghapus buku
    public function deleteBook($id) {
        $this->db->query("DELETE FROM books WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getBookById($id) {
        $this->db->query("SELECT * FROM books WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Memperbarui data buku
    public function updateBook($data) {
        // Cek apakah Admin mengupload gambar sampul baru
        if ($data['cover_image']) {
            $this->db->query("UPDATE books SET title = :title, author = :author, category_id = :category_id, cover_image = :cover_image, stock = :stock WHERE id = :id");
            $this->db->bind(':cover_image', $data['cover_image']);
        } else {
            // Jika tidak ada gambar baru, jangan update kolom cover_image
            $this->db->query("UPDATE books SET title = :title, author = :author, category_id = :category_id, stock = :stock WHERE id = :id");
        }
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':author', $data['author']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':stock', $data['stock']);
        
        return $this->db->execute();
    }
}