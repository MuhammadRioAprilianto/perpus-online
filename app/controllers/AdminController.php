<?php

class AdminController {
    private $bookModel;
    private $userModel;

    public function __construct() {
        // Panggil model yang dibutuhkan
        require_once '../app/models/Book.php';
        require_once '../app/models/UserModel.php';
        
        $this->bookModel = new Book();
        $this->userModel = new UserModel();
    }

    public function index() {
        // Ambil data dinamis dari database
        $totalBooks = $this->bookModel->getTotalBooks();
        $totalMembers = $this->userModel->getTotalMembers();
        
        // Untuk buku terlambat, kita set 0 dulu sampai modul Peminjaman (Loan) dibuat
        $totalLate = 0; 

        // Panggil view
        require_once '../app/views/admin/dashboard.php';
    }
}