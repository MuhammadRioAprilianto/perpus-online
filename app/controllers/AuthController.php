<?php

class AuthController {
    private $userModel;

    public function __construct() {
        // Panggil UserModel yang sudah kita perbarui sebelumnya
        require_once '../app/models/UserModel.php';
        $this->userModel = new UserModel();
        
        // Pastikan session sudah berjalan di setiap proses auth
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Menangani halaman dan proses Login
    public function login() {
        // Jika user sudah login, tendang sesuai role-nya
        if (isset($_SESSION['user_id'])) {
            $this->redirectBasedOnRole();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitasi input email
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            // Cari user berdasarkan email
            $user = $this->userModel->findByEmail($email);

            // Verifikasi password yang di-hash (krusial untuk keamanan)
            if ($user && password_verify($password, $user['password'])) {
                // Set variabel session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_name'] = $user['name'];

                $this->redirectBasedOnRole();
            } else {
                // Jika gagal, kembalikan ke halaman login dengan pesan error
                header("Location: /perpus-online/public/login?status=error");
                exit();
            }
        } else {
            // Tampilkan view form login
            require_once '../app/views/auth/login.php';
        }
    }

    // Menangani halaman dan proses Register (Khusus Member)
    public function register() {
        if (isset($_SESSION['user_id'])) {
            $this->redirectBasedOnRole();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Validasi password match
            if ($password !== $confirm_password) {
                header("Location: /perpus-online/public/register?status=password_mismatch");
                exit();
            }

            // Cek apakah email sudah terdaftar
            if ($this->userModel->findByEmail($email)) {
                header("Location: /perpus-online/public/register?status=email_exists");
                exit();
            }

            // Eksekusi registrasi
            if ($this->userModel->register($name, $email, $password)) {
                header("Location: /perpus-online/public/login?status=registered");
            } else {
                header("Location: /perpus-online/public/register?status=error");
            }
            exit();
        } else {
            // Tampilkan view form register
            require_once '../app/views/auth/register.php';
        }
    }

    // Menangani proses Logout
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Hapus semua data session
        $_SESSION = array();
        session_destroy();
        
        // Redirect ke halaman utama / login
        header("Location: /perpus-online/public/login");
        exit();
    }

    // Fungsi helper untuk routing otomatis berdasarkan role
    private function redirectBasedOnRole() {
        if ($_SESSION['user_role'] == 'admin') {
            header("Location: /perpus-online/public/admin/dashboard");
        } else {
            header("Location: /perpus-online/public/");
        }
        exit();
    }
}