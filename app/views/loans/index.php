<?php ob_start(); ?>

<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Daftar Pinjamanku</h1>
            <p class="text-gray-500 mt-1">Pantau status pengajuan sirkulasi dan batas waktu pengambilan buku pilihanmu.</p>
        </div>
        <a href="<?= BASEURL ?>" class="text-sm font-medium text-blue-600 hover:text-blue-700 flex items-center transition">
            &larr; Kembali Cari Buku
        </a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'loan_success'): ?>
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6 text-sm flex items-center space-x-2 shadow-sm">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Pengajuan peminjaman online berhasil dikirim! [cite_start]Silakan ambil buku fisik ke petugas dalam waktu 15 menit[cite: 16].</span>
        </div>
    <?php endif; ?>

    <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
        <?php if (empty($myLoans)): ?>
            <div class="p-12 text-center text-gray-500">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <p class="font-medium text-gray-700">Kamu belum mengajukan peminjaman apa pun</p>
                <p class="text-sm text-gray-400 mt-1">Silakan pilih buku di katalog umum terlebih dahulu.</p>
            </div>
        <?php else: ?>
            <table class="min-w-full divide-y divide-gray-200 text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Buku Yang Dipinjam</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu Pengajuan</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Masa Berlaku / Tenggat</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Status Konfirmasi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    <?php foreach($myLoans as $loan): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-800">
                                <?= $loan['title'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                <?= formatTanggal($loan['request_time']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                <?php if($loan['status'] === 'pending'): ?>
                                    <?php $sisaMenit = sisaWaktuBatal($loan['request_time']); ?>
                                    <?php if($sisaMenit > 0): ?>
                                        <span class="text-amber-600 font-semibold flex items-center gap-1 animate-pulse">
                                            [cite_start]⌛ Ambil dalam <?= $sisaMenit ?> menit [cite: 16]
                                        </span>
                                    <?php else: ?>
                                        [cite_start]<span class="text-red-600 font-semibold">Waktu pengambilan habis [cite: 16]</span>
                                    <?php endif; ?>
                                <?php elseif($loan['status'] === 'approved'): ?>
                                    <span class="text-green-600 font-medium">Harus kembali: <?= formatTanggal($loan['due_date']) ?></span>
                                <?php elseif($loan['status'] === 'returned'): ?>
                                    <span class="text-gray-400 italic">Selesai dikembalikan</span>
                                <?php else: ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($loan['status'] === 'pending'): ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu Diambil</span>
                                <?php elseif($loan['status'] === 'approved'): ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Sedang Dipinjam</span>
                                <?php elseif($loan['status'] === 'returned'): ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Sudah Kembali</span>
                                <?php else: ?>
                                    [cite_start]<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600">Otomatis Dibatalkan [cite: 16]</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require_once '../app/views/layouts/main.php'; 
?>