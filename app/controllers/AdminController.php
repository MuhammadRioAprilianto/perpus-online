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
        
        // Hitung buku terlambat (status 'late' atau status 'approved' yang sudah melewati jatuh tempo)
        $db = new Database();
        $db->query("SELECT COUNT(*) as total FROM loans 
                    WHERE status = 'late' OR (status = 'approved' AND due_date < CURRENT_DATE())");
        $result = $db->single();
        $totalLate = $result['total']; 

        // Panggil view
        require_once '../app/views/admin/dashboard.php';
    }
}