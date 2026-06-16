<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Online - Pinjam Buku Favoritmu Tanpa Antre</title>
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
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
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
        .floating-visual {
            animation: float-visual 8s ease-in-out infinite;
        }
        @keyframes float-visual {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
        }
        .gradient-bg {
            background: linear-gradient(135deg, #4f46e5 0%, #312e81 100%);
        }
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-left.active {
            opacity: 1;
            transform: translateX(0);
        }
        .reveal-right {
            opacity: 0;
            transform: translateX(40px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-right.active {
            opacity: 1;
            transform: translateX(0);
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
<body class="bg-slate-50 text-slate-900 dark:bg-slate-900 dark:text-slate-200 antialiased selection:bg-primary selection:text-white flex flex-col min-h-screen transition-colors duration-300">

    <!-- Glowing Background Ornaments -->
    <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[120px] -z-10 pointer-events-none"></div>
    <div class="absolute top-80 right-1/4 w-[500px] h-[500px] bg-accent/5 rounded-full blur-[120px] -z-10 pointer-events-none"></div>

    <!-- Navigation -->
    <nav class="glass-nav shadow-sm border-b border-slate-200/80 dark:border-slate-800 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="<?= BASE_URL ?>/" class="font-extrabold text-2xl text-primary dark:text-indigo-400 tracking-tight hover:opacity-90 transition-opacity flex items-center gap-2">
                <span>Perpus<span class="text-accent">Online</span></span>
            </a>
            
            <div class="flex items-center gap-5">
                <a href="<?= BASE_URL ?>/" class="text-primary dark:text-indigo-400 font-bold transition-colors text-sm border-b-2 border-primary dark:border-indigo-400 pb-1">Beranda</a>
                <a href="<?= BASE_URL ?>/catalog" class="text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-indigo-400 font-bold transition-colors text-sm">Katalog Buku</a>
                
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <a href="<?= BASE_URL ?>/login" class="text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-indigo-400 font-semibold transition-colors text-sm">Masuk</a>
                    <a href="<?= BASE_URL ?>/register" class="bg-primary hover:bg-opacity-95 hover:shadow-lg hover:shadow-primary/20 text-white px-6 py-3 rounded-2xl font-bold transition-all duration-300 hover:-translate-y-0.5 text-sm">Daftar</a>
                <?php else: ?>
                    <!-- Profile Dropdown -->
                    <div class="relative inline-block text-left" id="user-menu-wrapper">
                        <button onclick="toggleUserMenu()" class="flex items-center gap-2.5 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200/80 dark:bg-slate-800 dark:hover:bg-slate-750 transition-all font-bold text-sm text-slate-700 dark:text-slate-200 focus:outline-none">
                            <div class="w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center text-xs font-black uppercase tracking-wider select-none">
                                <?= substr($_SESSION['user_name'], 0, 1) ?>
                            </div>
                            <span class="max-w-[120px] truncate"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400 transition-transform duration-200" id="user-menu-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="user-dropdown-menu" class="origin-top-right absolute right-0 mt-3.5 w-56 rounded-3xl shadow-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/80 py-2.5 z-50 hidden transition-all duration-200 scale-95 opacity-0 transform">
                            <div class="px-5 py-2.5 border-b border-slate-100 dark:border-slate-700/60 mb-2">
                                <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Masuk sebagai</p>
                                <p class="font-bold text-slate-800 dark:text-slate-200 text-sm truncate"><?= htmlspecialchars($_SESSION['user_name']) ?></p>
                                <span class="inline-block bg-primary/10 text-primary dark:text-indigo-400 text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-md mt-1.5"><?= $_SESSION['user_role'] == 'admin' ? 'Pustakawan' : 'Member' ?></span>
                            </div>

                            <?php if($_SESSION['user_role'] == 'admin'): ?>
                                <a href="<?= BASE_URL ?>/admin/dashboard" class="flex items-center gap-3.5 px-5 py-3 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-primary dark:hover:text-white transition-colors">
                                    <?= renderIcon('dashboard', 'w-4 h-4') ?>
                                    <span>Dashboard Admin</span>
                                </a>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>/loans" class="flex items-center gap-3.5 px-5 py-3 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-primary dark:hover:text-white transition-colors">
                                    <?= renderIcon('clipboard', 'w-4 h-4') ?>
                                    <span>Pinjamanku</span>
                                </a>
                                <a href="<?= BASE_URL ?>/cart" class="flex items-center gap-3.5 px-5 py-3 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-primary dark:hover:text-white transition-colors">
                                    <?= renderIcon('cart', 'w-4 h-4') ?>
                                    <span>Keranjang</span>
                                </a>
                            <?php endif; ?>
                            
                            <div class="border-t border-slate-100 dark:border-slate-700/60 my-2"></div>
                            
                            <a href="<?= BASE_URL ?>/logout" class="flex items-center gap-3.5 px-5 py-3 text-sm font-bold text-red-500 hover:bg-red-50 dark:hover:bg-red-950/20 transition-colors">
                                <?= renderIcon('logout', 'w-4 h-4 text-red-500') ?>
                                <span>Keluar</span>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

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

    <!-- Main Content Area -->
    <main class="flex-grow">
        
        <!-- 1. Hero Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 flex flex-col lg:flex-row items-center justify-between gap-12">
            <div class="max-w-2xl text-center lg:text-left flex flex-col items-center lg:items-start reveal-left">
                <span class="bg-indigo-100 dark:bg-indigo-950/40 text-primary dark:text-indigo-400 text-xs font-extrabold px-4 py-2 rounded-full uppercase tracking-wider mb-6 inline-block">
                    Akses Literasi Tanpa Batas
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 dark:text-white mb-6 leading-[1.15] tracking-tight">
                    Pinjam Buku Favoritmu <span class="bg-gradient-to-r from-primary to-indigo-500 bg-clip-text text-transparent">Tanpa Antre</span>
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-lg sm:text-xl mb-10 font-medium max-w-xl">
                    Akses ribuan katalog perpustakaan dan kelola peminjamanmu langsung dari layar kaca. Cari, pilih, dan ajukan peminjaman buku favorit kapan saja.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <a href="<?= BASE_URL ?>/catalog" class="bg-primary hover:bg-opacity-95 hover:shadow-xl hover:shadow-primary/30 text-white px-8 py-4 rounded-2xl font-black text-center transition-all duration-300 hover:-translate-y-0.5 text-base">
                        Mulai Pinjam Sekarang
                    </a>
                    <?php if(!isset($_SESSION['user_id'])): ?>
                        <a href="<?= BASE_URL ?>/register" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-750 px-8 py-4 rounded-2xl font-bold text-center transition-all duration-300 hover:-translate-y-0.5 text-base">
                            Daftar Member
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="flex-1 max-w-lg lg:max-w-xl floating-visual reveal-right">
                <!-- SVG Visual (Premium Book Vector representation) -->
                <svg viewBox="0 0 500 500" class="w-full h-auto drop-shadow-3xl" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="svgGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#818cf8" />
                            <stop offset="100%" stop-color="#4f46e5" />
                        </linearGradient>
                        <filter id="shadow" x="-10%" y="-10%" width="120%" height="120%">
                            <feDropShadow dx="0" dy="8" stdDeviation="12" flood-color="#4F46E5" flood-opacity="0.15" />
                        </filter>
                    </defs>
                    <circle cx="250" cy="250" r="180" fill="url(#svgGrad)" fill-opacity="0.05" />
                    <!-- Visual Floating Elements -->
                    <circle cx="90" cy="120" r="15" fill="#F59E0B" fill-opacity="0.8" />
                    <circle cx="420" cy="200" r="8" fill="#10B981" fill-opacity="0.8" />
                    <circle cx="380" cy="380" r="12" fill="#6366F1" fill-opacity="0.8" />
                    
                    <!-- Main Book Object -->
                    <g filter="url(#shadow)">
                        <!-- Right Page Back -->
                        <path d="M250 150 C300 130 380 150 420 180 V360 C380 330 300 310 250 330 Z" fill="#EEF2F6" class="dark:fill-slate-700" />
                        <!-- Left Page Back -->
                        <path d="M250 150 C200 130 120 150 80 180 V360 C120 330 200 310 250 330 Z" fill="#E2E8F0" class="dark:fill-slate-800" />
                        <!-- Pages Thickness Right -->
                        <path d="M250 333 C300 313 380 333 420 363 V367 C380 337 300 317 250 337 Z" fill="#CBD5E1" class="dark:fill-slate-600" />
                        <!-- Pages Thickness Left -->
                        <path d="M250 333 C200 313 120 333 80 363 V367 C120 337 200 317 250 337 Z" fill="#94A3B8" class="dark:fill-slate-900" />
                        <!-- Right Page Front -->
                        <path d="M250 145 C300 125 380 145 420 175 V355 C380 325 300 305 250 325 Z" fill="#FFFFFF" class="dark:fill-slate-800" />
                        <!-- Left Page Front -->
                        <path d="M250 145 C200 125 120 145 80 175 V355 C120 325 200 305 250 325 Z" fill="#F8FAFC" class="dark:fill-slate-750" />
                        
                        <!-- Book Cover Spine -->
                        <path d="M246 150 H254 V335 H246 Z" fill="#4F46E5" />
                        <path d="M250 325 C200 305 120 325 80 355 V358 C120 328 200 308 250 328 C300 308 380 328 420 358 V355 C380 325 300 305 250 325" fill="#312E81" />
                        
                        <!-- Page Text Lines Representation (Left) -->
                        <path d="M120 220 H210 M120 240 H210 M120 260 H180 M120 280 H200" stroke="#94A3B8" stroke-width="4" stroke-linecap="round" opacity="0.4" />
                        <!-- Page Text Lines Representation (Right) -->
                        <path d="M290 220 H380 M290 240 H360 M290 260 H380 M290 280 H330" stroke="#94A3B8" stroke-width="4" stroke-linecap="round" opacity="0.4" />
                    </g>
                    
                    <!-- Decorative Light Sparkle -->
                    <path d="M250 80 L254 95 L269 99 L254 103 L250 118 L246 103 L231 99 L246 95 Z" fill="#F59E0B" />
                    <path d="M140 370 L142 377 L149 379 L142 381 L140 388 L138 381 L131 379 L138 377 Z" fill="#F59E0B" opacity="0.7" />
                </svg>
            </div>
        </section>

        <!-- 2. Social Proof (Elemen Kepercayaan) -->
        <section class="bg-white dark:bg-slate-900/60 border-y border-slate-200/80 dark:border-slate-800 py-16 transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 reveal">
                    <h2 class="text-xs font-bold text-primary dark:text-indigo-400 uppercase tracking-widest mb-3">Statistik Perpustakaan Kami</h2>
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Dipercaya oleh Ratusan Pembaca Aktif</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Stat Item 1 -->
                    <div class="bg-slate-50 dark:bg-slate-800 p-8 rounded-3xl border border-slate-200/60 dark:border-slate-700/50 flex flex-col items-center text-center shadow-sm hover:shadow-md transition-shadow reveal" style="transition-delay: 100ms;">
                        <div class="w-14 h-14 bg-indigo-100 dark:bg-indigo-950/50 text-primary dark:text-indigo-400 rounded-2xl flex items-center justify-center mb-5">
                            <?= renderIcon('tag', 'w-7 h-7') ?>
                        </div>
                        <span class="text-4xl font-extrabold text-slate-800 dark:text-white tracking-tight mb-2"><?= number_format($totalBooks) ?>+</span>
                        <span class="text-slate-400 dark:text-slate-400 font-bold text-sm uppercase tracking-wider">Koleksi Buku</span>
                    </div>

                    <!-- Stat Item 2 -->
                    <div class="bg-slate-50 dark:bg-slate-800 p-8 rounded-3xl border border-slate-200/60 dark:border-slate-700/50 flex flex-col items-center text-center shadow-sm hover:shadow-md transition-shadow reveal" style="transition-delay: 200ms;">
                        <div class="w-14 h-14 bg-amber-100 dark:bg-amber-950/50 text-accent rounded-2xl flex items-center justify-center mb-5">
                            <?= renderIcon('users', 'w-7 h-7') ?>
                        </div>
                        <span class="text-4xl font-extrabold text-slate-800 dark:text-white tracking-tight mb-2"><?= number_format($totalMembers) ?>+</span>
                        <span class="text-slate-400 dark:text-slate-400 font-bold text-sm uppercase tracking-wider">Member Aktif</span>
                    </div>

                    <!-- Stat Item 3 -->
                    <div class="bg-slate-50 dark:bg-slate-800 p-8 rounded-3xl border border-slate-200/60 dark:border-slate-700/50 flex flex-col items-center text-center shadow-sm hover:shadow-md transition-shadow reveal" style="transition-delay: 300ms;">
                        <div class="w-14 h-14 bg-emerald-100 dark:bg-emerald-950/50 text-emerald-500 rounded-2xl flex items-center justify-center mb-5">
                            <?= renderIcon('clipboard', 'w-7 h-7') ?>
                        </div>
                        <span class="text-4xl font-extrabold text-slate-800 dark:text-white tracking-tight mb-2"><?= number_format($totalLoans) ?>+</span>
                        <span class="text-slate-400 dark:text-slate-400 font-bold text-sm uppercase tracking-wider">Transaksi Peminjaman</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Benefits & Features (Nilai Jual) -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20 reveal">
                <h2 class="text-xs font-bold text-primary dark:text-indigo-400 uppercase tracking-widest mb-3">Keuntungan & Ketentuan</h2>
                <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                    Pinjam Buku secara Praktis dengan Layanan Modern
                </p>
                <p class="text-slate-400 dark:text-slate-400 font-medium mt-4">
                    Sistem peminjaman kami didesain demi kenyamanan, transparansi, serta keadilan bagi setiap pembaca.
                </p>
            </div>

            <!-- Features Zig-Zag Layout -->
            <div class="space-y-20 lg:space-y-32">
                <!-- Feature 1 -->
                <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                    <div class="flex-1 space-y-6 max-w-xl text-center lg:text-left reveal-left">
                        <span class="bg-primary/10 text-primary dark:text-indigo-400 text-xs font-extrabold px-3 py-1.5 rounded-xl uppercase tracking-wider">
                            Keadilan Membaca
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white leading-tight">
                            Maksimal Peminjaman 3 Buku Bersamaan
                        </h3>
                        <p class="text-slate-500 dark:text-slate-400 font-medium">
                            Setiap member dapat meminjam maksimal hingga 3 buku secara bersamaan. Hal ini memastikan ketersediaan buku tetap seimbang sehingga pembaca lain juga mendapatkan kesempatan membaca buku favorit mereka.
                        </p>
                    </div>
                    <div class="flex-1 bg-gradient-to-tr from-slate-100 to-indigo-50/50 dark:from-slate-800 dark:to-slate-800/40 p-8 rounded-4xl border border-slate-200/50 dark:border-slate-700/50 flex items-center justify-center max-w-md w-full mx-auto reveal-right">
                        <!-- Icon representation of Limit -->
                        <div class="text-primary p-12 bg-white dark:bg-slate-900 rounded-3xl shadow-xl shadow-indigo-500/5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="flex flex-col lg:flex-row-reverse items-center justify-between gap-12">
                    <div class="flex-1 space-y-6 max-w-xl text-center lg:text-left reveal-right">
                        <span class="bg-amber-100 dark:bg-amber-950/40 text-accent text-xs font-extrabold px-3 py-1.5 rounded-xl uppercase tracking-wider">
                            Real-time Verification
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white leading-tight">
                            Pantau Status Persetujuan Admin
                        </h3>
                        <p class="text-slate-500 dark:text-slate-400 font-medium">
                            Setelah mengajukan peminjaman secara online, pengajuan Anda akan ditinjau langsung oleh Pustakawan secara real-time. Dapatkan kejelasan status peminjaman (disetujui/ditolak) dalam hitungan menit.
                        </p>
                    </div>
                    <div class="flex-1 bg-gradient-to-tr from-slate-100 to-amber-50/50 dark:from-slate-800 dark:to-slate-800/40 p-8 rounded-4xl border border-slate-200/50 dark:border-slate-700/50 flex items-center justify-center max-w-md w-full mx-auto reveal-left">
                        <!-- Icon representation of Validation -->
                        <div class="text-accent p-12 bg-white dark:bg-slate-900 rounded-3xl shadow-xl shadow-amber-500/5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                    <div class="flex-1 space-y-6 max-w-xl text-center lg:text-left reveal-left">
                        <span class="bg-emerald-100 dark:bg-emerald-950/40 text-emerald-500 text-xs font-extrabold px-3 py-1.5 rounded-xl uppercase tracking-wider">
                            Bebas Antrean
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white leading-tight">
                            Ajukan Online, Ambil Buku Langsung
                        </h3>
                        <p class="text-slate-500 dark:text-slate-400 font-medium">
                            Tidak perlu lagi membuang waktu mengantre di perpustakaan. Cukup buat pesanan peminjaman dari mana saja, dan ambil fisik buku di meja pelayanan perpustakaan sesuai jadwal pengambilan pilihan Anda.
                        </p>
                    </div>
                    <div class="flex-1 bg-gradient-to-tr from-slate-100 to-emerald-50/50 dark:from-slate-800 dark:to-slate-800/40 p-8 rounded-4xl border border-slate-200/50 dark:border-slate-700/50 flex items-center justify-center max-w-md w-full mx-auto reveal-right">
                        <!-- Icon representation of Queue-free -->
                        <div class="text-emerald-500 p-12 bg-white dark:bg-slate-900 rounded-3xl shadow-xl shadow-emerald-500/5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. Final Call-to-Action -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 reveal">
            <div class="gradient-bg rounded-4xl p-8 md:p-16 text-center text-white shadow-2xl relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,0.08),transparent)] pointer-events-none"></div>
                <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -top-24 -right-24 w-72 h-72 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
                
                <div class="max-w-2xl mx-auto relative z-10 space-y-6">
                    <h2 class="text-3xl sm:text-4xl font-extrabold leading-tight">
                        Tunggu Apa Lagi? Cari Buku Favoritmu Sekarang!
                    </h2>
                    <p class="text-indigo-100/90 font-medium text-base sm:text-lg">
                        Mulai jelajahi katalog koleksi terlengkap kami dan buat pengalaman membaca buku Anda menjadi lebih mudah dan modern.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center pt-6">
                        <a href="<?= BASE_URL ?>/catalog" class="bg-white hover:bg-slate-100 text-primary px-8 py-4 rounded-2xl font-black text-center transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 text-base">
                            Lihat Katalog Buku
                        </a>
                        <?php if(!isset($_SESSION['user_id'])): ?>
                            <a href="<?= BASE_URL ?>/register" class="bg-indigo-500 hover:bg-indigo-600 text-white px-8 py-4 rounded-2xl font-bold text-center border border-indigo-400 transition-all duration-300 hover:-translate-y-0.5 text-base">
                                Daftar Member Baru
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <?php require APP_ROOT . '/views/components/footer.php'; ?>

    <script>
        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            const sunIcon = document.getElementById('theme-icon-sun');
            const moonIcon = document.getElementById('theme-icon-moon');
            if (sunIcon && moonIcon) {
                if (isDark) {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                } else {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
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

        function toggleUserMenu() {
            const dropdown = document.getElementById('user-dropdown-menu');
            const chevron = document.getElementById('user-menu-chevron');
            if (dropdown) {
                const isHidden = dropdown.classList.contains('hidden');
                if (isHidden) {
                    dropdown.classList.remove('hidden');
                    setTimeout(() => {
                        dropdown.classList.remove('scale-95', 'opacity-0');
                        dropdown.classList.add('scale-100', 'opacity-100');
                    }, 20);
                    if (chevron) chevron.classList.add('rotate-180');
                } else {
                    dropdown.classList.remove('scale-100', 'opacity-100');
                    dropdown.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        dropdown.classList.add('hidden');
                    }, 150);
                    if (chevron) chevron.classList.remove('rotate-180');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateThemeIcons();

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                const wrapper = document.getElementById('user-menu-wrapper');
                const dropdown = document.getElementById('user-dropdown-menu');
                const chevron = document.getElementById('user-menu-chevron');
                if (wrapper && !wrapper.contains(e.target)) {
                    if (dropdown && !dropdown.classList.contains('hidden')) {
                        dropdown.classList.remove('scale-100', 'opacity-100');
                        dropdown.classList.add('scale-95', 'opacity-0');
                        setTimeout(() => {
                            dropdown.classList.add('hidden');
                        }, 150);
                        if (chevron) chevron.classList.remove('rotate-180');
                    }
                }
            });

            // Scroll Reveal Observer
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, {
                threshold: 0.15
            });

            // Target elements to observe
            document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => {
                // Jangan observe Hero langsung, animasikan instan agar mantap
                if (el.closest('section') && el.closest('section').querySelector('.floating-visual')) {
                    setTimeout(() => {
                        el.classList.add('active');
                    }, 100);
                } else {
                    observer.observe(el);
                }
            });
        });
    </script>
</body>
</html>
