<?php
// Script Diagnostik Deploy cPanel
header('Content-Type: text/plain; charset=utf-8');

echo "=== DIAGNOSTIK SERVER CPANEL ===\n\n";

echo "1. INFORMASI HOST & PATH\n";
echo "HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'Tidak terdeteksi') . "\n";
echo "DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Tidak terdeteksi') . "\n";
echo "CURRENT FILE PATH: " . __FILE__ . "\n";
echo "CURRENT DIR PATH: " . __DIR__ . "\n";
echo "PHP VERSION: " . phpversion() . "\n\n";

echo "2. PENGECEKAN PATH DI SEKITAR\n";
$parentDir = dirname(__DIR__);
echo "Parent Dir (satu tingkat di atas): " . $parentDir . "\n";

$possibleAppPath = dirname($parentDir) . '/app';
echo "Apakah ada folder '/app' di luar web root? : " . (is_dir($possibleAppPath) ? 'YA (Ditemukan)' : 'TIDAK Ditemukan') . " (Dicari di: $possibleAppPath)\n";

$alternativeAppPath = $parentDir . '/app';
echo "Apakah ada folder '/app' di tingkat yang sama? : " . (is_dir($alternativeAppPath) ? 'YA (Ditemukan)' : 'TIDAK Ditemukan') . " (Dicari di: $alternativeAppPath)\n\n";

echo "3. UJI KONEKSI DATABASE\n";
// Ambil konfigurasi database jika filenya ada
$dbConfigPath = is_dir($possibleAppPath) ? $possibleAppPath . '/config/database.php' : (is_dir($alternativeAppPath) ? $alternativeAppPath . '/config/database.php' : null);

if ($dbConfigPath && file_exists($dbConfigPath)) {
    echo "Membaca file database.php...\n";
    // Cari define DB di file tanpa require agar tidak memicu error fatal
    $content = file_get_contents($dbConfigPath);
    preg_match_all("/define\(\s*['\"](DB_[A-Z]+)['\"]\s*,\s*['\"](.*?)['\"]\s*\)/", $content, $matches);
    
    $db_host = 'localhost';
    $db_user = '';
    $db_pass = '';
    $db_name = '';
    
    if (!empty($matches[1])) {
        $configs = array_combine($matches[1], $matches[2]);
        $db_host = $configs['DB_HOST'] ?? 'localhost';
        $db_user = $configs['DB_USER'] ?? '';
        $db_pass = $configs['DB_PASS'] ?? '';
        $db_name = $configs['DB_NAME'] ?? '';
        
        echo "Kredensial Terdeteksi (Mode cPanel/Production):\n";
        echo "- Host: $db_host\n";
        echo "- User: $db_user\n";
        echo "- DB Name: $db_name\n";
        
        try {
            $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 5
            ];
            $pdo = new PDO($dsn, $db_user, $db_pass, $options);
            echo "KONEKSI DATABASE BERHASIL!\n";
        } catch (Exception $e) {
            echo "KONEKSI DATABASE GAGAL: " . $e->getMessage() . "\n";
        }
    } else {
        echo "Gagal mengekstrak kredensial dari database.php (format mungkin dinamis)\n";
        // Coba require_once jika aman
        try {
            require_once $dbConfigPath;
            echo "Kredensial Terdefinisi:\n";
            echo "- DB_HOST: " . (defined('DB_HOST') ? DB_HOST : 'Belum di-define') . "\n";
            echo "- DB_USER: " . (defined('DB_USER') ? DB_USER : 'Belum di-define') . "\n";
            echo "- DB_NAME: " . (defined('DB_NAME') ? DB_NAME : 'Belum di-define') . "\n";
            
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 5];
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            echo "KONEKSI DATABASE BERHASIL (via require)!\n";
        } catch (Exception $e) {
            echo "KONEKSI DATABASE GAGAL (via require): " . $e->getMessage() . "\n";
        }
    }
} else {
    echo "File database.php tidak ditemukan di path mana pun.\n";
}
