<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - Perpus Online</title>
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
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .floating-circle {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.05); }
        }
    </style>
</head>
<body class="bg-base text-main antialiased selection:bg-primary selection:text-white flex flex-col min-h-screen">

    <!-- Glowing Background Ornaments -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl -z-10 pointer-events-none"></div>
    <div class="absolute top-80 right-1/4 w-96 h-96 bg-accent/5 rounded-full blur-3xl -z-10 pointer-events-none"></div>

    <nav class="glass-nav shadow-sm border-b border-slate-100 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/perpus-online/public/" class="font-extrabold text-2xl text-primary tracking-tight hover:opacity-90 transition-opacity flex items-center gap-2">
                <span>📚 Perpus<span class="text-accent">Online</span></span>
            </a>
            
            <div class="flex items-center gap-5">
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <a href="/perpus-online/public/login" class="text-slate-600 hover:text-primary font-semibold transition-colors text-sm">Masuk</a>
                    <a href="/perpus-online/public/register" class="bg-primary hover:bg-opacity-95 hover:shadow-lg hover:shadow-primary/20 text-white px-6 py-3 rounded-2xl font-bold transition-all duration-300 hover:-translate-y-0.5 text-sm">Daftar</a>
                <?php else: ?>
                    <span class="text-sm text-slate-500 font-medium hidden md:block">Halo, <span class="text-slate-800 font-bold"><?= htmlspecialchars($_SESSION['user_name']) ?></span>!</span>
                    
                    <?php if($_SESSION['user_role'] == 'admin'): ?>
                        <a href="/perpus-online/public/admin/dashboard" class="bg-accent hover:bg-opacity-95 text-white px-5 py-2.5 rounded-xl font-bold shadow-sm transition-all hover:-translate-y-0.5 text-sm">Dashboard Admin</a>
                    <?php else: ?>
                        <a href="/perpus-online/public/loans" class="text-slate-600 hover:text-primary font-bold transition-colors flex items-center gap-1 text-sm">
                            📋 Pinjamanku
                        </a>
                        <a href="/perpus-online/public/cart" class="bg-slate-100 hover:bg-primary hover:text-white text-slate-700 px-4 py-2.5 rounded-2xl font-bold transition-all duration-300 flex items-center gap-2 text-sm relative">
                            <span>🛒 Keranjang</span>
                        </a>
                    <?php endif; ?>
                    
                    <a href="/perpus-online/public/logout" class="text-red-500 hover:text-red-700 font-bold transition-colors text-sm">Keluar</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        
        <!-- Premium Hero Section -->
        <div class="bg-gradient-to-tr from-indigo-700 via-violet-600 to-primary text-white rounded-4xl p-8 md:p-14 mb-12 shadow-xl shadow-indigo-700/10 flex flex-col md:flex-row items-center justify-between gap-10 overflow-hidden relative">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,0.1),transparent)] pointer-events-none"></div>
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/5 rounded-full blur-xl pointer-events-none"></div>
            
            <div class="max-w-xl z-10">
                <span class="bg-white/10 text-white/90 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider mb-4 inline-block">
                    ⚡ Perpustakaan Masa Depan
                </span>
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight tracking-tight">
                    Temukan Dunia Baru Melalui Lembaran Buku.
                </h1>
                <p class="text-indigo-100 opacity-90 text-base md:text-lg mb-0 font-medium">
                    Lakukan pemesanan pinjam secara online, ambil fisik buku di lokasi kapan saja tanpa mengantre.
                </p>
            </div>
            
            <div class="text-8xl select-none floating-circle drop-shadow-2xl z-10">
                📚
            </div>
        </div>

        <!-- Alerts / Status -->
        <?php if(isset($_GET['status'])): ?>
            <?php if($_GET['status'] == 'added_to_cart'): ?>
                <div class="mb-8 p-5 bg-emerald-50 text-emerald-950 rounded-3xl border border-emerald-200 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4 animate-fade-in">
                    <span class="font-extrabold flex items-center gap-2 text-sm sm:text-base">
                        <span class="text-lg">✅</span> <span class="text-emerald-950">Buku berhasil ditambahkan ke keranjang belanja Anda!</span>
                    </span>
                    <a href="/perpus-online/public/cart" class="bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-2.5 rounded-2xl font-black transition-colors text-sm shadow-md">
                        Buka Keranjang &rarr;
                    </a>
                </div>
            <?php elseif($_GET['status'] == 'cart_full'): ?>
                <div class="mb-8 p-5 bg-rose-50 text-rose-950 rounded-3xl border border-rose-200 shadow-sm flex items-center gap-3 animate-fade-in text-sm sm:text-base">
                    <span class="text-lg">⚠️</span> 
                    <span class="font-black text-rose-950">Batas penuh!</span> 
                    <span class="font-bold text-rose-950">Maksimal buku yang dipinjam bersamaan adalah 3 buah.</span>
                </div>
            <?php elseif($_GET['status'] == 'already_in_cart'): ?>
                <div class="mb-8 p-5 bg-amber-50 text-amber-950 rounded-3xl border border-amber-200 shadow-sm flex items-center gap-3 animate-fade-in text-sm sm:text-base">
                    <span class="text-lg">ℹ️</span> 
                    <span class="font-bold text-amber-950">Buku tersebut sudah terdaftar di keranjang Anda.</span>
                </div>
            <?php elseif($_GET['status'] == 'loan_success'): ?>
                <div class="mb-8 p-5 bg-emerald-50 text-emerald-950 rounded-3xl border border-emerald-200 shadow-sm flex items-center gap-3 animate-fade-in text-sm sm:text-base">
                    <span class="text-lg">🎉</span> 
                    <span class="font-bold text-emerald-950">Peminjaman sukses diajukan! Silakan ambil buku Anda sesuai tanggal pengambilan.</span>
                </div>
            <?php elseif($_GET['status'] == 'removed'): ?>
                <div class="mb-8 p-5 bg-blue-50 text-blue-950 rounded-3xl border border-blue-200 shadow-sm flex items-center gap-3 animate-fade-in text-sm sm:text-base">
                    <span class="text-lg">🗑️</span> 
                    <span class="font-bold text-blue-950">Buku berhasil dihapus dari keranjang.</span>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Search and Filter Panel -->
        <form method="GET" action="/perpus-online/public/" class="mb-12 bg-white p-5 rounded-3xl shadow-sm border border-slate-100 flex flex-col md:flex-row gap-4 items-center">
            
            <div class="flex-1 w-full relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">🔍</span>
                <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                    placeholder="Masukkan judul buku atau nama penulis..." 
                    class="w-full pl-11 pr-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white text-sm text-slate-700 font-medium">
            </div>
            
            <div class="w-full md:w-64">
                <select name="category" class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white text-sm text-slate-700 font-semibold cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '' ?>>
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
                    <a href="/perpus-online/public/" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-6 py-3.5 rounded-2xl font-semibold transition-all text-sm text-center">
                        Reset
                    </a>
                <?php endif; ?>
            </div>
            
        </form>

        <!-- Catalog Section -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">Koleksi Buku Terpopuler</h2>
                <p class="text-sm text-slate-400 mt-1">Daftar buku pilihan yang tersedia untuk dipinjam.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <?php if(empty($books)): ?>
                <div class="col-span-full py-16 text-center text-slate-400 font-medium">
                    <div class="text-5xl mb-4">📭</div>
                    Buku yang Anda cari tidak ditemukan atau belum tersedia.
                </div>
            <?php else: ?>
                <?php foreach($books as $book): ?>
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-slate-200/50 group">
                        
                        <!-- Book Cover with Badges -->
                        <div class="relative bg-slate-50 aspect-[3/4] overflow-hidden flex items-center justify-center border-b border-slate-50">
                            <?php if($book['cover_image']): ?>
                                <img src="/perpus-online/public/uploads/books/<?= htmlspecialchars($book['cover_image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <?php else: ?>
                                <div class="text-slate-300 text-lg flex flex-col items-center gap-1 font-bold">
                                    <span class="text-4xl">📖</span>
                                    <span>No Cover</span>
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
                            <span class="text-[10px] font-extrabold text-primary uppercase tracking-wider mb-2 block">
                                <?= htmlspecialchars($book['category_name'] ?? 'Umum') ?>
                            </span>
                            <h3 class="font-bold text-base md:text-lg leading-snug mb-1 line-clamp-2 text-slate-800 flex-1 hover:text-primary transition-colors cursor-pointer" onclick="showBookDetail(<?= $book['id'] ?>)">
                                <?= htmlspecialchars($book['title']) ?>
                            </h3>
                            <p class="text-xs text-slate-400 mb-3 font-medium">
                                oleh <?= htmlspecialchars($book['author']) ?>
                            </p>
                            
                            <!-- Star Rating -->
                            <div class="flex items-center gap-1.5 mb-5 text-xs text-slate-500">
                                <span class="text-amber-400 text-base">★</span>
                                <span class="font-bold text-slate-700"><?= number_format($book['avg_rating'], 1) ?></span>
                                <span class="text-slate-400">•</span>
                                <span><?= $book['review_count'] ?> ulasan</span>
                            </div>

                            <div class="space-y-2">
                                <button onclick="showBookDetail(<?= $book['id'] ?>)" class="w-full block text-center bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold py-2.5 rounded-2xl text-xs transition-colors border border-slate-150">
                                    Detail & Ulasan
                                </button>
                                
                                <?php if($book['stock'] > 0): ?>
                                    <a href="/perpus-online/public/cart/add?id=<?= $book['id'] ?>" class="w-full block text-center bg-primary hover:bg-opacity-95 text-white font-bold py-3 rounded-2xl transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 text-xs">
                                        Pinjam Buku
                                    </a>
                                <?php else: ?>
                                    <button disabled class="w-full block text-center bg-slate-100 text-slate-400 font-bold py-3 rounded-2xl cursor-not-allowed text-xs">
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
    <footer class="bg-white border-t border-slate-100 py-8 mt-12 text-center text-xs text-slate-400 font-medium">
        <div class="max-w-7xl mx-auto px-4">
            &copy; 2026 PerpusOnline. Seluruh Hak Cipta Dilindungi.
        </div>
    </footer>

    <!-- Modal Detail Buku & Ulasan -->
    <div id="detailModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all scale-95 duration-300 flex flex-col max-h-[85vh]">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-lg text-slate-900">Detail & Ulasan</h3>
                <button onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-700 text-2xl font-bold transition-colors">&times;</button>
            </div>
            
            <div class="p-6 overflow-y-auto space-y-6 flex-1">
                <!-- Info Buku -->
                <div class="flex gap-5">
                    <div class="w-24 h-32 bg-slate-50 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-100 shadow-sm" id="detail_cover_container">
                        <!-- Cover Image -->
                    </div>
                    <div class="flex-1 flex flex-col justify-center">
                        <div>
                            <span class="bg-primary/10 text-primary px-3 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wider" id="detail_category">Kategori</span>
                        </div>
                        <h4 class="font-extrabold text-lg text-slate-900 mt-2 leading-snug" id="detail_title">Judul Buku</h4>
                        <p class="text-sm text-slate-400 mt-0.5 font-medium" id="detail_author">Penulis</p>
                        <div class="flex items-center gap-1.5 mt-3 text-xs text-slate-500 flex-wrap">
                            <span class="text-amber-400 text-lg">★</span>
                            <span class="font-bold text-slate-700 text-sm" id="detail_avg_rating">0.0</span>
                            <span id="detail_review_count">(0 ulasan)</span>
                            <span class="mx-2 text-slate-200">|</span>
                            <span>Sisa Stok:</span>
                            <span class="font-bold text-slate-800" id="detail_stock">0</span>
                        </div>
                    </div>
                </div>

                <!-- Kolom Ulasan -->
                <div class="space-y-4">
                    <h5 class="font-bold text-slate-900 border-b border-slate-100 pb-2 text-sm uppercase tracking-wider">Ulasan Anggota</h5>
                    <div id="reviews_list" class="space-y-4 max-h-[35vh] overflow-y-auto pr-1">
                        <!-- Ulasan-ulasan -->
                    </div>
                </div>
            </div>

            <div class="p-5 border-t border-slate-100 bg-slate-50/50 flex justify-end gap-3" id="detail_footer_action">
                <!-- Action button (e.g. Pinjam) -->
            </div>
        </div>
    </div>

    <script>
        const dModal = document.getElementById('detailModal');
        const dContent = dModal.querySelector('.scale-95');

        function showBookDetail(bookId) {
            // Fetch book details via AJAX
            fetch(`/perpus-online/public/book/detail?id=${bookId}`)
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
                            coverCont.innerHTML = `<img src="/perpus-online/public/uploads/books/${book.cover_image}" class="w-full h-full object-cover">`;
                        } else {
                            coverCont.innerHTML = `<div class="w-full h-full flex items-center justify-center text-xs text-slate-400">No Cover</div>`;
                        }

                        // Reviews list rendering
                        const reviewsList = document.getElementById('reviews_list');
                        if (reviews.length === 0) {
                            reviewsList.innerHTML = `<p class="text-sm text-slate-450 italic text-center py-6">Belum ada ulasan untuk buku ini.</p>`;
                            document.getElementById('detail_avg_rating').innerText = '0.0';
                            document.getElementById('detail_review_count').innerText = '(0 ulasan)';
                        } else {
                            let totalRating = 0;
                            let reviewsHTML = '';
                            reviews.forEach(rev => {
                                totalRating += parseInt(rev.rating);
                                let stars = '★'.repeat(rev.rating) + '☆'.repeat(5 - rev.rating);
                                reviewsHTML += `
                                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100 shadow-sm">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-bold text-xs text-slate-700">${rev.user_name}</span>
                                            <span class="text-xs text-amber-500 font-semibold tracking-wide">${stars}</span>
                                        </div>
                                        <p class="text-xs text-slate-600 leading-relaxed font-medium mt-1.5">${rev.comment}</p>
                                        <span class="text-[9px] text-slate-400 block mt-2 font-medium">${rev.created_at}</span>
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
                                <button onclick="closeDetailModal()" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-650 hover:bg-slate-100 text-sm font-semibold transition-colors">Tutup</button>
                                <a href="/perpus-online/public/cart/add?id=${book.id}" class="bg-primary hover:bg-opacity-95 text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all shadow-md shadow-primary/20 flex items-center gap-2">🛒 Pinjam Buku</a>
                            `;
                        } else {
                            footerAction.innerHTML = `
                                <button onclick="closeDetailModal()" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-650 hover:bg-slate-100 text-sm font-semibold transition-colors">Tutup</button>
                                <button disabled class="bg-slate-100 text-slate-400 px-6 py-2.5 rounded-xl font-bold text-sm cursor-not-allowed">Stok Habis</button>
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
    </script>

</body>
</html>