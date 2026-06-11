<?php
require_once '../app/models/BookModel.php';
require_once '../app/config/database.php';

class HomeController {
    private $bookModel;

    public function __construct() {
        // Menginisiasi Data Access Layer (DAL) untuk buku
        $this->bookModel = new BookModel();
    }

    // Method default untuk halaman utama
    public function index() {
        // Mengambil semua data buku dari database untuk ditampilkan di katalog publik
        $books = $this->bookModel->getAllBooks();
        
        // Memanggil Presentation Layer (Tampilan halaman utama yang sudah kita buat)
        require_once '../app/views/home.php';
    }
}