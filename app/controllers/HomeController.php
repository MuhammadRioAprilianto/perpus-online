<?php

class HomeController {
    private $bookModel;

    public function __construct() {
        require_once '../app/models/Book.php';
        $this->bookModel = new Book();
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        // Tangkap parameter dari URL (jika ada)
        $search = $_GET['search'] ?? '';
        $categoryId = $_GET['category'] ?? '';

        // Ambil data buku berdasarkan filter yang aktif
        $books = $this->bookModel->getAllBooks($search, $categoryId);
        
        // Ambil data kategori untuk dropdown filter di view
        $categories = $this->bookModel->getCategories();
        
        require_once '../app/views/home/index.php';
    }
}