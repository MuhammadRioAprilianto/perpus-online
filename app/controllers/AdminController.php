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
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            redirect('/login');
        }

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

    public function members() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            redirect('/login');
        }

        // Ambil data member dengan statistik pinjaman
        $db = new Database();
        $db->query("SELECT 
                        u.id, 
                        u.name, 
                        u.email, 
                        u.created_at,
                        COUNT(l.id) AS total_loans,
                        SUM(CASE WHEN l.status IN ('pending', 'approved') THEN 1 ELSE 0 END) AS active_loans,
                        IFNULL(SUM(l.fine_amount), 0.00) AS total_fines
                    FROM users u
                    LEFT JOIN loans l ON u.id = l.user_id
                    WHERE u.role = 'member'
                    GROUP BY u.id
                    ORDER BY u.created_at DESC");
        $members = $db->resultSet();

        require_once '../app/views/admin/members.php';
    }

    public function reviews() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            redirect('/login');
        }

        // Ambil daftar review buku
        $db = new Database();
        $db->query("SELECT 
                        r.id,
                        r.rating,
                        r.comment,
                        r.created_at,
                        u.name AS user_name,
                        b.title AS book_title
                    FROM reviews r
                    JOIN users u ON r.user_id = u.id
                    JOIN books b ON r.book_id = b.id
                    ORDER BY r.created_at DESC");
        $reviews = $db->resultSet();

        require_once '../app/views/admin/reviews.php';
    }

    public function deleteReview() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            redirect('/login');
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $db = new Database();
            $db->query("DELETE FROM reviews WHERE id = :id");
            $db->bind(':id', $id);
            if ($db->execute()) {
                redirect('/admin/reviews?status=success');
            }
        }
        redirect('/admin/reviews?status=error');
    }
}