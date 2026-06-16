<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Peminjaman - Admin</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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
        }
    </style>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 antialiased selection:bg-primary selection:text-white transition-colors duration-300">
    
    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-white dark:bg-slate-900 shadow-sm border-r border-slate-200 dark:border-slate-800 p-6 flex flex-col transition-colors">
            <div class="font-extrabold text-2xl text-primary dark:text-indigo-400 mb-10 tracking-tight flex items-center justify-between">
                <span>Perpus<span class="text-accent">Online</span></span>
                
                <!-- Theme Toggle Button Mobile -->
                <button onclick="toggleDarkMode()" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 transition-colors md:hidden" title="Ubah Tema">
                    <svg id="theme-icon-sun-mob" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                    <svg id="theme-icon-moon-mob" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
            </div>
            
            <nav class="space-y-2 flex-grow">
                <a href="<?= BASE_URL ?>/admin/dashboard" 
                   class="flex items-center gap-3 p-3.5 rounded-2xl font-bold transition-all duration-300 <?= (strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white' ?>">
                    <?= renderIcon('dashboard', 'w-5 h-5') ?>
                    <span>Dashboard</span>
                </a>
                <a href="<?= BASE_URL ?>/admin/books" 
                   class="flex items-center gap-3 p-3.5 rounded-2xl font-bold transition-all duration-300 <?= (strpos($_SERVER['REQUEST_URI'], 'books') !== false) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white' ?>">
                    <?= renderIcon('tag', 'w-5 h-5') ?>
                    <span>Manajemen Buku</span>
                </a>
                <a href="<?= BASE_URL ?>/admin/loans" 
                   class="flex items-center gap-3 p-3.5 rounded-2xl font-bold transition-all duration-300 <?= (strpos($_SERVER['REQUEST_URI'], 'loans') !== false) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white' ?>">
                    <?= renderIcon('clipboard', 'w-5 h-5') ?>
                    <span>Validasi Peminjaman</span>
                </a>
            </nav>
            
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-4">
                <!-- Theme Toggle Desktop -->
                <button onclick="toggleDarkMode()" class="hidden md:flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 transition-colors font-bold text-sm" title="Ubah Tema">
                    <span>Ubah Tema</span>
                    <span class="w-5 h-5 flex items-center justify-center">
                        <svg id="theme-icon-sun" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                        <svg id="theme-icon-moon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                </button>

                <a href="<?= BASE_URL ?>/logout" class="flex items-center gap-3 p-3.5 rounded-2xl text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all font-bold text-sm">
                    <?= renderIcon('logout', 'w-5 h-5 text-red-500') ?>
                    <span>Keluar</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Container -->
        <div class="flex-grow flex flex-col min-h-screen">
            <main class="flex-grow p-6 md:p-12">
                
                <div class="mb-10">
                    <span class="bg-primary/10 text-primary dark:text-indigo-400 text-xs font-bold px-3.5 py-1.5 rounded-xl uppercase tracking-wider mb-2.5 inline-block">
                        Peminjaman Sirkulasi
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Validasi Transaksi Peminjaman</h1>
                    <p class="text-slate-400 dark:text-slate-400 text-sm mt-1.5 font-medium">Setujui peminjaman baru, kelola denda, dan verifikasi bukti transfer deposit.</p>
                </div>

                <!-- Alerts -->
                <?php if(isset($_GET['status'])): ?>
                    <?php if($_GET['status'] == 'success'): ?>
                        <div class="mb-8 p-5 bg-emerald-50 dark:bg-emerald-950/20 text-emerald-800 dark:text-emerald-400 rounded-3xl border border-emerald-100 dark:border-emerald-900/40 flex items-center gap-2.5 text-sm font-semibold">
                            <span class="text-emerald-500 w-5 h-5 flex-shrink-0">
                                <?= renderIcon('check-circle', 'w-5 h-5') ?>
                            </span>
                            <span>Transaksi berhasil diproses!</span>
                        </div>
                    <?php elseif($_GET['status'] == 'out_of_stock'): ?>
                        <div class="mb-8 p-5 bg-rose-50 dark:bg-rose-900/20 text-rose-800 dark:text-rose-400 rounded-3xl border border-rose-100 dark:border-rose-900/40 flex items-center gap-2.5 text-sm font-semibold">
                            <span class="text-rose-500 w-5 h-5 flex-shrink-0">
                                <?= renderIcon('warning', 'w-5 h-5') ?>
                            </span>
                            <span>Gagal menyetujui peminjaman: Salah satu buku tidak memiliki cukup stok!</span>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Table Card -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-900/80 border-b border-slate-200 dark:border-slate-800">
                                    <th class="p-5 font-bold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Member & Buku</th>
                                    <th class="p-5 font-bold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Waktu Peminjaman</th>
                                    <th class="p-5 font-bold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider text-center">Deposit & Denda</th>
                                    <th class="p-5 font-bold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Bukti Transfer</th>
                                    <th class="p-5 font-bold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">Status</th>
                                    <th class="p-5 font-bold text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                                <?php if(empty($loans)): ?>
                                    <tr><td colspan="6" class="p-16 text-center text-slate-400 dark:text-slate-500 italic font-semibold">Belum ada data transaksi peminjaman.</td></tr>
                                <?php else: ?>
                                    <?php foreach($loans as $loan): ?>
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                                        
                                        <!-- Member & Buku -->
                                        <td class="p-5">
                                            <p class="font-bold text-slate-800 dark:text-slate-200 text-base leading-snug"><?= htmlspecialchars($loan['user_name']) ?></p>
                                            <div class="text-xs text-slate-400 dark:text-slate-400 font-semibold mt-2 space-y-0.5">
                                                <?php foreach($loan['books'] as $b): ?>
                                                    <p>• <?= htmlspecialchars($b['title']) ?> <span class="text-slate-400 dark:text-slate-500 font-normal">oleh <?= htmlspecialchars($b['author']) ?></span></p>
                                                <?php endforeach; ?>
                                            </div>
                                        </td>
                                        
                                        <!-- Waktu Peminjaman -->
                                        <td class="p-5 text-xs space-y-1 font-semibold text-slate-500 dark:text-slate-400">
                                            <p><span class="text-slate-400 dark:text-slate-500 font-medium">Ambil:</span> <span class="text-slate-800 dark:text-slate-200"><?= date('d M Y', strtotime($loan['pickup_date'])) ?></span></p>
                                            <p><span class="text-slate-500 dark:text-slate-500 font-medium">Tempo:</span> <span class="text-slate-800 dark:text-slate-200"><?= date('d M Y', strtotime($loan['due_date'])) ?></span></p>
                                            <?php if($loan['return_date']): ?>
                                                <p><span class="text-slate-500 dark:text-slate-500 font-medium">Kembali:</span> <span class="text-emerald-600 dark:text-emerald-400"><?= date('d M Y', strtotime($loan['return_date'])) ?></span></p>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Deposit & Denda -->
                                        <td class="p-5 text-center text-xs font-bold">
                                            <p class="text-primary dark:text-indigo-400">Jaminan: Rp <?= number_format($loan['deposit_amount'], 0, ',', '.') ?></p>
                                            <?php if((float)$loan['fine_amount'] > 0): ?>
                                                <p class="text-rose-500 dark:text-rose-400 mt-1">Denda: Rp <?= number_format($loan['fine_amount'], 0, ',', '.') ?></p>
                                            <?php else: ?>
                                                <p class="text-slate-400 dark:text-slate-500 mt-1 font-semibold">Denda: Rp 0</p>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <!-- Bukti Transfer -->
                                        <td class="p-5">
                                            <?php if($loan['payment_proof']): ?>
                                                <a href="<?= BASE_URL ?>/uploads/receipts/<?= htmlspecialchars($loan['payment_proof']) ?>" target="_blank" 
                                                   class="text-primary hover:text-opacity-80 dark:text-indigo-400 font-bold text-xs transition-colors">Lihat Bukti</a>
                                            <?php else: ?>
                                                <span class="text-slate-300 dark:text-slate-600 text-xs">-</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <!-- Status -->
                                        <td class="p-5">
                                            <?php
                                                $badgeColor = 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300';
                                                if ($loan['status'] == 'pending') $badgeColor = 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-400';
                                                elseif ($loan['status'] == 'approved') $badgeColor = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400';
                                                elseif ($loan['status'] == 'returned') $badgeColor = 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-400';
                                                elseif ($loan['status'] == 'late') $badgeColor = 'bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:text-rose-400';
                                                elseif ($loan['status'] == 'rejected') $badgeColor = 'bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:text-rose-400';
                                            ?>
                                            <span class="px-3.5 py-1.5 rounded-xl text-[10px] font-extrabold uppercase tracking-wider <?= $badgeColor ?>">
                                                <?= htmlspecialchars($loan['status']) ?>
                                            </span>
                                        </td>
                                        
                                        <!-- Aksi -->
                                        <td class="p-5 text-center">
                                            <?php if($loan['status'] == 'pending'): ?>
                                                <div class="flex flex-col sm:flex-row gap-2 justify-center items-center">
                                                    <a href="<?= BASE_URL ?>/admin/loans/approve?id=<?= $loan['id'] ?>&status=approved" 
                                                       class="bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/20 dark:hover:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 px-3 py-2 rounded-xl font-bold text-xs transition-all inline-block">Approve</a>
                                                    <a href="<?= BASE_URL ?>/admin/loans/approve?id=<?= $loan['id'] ?>&status=rejected" 
                                                       class="bg-rose-50 hover:bg-rose-100 dark:bg-rose-900/20 dark:hover:bg-rose-900/40 text-rose-600 dark:text-rose-400 px-3 py-2 rounded-xl font-bold text-xs transition-all inline-block">Reject</a>
                                                </div>
                                            <?php elseif($loan['status'] == 'approved'): ?>
                                                <a href="<?= BASE_URL ?>/admin/loans/return?id=<?= $loan['id'] ?>" 
                                                   onclick="return confirm('Konfirmasi pengembalian buku ini?')"
                                                   class="bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 text-blue-600 dark:text-blue-400 px-5 py-2.5 rounded-xl font-bold text-xs transition-all shadow-sm inline-block">
                                                    Konfirmasi Kembali
                                                </a>
                                            <?php else: ?>
                                                <span class="text-slate-300 dark:text-slate-500 text-xs font-bold">Selesai</span>
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

            <!-- Admin Footer -->
            <?php require APP_ROOT . '/views/components/footer.php'; ?>
        </div>
    </div>

    <script>
        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            const sunIcon = document.getElementById('theme-icon-sun');
            const moonIcon = document.getElementById('theme-icon-moon');
            const sunIconMob = document.getElementById('theme-icon-sun-mob');
            const moonIconMob = document.getElementById('theme-icon-moon-mob');
            
            if (sunIcon && moonIcon) {
                if (isDark) {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                } else {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                }
            }
            if (sunIconMob && moonIconMob) {
                if (isDark) {
                    sunIconMob.classList.remove('hidden');
                    moonIconMob.classList.add('hidden');
                } else {
                    sunIconMob.classList.add('hidden');
                    moonIconMob.classList.remove('hidden');
                }
            }
        }

        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
            updateThemeIcons();
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateThemeIcons();
        });
    </script>
</body>
</html>

