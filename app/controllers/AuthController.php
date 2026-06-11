<?php
require_once '../app/models/UserModel.php';
require_once '../app/config/database.php';

class AuthController {
    private $userModel;

    public function __construct() {
        // Menginisiasi koneksi database dan Data Access Layer (DAL)
        $db = new Database();
        $this->userModel = new UserModel($db->getConnection());
    }

    // Menampilkan halaman login (Bisa digunakan bersama oleh Admin & User)
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Logika Bisnis: Jika sudah login, langsung alihkan sesuai role-nya
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role'] === 'admin') {
                header('Location: ' . BASEURL . '/admin/dashboard');
            } else {
                header('Location: ' . BASEURL . '/');
            }
            exit;
        }

        // Memanggil Presentation Layer (Tampilan Login)
        require_once '../app/views/auth/login.php';
    }

    // Memproses data form login
    public function processLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // Mengambil data dari DAL (Data Access Layer)
            $user = $this->userModel->findByUsername($username);

            // Logika Bisnis (BLL): Validasi akun dan kecocokan password_hash
            if ($user && password_verify($password, $user['password'])) {
                // Menyimpan data kredensial ke dalam Session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Pengalihan hak akses sesuai spesifikasi di dokumen
                if ($user['role'] === 'admin') {
                    header('Location: ' . BASEURL . '/admin/dashboard');
                } else {
                    header('Location: ' . BASEURL . '/');
                }
                exit;
            } else {
                // Jika gagal, kembalikan ke halaman login dengan pesan error
                header('Location: ' . BASEURL . '/login?error=invalid_credentials');
                exit;
            }
        }
    }

    // Menampilkan halaman registrasi akun untuk User (Pembaca)
    public function register() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/');
            exit;
        }

        // Memanggil Presentation Layer (Tampilan Register)
        require_once '../app/views/auth/register.php';
    }

    // Memproses pengajuan pembuatan akun baru oleh User
    public function processRegister() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // Logika Bisnis: Validasi apakah username sudah terdaftar atau belum
            $existingUser = $this->userModel->findByUsername($username);
            if ($existingUser) {
                header('Location: ' . BASEURL . '/register?error=username_taken');
                exit;
            }

            // Jika username aman, kirim data ke DAL untuk dieksekusi ke database
            if ($this->userModel->register($username, $password)) {
                header('Location: ' . BASEURL . '/login?success=registered');
                exit;
            } else {
                header('Location: ' . BASEURL . '/register?error=failed');
                exit;
            }
        }
    }

    // Memproses Logout aplikasi
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Hapus semua data session
        $_SESSION = [];
        session_destroy();

        // Alihkan kembali ke halaman login
        header('Location: ' . BASEURL . '/login');
        exit;
    }
}