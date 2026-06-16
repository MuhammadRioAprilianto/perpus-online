<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjamanku - Perpus Online</title>
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
                <a href="<?= BASE_URL ?>/loans" class="text-primary dark:text-indigo-400 font-bold relative flex items-center gap-2 text-sm">
                    <?= renderIcon('clipboard', 'w-4 h-4') ?>
                    <span>Pinjamanku</span>
                </a>
                <a href="<?= BASE_URL ?>/cart" class="text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-indigo-400 font-bold transition-colors relative flex items-center gap-2 text-sm">
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

    <main class="flex-grow max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        
        <div class="mb-10">
            <a href="<?= BASE_URL ?>/" class="text-slate-400 dark:text-slate-400 hover:text-primary dark:hover:text-indigo-400 mb-3 inline-block font-semibold transition-colors text-sm">
                &larr; Kembali ke Katalog
            </a>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Riwayat Pinjamanku</h1>
            <p class="text-slate-400 dark:text-slate-400 text-sm mt-1">Pantau status pengajuan buku, kelola pembayaran jaminan, dan berikan rating ulasan buku yang sudah selesai dibaca.</p>
        </div>

        <?php if(isset($_GET['status'])): ?>
            <?php if($_GET['status'] == 'review_success'): ?>
                <div class="mb-8 p-5 bg-emerald-50 dark:bg-emerald-950/20 text-emerald-800 dark:text-emerald-300 rounded-3xl border border-emerald-100 dark:border-emerald-900/50 flex items-center gap-2 animate-fade-in text-sm font-semibold">
                    <span class="w-5 h-5 text-emerald-500">
                        <?= renderIcon('check-circle', 'w-5 h-5') ?>
                    </span>
                    <span>Ulasan buku berhasil dipublikasikan! Terima kasih atas ulasan Anda.</span>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Tab Filters (Visual Only) -->
        <div class="flex border-b border-slate-200 dark:border-slate-800 mb-8 gap-6 overflow-x-auto pb-1 text-sm font-semibold">
            <button onclick="filterLoans('all')" class="tab-btn pb-3 border-b-2 border-primary text-primary dark:text-indigo-400 dark:border-indigo-400 transition-all duration-300">Semua</button>
            <button onclick="filterLoans('pending')" class="tab-btn pb-3 text-slate-400 border-b-2 border-transparent hover:text-slate-600 dark:hover:text-slate-200 transition-all duration-300">Menunggu (Pending)</button>
            <button onclick="filterLoans('approved')" class="tab-btn pb-3 text-slate-400 border-b-2 border-transparent hover:text-slate-600 dark:hover:text-slate-200 transition-all duration-300">Dipinjam (Active)</button>
            <button onclick="filterLoans('returned')" class="tab-btn pb-3 text-slate-400 border-b-2 border-transparent hover:text-slate-600 dark:hover:text-slate-200 transition-all duration-300">Selesai (Returned)</button>
        </div>

        <div class="space-y-6" id="loans_container">
            <?php if(empty($loans)): ?>
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-12 text-center flex flex-col items-center justify-center">
                    <div class="w-16 h-16 text-slate-400 dark:text-slate-600 mb-6">
                        <?= renderIcon('clipboard', 'w-16 h-16') ?>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Belum ada peminjaman</h3>
                    <p class="text-slate-400 dark:text-slate-400 mb-8 max-w-sm text-sm">Jelajahi koleksi terlengkap buku perpustakaan untuk mulai meminjam.</p>
                    <a href="<?= BASE_URL ?>/" class="bg-primary hover:bg-opacity-95 text-white px-8 py-3.5 rounded-2xl font-bold transition-all duration-300 shadow-lg hover:-translate-y-0.5 text-sm">Lihat Katalog</a>
                </div>
            <?php else: ?>
                <?php foreach($loans as $loan): ?>
                    <div class="loan-card bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-6 transition-all hover:shadow-md hover:border-slate-200/55 dark:hover:border-slate-700 flex flex-col gap-5" data-status="<?= $loan['status'] ?>">
                        
                        <!-- Header Card -->
                        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 dark:border-slate-700 pb-5">
                            <div class="flex items-center gap-3.5">
                                <?php
                                    $badgeColor = 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300';
                                    if ($loan['status'] == 'pending') $badgeColor = 'bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-400';
                                    elseif ($loan['status'] == 'approved') $badgeColor = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400';
                                    elseif ($loan['status'] == 'returned') $badgeColor = 'bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-400';
                                    elseif ($loan['status'] == 'late') $badgeColor = 'bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:text-rose-400';
                                    elseif ($loan['status'] == 'rejected') $badgeColor = 'bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:text-rose-400';
                                ?>
                                <span class="px-3.5 py-1.5 rounded-xl text-[10px] font-extrabold uppercase tracking-wider <?= $badgeColor ?>">
                                    <?= htmlspecialchars($loan['status']) ?>
                                </span>
                                <span class="text-xs text-slate-400 dark:text-slate-400 font-medium">Diajukan: <?= date('d M Y', strtotime($loan['created_at'])) ?></span>
                            </div>
                            
                            <div class="flex flex-wrap gap-5 text-xs font-semibold text-slate-500 dark:text-slate-400">
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 font-medium">Pengambilan:</span>
                                    <span class="text-slate-800 dark:text-slate-300"><?= date('d M Y', strtotime($loan['pickup_date'])) ?></span>
                                </div>
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 font-medium">Jatuh Tempo:</span>
                                    <span class="text-slate-800 dark:text-slate-300"><?= date('d M Y', strtotime($loan['due_date'])) ?></span>
                                </div>
                                <?php if($loan['return_date']): ?>
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 font-medium">Kembali:</span>
                                    <span class="text-slate-800 dark:text-slate-300"><?= date('d M Y', strtotime($loan['return_date'])) ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Data Jaminan / Denda -->
                        <div class="flex flex-wrap justify-between items-center gap-4 bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl text-xs font-bold text-slate-600 dark:text-slate-400">
                            <div>
                                <span class="text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Dana Jaminan:</span>
                                <span class="text-primary dark:text-indigo-400 text-sm font-extrabold">Rp <?= number_format($loan['deposit_amount'], 0, ',', '.') ?></span>
                            </div>
                            <?php if((float)$loan['fine_amount'] > 0): ?>
                            <div class="bg-rose-50 dark:bg-rose-950/20 text-rose-700 dark:text-rose-300 px-4 py-2 rounded-xl border border-rose-100/50 dark:border-rose-900/40">
                                Denda Keterlambatan: Rp <?= number_format($loan['fine_amount'], 0, ',', '.') ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Buku yang dipinjam -->
                        <div class="space-y-4">
                            <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500">Daftar Buku</p>
                            
                            <?php foreach($loan['books'] as $book): ?>
                                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 border-b border-dashed border-slate-100 dark:border-slate-700 pb-4 last:border-0 last:pb-0 group/book">
                                    <div class="flex gap-4 items-center">
                                        <div class="w-12 h-16 bg-slate-50 dark:bg-slate-900 rounded-xl overflow-hidden flex-shrink-0 border border-slate-100 dark:border-slate-700/50 shadow-sm">
                                            <?php if($book['cover_image']): ?>
                                                <img src="<?= BASE_URL ?>/uploads/books/<?= htmlspecialchars($book['cover_image']) ?>" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center text-[9px] text-slate-400 dark:text-slate-500 font-bold leading-none select-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm text-slate-800 dark:text-slate-200 group-hover/book:text-primary dark:group-hover/book:text-indigo-400 transition-colors line-clamp-1"><?= htmlspecialchars($book['title']) ?></h4>
                                            <p class="text-xs text-slate-400 dark:text-slate-400 font-medium mt-0.5">oleh <?= htmlspecialchars($book['author']) ?></p>
                                        </div>
                                    </div>

                                    <!-- Aksi ulasan -->
                                    <?php if(in_array($loan['status'], ['returned', 'late'])): ?>
                                        <div>
                                            <?php if(in_array($book['book_id'], $reviewed_books)): ?>
                                                <span class="inline-block bg-emerald-50 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-400 text-xs font-bold px-3 py-1.5 rounded-xl border border-emerald-100/50 dark:border-emerald-900/40">
                                                    ✓ Ulasan Terkirim
                                                </span>
                                            <?php else: ?>
                                                <button onclick="openReviewModal(<?= $book['book_id'] ?>, '<?= htmlspecialchars(addslashes($book['title'])) ?>')"
                                                        class="bg-accent hover:bg-opacity-95 text-white font-extrabold text-xs px-4 py-2.5 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 shadow-sm shadow-accent/20">
                                                    Tulis Ulasan
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </main>

    <!-- Modal Ulasan Buku -->
    <div id="reviewModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 w-full max-w-md rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-700/50 overflow-hidden transform transition-all scale-95 duration-300">
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-900/40">
                <h3 class="font-extrabold text-lg text-slate-900 dark:text-white">Ulas Buku</h3>
                <button onclick="closeReviewModal()" class="text-slate-400 hover:text-slate-700 text-2xl font-bold transition-colors">&times;</button>
            </div>
            
            <form action="<?= BASE_URL ?>/loans/review" method="POST" class="p-6 space-y-5">
                <input type="hidden" id="modal_book_id" name="book_id">
                
                <div>
                    <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">Judul Buku</label>
                    <p id="modal_book_title" class="font-bold text-slate-800 dark:text-slate-200 text-sm leading-snug line-clamp-2"></p>
                </div>

                <div>
                    <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-2">Penilaian Bintang</label>
                    <div class="flex gap-2" id="star_rating_container">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="<?= $i ?>" required class="sr-only peer">
                                <span class="text-4xl text-slate-200 dark:text-slate-700 peer-checked:text-amber-400 dark:peer-checked:text-amber-400 hover:text-amber-300 dark:hover:text-amber-300 transition-colors duration-250 select-none">★</span>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div>
                    <label for="comment" class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1 font-semibold">Tanggapan / Komentar</label>
                    <textarea id="comment" name="comment" rows="4" required placeholder="Bagikan tanggapan jujur Anda untuk membantu pembaca lain..."
                              class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-900 text-sm text-slate-700 dark:text-slate-300 font-medium"></textarea>
                </div>

                <div class="flex gap-3 justify-end pt-2">
                    <button type="button" onclick="closeReviewModal()" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 text-xs font-bold transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="bg-primary hover:bg-opacity-95 text-white px-6 py-2.5 rounded-xl font-bold text-xs transition-all shadow-md shadow-primary/20">
                        Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php require APP_ROOT . '/views/components/footer.php'; ?>

    <script>
        // Modal functions
        const modal = document.getElementById('reviewModal');
        const modalContent = modal.querySelector('.scale-95');
        const inputBookId = document.getElementById('modal_book_id');
        const textBookTitle = document.getElementById('modal_book_title');

        function openReviewModal(bookId, bookTitle) {
            inputBookId.value = bookId;
            textBookTitle.innerText = bookTitle;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 50);
        }

        function closeReviewModal() {
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 150);
        }

        // Animated star reviews selection
        const starContainer = document.getElementById('star_rating_container');
        const stars = starContainer.querySelectorAll('input[name="rating"]');
        stars.forEach((star, idx) => {
            star.addEventListener('change', () => {
                const labels = starContainer.querySelectorAll('span');
                labels.forEach((label, labelIdx) => {
                    if (labelIdx <= idx) {
                        label.classList.add('text-amber-400', 'dark:text-amber-400');
                        label.classList.remove('text-slate-200', 'dark:text-slate-700');
                    } else {
                        label.classList.remove('text-amber-400', 'dark:text-amber-400');
                        label.classList.add('text-slate-200', 'dark:text-slate-700');
                    }
                });
            });
        });

        // Tab Filtering Logic
        function filterLoans(status) {
            const tabBtns = document.querySelectorAll('.tab-btn');
            tabBtns.forEach(btn => {
                btn.classList.remove('text-primary', 'border-primary', 'dark:text-indigo-400', 'dark:border-indigo-400');
                btn.classList.add('text-slate-400', 'border-transparent');
            });
            
            const activeBtn = event.currentTarget;
            activeBtn.classList.remove('text-slate-400', 'border-transparent');
            activeBtn.classList.add('text-primary', 'border-primary', 'dark:text-indigo-400', 'dark:border-indigo-400');

            const cards = document.querySelectorAll('.loan-card');
            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                if (status === 'all') {
                    card.classList.remove('hidden');
                } else if (status === 'pending') {
                    if (cardStatus === 'pending') card.classList.remove('hidden');
                    else card.hidden = true, card.classList.add('hidden');
                } else if (status === 'approved') {
                    if (cardStatus === 'approved') card.classList.remove('hidden');
                    else card.classList.add('hidden');
                } else if (status === 'returned') {
                    if (cardStatus === 'returned' || cardStatus === 'late') card.classList.remove('hidden');
                    else card.classList.add('hidden');
                }
            });
        }

        // Theme Toggle with Micro-Animations
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


