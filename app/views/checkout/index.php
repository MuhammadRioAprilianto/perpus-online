<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Deposit - Perpus Online</title>
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

    <main class="flex-grow max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        
        <!-- Progress Tracker -->
        <div class="max-w-3xl mx-auto mb-12">
            <div class="flex items-center justify-between relative">
                <!-- Line -->
                <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-1 bg-slate-200 dark:bg-slate-700 -z-10 rounded-full"></div>
                <div class="absolute left-0 w-full top-1/2 -translate-y-1/2 h-1 bg-primary -z-10 rounded-full"></div>
                
                <!-- Steps -->
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold shadow-md shadow-primary/20 ring-4 ring-white dark:ring-slate-900 text-sm flex items-center justify-center">
                        <?= renderIcon('check', 'w-5 h-5 text-white') ?>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">Keranjang Pinjam</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold shadow-md shadow-primary/20 ring-4 ring-white dark:ring-slate-900 text-sm">2</div>
                    <span class="text-xs font-bold text-primary dark:text-indigo-400">Pembayaran Deposit</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 rounded-full flex items-center justify-center font-bold ring-4 ring-white dark:ring-slate-900 text-sm">3</div>
                    <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">Persetujuan Pustakawan</span>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <a href="<?= BASE_URL ?>/cart" class="text-slate-400 dark:text-slate-400 hover:text-primary dark:hover:text-indigo-400 mb-3 inline-block font-semibold transition-colors text-sm">
                &larr; Kembali ke Keranjang
            </a>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Pembayaran Deposit</h1>
            <p class="text-slate-400 dark:text-slate-400 text-sm mt-1">Selesaikan transfer dana jaminan untuk mengirim permohonan pinjam buku Anda.</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700/50 overflow-hidden mb-8 transition-colors">
            <div class="p-6 md:p-8 border-b border-slate-100 dark:border-slate-700 flex flex-col md:flex-row justify-between md:items-center gap-4 bg-slate-50/50 dark:bg-slate-900/40">
                <div>
                    <p class="text-slate-400 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Deposit Jaminan</p>
                    <h2 class="text-3xl font-extrabold text-primary dark:text-indigo-400">Rp <?= number_format($deposit_amount, 0, ',', '.') ?></h2>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-slate-400 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Tanggal Rencana Ambil</p>
                    <p class="font-bold text-slate-800 dark:text-slate-200 text-lg"><?= date('d F Y', strtotime($pickup_date)) ?></p>
                </div>
            </div>

            <div class="p-6 md:p-8">
                <h3 class="font-bold text-slate-800 dark:text-slate-200 text-base mb-4">Transfer ke Salah Satu Rekening Kami:</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <div class="border border-slate-200 dark:border-slate-700 rounded-2xl p-5 flex gap-4 items-center bg-slate-50/25 dark:bg-slate-900/20">
                        <div class="w-16 h-12 bg-blue-50 dark:bg-blue-950/20 text-blue-700 dark:text-blue-300 rounded-xl flex items-center justify-center font-extrabold text-sm border border-blue-100 dark:border-blue-900/30 select-none">BCA</div>
                        <div>
                            <p class="text-xs text-slate-400 dark:text-slate-400 font-semibold">Bank BCA</p>
                            <p class="font-bold text-slate-800 dark:text-slate-200 text-base tracking-wide mt-0.5">8732 1123 99</p>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500">a.n. PerpusOnline</p>
                        </div>
                    </div>
                    <div class="border border-slate-200 dark:border-slate-700 rounded-2xl p-5 flex gap-4 items-center bg-slate-50/25 dark:bg-slate-900/20">
                        <div class="w-16 h-12 bg-amber-50 dark:bg-amber-950/20 text-amber-700 dark:text-amber-300 rounded-xl flex items-center justify-center font-extrabold text-sm border border-amber-100 dark:border-amber-900/30 select-none">BSI</div>
                        <div>
                            <p class="text-xs text-slate-400 dark:text-slate-400 font-semibold">Bank BSI</p>
                            <p class="font-bold text-slate-800 dark:text-slate-200 text-base tracking-wide mt-0.5">7123 9000 11</p>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500">a.n. PerpusOnline</p>
                        </div>
                    </div>
                </div>

                <form action="<?= BASE_URL ?>/loan/request" method="POST" enctype="multipart/form-data">
                    
                    <input type="hidden" name="pickup_date" value="<?= htmlspecialchars($pickup_date) ?>">
                    <input type="hidden" name="deposit_amount" value="<?= htmlspecialchars($deposit_amount) ?>">

                    <div class="space-y-2 mb-8">
                        <label for="deposit_receipt" class="block font-bold text-xs uppercase tracking-wider text-slate-400 dark:text-slate-400">Upload Bukti Transfer <span class="text-rose-500">*</span></label>
                        <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 hover:border-primary dark:hover:border-indigo-400 rounded-2xl p-8 text-center hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-all duration-300 relative group cursor-pointer">
                            <input type="file" id="deposit_receipt" name="deposit_receipt" required accept="image/jpeg, image/png, image/webp"
                                class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                            <div class="flex flex-col items-center justify-center">
                                <span class="w-10 h-10 mb-3 text-slate-400 dark:text-slate-500 group-hover:scale-110 transition-transform duration-300 flex items-center justify-center">
                                    <?= renderIcon('upload', 'w-10 h-10') ?>
                                </span>
                                <p class="text-sm font-bold text-slate-600 dark:text-slate-300" id="file_label_text">Klik atau seret file gambar ke sini</p>
                                <p class="text-xs text-slate-400 dark:text-slate-400 mt-2 font-medium">Mendukung format JPG, PNG, WEBP. Maksimal ukuran file 2MB.</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-opacity-95 text-white font-bold py-4.5 rounded-2xl shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 text-sm">
                        Konfirmasi Pembayaran & Ajukan Pinjaman
                    </button>
                </form>

            </div>
        </div>

    </main>

    <!-- Footer -->
    <?php require APP_ROOT . '/views/components/footer.php'; ?>

    <script>
        // File input label update
        const fileInput = document.getElementById('deposit_receipt');
        const fileLabelText = document.getElementById('file_label_text');
        fileInput.addEventListener('change', (e) => {
            if (fileInput.files.length > 0) {
                fileLabelText.innerText = "✓ File Terpilih: " + fileInput.files[0].name;
                fileLabelText.classList.remove('text-slate-600', 'dark:text-slate-300');
                fileLabelText.classList.add('text-primary', 'dark:text-indigo-400');
            }
        });

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

