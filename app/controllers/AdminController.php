<?php
require_once '../app/models/BookModel.php';
require_once '../app/models/LoanModel.php';
require_once '../app/config/database.php';

class AdminController {
    private $bookModel;
    private $loanModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // BLL: Proteksi ketat hak akses khusus Admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        $db = new Database();
        $this->bookModel = new BookModel($db->getConnection());
        $this->loanModel = new LoanModel($db->getConnection());
    }

    // Menampilkan halaman utama Dashboard Admin
    public function index() {
        $books = $this->bookModel->getAllBooks();
        $loans = $this->loanModel->getAllLoans();

        // Menyusun data statistik ringkas untuk Dashboard
        $stats = [
            'total_buku' => count($books),
            'total_peminjaman' => count($loans),
            'pending' => count(array_filter($loans, function($l) { return $l['status'] === 'pending'; })),
            'disetujui' => count(array_filter($loans, function($l) { return $l['status'] === 'approved'; }))
        ];

        // Memanggil Presentation Layer (Dashboard)
        require_once '../app/views/admin/dashboard.php';
    }
}