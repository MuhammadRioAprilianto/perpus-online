<?php
require_once '../app/models/BookModel.php';
require_once '../app/config/database.php';

class BookController {
    private $bookModel;

    public function __construct() {
        $db = new Database();
        $this->bookModel = new BookModel($db->getConnection());
    }

    // [User & Public] Melihat daftar katalog buku
    public function index() {
        $books = $this->bookModel->getAllBooks();
        require_once '../app/views/books/index.php';
    }

    // Fungsi internal untuk validasi token/role admin
    private function checkAdmin() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . '/login');
            exit;
        }
    }

    // [Admin] Menampilkan halaman manajemen tabel buku
    public function adminIndex() {
        $this->checkAdmin();
        $books = $this->bookModel->getAllBooks();
        require_once '../app/views/admin/books.php';
    }

    // [Admin] Menambah Buku Baru
    public function add() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = trim($_POST['title']);
            $author = trim($_POST['author']);
            $stock = intval($_POST['stock']);
            
            // Pengolahan file gambar lokal
            $cover_image = 'default-cover.jpg';
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                $fileName = time() . '_' . $_FILES['cover_image']['name'];
                $uploadDir = '../public/uploads/books/';
                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadDir . $fileName)) {
                    $cover_image = $fileName;
                }
            }

            $this->bookModel->createBook($title, $author, $cover_image, $stock);
            header('Location: ' . BASEURL . '/admin/books');
            exit;
        }
    }

    // [Admin] Mengubah Data Buku
    public function edit() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $title = trim($_POST['title']);
            $author = trim($_POST['author']);
            $stock = intval($_POST['stock']);
            
            $currentBook = $this->bookModel->getBookById($id);
            $cover_image = $currentBook['cover_image'];

            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                $fileName = time() . '_' . $_FILES['cover_image']['name'];
                $uploadDir = '../public/uploads/books/';
                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadDir . $fileName)) {
                    $cover_image = $fileName;
                }
            }

            $this->bookModel->updateBook($id, $title, $author, $cover_image, $stock);
            header('Location: ' . BASEURL . '/admin/books');
            exit;
        }
    }

    // [Admin] Menghapus Buku
    public function delete() {
        $this->checkAdmin();
        if (isset($_POST['id'])) {
            $this->bookModel->deleteBook($_POST['id']);
        }
        header('Location: ' . BASEURL . '/admin/books');
        exit;
    }
}