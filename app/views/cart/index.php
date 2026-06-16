<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Pinjam - Perpus Online</title>
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
                <a href="/perpus-online/public/loans" class="text-slate-500 hover:text-primary font-bold transition-colors text-sm">📋 Pinjamanku</a>
                <a href="/perpus-online/public/cart" class="text-primary font-bold relative flex items-center gap-2 text-sm">🛒 Keranjang</a>
                <a href="/perpus-online/public/logout" class="text-red-500 hover:text-red-700 font-bold transition-colors text-sm">Logout</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        
        <!-- Progress Tracker -->
        <div class="max-w-3xl mx-auto mb-12">
            <div class="flex items-center justify-between relative">
                <!-- Line -->
                <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-1 bg-slate-200 -z-10 rounded-full"></div>
                <div class="absolute left-0 w-1/2 top-1/2 -translate-y-1/2 h-1 bg-primary -z-10 rounded-full"></div>
                
                <!-- Steps -->
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold shadow-md shadow-primary/20 ring-4 ring-white text-sm">1</div>
                    <span class="text-xs font-bold text-primary">Keranjang Pinjam</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 bg-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold ring-4 ring-white text-sm">2</div>
                    <span class="text-xs font-semibold text-slate-400">Pembayaran Deposit</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 bg-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold ring-4 ring-white text-sm">3</div>
                    <span class="text-xs font-semibold text-slate-400">Persetujuan Pustakawan</span>
                </div>
            </div>
        </div>

        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <a href="/perpus-online/public/" class="text-slate-400 hover:text-primary mb-3 inline-block font-semibold transition-colors text-sm">
                    &larr; Kembali ke Katalog
                </a>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Keranjang Peminjaman</h1>
                <p class="text-slate-400 text-sm mt-1">Sesuai peraturan perpustakaan, Anda dapat meminjam maksimal 3 judul buku sekaligus.</p>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Daftar Buku di Keranjang -->
            <div class="flex-grow space-y-4">
                <?php if(empty($cartItems)): ?>
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-12 text-center flex flex-col items-center justify-center">
                        <span class="text-7xl mb-6">🛒</span>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Keranjang Anda masih kosong</h3>
                        <p class="text-slate-400 mb-8 max-w-sm text-sm">Silakan jelajahi katalog buku kami untuk menambahkan buku yang ingin dipinjam.</p>
                        <a href="/perpus-online/public/" class="bg-primary hover:bg-opacity-95 text-white px-8 py-3.5 rounded-2xl font-bold transition-all duration-300 shadow-lg shadow-primary/20 hover:-translate-y-0.5 text-sm">Kembali ke Katalog</a>
                    </div>
                <?php else: ?>
                    <?php foreach($cartItems as $item): ?>
                        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5 flex gap-5 items-center transition-all hover:shadow-md hover:border-slate-200/55 group">
                            
                            <div class="w-20 h-28 bg-slate-50 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-100">
                                <?php if($item['cover_image']): ?>
                                    <img src="/perpus-online/public/uploads/books/<?= htmlspecialchars($item['cover_image']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-xs text-slate-400 font-bold">No Cover</div>
                                <?php endif; ?>
                            </div>

                            <div class="flex-1">
                                <span class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider">Buku Fisik</span>
                                <h3 class="font-bold text-lg text-slate-900 leading-snug mt-1.5 group-hover:text-primary transition-colors"><?= htmlspecialchars($item['title']) ?></h3>
                                <p class="text-xs text-slate-400 mt-1 font-semibold">penulis: <?= htmlspecialchars($item['author']) ?></p>
                            </div>

                            <div class="pr-2">
                                <a href="/perpus-online/public/cart/remove?id=<?= $item['cart_id'] ?>" 
                                   onclick="return confirm('Hapus buku ini dari keranjang?')"
                                   class="w-11 h-11 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all duration-300 hover:shadow-lg hover:shadow-rose-500/20" title="Hapus">
                                   🗑️
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Ringkasan Peminjaman -->
            <?php if(!empty($cartItems)): ?>
            <div class="w-full lg:w-96 flex-shrink-0">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 sticky top-28">
                    <h2 class="text-xl font-bold text-slate-900 mb-5 border-b border-slate-100 pb-4">Ringkasan</h2>
                    
                    <div class="flex justify-between items-center mb-3 text-sm">
                        <span class="text-slate-400 font-semibold">Total Buku</span>
                        <span class="font-bold text-slate-800"><?= count($cartItems) ?> Buku</span>
                    </div>

                    <?php 
                        $depositPerBuku = 50000;
                        $totalDeposit = count($cartItems) * $depositPerBuku;
                    ?>
                    <div class="flex justify-between items-center mb-6 text-sm">
                        <span class="text-slate-400 font-semibold">Jaminan Deposit</span>
                        <span class="font-extrabold text-base text-primary">Rp <?= number_format($totalDeposit, 0, ',', '.') ?></span>
                    </div>

                    <div class="bg-blue-50/50 text-blue-700 text-xs p-4 rounded-2xl mb-6 leading-relaxed border border-blue-100/50 font-medium">
                        ℹ️ Biaya jaminan akan dikembalikan penuh (100%) ketika seluruh buku dikembalikan tepat waktu dalam kondisi baik.
                    </div>

                    <form action="/perpus-online/public/checkout" method="POST" class="space-y-5">
                        <div class="space-y-2">
                            <label for="pickup_date" class="block font-bold text-xs uppercase tracking-wider text-slate-400">Rencana Tanggal Pengambilan <span class="text-rose-500">*</span></label>
                            <input type="date" id="pickup_date" name="pickup_date" required min="<?= date('Y-m-d') ?>"
                                class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white text-sm text-slate-700 font-semibold">
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

    <footer class="bg-white border-t border-slate-100 py-6 text-center text-xs text-slate-400 font-medium">
        &copy; 2026 PerpusOnline. Seluruh Hak Cipta Dilindungi.
    </footer>

</body>
</html>