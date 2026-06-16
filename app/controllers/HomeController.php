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
        // Halaman landing page
        require_once '../app/models/UserModel.php';
        $userModel = new UserModel();

        $totalBooks = $this->bookModel->getTotalBooks();
        $totalMembers = $userModel->getTotalMembers();

        // Hitung total transaksi peminjaman
        $db = new Database();
        $db->query("SELECT COUNT(*) as total FROM loans");
        $loanResult = $db->single();
        $totalLoans = $loanResult['total'] ?? 0;

        require_once '../app/views/home/landing.php';
    }

    public function catalog() {
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