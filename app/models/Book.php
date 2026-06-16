<?php

class Book {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Mengambil buku dengan dukungan pencarian dan filter kategori
    public function getAllBooks($search = '', $categoryId = '') {
        $query = "SELECT books.*, categories.name as category_name,
                  COALESCE(AVG(reviews.rating), 0) as avg_rating,
                  COUNT(reviews.id) as review_count
                  FROM books 
                  LEFT JOIN categories ON books.category_id = categories.id 
                  LEFT JOIN reviews ON books.id = reviews.book_id
                  WHERE 1=1"; 
        
        if (!empty($search)) {
            $query .= " AND (books.title LIKE :search OR books.author LIKE :search)";
        }
        
        if (!empty($categoryId)) {
            $query .= " AND books.category_id = :category_id";
        }
        
        $query .= " GROUP BY books.id ORDER BY books.created_at DESC";
        
        $this->db->query($query);
        
        if (!empty($search)) {
            $this->db->bind(':search', "%$search%");
        }
        if (!empty($categoryId)) {
            $this->db->bind(':category_id', $categoryId);
        }
        
        return $this->db->resultSet();
    }

    // Mengambil semua kategori
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

    // Mengambil satu buku spesifik untuk form edit
    public function getBookById($id) {
        $this->db->query("SELECT * FROM books WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Memperbarui data buku
    public function updateBook($data) {
        if ($data['cover_image']) {
            $this->db->query("UPDATE books SET title = :title, author = :author, category_id = :category_id, cover_image = :cover_image, stock = :stock WHERE id = :id");
            $this->db->bind(':cover_image', $data['cover_image']);
        } else {
            $this->db->query("UPDATE books SET title = :title, author = :author, category_id = :category_id, stock = :stock WHERE id = :id");
        }
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':author', $data['author']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':stock', $data['stock']);
        
        return $this->db->execute();
    }

    // Menghitung total buku di katalog untuk dashboard
    public function getTotalBooks() {
        $this->db->query("SELECT COUNT(*) as total FROM books");
        $result = $this->db->single();
        return $result['total'];
    }
}