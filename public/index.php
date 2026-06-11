<?php
// Mulai sesi aplikasi
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Memanggil konfigurasi dasar dan fungsi bantuan (helpers)
require_once '../app/config/app.php';
require_once '../app/config/database.php';
require_once '../app/helpers/env.php';
require_once '../app/helpers/functions.php';

// 2. Memanggil daftar rute yang terdaftar
require_once '../app/config/routes.php';

// 3. Menangkap URL yang diketik pengunjung di browser
// Jika URL kosong (halaman beranda utama), set menjadi string kosong ''
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';

// 4. Logika Router: Mengecek apakah URL ada di dalam daftar routes.php
if (array_key_exists($url, $routes)) {
    // Memecah nama Controller dan Method-nya
    $controllerName = $routes[$url][0];
    $methodName = $routes[$url][1];

    // Memuat file Controller dari folder app/controllers/
    require_once '../app/controllers/' . $controllerName . '.php';

    // Membuat instansiasi dari class Controller tersebut dan menjalankan method-nya
    $controller = new $controllerName();
    
    if (method_exists($controller, $methodName)) {
        $controller->$methodName();
    } else {
        die("Fatal Error: Method '$methodName' tidak ditemukan di dalam controller '$controllerName'.");
    }
} else {
    // 5. Jika URL tidak ditemukan di routes.php, tampilkan halaman 404 (Not Found)
    http_response_code(404);
    if (file_exists('../app/views/404.php')) {
        require_once '../app/views/404.php';
    } else {
        echo "<h1 style='text-align:center; margin-top:50px;'>404 - Halaman Tidak Ditemukan</h1>";
    }
}