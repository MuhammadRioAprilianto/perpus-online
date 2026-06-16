<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjamanku - Perpus Online</title>
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
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-base text-main antialiased flex flex-col min-h-screen">

    <nav class="glass-nav shadow-sm border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/perpus-online/public/" class="font-extrabold text-2xl text-primary tracking-tight flex items-center gap-2">
                <span>📚 Perpus<span class="text-accent">Online</span></span>
            </a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-500 font-medium hidden md:block">Halo, <span class="font-bold text-slate-800"><?= htmlspecialchars($_SESSION['user_name']) ?></span>!</span>
                <a href="/perpus-online/public/loans" class="text-primary font-bold relative flex items-center gap-2 text-sm">📋 Pinjamanku</a>
                <a href="/perpus-online/public/cart" class="text-slate-500 hover:text-primary font-bold transition-colors relative flex items-center gap-2 text-sm">🛒 Keranjang</a>
                <a href="/perpus-online/public/logout" class="text-red-500 hover:text-red-700 font-bold transition-colors text-sm">Logout</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        
        <div class="mb-10">
            <a href="/perpus-online/public/" class="text-slate-400 hover:text-primary mb-3 inline-block font-semibold transition-colors text-sm">
                &larr; Kembali ke Katalog
            </a>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Riwayat Pinjamanku</h1>
            <p class="text-slate-400 text-sm mt-1">Pantau status pengajuan buku, kelola pembayaran jaminan, dan berikan rating ulasan buku yang sudah selesai dibaca.</p>
        </div>

        <?php if(isset($_GET['status'])): ?>
            <?php if($_GET['status'] == 'review_success'): ?>
                <div class="mb-8 p-5 bg-emerald-50 text-emerald-800 rounded-3xl border border-emerald-100 flex items-center gap-2 animate-fade-in text-sm font-semibold">
                    <span>✅</span> Ulasan buku berhasil dipublikasikan! Terima kasih atas ulasan Anda.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Tab Filters (Visual Only) -->
        <div class="flex border-b border-slate-100 mb-8 gap-6 overflow-x-auto pb-1 text-sm font-semibold">
            <button onclick="filterLoans('all')" class="tab-btn pb-3 border-b-2 border-primary text-primary transition-all duration-300">Semua</button>
            <button onclick="filterLoans('pending')" class="tab-btn pb-3 text-slate-400 border-b-2 border-transparent hover:text-slate-650 transition-all duration-300">Menunggu (Pending)</button>
            <button onclick="filterLoans('approved')" class="tab-btn pb-3 text-slate-400 border-b-2 border-transparent hover:text-slate-650 transition-all duration-300">Dipinjam (Active)</button>
            <button onclick="filterLoans('returned')" class="tab-btn pb-3 text-slate-400 border-b-2 border-transparent hover:text-slate-650 transition-all duration-300">Selesai (Returned)</button>
        </div>

        <div class="space-y-6" id="loans_container">
            <?php if(empty($loans)): ?>
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-12 text-center flex flex-col items-center justify-center">
                    <span class="text-7xl mb-6">📖</span>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Belum ada peminjaman</h3>
                    <p class="text-slate-400 mb-8 max-w-sm text-sm">Jelajahi koleksi terlengkap buku perpustakaan untuk mulai meminjam.</p>
                    <a href="/perpus-online/public/" class="bg-primary hover:bg-opacity-95 text-white px-8 py-3.5 rounded-2xl font-bold transition-all duration-300 shadow-lg shadow-primary/20 hover:-translate-y-0.5 text-sm">Lihat Katalog</a>
                </div>
            <?php else: ?>
                <?php foreach($loans as $loan): ?>
                    <div class="loan-card bg-white rounded-3xl shadow-sm border border-slate-100 p-6 transition-all hover:shadow-md hover:border-slate-200/55 flex flex-col gap-5" data-status="<?= $loan['status'] ?>">
                        
                        <!-- Header Card -->
                        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-5">
                            <div class="flex items-center gap-3.5">
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
                                <span class="text-xs text-slate-400 font-medium">Diajukan: <?= date('d M Y', strtotime($loan['created_at'])) ?></span>
                            </div>
                            
                            <div class="flex flex-wrap gap-5 text-xs font-semibold text-slate-500">
                                <div>
                                    <span class="text-slate-400 font-medium">Pengambilan:</span>
                                    <span class="text-slate-800"><?= date('d M Y', strtotime($loan['pickup_date'])) ?></span>
                                </div>
                                <div>
                                    <span class="text-slate-400 font-medium">Jatuh Tempo:</span>
                                    <span class="text-slate-800"><?= date('d M Y', strtotime($loan['due_date'])) ?></span>
                                </div>
                                <?php if($loan['return_date']): ?>
                                <div>
                                    <span class="text-slate-400 font-medium">Kembali:</span>
                                    <span class="text-slate-800"><?= date('d M Y', strtotime($loan['return_date'])) ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Data Jaminan / Denda -->
                        <div class="flex flex-wrap justify-between items-center gap-4 bg-slate-50 p-4 rounded-2xl text-xs font-bold text-slate-600">
                            <div>
                                <span class="text-slate-400 font-bold uppercase tracking-wider">Dana Jaminan:</span>
                                <span class="text-primary text-sm font-extrabold">Rp <?= number_format($loan['deposit_amount'], 0, ',', '.') ?></span>
                            </div>
                            <?php if((float)$loan['fine_amount'] > 0): ?>
                            <div class="bg-rose-50 text-rose-700 px-4 py-2 rounded-xl border border-rose-100/50">
                                Denda Keterlambatan: Rp <?= number_format($loan['fine_amount'], 0, ',', '.') ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Buku yang dipinjam -->
                        <div class="space-y-4">
                            <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Daftar Buku</p>
                            
                            <?php foreach($loan['books'] as $book): ?>
                                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 border-b border-dashed border-slate-100 pb-4 last:border-0 last:pb-0 group/book">
                                    <div class="flex gap-4 items-center">
                                        <div class="w-12 h-16 bg-slate-50 rounded-xl overflow-hidden flex-shrink-0 border border-slate-100 shadow-sm">
                                            <?php if($book['cover_image']): ?>
                                                <img src="/perpus-online/public/uploads/books/<?= htmlspecialchars($book['cover_image']) ?>" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center text-[9px] text-slate-400 font-bold leading-none">No Cover</div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm text-slate-800 group-hover/book:text-primary transition-colors line-clamp-1"><?= htmlspecialchars($book['title']) ?></h4>
                                            <p class="text-xs text-slate-400 font-medium">oleh <?= htmlspecialchars($book['author']) ?></p>
                                        </div>
                                    </div>

                                    <!-- Aksi ulasan -->
                                    <?php if(in_array($loan['status'], ['returned', 'late'])): ?>
                                        <div>
                                            <?php if(in_array($book['book_id'], $reviewed_books)): ?>
                                                <span class="inline-block bg-emerald-50 text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-xl border border-emerald-100/50">
                                                    ✓ Ulasan Terkirim
                                                </span>
                                            <?php else: ?>
                                                <button onclick="openReviewModal(<?= $book['book_id'] ?>, '<?= htmlspecialchars(addslashes($book['title'])) ?>')"
                                                        class="bg-accent hover:bg-opacity-95 text-white font-extrabold text-xs px-4 py-2.5 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 shadow-sm shadow-accent/20">
                                                    ✍ Tulis Ulasan
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
        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all scale-95 duration-300">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-lg text-slate-900">Ulas Buku</h3>
                <button onclick="closeReviewModal()" class="text-slate-400 hover:text-slate-700 text-2xl font-bold transition-colors">&times;</button>
            </div>
            
            <form action="/perpus-online/public/loans/review" method="POST" class="p-6 space-y-5">
                <input type="hidden" id="modal_book_id" name="book_id">
                
                <div>
                    <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-1">Judul Buku</label>
                    <p id="modal_book_title" class="font-bold text-slate-800 text-sm leading-snug line-clamp-2"></p>
                </div>

                <div>
                    <label class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">Penilaian Bintang</label>
                    <div class="flex gap-2" id="star_rating_container">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="<?= $i ?>" required class="sr-only peer">
                                <span class="text-4xl text-slate-200 peer-checked:text-amber-400 hover:text-amber-300 transition-colors duration-250 select-none">★</span>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div>
                    <label for="comment" class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-1 font-semibold">Tanggapan / Komentar</label>
                    <textarea id="comment" name="comment" rows="4" required placeholder="Bagikan tanggapan jujur Anda untuk membantu pembaca lain..."
                              class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white text-sm text-slate-700 font-medium"></textarea>
                </div>

                <div class="flex gap-3 justify-end pt-2">
                    <button type="button" onclick="closeReviewModal()" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 text-xs font-bold transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="bg-primary hover:bg-opacity-95 text-white px-6 py-2.5 rounded-xl font-bold text-xs transition-all shadow-md shadow-primary/20">
                        Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-white border-t border-slate-100 py-6 text-center text-xs text-slate-400 font-medium mt-12">
        &copy; 2026 PerpusOnline. Seluruh Hak Cipta Dilindungi.
    </footer>

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
                        label.classList.add('text-amber-400');
                        label.classList.remove('text-slate-200');
                    } else {
                        label.classList.remove('text-amber-400');
                        label.classList.add('text-slate-200');
                    }
                });
            });
        });

        // Tab Filtering Logic
        function filterLoans(status) {
            // Update active tab styling
            const tabBtns = document.querySelectorAll('.tab-btn');
            tabBtns.forEach(btn => {
                btn.classList.remove('text-primary', 'border-primary');
                btn.classList.add('text-slate-400', 'border-transparent');
            });
            
            // Set current tab active style
            const activeBtn = event.currentTarget;
            activeBtn.classList.remove('text-slate-400', 'border-transparent');
            activeBtn.classList.add('text-primary', 'border-primary');

            // Filter cards
            const cards = document.querySelectorAll('.loan-card');
            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                if (status === 'all') {
                    card.classList.remove('hidden');
                } else if (status === 'pending') {
                    if (cardStatus === 'pending') card.classList.remove('hidden');
                    else card.classList.add('hidden');
                } else if (status === 'approved') {
                    if (cardStatus === 'approved') card.classList.remove('hidden');
                    else card.classList.add('hidden');
                } else if (status === 'returned') {
                    if (cardStatus === 'returned' || cardStatus === 'late') card.classList.remove('hidden');
                    else card.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
