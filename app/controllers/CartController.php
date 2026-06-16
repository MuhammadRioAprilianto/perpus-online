<?php

class CartController {
    private $cartModel;

    public function __construct() {
        require_once '../app/models/Cart.php';
        $this->cartModel = new Cart();
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Menampilkan isi keranjang
    public function index() {
        // Hanya member yang boleh akses
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'member') {
            redirect('/login');
        }

        $userId = $_SESSION['user_id'];
        $cartItems = $this->cartModel->getCartItems($userId);
        
        require_once '../app/views/cart/index.php';
    }

    // Memproses penambahan buku ke keranjang
    public function add() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'member') {
            redirect('/login');
        }

        $userId = $_SESSION['user_id'];
        $bookId = $_GET['id'] ?? null;

        if ($bookId) {
            // 1. Cek apakah keranjang sudah penuh (Maks 3)
            $totalInCart = $this->cartModel->countUserCart($userId);
            if ($totalInCart >= 3) {
                redirect('/catalog?status=cart_full');
            }

            // 2. Cek apakah buku sudah ada di keranjang
            if ($this->cartModel->isBookInCart($userId, $bookId)) {
                redirect('/catalog?status=already_in_cart');
            }

            // 3. Tambahkan ke keranjang
            $this->cartModel->addToCart($userId, $bookId);
            // Kembalikan ke halaman utama (katalog) agar user bisa lanjut milih buku
            redirect('/catalog?status=added_to_cart');
        }

        redirect('/catalog');
    }

    // Menghapus buku dari keranjang
    public function remove() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'member') {
            redirect('/login');
        }

        $cartId = $_GET['id'] ?? null;
        $userId = $_SESSION['user_id'];

        if ($cartId) {
            $this->cartModel->removeFromCart($cartId, $userId);
        }

        redirect('/cart?status=removed');
    }

}