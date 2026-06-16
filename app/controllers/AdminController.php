<?php

class AdminController {
    public function index() {
        // Nanti di sini kita bisa ambil data statistik (misal: total buku, total pinjaman)
        // Untuk sekarang, kita langsung panggil view dasbornya saja
        require_once '../app/views/admin/dashboard.php';
    }
}