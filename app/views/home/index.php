<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - Perpus Online</title>
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
        .floating-circle {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.05); }
        }
        
        /* Custom Alert Styles for High Visibility */
        .alert-success {
            background-color: #f0fdf4 !important;
            color: #15803d !important;
            border-color: #bbf7d0 !important;
        }
        .alert-success span:not(.text-emerald-500) {
            color: #15803d !important;
        }
        .dark .alert-success {
            background-color: rgba(6, 78, 59, 0.2) !important;
            color: #6ee7b7 !important;
            border-color: rgba(6, 78, 59, 0.5) !important;
        }
        .dark .alert-success span:not(.text-emerald-500) {
            color: #6ee7b7 !important;
        }
        
        .alert-rose {
            background-color: #fff1f2 !important;
            color: #b91c1c !important;
            border-color: #fecdd3 !important;
        }
        .dark .alert-rose {
            background-color: rgba(159, 18, 57, 0.2) !important;
            color: #fda4af !important;
            border-color: rgba(159, 18, 57, 0.5) !important;
        }
        
        .alert-amber {
            background-color: #fffbeb !important;
            color: #b45309 !important;
            border-color: #fde68a !important;
        }
        .dark .alert-amber {
            background-color: rgba(120, 53, 4, 0.2) !important;
            color: #fcd34d !important;
            border-color: rgba(120, 53, 4, 0.5) !important;
        }
        
        .alert-blue {
            background-color: #eff6ff !important;
            color: #1d4ed8 !important;
            border-color: #bfdbfe !important;
        }
        .dark .alert-blue {
            background-color: rgba(30, 58, 138, 0.2) !important;
            color: #93c5fd !important;
            border-color: rgba(30, 58, 138, 0.5) !important;
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
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl -z-10 pointer-events-none"></div>
    <div class="absolute top-80 right-1/4 w-96 h-96 bg-accent/5 rounded-full blur-3xl -z-10 pointer-events-none"></div>

    <nav class="glass-nav shadow-sm border-b border-slate-200/80 dark:border-slate-800 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="<?= BASE_URL ?>/" class="font-extrabold text-2xl text-primary dark:text-indigo-400 tracking-tight hover:opacity-90 transition-opacity flex items-center gap-2">
                <span>Perpus<span class="text-accent">Online</span></span>
            </a>
            
            <div class="flex items-center gap-5">
                <a href="<?= BASE_URL ?>/" class="text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-indigo-400 font-bold transition-colors text-sm">Beranda</a>
                <a href="<?= BASE_URL ?>/catalog" class="text-primary dark:text-indigo-400 font-bold transition-colors text-sm border-b-2 border-primary dark:border-indigo-400 pb-1">Katalog Buku</a>
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

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        
        <!-- Premium Hero Section -->
        <div class="bg-gradient-to-tr from-indigo-900 via-indigo-700 to-primary text-white rounded-4xl p-8 md:p-14 mb-12 shadow-xl shadow-indigo-500/10 flex flex-col md:flex-row items-center justify-between gap-10 overflow-hidden relative">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,0.1),transparent)] pointer-events-none"></div>
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/5 rounded-full blur-xl pointer-events-none"></div>
            
            <div class="max-w-xl z-10">
                <span class="bg-white/10 text-white/90 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider mb-4 inline-block">
                    Perpustakaan Masa Depan
                </span>
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight tracking-tight">
                    Temukan Dunia Baru Melalui Lembaran Buku.
                </h1>
                <p class="text-indigo-100 opacity-90 text-base md:text-lg mb-0 font-medium">
                    Lakukan pemesanan pinjam secara online, ambil fisik buku di lokasi kapan saja tanpa mengantre.
                </p>
            </div>
            
            <div class="z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-indigo-200/90 drop-shadow-2xl floating-circle" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        </div>

        <!-- Alerts / Status -->
        <?php if(isset($_GET['status'])): ?>
            <?php if($_GET['status'] == 'added_to_cart'): ?>
                <div class="mb-8 p-5 alert-success rounded-3xl border shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4 animate-fade-in">
                    <div class="font-extrabold flex items-center gap-3 text-sm sm:text-base">
                        <span class="w-6 h-6 flex-shrink-0 text-emerald-500">
                            <?= renderIcon('check-circle', 'w-6 h-6') ?>
                        </span> 
                        <span>Buku berhasil ditambahkan ke keranjang peminjaman Anda!</span>
                    </div>
                    <a href="<?= BASE_URL ?>/cart" class="bg-emerald-700 hover:bg-emerald-800 dark:bg-emerald-600 dark:hover:bg-emerald-500 text-white px-6 py-2.5 rounded-2xl font-black transition-colors text-sm shadow-md">
                        Buka Keranjang &rarr;
                    </a>
                </div>
            <?php elseif($_GET['status'] == 'cart_full'): ?>
                <div class="mb-8 p-5 alert-rose rounded-3xl border shadow-sm flex items-center gap-3 animate-fade-in text-sm sm:text-base">
                    <span class="w-6 h-6 flex-shrink-0 text-rose-500">
                        <?= renderIcon('warning', 'w-6 h-6') ?>
                    </span> 
                    <span class="font-black">Batas penuh!</span> 
                    <span class="font-bold">Maksimal buku yang dipinjam bersamaan adalah 3 buah.</span>
                </div>
            <?php elseif($_GET['status'] == 'already_in_cart'): ?>
                <div class="mb-8 p-5 alert-amber rounded-3xl border shadow-sm flex items-center gap-3 animate-fade-in text-sm sm:text-base">
                    <span class="w-6 h-6 flex-shrink-0 text-amber-500">
                        <?= renderIcon('info', 'w-6 h-6') ?>
                    </span> 
                    <span class="font-bold">Buku tersebut sudah terdaftar di keranjang Anda.</span>
                </div>
            <?php elseif($_GET['status'] == 'loan_success'): ?>
                <div class="mb-8 p-5 alert-success rounded-3xl border shadow-sm flex items-center gap-3 animate-fade-in text-sm sm:text-base">
                    <span class="w-6 h-6 flex-shrink-0 text-emerald-500">
                        <?= renderIcon('check-circle', 'w-6 h-6') ?>
                    </span> 
                    <span class="font-bold">Peminjaman sukses diajukan! Silakan ambil buku Anda sesuai tanggal pengambilan.</span>
                </div>
            <?php elseif($_GET['status'] == 'removed'): ?>
                <div class="mb-8 p-5 alert-blue rounded-3xl border shadow-sm flex items-center gap-3 animate-fade-in text-sm sm:text-base">
                    <span class="w-6 h-6 flex-shrink-0 text-blue-500">
                        <?= renderIcon('trash', 'w-6 h-6') ?>
                    </span> 
                    <span class="font-bold">Buku berhasil dihapus dari keranjang.</span>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Search and Filter Panel -->
        <form method="GET" action="<?= BASE_URL ?>/catalog" class="mb-12 bg-white dark:bg-slate-800 p-5 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700/50 flex flex-col md:flex-row gap-4 items-center transition-colors">
            
            <div class="flex-1 w-full relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <?= renderIcon('search', 'w-5 h-5') ?>
                </span>
                <input type="text" name="search" id="search-input" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                    placeholder="Masukkan judul buku atau nama penulis..." 
                    class="w-full pl-12 pr-4 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-900 text-sm text-slate-700 dark:text-slate-200 font-medium">
            </div>
            
            <div class="w-full md:w-64">
                <select name="category" id="category-select" class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-900 text-sm text-slate-700 dark:text-slate-300 font-semibold cursor-pointer">
                    <option value="" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Semua Kategori</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200" <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="flex-1 md:flex-none bg-primary hover:bg-opacity-95 text-white px-8 py-3.5 rounded-2xl font-bold transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 hover:-translate-y-0.5 text-sm">
                    Cari Buku
                </button>
                
                <?php if(!empty($_GET['search']) || !empty($_GET['category'])): ?>
                    <a href="<?= BASE_URL ?>/catalog" class="bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-200 px-6 py-3.5 rounded-2xl font-semibold transition-all text-sm text-center">
                        Reset
                    </a>
                <?php endif; ?>
            </div>
            
        </form>

        <!-- Catalog Section -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">Koleksi Buku Terpopuler</h2>
                <p class="text-sm text-slate-400 dark:text-slate-400 mt-1">Daftar buku pilihan yang tersedia untuk dipinjam.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8" id="book-grid">
            <!-- Dynamic empty state for live search -->
            <div id="live-empty-state" class="col-span-full py-16 text-center text-slate-400 dark:text-slate-400 font-medium hidden animate-fade-in">
                <div class="w-16 h-16 mx-auto mb-4 text-slate-400">
                    <?= renderIcon('info', 'w-16 h-16') ?>
                </div>
                Buku yang Anda cari tidak ditemukan atau belum tersedia.
            </div>

            <!-- Skeleton Loading Cards -->
            <?php for ($i = 0; $i < 4; $i++): ?>
            <div class="skeleton-card bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700/50 overflow-hidden flex flex-col animate-pulse hidden" style="transition: opacity 0.3s ease;">
                <div class="bg-slate-200 dark:bg-slate-700 aspect-[3/4] w-full"></div>
                <div class="p-6 space-y-3 flex-grow flex flex-col justify-between">
                    <div class="space-y-2.5">
                        <div class="h-2.5 bg-slate-200 dark:bg-slate-700 rounded-full w-1/4"></div>
                        <div class="h-4 bg-slate-200 dark:bg-slate-700 rounded-full w-3/4"></div>
                        <div class="h-2.5 bg-slate-200 dark:bg-slate-700 rounded-full w-1/2"></div>
                    </div>
                    <div class="space-y-2 pt-4 mt-auto">
                        <div class="h-9 bg-slate-200 dark:bg-slate-700 rounded-2xl w-full"></div>
                        <div class="h-10 bg-slate-200 dark:bg-slate-700 rounded-2xl w-full"></div>
                    </div>
                </div>
            </div>
            <?php endfor; ?>

            <?php if(empty($books)): ?>
                <div class="col-span-full py-16 text-center text-slate-400 dark:text-slate-400 font-medium">
                    <div class="w-16 h-16 mx-auto mb-4 text-slate-400">
                        <?= renderIcon('info', 'w-16 h-16') ?>
                    </div>
                    Buku yang Anda cari tidak ditemukan atau belum tersedia.
                </div>
            <?php else: ?>
                <?php foreach($books as $book): ?>
                    <div class="book-card bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700/50 overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/10 dark:hover:shadow-primary/5 hover:border-primary/30 dark:hover:border-indigo-400/30 group"
                         data-title="<?= strtolower(htmlspecialchars($book['title'])) ?>"
                         data-author="<?= strtolower(htmlspecialchars($book['author'])) ?>"
                         data-category="<?= htmlspecialchars($book['category_id'] ?? '') ?>">
                        
                        <!-- Book Cover with Badges -->
                        <div class="relative bg-slate-50 dark:bg-slate-900 aspect-[3/4] overflow-hidden flex items-center justify-center border-b border-slate-50 dark:border-slate-700/50">
                            <?php if($book['cover_image']): ?>
                                <img src="<?= BASE_URL ?>/uploads/books/<?= htmlspecialchars($book['cover_image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <?php else: ?>
                                <div class="text-slate-300 dark:text-slate-600 text-lg flex flex-col items-center gap-2 font-bold select-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <span class="text-xs uppercase tracking-wider text-slate-400">Tidak ada sampul</span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($book['stock'] > 0): ?>
                                <span class="absolute top-4 right-4 bg-emerald-500/90 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-md">
                                    Tersedia (<?= htmlspecialchars($book['stock']) ?>)
                                </span>
                            <?php else: ?>
                                <span class="absolute top-4 right-4 bg-rose-500/90 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-md">
                                    Habis
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Book Details -->
                        <div class="p-6 flex flex-col flex-1">
                            <span class="text-[10px] font-extrabold text-primary dark:text-indigo-400 uppercase tracking-wider mb-2 block">
                                <?= htmlspecialchars($book['category_name'] ?? 'Umum') ?>
                            </span>
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base md:text-lg leading-snug mb-1 line-clamp-2 flex-1 hover:text-primary dark:hover:text-indigo-400 transition-colors cursor-pointer" onclick="showBookDetail(<?= $book['id'] ?>)">
                                <?= htmlspecialchars($book['title']) ?>
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-3 font-medium">
                                oleh <?= htmlspecialchars($book['author']) ?>
                            </p>
                            
                            <!-- Star Rating -->
                            <div class="flex items-center gap-1.5 mb-5 text-xs text-slate-500 dark:text-slate-400">
                                <span class="text-amber-400 text-base">★</span>
                                <span class="font-bold text-slate-700 dark:text-slate-300"><?= number_format($book['avg_rating'], 1) ?></span>
                                <span class="text-slate-400 dark:text-slate-600">•</span>
                                <span><?= $book['review_count'] ?> ulasan</span>
                            </div>

                            <div class="space-y-2">
                                <button onclick="showBookDetail(<?= $book['id'] ?>)" class="w-full block text-center bg-slate-50 dark:bg-slate-700/50 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold py-2.5 rounded-2xl text-xs transition-colors border border-slate-200 dark:border-slate-600/50">
                                    Detail & Ulasan
                                </button>
                                
                                <?php if($book['stock'] > 0): ?>
                                    <a href="<?= BASE_URL ?>/cart/add?id=<?= $book['id'] ?>" class="w-full block text-center bg-primary hover:bg-opacity-95 text-white font-bold py-3 rounded-2xl transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 text-xs">
                                        Pinjam Buku
                                    </a>
                                <?php else: ?>
                                    <button disabled class="w-full block text-center bg-slate-100 dark:bg-slate-700/40 text-slate-400 dark:text-slate-500 font-bold py-3 rounded-2xl cursor-not-allowed text-xs">
                                        Stok Habis
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </main>

    <!-- Footer -->
    <?php require APP_ROOT . '/views/components/footer.php'; ?>

    <!-- Modal Detail Buku & Ulasan -->
    <div id="detailModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 w-full max-w-lg rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-700/50 overflow-hidden transform transition-all scale-95 duration-300 flex flex-col max-h-[85vh]">
            <div class="p-6 border-b border-slate-100 dark:border-slate-700/50 flex justify-between items-center bg-slate-50/50 dark:bg-slate-900/40">
                <h3 class="font-extrabold text-lg text-slate-900 dark:text-white">Detail & Ulasan</h3>
                <button onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-700 text-2xl font-bold transition-colors">&times;</button>
            </div>
            
            <div class="p-6 overflow-y-auto space-y-6 flex-1">
                <!-- Info Buku -->
                <div class="flex gap-5">
                    <div class="w-24 h-32 bg-slate-50 dark:bg-slate-900 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-100 dark:border-slate-700/50 shadow-sm" id="detail_cover_container">
                        <!-- Cover Image -->
                    </div>
                    <div class="flex-1 flex flex-col justify-center">
                        <div>
                            <span class="bg-primary/10 text-primary dark:text-indigo-400 px-3 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wider" id="detail_category">Kategori</span>
                        </div>
                        <h4 class="font-extrabold text-lg text-slate-900 dark:text-white mt-2 leading-snug" id="detail_title">Judul Buku</h4>
                        <p class="text-sm text-slate-400 dark:text-slate-400 mt-0.5 font-medium" id="detail_author">Penulis</p>
                        <div class="flex items-center gap-1.5 mt-3 text-xs text-slate-500 dark:text-slate-400 flex-wrap">
                            <span class="text-amber-400 text-lg">★</span>
                            <span class="font-bold text-slate-700 dark:text-slate-200 text-sm" id="detail_avg_rating">0.0</span>
                            <span id="detail_review_count">(0 ulasan)</span>
                            <span class="mx-2 text-slate-200 dark:text-slate-700">|</span>
                            <span>Sisa Stok:</span>
                            <span class="font-bold text-slate-800 dark:text-slate-100" id="detail_stock">0</span>
                        </div>
                    </div>
                </div>

                <!-- Kolom Ulasan -->
                <div class="space-y-4">
                    <h5 class="font-bold text-slate-900 dark:text-slate-200 border-b border-slate-100 dark:border-slate-700/50 pb-2 text-sm uppercase tracking-wider">Ulasan Anggota</h5>
                    <div id="reviews_list" class="space-y-4 max-h-[35vh] overflow-y-auto pr-1">
                        <!-- Ulasan-ulasan -->
                    </div>
                </div>
            </div>

            <div class="p-5 border-t border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/40 flex justify-end gap-3" id="detail_footer_action">
                <!-- Action button (e.g. Pinjam) -->
            </div>
        </div>
    </div>

    <script>
        const dModal = document.getElementById('detailModal');
        const dContent = dModal.querySelector('.scale-95');

        function showBookDetail(bookId) {
            fetch(`<?= BASE_URL ?>/book/detail?id=${bookId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const book = data.book;
                        const reviews = data.reviews;

                        // Set Book Info
                        document.getElementById('detail_title').innerText = book.title;
                        document.getElementById('detail_author').innerText = 'oleh ' + book.author;
                        document.getElementById('detail_category').innerText = book.category_name || 'Umum';
                        document.getElementById('detail_stock').innerText = book.stock;

                        // Cover
                        const coverCont = document.getElementById('detail_cover_container');
                        if (book.cover_image) {
                            coverCont.innerHTML = `<img src="<?= BASE_URL ?>/uploads/books/${book.cover_image}" class="w-full h-full object-cover">`;
                        } else {
                            coverCont.innerHTML = `<div class="w-full h-full flex items-center justify-center text-xs text-slate-400 dark:text-slate-500 font-bold select-none"><svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg></div>`;
                        }

                        // Reviews list rendering
                        const reviewsList = document.getElementById('reviews_list');
                        if (reviews.length === 0) {
                            reviewsList.innerHTML = `<p class="text-sm text-slate-500 dark:text-slate-400 italic text-center py-6 select-none font-medium">Belum ada ulasan untuk buku ini.</p>`;
                            document.getElementById('detail_avg_rating').innerText = '0.0';
                            document.getElementById('detail_review_count').innerText = '(0 ulasan)';
                        } else {
                            let totalRating = 0;
                            let reviewsHTML = '';
                            reviews.forEach(rev => {
                                totalRating += parseInt(rev.rating);
                                let stars = '★'.repeat(rev.rating) + '☆'.repeat(5 - rev.rating);
                                reviewsHTML += `
                                    <div class="bg-slate-50/50 dark:bg-slate-900/40 p-4 rounded-2xl border border-slate-100 dark:border-slate-700/50 shadow-sm">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-bold text-xs text-slate-700 dark:text-slate-300">${rev.user_name}</span>
                                            <span class="text-xs text-amber-500 font-semibold tracking-wide">${stars}</span>
                                        </div>
                                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed font-medium mt-1.5">${rev.comment}</p>
                                        <span class="text-[9px] text-slate-400 dark:text-slate-500 block mt-2 font-medium">${rev.created_at}</span>
                                    </div>
                                `;
                            });
                            reviewsList.innerHTML = reviewsHTML;

                            const avgRating = (totalRating / reviews.length).toFixed(1);
                            document.getElementById('detail_avg_rating').innerText = avgRating;
                            document.getElementById('detail_review_count').innerText = `(${reviews.length} ulasan)`;
                        }

                        // Footer Action (Tambah ke Keranjang)
                        const footerAction = document.getElementById('detail_footer_action');
                        if (parseInt(book.stock) > 0) {
                            footerAction.innerHTML = `
                                <button onclick="closeDetailModal()" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 text-sm font-semibold transition-colors">Tutup</button>
                                <a href="<?= BASE_URL ?>/cart/add?id=${book.id}" class="bg-primary hover:bg-opacity-95 text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all shadow-md shadow-primary/20 flex items-center gap-2">Pinjam Buku</a>
                            `;
                        } else {
                            footerAction.innerHTML = `
                                <button onclick="closeDetailModal()" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 text-sm font-semibold transition-colors">Tutup</button>
                                <button disabled class="bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 px-6 py-2.5 rounded-xl font-bold text-sm cursor-not-allowed">Stok Habis</button>
                            `;
                        }

                        // Open modal
                        dModal.classList.remove('hidden');
                        dModal.classList.add('flex');
                        setTimeout(() => {
                            dContent.classList.remove('scale-95');
                            dContent.classList.add('scale-100');
                        }, 50);
                    }
                });
        }

        function closeDetailModal() {
            dContent.classList.remove('scale-100');
            dContent.classList.add('scale-95');
            setTimeout(() => {
                dModal.classList.remove('flex');
                dModal.classList.add('hidden');
            }, 150);
        }

        // Theme Toggle with Micro-Animations
        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            const sunIcon = document.getElementById('theme-icon-sun');
            const moonIcon = document.getElementById('theme-icon-moon');
            if (sunIcon && moonIcon) {
                // Reset rotation
                sunIcon.classList.remove('rotate-90', 'scale-100');
                moonIcon.classList.remove('-rotate-12', 'scale-100');

                if (isDark) {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                    // Add animate classes
                    setTimeout(() => {
                        sunIcon.classList.add('scale-100', 'rotate-90');
                    }, 50);
                } else {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                    // Add animate classes
                    setTimeout(() => {
                        moonIcon.classList.add('scale-100', '-rotate-12');
                    }, 50);
                }
            }
        }

        function toggleDarkMode() {
            // Add rotation class to active button for immediate visual feedback
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

        // Live Search / Filter Implementation
        const searchInput = document.getElementById('search-input');
        const categorySelect = document.getElementById('category-select');
        const bookCards = document.querySelectorAll('.book-card');
        const skeletonCards = document.querySelectorAll('.skeleton-card');
        const liveEmptyState = document.getElementById('live-empty-state');
        let filterTimeout = null;

        function liveFilter() {
            // Hide all book cards immediately and clear empty state
            bookCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(8px) scale(0.98)';
                setTimeout(() => {
                    if (card.style.opacity === '0') {
                        card.style.display = 'none';
                    }
                }, 150);
            });
            if (liveEmptyState) {
                liveEmptyState.style.opacity = '0';
                setTimeout(() => {
                    liveEmptyState.classList.add('hidden');
                }, 150);
            }

            // Show skeleton loader cards
            skeletonCards.forEach(s => {
                s.classList.remove('hidden');
                setTimeout(() => {
                    s.style.opacity = '1';
                }, 20);
            });

            // Debounce
            if (filterTimeout) clearTimeout(filterTimeout);

            filterTimeout = setTimeout(() => {
                const query = searchInput.value.toLowerCase().trim();
                const catId = categorySelect.value;
                let matchCount = 0;

                // Hide skeleton cards
                skeletonCards.forEach(s => {
                    s.style.opacity = '0';
                    setTimeout(() => {
                        s.classList.add('hidden');
                    }, 150);
                });

                // Apply filtering to book cards after skeleton hides
                setTimeout(() => {
                    bookCards.forEach(card => {
                        const title = card.getAttribute('data-title') || '';
                        const author = card.getAttribute('data-author') || '';
                        const category = card.getAttribute('data-category') || '';

                        const queryMatch = !query || title.includes(query) || author.includes(query);
                        const categoryMatch = !catId || category === catId;

                        if (queryMatch && categoryMatch) {
                            card.style.display = 'flex';
                            // Trigger fade in animation
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0) scale(1)';
                            }, 20);
                            matchCount++;
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(8px) scale(0.98)';
                            card.style.display = 'none';
                        }
                    });

                    // Handle empty state
                    if (liveEmptyState) {
                        if (matchCount === 0) {
                            liveEmptyState.classList.remove('hidden');
                            setTimeout(() => {
                                liveEmptyState.style.opacity = '1';
                            }, 20);
                        } else {
                            liveEmptyState.style.opacity = '0';
                            setTimeout(() => {
                                liveEmptyState.classList.add('hidden');
                            }, 300);
                        }
                    }
                }, 150);

            }, 350); // 350ms of pulsing skeleton feel
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

            // Bind live filters
            if (searchInput && categorySelect) {
                searchInput.addEventListener('input', liveFilter);
                categorySelect.addEventListener('change', liveFilter);

                // Intercept form submit to avoid reload
                const searchForm = searchInput.closest('form');
                if (searchForm) {
                    searchForm.addEventListener('submit', (e) => {
                        e.preventDefault();
                        liveFilter();
                    });
                }
            }

            // Set transition styles for cards to allow smooth opacity and scale animations
            bookCards.forEach(card => {
                card.style.transition = 'opacity 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease';
            });
            if (liveEmptyState) {
                liveEmptyState.style.transition = 'opacity 0.3s ease';
            }
        });
    </script>
</body>
</html>
