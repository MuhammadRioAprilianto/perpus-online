<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Admin Perpustakaan</title>
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
                    <a href="<?= BASE_URL ?>/admin/books" class="text-slate-400 dark:text-slate-400 hover:text-primary dark:hover:text-indigo-400 mb-3 inline-block font-semibold transition-colors text-sm">
                        &larr; Kembali ke Daftar
                    </a>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Ubah Data Buku</h1>
                    <p class="text-slate-400 dark:text-slate-400 text-sm mt-1.5 font-medium">Ubah rincian informasi dan gambar sampul untuk buku: <span class="text-slate-800 dark:text-slate-200 font-bold"><?= htmlspecialchars($book['title']) ?></span></p>
                </div>

                <!-- Form Card -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 p-8 max-w-3xl transition-colors">
                    <form action="<?= BASE_URL ?>/admin/books/edit?id=<?= $book['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="space-y-2 md:col-span-2">
                                <label for="title" class="block font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Judul Buku</label>
                                <input type="text" id="title" name="title" required value="<?= htmlspecialchars($book['title']) ?>"
                                    class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 dark:bg-slate-950 focus:bg-white dark:focus:bg-slate-900 text-sm font-semibold text-slate-800 dark:text-slate-200">
                            </div>

                            <div class="space-y-2">
                                <label for="author" class="block font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Penulis / Pengarang</label>
                                <input type="text" id="author" name="author" required value="<?= htmlspecialchars($book['author']) ?>"
                                    class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 dark:bg-slate-950 focus:bg-white dark:focus:bg-slate-900 text-sm font-semibold text-slate-800 dark:text-slate-200">
                            </div>

                            <div class="space-y-2">
                                <label for="category_id" class="block font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Kategori</label>
                                <select id="category_id" name="category_id" 
                                    class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-900 text-sm font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" <?= ($category['id'] == $book['category_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="stock" class="block font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Jumlah Stok</label>
                                <input type="number" id="stock" name="stock" required min="0" value="<?= htmlspecialchars($book['stock']) ?>"
                                    class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 dark:bg-slate-950 focus:bg-white dark:focus:bg-slate-900 text-sm font-bold text-slate-700 dark:text-slate-300">
                            </div>

                            <div class="space-y-2 md:col-span-2">
                                <label for="cover_image" class="block font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Gambar Sampul Baru (Opsional)</label>
                                <input type="file" id="cover_image" name="cover_image" accept="image/jpeg, image/png, image/webp"
                                    class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 dark:bg-slate-950 focus:bg-white dark:focus:bg-slate-900 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer text-sm font-semibold text-slate-500 dark:text-slate-400">
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1.5 font-medium">Biarkan kosong jika tidak ingin mengganti gambar sampul.</p>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-200 dark:border-slate-800 flex items-center justify-end gap-4">
                            <a href="<?= BASE_URL ?>/admin/books" class="px-6 py-3 font-bold text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors text-sm">Batal</a>
                            <button type="submit" class="bg-primary hover:bg-opacity-95 text-white px-8 py-3.5 rounded-2xl font-bold transition-all duration-300 hover:-translate-y-0.5 text-sm">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
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
