<?php ob_start(); ?>

<div class="flex flex-col md:flex-row md:space-x-6">
    <aside class="w-full md:w-64 bg-white p-6 border rounded-xl shadow-sm mb-6 md:mb-0 h-fit">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Menu Admin</h2>
        <nav class="space-y-2">
            <a href="<?= BASEURL ?>/admin/dashboard" class="block px-4 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition">Dashboard</a>
            <a href="<?= BASEURL ?>/admin/books" class="block px-4 py-2 rounded-md bg-blue-50 text-blue-700 font-semibold">Manajemen Buku</a>
            <a href="<?= BASEURL ?>/admin/loans" class="block px-4 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition">Manajemen Peminjaman</a>
        </nav>
    </aside>

    <section class="flex-grow">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Manajemen Koleksi Buku</h1>
                <p class="text-gray-500 mt-1">Tambah, perbarui, atau hapus katalog buku perpustakaan.</p>
            </div>
            <a href="#form-buku" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium text-sm transition">
                + Tambah Buku Baru
            </a>
        </div>

        <div class="bg-white border rounded-xl shadow-sm overflow-hidden mb-8">
            <table class="min-w-full divide-y divide-gray-200 text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Cover</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Judul / Penulis</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    <?php foreach($books as $book): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="<?= asset('uploads/books/' . $book['cover_image']) ?>" class="w-12 h-16 object-cover rounded border bg-gray-100">
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900"><?= $book['title'] ?></div>
                                <div class="text-gray-500 text-xs"><?= $book['author'] ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">
                                <?= $book['stock'] ?> Eks.
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                                <form action="<?= BASEURL ?>/admin/books/delete" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                    <input type="hidden" name="id" value="<?= $book['id'] ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="form-buku" class="bg-white border rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Form Data Buku</h3>
            <form action="<?= BASEURL ?>/admin/books/add" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul Buku</label>
                        <input type="text" name="title" required class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Penulis</label>
                        <input type="text" name="author" required class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Stok</label>
                        <input type="number" name="stock" min="1" required class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">File Gambar Cover (Aset Lokal)</label>
                        <input type="file" name="cover_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>
                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium text-sm transition">
                        Simpan Data Buku
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

<?php 
$content = ob_get_clean(); 
require_once '../app/views/layouts/main.php'; 
?>