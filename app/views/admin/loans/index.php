<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Peminjaman - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { base: '#F5F2F2', main: '#2B2A2A', primary: '#5A7ACD', accent: '#FEB05D', } } }
        }
    </script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-base text-main antialiased">
    
    <div class="min-h-screen flex flex-col md:flex-row">
        
        <aside class="w-full md:w-64 bg-white shadow-sm border-r border-gray-100 min-h-screen p-6">
            <div class="font-bold text-2xl text-primary mb-8">
                Perpus<span class="text-accent">Online</span>
            </div>
            <nav class="space-y-2">
                <a href="/perpus-online/public/admin/dashboard" 
                   class="block p-3 rounded-xl transition-all text-gray-500 hover:bg-base">
                   Dashboard
                </a>
                <a href="/perpus-online/public/admin/books" 
                   class="block p-3 rounded-xl transition-all text-gray-500 hover:bg-base">
                   Manajemen Buku
                </a>
                <a href="/perpus-online/public/admin/loans" 
                   class="block p-3 rounded-xl transition-all bg-primary text-white shadow-md shadow-primary/30">
                   Peminjaman
                </a>
            </nav>
            <div class="mt-auto pt-8 border-t border-gray-100">
                <a href="/perpus-online/public/logout" class="block p-3 rounded-xl text-red-500 hover:bg-red-50 transition-all font-medium">
                    Logout
                </a>
            </div>
        </aside>

        <main class="flex-1 p-6 md:p-10">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight">Manajemen Peminjaman</h1>
                <p class="text-gray-500 mt-1">Validasi status peminjaman buku dari anggota.</p>
            </div>

            <?php if(isset($_GET['status'])): ?>
                <?php if($_GET['status'] == 'success'): ?>
                    <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-100 flex items-center">
                        <span>✅ Transaksi berhasil diproses!</span>
                    </div>
                <?php elseif($_GET['status'] == 'out_of_stock'): ?>
                    <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-150 flex items-center">
                        <span>⚠️ Gagal menyetujui peminjaman: Salah satu buku tidak memiliki cukup stok!</span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="p-4 text-sm font-semibold text-gray-500">Member & Buku</th>
                                <th class="p-4 text-sm font-semibold text-gray-500">Waktu Peminjaman</th>
                                <th class="p-4 text-sm font-semibold text-gray-500 text-center">Deposit & Denda</th>
                                <th class="p-4 text-sm font-semibold text-gray-500">Bukti Transfer</th>
                                <th class="p-4 text-sm font-semibold text-gray-500">Status</th>
                                <th class="p-4 text-sm font-semibold text-gray-500 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if(empty($loans)): ?>
                                <tr><td colspan="6" class="p-6 text-center text-gray-400 italic">Belum ada data peminjaman.</td></tr>
                            <?php else: ?>
                                <?php foreach($loans as $loan): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <!-- Member & Buku -->
                                    <td class="p-4">
                                        <p class="font-bold text-main"><?= htmlspecialchars($loan['user_name']) ?></p>
                                        <div class="text-xs text-gray-500 mt-1.5 space-y-0.5">
                                            <?php foreach($loan['books'] as $b): ?>
                                                <p>• <?= htmlspecialchars($b['title']) ?> <span class="italic text-gray-400">oleh <?= htmlspecialchars($b['author']) ?></span></p>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    
                                    <!-- Waktu Peminjaman -->
                                    <td class="p-4 text-xs space-y-1">
                                        <p><span class="text-gray-400">Ambil:</span> <span class="font-semibold text-main"><?= date('d M Y', strtotime($loan['pickup_date'])) ?></span></p>
                                        <p><span class="text-gray-400">Tempo:</span> <span class="font-semibold text-main"><?= date('d M Y', strtotime($loan['due_date'])) ?></span></p>
                                        <?php if($loan['return_date']): ?>
                                            <p><span class="text-gray-400">Kembali:</span> <span class="font-semibold text-green-600"><?= date('d M Y', strtotime($loan['return_date'])) ?></span></p>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Deposit & Denda -->
                                    <td class="p-4 text-center text-xs">
                                        <p class="font-semibold text-primary">Jaminan: Rp <?= number_format($loan['deposit_amount'], 0, ',', '.') ?></p>
                                        <?php if((float)$loan['fine_amount'] > 0): ?>
                                            <p class="font-semibold text-red-500 mt-1">Denda: Rp <?= number_format($loan['fine_amount'], 0, ',', '.') ?></p>
                                        <?php else: ?>
                                            <p class="text-gray-400 mt-1">Denda: Rp 0</p>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Bukti Transfer -->
                                    <td class="p-4">
                                        <?php if($loan['payment_proof']): ?>
                                            <a href="/perpus-online/public/uploads/receipts/<?= htmlspecialchars($loan['payment_proof']) ?>" target="_blank" 
                                               class="text-primary hover:text-accent font-medium text-sm transition-colors">Lihat Bukti</a>
                                        <?php else: ?>
                                            <span class="text-gray-400 text-xs">-</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Status -->
                                    <td class="p-4">
                                        <?php
                                            $badgeColor = 'bg-gray-100 text-gray-700';
                                            if ($loan['status'] == 'pending') $badgeColor = 'bg-yellow-100 text-yellow-700';
                                            elseif ($loan['status'] == 'approved') $badgeColor = 'bg-green-100 text-green-700';
                                            elseif ($loan['status'] == 'returned') $badgeColor = 'bg-blue-100 text-blue-700';
                                            elseif ($loan['status'] == 'late') $badgeColor = 'bg-red-100 text-red-700';
                                            elseif ($loan['status'] == 'rejected') $badgeColor = 'bg-red-100 text-red-700';
                                        ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase <?= $badgeColor ?>">
                                            <?= htmlspecialchars($loan['status']) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Aksi -->
                                    <td class="p-4 text-center">
                                        <?php if($loan['status'] == 'pending'): ?>
                                            <a href="/perpus-online/public/admin/loans/approve?id=<?= $loan['id'] ?>&status=approved" 
                                               class="bg-green-50 text-green-600 px-3 py-1.5 rounded-lg font-bold text-xs hover:bg-green-150 mr-2 transition-all inline-block">Approve</a>
                                            <a href="/perpus-online/public/admin/loans/approve?id=<?= $loan['id'] ?>&status=rejected" 
                                               class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg font-bold text-xs hover:bg-red-150 transition-all inline-block">Reject</a>
                                        <?php elseif($loan['status'] == 'approved'): ?>
                                            <a href="/perpus-online/public/admin/loans/return?id=<?= $loan['id'] ?>" 
                                               onclick="return confirm('Konfirmasi pengembalian buku ini?')"
                                               class="bg-blue-50 text-blue-600 px-4 py-2 rounded-xl font-bold text-xs hover:bg-blue-150 transition-all shadow-sm inline-block">
                                                Kembalikan
                                            </a>
                                        <?php else: ?>
                                            <span class="text-gray-300 text-xs font-medium">Selesai</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</body>
</html>