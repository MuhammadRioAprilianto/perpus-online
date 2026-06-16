<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Peminjaman - Admin</title>
    <link rel="icon" type="image/png" href="/perpus-online/public/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        base: '#F8FAFC',
                        main: '#0F172A',
                        primary: '#4F46E5',
                        accent: '#F59E0B',
                        card: '#FFFFFF'
                    },
                    borderRadius: {
                        '3xl': '1.5rem',
                        '4xl': '2rem'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }
    </style>
</head>
<body class="bg-base text-main antialiased selection:bg-primary selection:text-white">
    
    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-white shadow-sm border-r border-slate-100 min-h-screen p-6 flex flex-col">
            <div class="font-extrabold text-2xl text-primary mb-10 tracking-tight">
                📚 Perpus<span class="text-accent">Online</span>
            </div>
            
            <nav class="space-y-2 flex-grow">
                <a href="/perpus-online/public/admin/dashboard" 
                   class="block p-3.5 rounded-2xl font-bold transition-all duration-300 <?= (strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' ?>">
                    📊 Dashboard
                </a>
                <a href="/perpus-online/public/admin/books" 
                   class="block p-3.5 rounded-2xl font-bold transition-all duration-300 <?= (strpos($_SERVER['REQUEST_URI'], 'books') !== false) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' ?>">
                    📖 Manajemen Buku
                </a>
                <a href="/perpus-online/public/admin/loans" 
                   class="block p-3.5 rounded-2xl font-bold transition-all duration-300 <?= (strpos($_SERVER['REQUEST_URI'], 'loans') !== false) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' ?>">
                    📋 Validasi Peminjaman
                </a>
            </nav>
            
            <div class="pt-6 border-t border-slate-100">
                <a href="/perpus-online/public/logout" class="block p-3.5 rounded-2xl text-red-500 hover:bg-red-50 transition-all font-bold text-sm">
                    🚪 Logout Admin
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-12">
            
            <div class="mb-10">
                <span class="bg-primary/10 text-primary text-xs font-bold px-3.5 py-1.5 rounded-xl uppercase tracking-wider mb-2.5 inline-block">
                    Peminjaman Sirkulasi
                </span>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Validasi Transaksi Peminjaman</h1>
                <p class="text-slate-400 text-sm mt-1.5">Setujui peminjaman baru, kelola denda, dan verifikasi bukti transfer deposit.</p>
            </div>

            <!-- Alerts -->
            <?php if(isset($_GET['status'])): ?>
                <?php if($_GET['status'] == 'success'): ?>
                    <div class="mb-8 p-5 bg-emerald-50 text-emerald-800 rounded-3xl border border-emerald-100 flex items-center gap-2 text-sm font-semibold">
                        <span>✅</span> Transaksi berhasil diproses!
                    </div>
                <?php elseif($_GET['status'] == 'out_of_stock'): ?>
                    <div class="mb-8 p-5 bg-rose-50 text-rose-800 rounded-3xl border border-rose-100 flex items-center gap-2 text-sm font-semibold">
                        <span>⚠️</span> Gagal menyetujui peminjaman: Salah satu buku tidak memiliki cukup stok!
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Table Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr class="text-slate-550">
                                <th class="p-5 font-bold text-xs uppercase tracking-wider">Member & Buku</th>
                                <th class="p-5 font-bold text-xs uppercase tracking-wider">Waktu Peminjaman</th>
                                <th class="p-5 font-bold text-xs uppercase tracking-wider text-center">Deposit & Denda</th>
                                <th class="p-5 font-bold text-xs uppercase tracking-wider">Bukti Transfer</th>
                                <th class="p-5 font-bold text-xs uppercase tracking-wider">Status</th>
                                <th class="p-5 font-bold text-xs uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if(empty($loans)): ?>
                                <tr><td colspan="6" class="p-16 text-center text-slate-400 italic font-medium">Belum ada data transaksi peminjaman.</td></tr>
                            <?php else: ?>
                                <?php foreach($loans as $loan): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    
                                    <!-- Member & Buku -->
                                    <td class="p-5">
                                        <p class="font-bold text-slate-800 text-base leading-snug"><?= htmlspecialchars($loan['user_name']) ?></p>
                                        <div class="text-xs text-slate-400 font-semibold mt-2 space-y-0.5">
                                            <?php foreach($loan['books'] as $b): ?>
                                                <p>• <?= htmlspecialchars($b['title']) ?> <span class="text-slate-300 font-normal">oleh <?= htmlspecialchars($b['author']) ?></span></p>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    
                                    <!-- Waktu Peminjaman -->
                                    <td class="p-5 text-xs space-y-1 font-semibold text-slate-550">
                                        <p><span class="text-slate-400 font-medium">Ambil:</span> <span class="text-slate-800"><?= date('d M Y', strtotime($loan['pickup_date'])) ?></span></p>
                                        <p><span class="text-slate-400 font-medium">Tempo:</span> <span class="text-slate-800"><?= date('d M Y', strtotime($loan['due_date'])) ?></span></p>
                                        <?php if($loan['return_date']): ?>
                                            <p><span class="text-slate-400 font-medium">Kembali:</span> <span class="text-emerald-600"><?= date('d M Y', strtotime($loan['return_date'])) ?></span></p>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Deposit & Denda -->
                                    <td class="p-5 text-center text-xs font-bold">
                                        <p class="text-primary">Jaminan: Rp <?= number_format($loan['deposit_amount'], 0, ',', '.') ?></p>
                                        <?php if((float)$loan['fine_amount'] > 0): ?>
                                            <p class="text-rose-500 mt-1">Denda: Rp <?= number_format($loan['fine_amount'], 0, ',', '.') ?></p>
                                        <?php else: ?>
                                            <p class="text-slate-400 mt-1 font-semibold">Denda: Rp 0</p>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Bukti Transfer -->
                                    <td class="p-5">
                                        <?php if($loan['payment_proof']): ?>
                                            <a href="/perpus-online/public/uploads/receipts/<?= htmlspecialchars($loan['payment_proof']) ?>" target="_blank" 
                                               class="text-primary hover:text-opacity-80 font-bold text-xs transition-colors">Lihat Bukti</a>
                                        <?php else: ?>
                                            <span class="text-slate-350 text-xs">-</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Status -->
                                    <td class="p-5">
                                        <?php
                                            $badgeColor = 'bg-slate-100 text-slate-700';
                                            if ($loan['status'] == 'pending') $badgeColor = 'bg-amber-100 text-amber-700';
                                            elseif ($loan['status'] == 'approved') $badgeColor = 'bg-emerald-100 text-emerald-700';
                                            elseif ($loan['status'] == 'returned') $badgeColor = 'bg-blue-100 text-blue-700';
                                            elseif ($loan['status'] == 'late') $badgeColor = 'bg-rose-100 text-rose-700';
                                            elseif ($loan['status'] == 'rejected') $badgeColor = 'bg-rose-100 text-rose-700';
                                        ?>
                                        <span class="px-3.5 py-1.5 rounded-xl text-[10px] font-extrabold uppercase tracking-wider <?= $badgeColor ?>">
                                            <?= htmlspecialchars($loan['status']) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Aksi -->
                                    <td class="p-5 text-center">
                                        <?php if($loan['status'] == 'pending'): ?>
                                            <div class="flex flex-col sm:flex-row gap-2 justify-center items-center">
                                                <a href="/perpus-online/public/admin/loans/approve?id=<?= $loan['id'] ?>&status=approved" 
                                                   class="bg-emerald-50 text-emerald-600 px-3 py-2 rounded-xl font-bold text-xs hover:bg-emerald-100 transition-all inline-block">Approve</a>
                                                <a href="/perpus-online/public/admin/loans/approve?id=<?= $loan['id'] ?>&status=rejected" 
                                                   class="bg-rose-50 text-rose-600 px-3 py-2 rounded-xl font-bold text-xs hover:bg-rose-100 transition-all inline-block">Reject</a>
                                            </div>
                                        <?php elseif($loan['status'] == 'approved'): ?>
                                            <a href="/perpus-online/public/admin/loans/return?id=<?= $loan['id'] ?>" 
                                               onclick="return confirm('Konfirmasi pengembalian buku ini?')"
                                               class="bg-blue-50 text-blue-600 px-5 py-2.5 rounded-xl font-bold text-xs hover:bg-blue-100 transition-all shadow-sm inline-block">
                                                Konfirmasi Kembali
                                            </a>
                                        <?php else: ?>
                                            <span class="text-slate-350 text-xs font-bold">Selesai</span>
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