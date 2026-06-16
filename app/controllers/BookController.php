<?php

class BookController {
    private $bookModel;

    public function __construct() {
        // Load model Book
        require_once '../app/models/Book.php';
        $this->bookModel = new Book();
    }

    // Menampilkan daftar buku di halaman admin (admin/books)
    public function index() {
        $books = $this->bookModel->getAllBooks();
        require_once '../app/views/admin/books/index.php';
    }

    // Proses tambah buku (admin/books/add)
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = htmlspecialchars($_POST['title']);
            $author = htmlspecialchars($_POST['author']);
            $category_id = $_POST['category_id'];
            $stock = (int)$_POST['stock'];
            $cover_image = null;

            // Logika upload gambar
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
                $target_dir = "../public/uploads/books/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }

                $fileName = time() . '_' . basename($_FILES["cover_image"]["name"]);
                if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_dir . $fileName)) {
                    $cover_image = $fileName;
                }
            }

            $data = [
                'title' => $title,
                'author' => $author,
                'category_id' => $category_id,
                'cover_image' => $cover_image,
                'stock' => $stock
            ];

            if ($this->bookModel->addBook($data)) {
                header("Location: /perpus-online/public/admin/books?status=success");
            } else {
                header("Location: /perpus-online/public/admin/books?status=error");
            }
            exit();
        } else {
            // Jika diakses lewat GET, tampilkan form tambah buku
            $categories = $this->bookModel->getCategories();
            require_once '../app/views/admin/books/add.php';
        }
    }

    // Proses edit buku (admin/books/edit)
    public function edit() {
        // Ambil ID dari URL (contoh: ?id=1)
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header("Location: /perpus-online/public/admin/books");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = htmlspecialchars($_POST['title']);
            $author = htmlspecialchars($_POST['author']);
            $category_id = $_POST['category_id'];
            $stock = (int)$_POST['stock'];
            $cover_image = null;

            // Logika upload gambar sama persis seperti saat add()
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
                $target_dir = "../public/uploads/books/";
                $fileName = time() . '_' . basename($_FILES["cover_image"]["name"]);
                if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_dir . $fileName)) {
                    $cover_image = $fileName;
                }
            }

            $data = [
                'id' => $id,
                'title' => $title,
                'author' => $author,
                'category_id' => $category_id,
                'cover_image' => $cover_image,
                'stock' => $stock
            ];

            if ($this->bookModel->updateBook($data)) {
                header("Location: /perpus-online/public/admin/books?status=success");
            } else {
                header("Location: /perpus-online/public/admin/books?status=error");
            }
            exit();
        } else {
            // Jika diakses lewat GET, ambil data buku yang akan diedit
            $book = $this->bookModel->getBookById($id);
            $categories = $this->bookModel->getCategories();
            
            // Panggil view edit
            require_once '../app/views/admin/books/edit.php';
        }
    }

    // Proses hapus buku (admin/books/delete)
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->bookModel->deleteBook($id);
        }
        header("Location: /perpus-online/public/admin/books?status=success");
        exit();
    }

    // AJAX: Mendapatkan detail buku beserta ulasan-ulasannya
    public function detail() {
        $book_id = $_GET['id'] ?? null;
        if ($book_id) {
            $book = $this->bookModel->getBookById($book_id);
            if ($book) {
                // Get category name
                $categories = $this->bookModel->getCategories();
                $category_name = 'Umum';
                foreach ($categories as $cat) {
                    if ($cat['id'] == $book['category_id']) {
                        $category_name = $cat['name'];
                        break;
                    }
                }
                $book['category_name'] = $category_name;

                // Get reviews
                $db = new Database();
                $db->query("SELECT reviews.*, users.name as user_name FROM reviews 
                            JOIN users ON reviews.user_id = users.id 
                            WHERE reviews.book_id = :book_id ORDER BY reviews.created_at DESC");
                $db->bind(':book_id', $book_id);
                $reviews = $db->resultSet();

                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'book' => $book,
                    'reviews' => $reviews
                ]);
                exit();
            }
        }
        
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Invalid Request']);
        exit();
    }
}