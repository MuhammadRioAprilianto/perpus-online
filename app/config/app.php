<?php
// Deteksi apakah sedang berjalan di local (localhost) atau di cPanel (production)
$isLocal = in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1', '::1']) || (isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] === '127.0.0.1');

if ($isLocal) {
    define('BASEURL', 'http://localhost/perpus-online/public');
    define('APP_ROOT', dirname(__DIR__));
    define('PUBLIC_ROOT', APP_ROOT . '/../public');
} else {
    // Pengaturan URL dan Path untuk cPanel Production (Dinamis)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] ?? 'perpus-online.pdwtiumy.click';
    define('BASEURL', $protocol . $host);
    
    // APP_ROOT selalu menunjuk ke absolute path folder app/ secara dinamis
    define('APP_ROOT', dirname(__DIR__));
    
    // PUBLIC_ROOT dideteksi berdasarkan struktur folder Anda di cPanel
    if (is_dir(dirname(__DIR__) . '/../public')) {
        // Jika menggunakan struktur utuh lokal (Pilihan A)
        define('PUBLIC_ROOT', dirname(__DIR__) . '/../public');
    } else {
        // Jika folder public dipisah / dimasukkan langsung ke domain root (Pilihan B)
        define('PUBLIC_ROOT', $_SERVER['DOCUMENT_ROOT'] ?? '/home/pdwp8946/public_html/perpus-online.pdwtiumy.click');
    }
}
define('BASE_URL', BASEURL);

// Nama Aplikasi
define('APP_NAME', 'Website Perpustakaan Online');

// Atur zona waktu ke WIB (penting untuk perhitungan timer 15 menit nanti)
date_default_timezone_set('Asia/Jakarta');