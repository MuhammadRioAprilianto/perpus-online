<?php
// Format routing: 'url/path' => ['NamaController', 'namaMethod']

$routes = [
    // --- Public / User Routes ---
    '' => ['HomeController', 'index'],                  // Halaman utama (Katalog Buku)
    'login' => ['AuthController', 'login'],             // Halaman Login User & Admin
    'register' => ['AuthController', 'register'],       // Halaman Register User
    'logout' => ['AuthController', 'logout'],           // Proses Logout

    // --- Loan Routes (Peminjaman) ---
    'loan/request' => ['LoanController', 'requestLoan'], // User mengajukan pinjaman
    'loans' => ['LoanController', 'myLoans'],            // Riwayat peminjaman user
    'loans/review' => ['LoanController', 'addReview'],   // Member menulis ulasan buku
    'book/detail' => ['BookController', 'detail'],       // Detail buku & ulasan (AJAX)
    
    // --- Admin Routes ---
    'admin/dashboard' => ['AdminController', 'index'],
    
    // Manajemen Buku (Admin)
    'admin/books' => ['BookController', 'index'],
    'admin/books/add' => ['BookController', 'add'],
    'admin/books/edit' => ['BookController', 'edit'],
    'admin/books/delete' => ['BookController', 'delete'],
    
    // Manajemen Peminjaman (Admin)
    'admin/loans' => ['LoanController', 'index'],
    'admin/loans/approve' => ['LoanController', 'approve'], // Konfirmasi pinjaman
    'admin/loans/return' => ['LoanController', 'returnBook'], // Konfirmasi pengembalian

    // Cart Routes (Keranjang) ---
    'cart' => ['CartController', 'index'],
    'cart/add' => ['CartController', 'add'],
    'cart/remove' => ['CartController', 'remove'],
    'checkout' => ['CheckoutController', 'index']
];