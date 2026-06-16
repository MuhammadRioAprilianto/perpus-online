<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Pinjam - Perpus Online</title>
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
        html {
            color-scheme: light;
        }
        html.dark {
            color-scheme: dark;
        }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .dark .glass-nav {
            background: rgba(15, 23, 42, 0.8);
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
<body class="bg-slate-50 text-slate-900 dark:bg-slate-900 dark:text-slate-100 flex flex-col min-h-screen transition-colors duration-300">

    <nav class="glass-nav shadow-sm border-b border-slate-200/80 dark:border-slate-800 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="<?= BASE_URL ?>/" class="font-extrabold text-2xl text-primary dark:text-indigo-400 tracking-tight flex items-center gap-2">
                <span>Perpus<span class="text-accent">Online</span></span>
            </a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-500 dark:text-slate-400 font-medium hidden md:block">Halo, <span class="font-bold text-slate-800 dark:text-slate-200"><?= htmlspecialchars($_SESSION['user_name']) ?></span></span>
                <a href="<?= BASE_URL ?>/loans" class="text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-indigo-400 font-bold transition-colors text-sm flex items-center gap-2">
                    <?= renderIcon('clipboard', 'w-4 h-4') ?>
                    <span>Pinjamanku</span>
                </a>
                <a href="<?= BASE_URL ?>/cart" class="text-primary dark:text-indigo-400 font-bold relative flex items-center gap-2 text-sm">
                    <?= renderIcon('cart', 'w-4 h-4') ?>
                    <span>Keranjang</span>
                </a>
                <a href="<?= BASE_URL ?>/logout" class="text-red-500 hover:text-red-700 font-bold transition-colors text-sm">Logout</a>

                <!-- Theme Toggle Button -->
                <button onclick="toggleDarkMode()" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition-colors" title="Ubah Tema">
                    <svg id="theme-icon-sun" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                    <svg id="theme-icon-moon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        
        <!-- Progress Tracker -->
        <div class="max-w-3xl mx-auto mb-12">
            <div class="flex items-center justify-between relative">
                <!-- Line -->
                <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-1 bg-slate-200 dark:bg-slate-700 -z-10 rounded-full"></div>
                <div class="absolute left-0 w-1/2 top-1/2 -translate-y-1/2 h-1 bg-primary -z-10 rounded-full"></div>
                
                <!-- Steps -->
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold shadow-md shadow-primary/20 ring-4 ring-white dark:ring-slate-900 text-sm">1</div>
                    <span class="text-xs font-bold text-primary dark:text-indigo-400">Keranjang Pinjam</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 rounded-full flex items-center justify-center font-bold ring-4 ring-white dark:ring-slate-900 text-sm">2</div>
                    <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">Pembayaran Deposit</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 rounded-full flex items-center justify-center font-bold ring-4 ring-white dark:ring-slate-900 text-sm">3</div>
                    <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">Persetujuan Pustakawan</span>
                </div>
            </div>
        </div>

        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <a href="<?= BASE_URL ?>/" class="text-slate-400 dark:text-slate-400 hover:text-primary dark:hover:text-indigo-400 mb-3 inline-block font-semibold transition-colors text-sm">
                    &larr; Kembali ke Katalog
                </a>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Keranjang Peminjaman</h1>
                <p class="text-slate-400 dark:text-slate-400 text-sm mt-1">Sesuai peraturan perpustakaan, Anda dapat meminjam maksimal 3 judul buku sekaligus dalam satu pengajuan.</p>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Daftar Buku di Keranjang -->
            <div class="flex-grow space-y-4">
                <?php if(empty($cartItems)): ?>
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-12 text-center flex flex-col items-center justify-center">
                        <div class="w-16 h-16 text-slate-400 dark:text-slate-600 mb-6">
                            <?= renderIcon('cart', 'w-16 h-16') ?>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Keranjang Anda masih kosong</h3>
                        <p class="text-slate-400 dark:text-slate-400 mb-8 max-w-sm text-sm">Silakan jelajahi katalog buku kami untuk menambahkan buku yang ingin dipinjam.</p>
                        <a href="<?= BASE_URL ?>/" class="bg-primary hover:bg-opacity-95 text-white px-8 py-3.5 rounded-2xl font-bold transition-all duration-300 shadow-lg hover:-translate-y-0.5 text-sm">Kembali ke Katalog</a>
                    </div>
                <?php else: ?>
                    <?php foreach($cartItems as $item): ?>
                        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-5 flex gap-5 items-center transition-all hover:shadow-md hover:border-slate-200/55 dark:hover:border-slate-700 group">
                            
                            <div class="w-20 h-28 bg-slate-50 dark:bg-slate-900 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-100 dark:border-slate-700/50">
                                <?php if($item['cover_image']): ?>
                                    <img src="<?= BASE_URL ?>/uploads/books/<?= htmlspecialchars($item['cover_image']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-600 font-bold select-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="flex-1">
                                <span class="bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider">Buku Fisik</span>
                                <h3 class="font-bold text-lg text-slate-900 dark:text-white leading-snug mt-1.5 group-hover:text-primary dark:group-hover:text-indigo-400 transition-colors"><?= htmlspecialchars($item['title']) ?></h3>
                                <p class="text-xs text-slate-400 dark:text-slate-400 mt-1 font-semibold">penulis: <?= htmlspecialchars($item['author']) ?></p>
                            </div>

                            <div class="pr-2">
                                <a href="<?= BASE_URL ?>/cart/remove?id=<?= $item['cart_id'] ?>" 
                                   onclick="return confirm('Hapus buku ini dari keranjang?')"
                                   class="w-11 h-11 bg-rose-50 dark:bg-rose-900/20 text-rose-500 dark:text-rose-400 rounded-2xl flex items-center justify-center hover:bg-rose-500 hover:text-white dark:hover:bg-rose-600 transition-all duration-300 hover:shadow-lg" title="Hapus">
                                   <?= renderIcon('trash', 'w-5 h-5') ?>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Ringkasan Peminjaman -->
            <?php if(!empty($cartItems)): ?>
            <div class="w-full lg:w-96 flex-shrink-0">
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-6 sticky top-28 transition-colors">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-5 border-b border-slate-100 dark:border-slate-700 pb-4">Ringkasan</h2>
                    
                    <div class="flex justify-between items-center mb-3 text-sm">
                        <span class="text-slate-400 dark:text-slate-400 font-semibold">Total Buku</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200"><?= count($cartItems) ?> Buku</span>
                    </div>

                    <?php 
                        $depositPerBuku = 50000;
                        $totalDeposit = count($cartItems) * $depositPerBuku;
                    ?>
                    <div class="flex justify-between items-center mb-6 text-sm">
                        <span class="text-slate-400 dark:text-slate-400 font-semibold">Jaminan Deposit</span>
                        <span class="font-extrabold text-base text-primary dark:text-indigo-400">Rp <?= number_format($totalDeposit, 0, ',', '.') ?></span>
                    </div>

                    <div class="bg-blue-50/50 dark:bg-blue-950/20 text-blue-700 dark:text-blue-300 text-xs p-4 rounded-2xl mb-6 leading-relaxed border border-blue-100/50 dark:border-blue-900/50 flex gap-2.5 font-medium">
                        <span class="w-5 h-5 flex-shrink-0 text-blue-500">
                            <?= renderIcon('info', 'w-5 h-5') ?>
                        </span>
                        <span>Biaya jaminan akan dikembalikan penuh (100%) ketika seluruh buku dikembalikan tepat waktu dalam kondisi baik.</span>
                    </div>

                    <form action="<?= BASE_URL ?>/checkout" method="POST" class="space-y-5">
                        <div class="space-y-2">
                            <label for="pickup_date" class="block font-bold text-xs uppercase tracking-wider text-slate-400 dark:text-slate-400">Rencana Tanggal Pengambilan <span class="text-rose-500">*</span></label>
                            <input type="date" id="pickup_date" name="pickup_date" required min="<?= date('Y-m-d') ?>"
                                class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-900 text-sm text-slate-700 dark:text-slate-200 font-semibold">
                        </div>

                        <input type="hidden" name="deposit_amount" value="<?= $totalDeposit ?>">

                        <button type="submit" class="w-full bg-accent hover:bg-opacity-95 text-white font-bold py-4 rounded-2xl shadow-lg shadow-accent/20 transition-all duration-300 transform hover:-translate-y-0.5 flex justify-center items-center gap-2 text-sm">
                            Lanjut ke Pembayaran &rarr;
                        </button>
                    </form>

                </div>
            </div>
            <?php endif; ?>

        </div>
    </main>

    <!-- Footer -->
    <?php require APP_ROOT . '/views/components/footer.php'; ?>

    <script>
        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            const sunIcon = document.getElementById('theme-icon-sun');
            const moonIcon = document.getElementById('theme-icon-moon');
            if (sunIcon && moonIcon) {
                sunIcon.classList.remove('rotate-90', 'scale-100');
                moonIcon.classList.remove('-rotate-12', 'scale-100');

                if (isDark) {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                    setTimeout(() => {
                        sunIcon.classList.add('scale-100', 'rotate-90');
                    }, 50);
                } else {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                    setTimeout(() => {
                        moonIcon.classList.add('scale-100', '-rotate-12');
                    }, 50);
                }
            }
        }

        function toggleDarkMode() {
            const activeIcon = document.querySelector('#theme-icon-sun:not(.hidden), #theme-icon-moon:not(.hidden)');
            if (activeIcon) {
                activeIcon.classList.add('scale-75', 'rotate-45');
            }

            setTimeout(() => {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
                updateThemeIcons();
            }, 150);
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateThemeIcons();
        });
    </script>
</body>
</html>
