<?php ob_start(); ?>

<div class="flex flex-col md:flex-row md:space-x-6">
    <aside class="w-full md:w-64 bg-white p-6 border rounded-xl shadow-sm mb-6 md:mb-0 h-fit">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Menu Admin</h2>
        <nav class="space-y-2">
            <a href="<?= BASEURL ?>/admin/dashboard" class="block px-4 py-2 rounded-md bg-blue-50 text-blue-700 font-semibold">Dashboard</a>
            <a href="<?= BASEURL ?>/admin/books" class="block px-4 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition">Manajemen Buku</a>
            <a href="<?= BASEURL ?>/admin/loans" class="block px-4 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition">Manajemen Peminjaman</a>
        </nav>
    </aside>

    <section class="flex-grow">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Utama</h1>
            <p class="text-gray-500 mt-1">Selamat datang kembali, Admin. Berikut ringkasan aktivitas perpustakaan hari ini.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 border rounded-xl shadow-sm">
                <span class="block text-sm text-gray-500 font-medium">Total Koleksi Buku</span>
                <span class="block text-3xl font-bold text-gray-900 mt-2"><?= $stats['total_buku'] ?></span>
            </div>
            <div class="bg-white p-6 border rounded-xl shadow-sm">
                <span class="block text-sm text-gray-500 font-medium">Total Transaksi</span>
                <span class="block text-3xl font-bold text-gray-900 mt-2"><?= $stats['total_peminjaman'] ?></span>
            </div>
            <div class="bg-white p-6 border rounded-xl shadow-sm bg-yellow-50 border-yellow-200">
                <span class="block text-sm text-yellow-700 font-medium">Menunggu Konfirmasi</span>
                <span class="block text-3xl font-bold text-yellow-900 mt-2"><?= $stats['pending'] ?></span>
            </div>
            <div class="bg-white p-6 border rounded-xl shadow-sm bg-green-50 border-green-200">
                <span class="block text-sm text-green-700 font-medium">Sedang Dipinjam</span>
                <span class="block text-3xl font-bold text-green-900 mt-2"><?= $stats['disetujui'] ?></span>
            </div>
        </div>

        <div class="bg-white border rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Aktivitas Terkini</h3>
            <p class="text-sm text-gray-500">Silakan pilih menu <a href="<?= BASEURL ?>/admin/loans" class="text-blue-600 hover:underline">Manajemen Peminjaman</a> untuk memproses permintaan peminjaman baru dari pengguna atau memproses pengembalian buku.</p>
        </div>
    </section>
</div>

<?php 
$content = ob_get_clean(); 
require_once '../app/views/layouts/main.php'; 
?>