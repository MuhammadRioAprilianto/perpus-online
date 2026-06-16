<?php

class LoanController {
    private $db;

    public function __construct() {
        require_once '../app/config/database.php'; // Atau sesuaikan path-nya
        $this->db = new Database();
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function requestLoan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_SESSION['user_id'];
            $pickup_date = $_POST['pickup_date'];
            $deposit_amount = $_POST['deposit_amount'];
            
            // 1. Upload Bukti Transfer
            $file_name = time() . '_' . $_FILES['deposit_receipt']['name'];
            move_uploaded_file($_FILES['deposit_receipt']['tmp_name'], '../public/uploads/receipts/' . $file_name);

            // 2. Insert ke tabel loans (Sesuai kolom tabelmu)
            // Menghitung due_date (misal: 7 hari setelah pickup)
            $due_date = date('Y-m-d', strtotime($pickup_date . ' + 7 days'));

            $query = "INSERT INTO loans (user_id, pickup_date, due_date, deposit_amount, payment_proof, status) 
                      VALUES (:user_id, :pickup_date, :due_date, :deposit_amount, :payment_proof, 'pending')";
            
            $this->db->query($query);
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':pickup_date', $pickup_date);
            $this->db->bind(':due_date', $due_date);
            $this->db->bind(':deposit_amount', $deposit_amount);
            $this->db->bind(':payment_proof', $file_name);
            $this->db->execute();

            $loan_id = $this->db->lastInsertId(); // Mengambil ID loan yang baru dibuat

            // 3. Masukkan item buku dari keranjang ke loan_items
            // (Asumsi kamu punya model Cart untuk ambil item)
            require_once '../app/models/Cart.php';
            $cartModel = new Cart();
            $items = $cartModel->getCartItems($user_id);

            foreach ($items as $item) {
                $this->db->query("INSERT INTO loan_items (loan_id, book_id) VALUES (:loan_id, :book_id)");
                $this->db->bind(':loan_id', $loan_id);
                $this->db->bind(':book_id', $item['id']);
                $this->db->execute();
            }

            // 4. Kosongkan keranjang
            $this->db->query("DELETE FROM carts WHERE user_id = :user_id");
            $this->db->bind(':user_id', $user_id);
            $this->db->execute();

            header("Location: /perpus-online/public/?status=loan_success");
            exit();
        }
    }

    // Admin: Melihat daftar semua peminjaman
    public function index() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            header("Location: /perpus-online/public/login");
            exit();
        }

        $this->db->query("SELECT loans.*, users.name as user_name FROM loans 
                          JOIN users ON loans.user_id = users.id 
                          ORDER BY created_at DESC");
        $loans = $this->db->resultSet();

        // Ambil data buku untuk setiap transaksi peminjaman
        foreach ($loans as &$loan) {
            $this->db->query("SELECT books.title, books.author FROM loan_items 
                              JOIN books ON loan_items.book_id = books.id 
                              WHERE loan_items.loan_id = :loan_id");
            $this->db->bind(':loan_id', $loan['id']);
            $loan['books'] = $this->db->resultSet();
        }
        
        require_once '../app/views/admin/loans/index.php';
    }

    // Admin: Mengubah status peminjaman (approve/reject)
    public function approve() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            header("Location: /perpus-online/public/login");
            exit();
        }

        $loan_id = $_GET['id'] ?? null;
        $status = $_GET['status'] ?? 'approved'; // 'approved' atau 'rejected'

        if ($loan_id) {
            if ($status == 'approved') {
                // Pastikan stok semua buku dalam peminjaman ini masih tersedia (> 0)
                $this->db->query("SELECT li.book_id, b.title, b.stock FROM loan_items li 
                                  JOIN books b ON li.book_id = b.id 
                                  WHERE li.loan_id = :loan_id");
                $this->db->bind(':loan_id', $loan_id);
                $books = $this->db->resultSet();

                $can_approve = true;
                foreach ($books as $book) {
                    if ($book['stock'] <= 0) {
                        $can_approve = false;
                        break;
                    }
                }

                if (!$can_approve) {
                    header("Location: /perpus-online/public/admin/loans?status=out_of_stock");
                    exit();
                }

                // Kurangi stok masing-masing buku sebanyak 1
                foreach ($books as $book) {
                    $this->db->query("UPDATE books SET stock = stock - 1 WHERE id = :book_id");
                    $this->db->bind(':book_id', $book['book_id']);
                    $this->db->execute();
                }
            }

            $this->db->query("UPDATE loans SET status = :status WHERE id = :id");
            $this->db->bind(':status', $status);
            $this->db->bind(':id', $loan_id);
            $this->db->execute();
        }
        
        header("Location: /perpus-online/public/admin/loans?status=success");
        exit();
    }

    // Admin: Konfirmasi pengembalian buku & kalkulasi denda otomatis
    public function returnBook() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            header("Location: /perpus-online/public/login");
            exit();
        }

        $loan_id = $_GET['id'] ?? null;
        if ($loan_id) {
            // Dapatkan detail peminjaman
            $this->db->query("SELECT * FROM loans WHERE id = :id LIMIT 1");
            $this->db->bind(':id', $loan_id);
            $loan = $this->db->single();

            if ($loan && $loan['status'] == 'approved') {
                $today = date('Y-m-d');
                $due_date = $loan['due_date'];
                
                $fine_amount = 0.00;
                $status = 'returned';
                
                // Kalkulasi denda jika melewati tanggal jatuh tempo
                if (strtotime($today) > strtotime($due_date)) {
                    $diff = strtotime($today) - strtotime($due_date);
                    $days_late = floor($diff / (24 * 60 * 60));
                    if ($days_late > 0) {
                        $fine_amount = $days_late * 5000; // Rp 5.000 per hari keterlambatan
                        $status = 'late';
                    }
                }

                // Update data peminjaman
                $this->db->query("UPDATE loans SET status = :status, return_date = :return_date, fine_amount = :fine_amount WHERE id = :id");
                $this->db->bind(':status', $status);
                $this->db->bind(':return_date', $today);
                $this->db->bind(':fine_amount', $fine_amount);
                $this->db->bind(':id', $loan_id);
                $this->db->execute();

                // Kembalikan/tambah stok buku yang telah dikembalikan
                $this->db->query("SELECT book_id FROM loan_items WHERE loan_id = :loan_id");
                $this->db->bind(':loan_id', $loan_id);
                $items = $this->db->resultSet();

                foreach ($items as $item) {
                    $this->db->query("UPDATE books SET stock = stock + 1 WHERE id = :book_id");
                    $this->db->bind(':book_id', $item['book_id']);
                    $this->db->execute();
                }
            }
        }

        header("Location: /perpus-online/public/admin/loans?status=success");
        exit();
    }

    // User: Melihat riwayat peminjaman sendiri
    public function myLoans() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'member') {
            header("Location: /perpus-online/public/login");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        
        // Ambil semua peminjaman milik user ini
        $this->db->query("SELECT * FROM loans WHERE user_id = :user_id ORDER BY created_at DESC");
        $this->db->bind(':user_id', $user_id);
        $loans = $this->db->resultSet();

        // Ambil buku untuk setiap peminjaman
        foreach ($loans as &$loan) {
            $this->db->query("SELECT books.id as book_id, books.title, books.author, books.cover_image 
                              FROM loan_items 
                              JOIN books ON loan_items.book_id = books.id 
                              WHERE loan_items.loan_id = :loan_id");
            $this->db->bind(':loan_id', $loan['id']);
            $loan['books'] = $this->db->resultSet();
        }

        // Ambil semua ID buku yang sudah diulas oleh user ini untuk divalidasi di view
        $this->db->query("SELECT book_id FROM reviews WHERE user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        $reviewed_books = array_column($this->db->resultSet(), 'book_id');

        require_once '../app/views/loans/my_loans.php';
    }

    // User: Mengirim ulasan untuk buku yang telah dibaca/dikembalikan
    public function addReview() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'member') {
                header("Location: /perpus-online/public/login");
                exit();
            }

            $user_id = $_SESSION['user_id'];
            $book_id = (int)$_POST['book_id'];
            $rating = (int)$_POST['rating'];
            $comment = htmlspecialchars($_POST['comment']);

            if ($rating >= 1 && $rating <= 5 && $book_id > 0) {
                // Pastikan belum pernah diulas oleh user ini untuk buku ini
                $this->db->query("SELECT id FROM reviews WHERE user_id = :user_id AND book_id = :book_id");
                $this->db->bind(':user_id', $user_id);
                $this->db->bind(':book_id', $book_id);
                
                if (!$this->db->single()) {
                    $this->db->query("INSERT INTO reviews (user_id, book_id, rating, comment) 
                                      VALUES (:user_id, :book_id, :rating, :comment)");
                    $this->db->bind(':user_id', $user_id);
                    $this->db->bind(':book_id', $book_id);
                    $this->db->bind(':rating', $rating);
                    $this->db->bind(':comment', $comment);
                    $this->db->execute();
                }
            }

            header("Location: /perpus-online/public/loans?status=review_success");
            exit();
        }
    }
}