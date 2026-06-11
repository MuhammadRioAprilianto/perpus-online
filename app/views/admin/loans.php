<?php ob_start(); ?>

<div class="flex flex-col md:flex-row md:space-x-6">
    <aside class="w-full md:w-64 bg-white p-6 border rounded-xl shadow-sm mb-6 md:mb-0 h-fit">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Menu Admin</h2>
        <nav class="space-y-2">
            <a href="<?= BASEURL ?>/admin/dashboard" class="block px-4 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition">Dashboard</a>
            <a href="<?= BASEURL ?>/admin/books" class="block px-4 py-2 rounded-md text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition">Manajemen Buku</a>
            <a href="<?= BASEURL ?>/admin/loans" class="block px-4 py-2 rounded-md bg-blue-50 text-blue-700 font-semibold">Manajemen Peminjaman</a>
        </nav>
    </aside>

    <section class="flex-grow">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Log Aktivitas Peminjaman</h1>
            <p class="text-gray-500 mt-1">Konfirmasi permintaan sirkulasi buku dan atur durasi pengembalian secara digital.</p>
        </div>

        <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Peminjam / Buku</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu Pengajuan</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tenggat Waktu</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    <?php foreach($loans as $loan): ?>
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">@<?= $loan['username'] ?></div>
                                <div class="text-gray-500 text-xs">Buku: <?= $loan['title'] ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                <?= formatTanggal($loan['request_time']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                <?= $loan['due_date'] ? formatTanggal($loan['due_date']) : '<span class="text-gray-400 italic">Belum diatur</span>' ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($loan['status'] === 'pending'): ?>
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                <?php elseif($loan['status'] === 'approved'): ?>
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Dipinjam</span>
                                <?php elseif($loan['status'] === 'returned'): ?>
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Kembali</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Batal (15m)</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <?php if($loan['status'] === 'pending'): ?>
                                    <form action="<?= BASEURL ?>/admin/loans/approve" method="POST" class="inline-flex items-center space-x-2">
                                        <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                        <input type="number" name="duration" value="7" min="1" title="Durasi Hari" class="w-12 px-1 py-1 border text-center rounded text-xs focus:ring-1 focus:ring-blue-500">
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-2 py-1 rounded transition">
                                            Setujui
                                        </button>
                                    </form>
                                <?php elseif($loan['status'] === 'approved'): ?>
                                    <form action="<?= BASEURL ?>/admin/loans/return" method="POST" class="inline-block">
                                        <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded transition">
                                            Selesai Kembali
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<?php 
$content = ob_get_clean(); 
require_once '../app/views/layouts/main.php'; 
?>