<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjamanku - Perpus Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { base: '#F5F2F2', main: '#2B2A2A', primary: '#5A7ACD', accent: '#FEB05D', } } } }
    </script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-base text-main antialiased selection:bg-primary selection:text-white flex flex-col min-h-screen">

    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/perpus-online/public/" class="font-bold text-2xl text-primary">
                Perpus<span class="text-accent">Online</span>
            </a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-500 mr-2 hidden md:block">Halo, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
                <a href="/perpus-online/public/loans" class="text-primary font-bold relative flex items-center gap-2">📋 Pinjamanku</a>
                <a href="/perpus-online/public/cart" class="text-gray-500 hover:text-primary font-medium transition-colors relative flex items-center gap-2">🛒 Keranjang</a>
                <a href="/perpus-online/public/logout" class="ml-4 text-red-500 hover:text-red-700 font-medium transition-colors text-sm">Logout</a>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        
        <div class="mb-8">
            <a href="/perpus-online/public/" class="text-gray-500 hover:text-primary mb-4 inline-block font-medium transition-colors">
                &larr; Kembali ke Katalog
            </a>
            <h1 class="text-3xl font-bold tracking-tight">Riwayat Pinjamanku</h1>
            <p class="text-gray-500 mt-1">Pantau status peminjaman buku Anda dan berikan ulasan buku yang sudah selesai dibaca.</p>
        </div>

        <?php if(isset($_GET['status'])): ?>
            <?php if($_GET['status'] == 'review_success'): ?>
                <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-150 flex items-center">
                    <span class="font-medium">✅ Ulasan buku berhasil dikirim! Terima kasih atas masukan Anda.</span>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="space-y-6">
            <?php if(empty($loans)): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center flex flex-col items-center justify-center">
                    <span class="text-6xl mb-4">📖</span>
                    <h3 class="text-xl font-bold text-main mb-2">Anda belum meminjam buku</h3>
                    <p class="text-gray-500 mb-6">Pilih buku di katalog untuk diajukan peminjaman.</p>
                    <a href="/perpus-online/public/" class="bg-primary hover:bg-opacity-90 text-white px-8 py-3 rounded-xl font-semibold transition-all hover:-translate-y-1">Lihat Katalog</a>
                </div>
            <?php else: ?>
                <?php foreach($loans as $loan): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all hover:shadow-md">
                        
                        <!-- Header status peminjaman -->
                        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 pb-4 mb-4">
                            <div class="flex items-center gap-3">
                                <?php
                                    $badgeColor = 'bg-gray-100 text-gray-700';
                                    if ($loan['status'] == 'pending') $badgeColor = 'bg-yellow-100 text-yellow-700';
                                    elseif ($loan['status'] == 'approved') $badgeColor = 'bg-green-100 text-green-700';
                                    elseif ($loan['status'] == 'returned') $badgeColor = 'bg-blue-100 text-blue-700';
                                    elseif ($loan['status'] == 'late') $badgeColor = 'bg-red-100 text-red-700';
                                    elseif ($loan['status'] == 'rejected') $badgeColor = 'bg-red-100 text-red-700';
                                ?>
                                <span class="px-3 py-1.5 rounded-xl text-xs font-bold uppercase <?= $badgeColor ?>">
                                    <?= htmlspecialchars($loan['status']) ?>
                                </span>
                                <span class="text-xs text-gray-400 font-medium">Diajukan: <?= date('d M Y', strtotime($loan['created_at'])) ?></span>
                            </div>
                            
                            <div class="flex flex-wrap gap-4 text-xs md:text-sm">
                                <div>
                                    <span class="text-gray-400 font-medium">Rencana Ambil:</span>
                                    <span class="font-bold text-main"><?= date('d M Y', strtotime($loan['pickup_date'])) ?></span>
                                </div>
                                <div>
                                    <span class="text-gray-400 font-medium">Batas Kembali:</span>
                                    <span class="font-bold text-main"><?= date('d M Y', strtotime($loan['due_date'])) ?></span>
                                </div>
                                <?php if($loan['return_date']): ?>
                                <div>
                                    <span class="text-gray-400 font-medium">Dikembalikan:</span>
                                    <span class="font-bold text-main"><?= date('d M Y', strtotime($loan['return_date'])) ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Info denda dan jaminan -->
                        <div class="flex flex-wrap justify-between items-center gap-4 bg-gray-50 p-4 rounded-xl mb-4 text-sm">
                            <div>
                                <span class="text-gray-500">Jaminan/Deposit:</span>
                                <span class="font-semibold text-primary">Rp <?= number_format($loan['deposit_amount'], 0, ',', '.') ?></span>
                            </div>
                            <?php if((float)$loan['fine_amount'] > 0): ?>
                            <div class="bg-red-50 text-red-700 px-3 py-1 rounded-lg font-semibold border border-red-100">
                                Denda Terlambat: Rp <?= number_format($loan['fine_amount'], 0, ',', '.') ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Daftar buku dalam peminjaman ini -->
                        <div class="space-y-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Daftar Buku</p>
                            
                            <?php foreach($loan['books'] as $book): ?>
                                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 border-b border-dashed border-gray-100 pb-4 last:border-0 last:pb-0">
                                    <div class="flex gap-4 items-center">
                                        <div class="w-12 h-16 bg-gray-50 rounded-lg overflow-hidden flex-shrink-0 border border-gray-100">
                                            <?php if($book['cover_image']): ?>
                                                <img src="/perpus-online/public/uploads/books/<?= htmlspecialchars($book['cover_image']) ?>" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-400 leading-none">No Cover</div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-main line-clamp-1"><?= htmlspecialchars($book['title']) ?></h4>
                                            <p class="text-xs text-gray-500">oleh <?= htmlspecialchars($book['author']) ?></p>
                                        </div>
                                    </div>

                                    <!-- Tombol beri ulasan jika status returned/late -->
                                    <?php if(in_array($loan['status'], ['returned', 'late'])): ?>
                                        <div>
                                            <?php if(in_array($book['book_id'], $reviewed_books)): ?>
                                                <span class="inline-block bg-green-50 text-green-700 text-xs font-semibold px-3 py-1.5 rounded-lg border border-green-100">
                                                    ✓ Ulasan Terkirim
                                                </span>
                                            <?php else: ?>
                                                <button onclick="openReviewModal(<?= $book['book_id'] ?>, '<?= htmlspecialchars(addslashes($book['title'])) ?>')"
                                                        class="bg-accent hover:bg-opacity-95 text-white font-bold text-xs px-4 py-2 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 shadow-sm shadow-accent/20">
                                                    ✍ Beri Ulasan
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
    <div id="reviewModal" class="fixed inset-0 z-50 bg-black/55 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl border border-gray-100 overflow-hidden transform transition-all scale-95 duration-300">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-lg text-main">Tulis Ulasan Buku</h3>
                <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-700 text-xl font-bold transition-colors">&times;</button>
            </div>
            
            <form action="/perpus-online/public/loans/review" method="POST" class="p-6 space-y-4">
                <input type="hidden" id="modal_book_id" name="book_id">
                
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Buku</label>
                    <p id="modal_book_title" class="font-bold text-main line-clamp-2"></p>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Penilaian (Bintang)</label>
                    <div class="flex gap-2">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="<?= $i ?>" required class="sr-only peer">
                                <span class="text-3xl text-gray-300 peer-checked:text-amber-400 hover:text-amber-300 transition-colors">★</span>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div>
                    <label for="comment" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Komentar / Ulasan</label>
                    <textarea id="comment" name="comment" rows="4" required placeholder="Bagikan pendapat Anda tentang buku ini..."
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors bg-gray-50 focus:bg-white text-sm"></textarea>
                </div>

                <div class="flex gap-3 justify-end pt-2">
                    <button type="button" onclick="closeReviewModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="bg-primary hover:bg-opacity-90 text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-md shadow-primary/20">
                        Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('reviewModal');
        const modalContent = modal.querySelector('.scale-95');
        const inputBookId = document.getElementById('modal_book_id');
        const textBookTitle = document.getElementById('modal_book_title');

        // Buka Modal Ulasan
        function openReviewModal(bookId, bookTitle) {
            inputBookId.value = bookId;
            textBookTitle.innerText = bookTitle;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Animasi masuk
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 50);
        }

        // Tutup Modal Ulasan
        function closeReviewModal() {
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            
            // Animasi keluar
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 150);
        }

        // Bintang interaktif
        const stars = document.querySelectorAll('input[name="rating"]');
        stars.forEach((star, idx) => {
            star.addEventListener('change', () => {
                const labels = star.closest('.flex').querySelectorAll('span');
                labels.forEach((label, labelIdx) => {
                    if (labelIdx <= idx) {
                        label.classList.add('text-amber-400');
                        label.classList.remove('text-gray-300');
                    } else {
                        label.classList.remove('text-amber-400');
                        label.classList.add('text-gray-300');
                    }
                });
            });
        });
    </script>
</body>
</html>
