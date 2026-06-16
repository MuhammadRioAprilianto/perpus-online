<?php

class CheckoutController {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        // Keamanan: Hanya member yang boleh akses
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'member') {
            redirect('/login');
        }

        // Tangkap data dari form keranjang (via POST)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pickup_date = htmlspecialchars($_POST['pickup_date']);
            $deposit_amount = (int)$_POST['deposit_amount'];

            // Tampilkan halaman pembayaran
            require_once '../app/views/checkout/index.php';
        } else {
            // Jika ada yang mencoba akses URL /checkout langsung tanpa lewat keranjang, tendang kembali
            redirect('/cart');
        }
    }
}