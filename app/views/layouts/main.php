<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
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
                    }
                }
            }
        }
    </script>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        html {
            color-scheme: light;
        }
        html.dark {
            color-scheme: dark;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-slate-900 dark:text-slate-100 flex flex-col min-h-screen transition-colors duration-300">

    <nav class="bg-white dark:bg-slate-800 shadow-md sticky top-0 z-50 border-b border-slate-100 dark:border-slate-700/50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?= BASE_URL ?>" class="text-2xl font-extrabold text-indigo-600 dark:text-indigo-400 tracking-tight flex items-center gap-2">
                        <span>Perpus<span class="text-amber-500">Online</span></span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= BASE_URL ?>/" class="text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition">Beranda</a>
                    <a href="<?= BASE_URL ?>/catalog" class="text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition">Katalog</a>
                    
                    <?php if(!isset($_SESSION['user_id'])): ?>
                        <a href="<?= BASE_URL ?>/login" class="text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition">Masuk</a>
                        <a href="<?= BASE_URL ?>/register" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl transition font-bold text-sm shadow-sm">Daftar</a>
                    <?php else: ?>
                        <!-- Profile Dropdown -->
                        <div class="relative inline-block text-left shadow-none" id="user-menu-wrapper">
                            <button onclick="toggleUserMenu()" class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200/80 dark:bg-slate-800 dark:hover:bg-slate-750 transition-all font-bold text-xs text-slate-700 dark:text-slate-200 focus:outline-none">
                                <div class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center text-[10px] font-black uppercase tracking-wider select-none">
                                    <?= substr($_SESSION['user_name'], 0, 1) ?>
                                </div>
                                <span class="max-w-[100px] truncate"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" id="user-menu-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="user-dropdown-menu" class="origin-top-right absolute right-0 mt-2.5 w-52 rounded-2xl shadow-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/80 py-2 z-50 hidden transition-all duration-200 scale-95 opacity-0 transform">
                                <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-700/60 mb-1.5">
                                    <p class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">Masuk sebagai</p>
                                    <p class="font-bold text-slate-800 dark:text-slate-200 text-xs truncate"><?= htmlspecialchars($_SESSION['user_name']) ?></p>
                                    <span class="inline-block bg-primary/10 text-primary dark:text-indigo-400 text-[8px] font-extrabold uppercase px-1.5 py-0.5 rounded-md mt-1"><?= $_SESSION['user_role'] == 'admin' ? 'Pustakawan' : 'Member' ?></span>
                                </div>

                                <?php if($_SESSION['user_role'] == 'admin'): ?>
                                    <a href="<?= BASE_URL ?>/admin/dashboard" class="flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-slate-750 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-primary dark:hover:text-white transition-colors">
                                        <?= renderIcon('dashboard', 'w-3.5 h-3.5') ?>
                                        <span>Dashboard Admin</span>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= BASE_URL ?>/loans" class="flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-slate-750 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-primary dark:hover:text-white transition-colors">
                                        <?= renderIcon('clipboard', 'w-3.5 h-3.5') ?>
                                        <span>Pinjamanku</span>
                                    </a>
                                    <a href="<?= BASE_URL ?>/cart" class="flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-slate-750 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-primary dark:hover:text-white transition-colors">
                                        <?= renderIcon('cart', 'w-3.5 h-3.5') ?>
                                        <span>Keranjang</span>
                                    </a>
                                <?php endif; ?>
                                
                                <div class="border-t border-slate-100 dark:border-slate-700/60 my-1.5"></div>
                                
                                <a href="<?= BASE_URL ?>/logout" class="flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-red-500 hover:bg-red-50 dark:hover:bg-red-950/20 transition-colors">
                                    <?= renderIcon('logout', 'w-3.5 h-3.5 text-red-500') ?>
                                    <span>Keluar</span>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 transition-colors" title="Ubah Tema">
                        <svg id="theme-icon-sun" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                        <svg id="theme-icon-moon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <?= $content ?? '' ?> 
    </main>

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
        });
    </script>
</body>
</html>