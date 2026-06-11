<?php
require_once '../app/models/LoanModel.php';
require_once '../app/config/database.php';

class LoanController {
    private $loanModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Koneksi database diinisialisasi langsung di dalam konstruktor model (DAL)
        $this->loanModel = new LoanModel();
    }

    // Fungsi internal untuk mengamankan route khusus Admin
    private function checkAdmin() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . '/login');
            exit;
        }
    }

    // ==========================================
    //            FITUR UTAMA USER
    // ==========================================

    // Menampilkan daftar peminjaman mandiri milik user yang sedang login
    public function userLoans() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        // Jalankan pengecekan otomatis pembatalan 15 menit sebelum data ditarik
        $this->checkExpiredLoans();

        // Mengambil data peminjaman khusus milik ID user yang login
        $db = new Database();
        $db->query("SELECT l.*, b.title FROM loans l JOIN books b ON l.book_id = b.id WHERE l.user_id = :user_id ORDER BY l.request_time DESC");
        $db->bind(':user_id', $_SESSION['user_id']);
        $myLoans = $db->resultSet();

        // Memanggil presentation layer riwayat peminjaman user
        require_once '../app/views/loans/index.php';
    }

    // Memproses pengajuan peminjaman online dari katalog utama
    public function requestLoan() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];
            $bookId = $_POST['book_id'];

            // Mengirim instruksi pembuatan data ke Data Access Layer
            if ($this->loanModel->createLoanRequest($userId, $bookId)) {
                header('Location: ' . BASEURL . '/loans?msg=loan_success');
            } else {
                header('Location: ' . BASEURL . '/?msg=loan_failed');
            }
            exit;
        }
    }

    // ==========================================
    //          LOGIKA BISNIS OTOMATIS
    // ==========================================

    // Logika BLL: Membatalkan pengajuan pending jika lewat dari 15 menit tidak diambil
    public function checkExpiredLoans() {
        // Meminta data transaksi hangus dari DAL
        $expiredLoans = $this->loanModel->getExpiredPendingLoans(15);
        
        // Memperbarui status setiap data yang hangus menjadi cancelled
        foreach ($expiredLoans as $loan) {
            $this->loanModel->updateLoanStatus($loan['id'], 'cancelled');
        }
    }

    // ==========================================
    //            FITUR UTAMA ADMIN
    // ==========================================

    // Menampilkan semua log sirkulasi aktivitas peminjaman buku di dashboard admin
    public function index() {
        $this->checkAdmin();
        
        // Selalu picu pengecekan peminjaman kedaluwarsa setiap kali halaman log dibuka
        $this->checkExpiredLoans();
        
        $loans = $this->loanModel->getAllLoans();
        require_once '../app/views/admin/loans.php';
    }

    // Konfirmasi persetujuan pinjaman dan menentukan durasi lama pinjam buku
    public function approve() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $loanId = $_POST['loan_id'];
            
            // Menangkap input angka durasi hari dari form admin (default 7 hari jika kosong)
            $durationDays = isset($_POST['duration']) ? intval($_POST['duration']) : 7; 
            $dueDate = date('Y-m-d H:i:s', strtotime("+$durationDays days"));
            
            $this->loanModel->updateLoanStatus($loanId, 'approved', $dueDate);
            header('Location: ' . BASEURL . '/admin/loans?status=approved');
            exit;
        }
    }

    // Konfirmasi pengembalian buku ketika fisik buku dikembalikan ke meja sirkulasi perpus
    public function returnBook() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $loanId = $_POST['loan_id'];
            
            $this->loanModel->updateLoanStatus($loanId, 'returned');
            header('Location: ' . BASEURL . '/admin/loans?status=returned');
            exit;
        }
    }
}