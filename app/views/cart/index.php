<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Pinjam - Perpus Online</title>
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
                <a href="/perpus-online/public/cart" class="text-primary font-bold relative flex items-center gap-2">🛒 Keranjang</a>
                <a href="/perpus-online/public/logout" class="ml-4 text-red-500 hover:text-red-700 font-medium transition-colors text-sm">Logout</a>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        
        <div class="mb-8">
            <a href="/perpus-online/public/" class="text-gray-500 hover:text-primary mb-4 inline-block font-medium transition-colors">
                &larr; Kembali ke Katalog
            </a>
            <h1 class="text-3xl font-bold tracking-tight">Keranjang Pinjam</h1>
            <p class="text-gray-500 mt-1">Maksimal peminjaman adalah 3 buku dalam satu transaksi.</p>
        </div>

        <?php if(isset($_GET['status'])): ?>
            <?php if($_GET['status'] == 'added'): ?>
                <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-100">Buku berhasil ditambahkan ke keranjang!</div>
            <?php elseif($_GET['status'] == 'removed'): ?>
                <div class="mb-6 p-4 bg-blue-50 text-blue-700 rounded-xl border border-blue-100">Buku dihapus dari keranjang.</div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="flex-1 space-y-4">
                <?php if(empty($cartItems)): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center flex flex-col items-center justify-center">
                        <span class="text-6xl mb-4">🛒</span>
                        <h3 class="text-xl font-bold text-main mb-2">Keranjang Anda masih kosong</h3>
                        <p class="text-gray-500 mb-6">Jelajahi katalog kami dan temukan buku menarik untuk dibaca.</p>
                        <a href="/perpus-online/public/" class="bg-primary hover:bg-opacity-90 text-white px-8 py-3 rounded-xl font-semibold transition-all hover:-translate-y-1">Lihat Katalog Buku</a>
                    </div>
                <?php else: ?>
                    <?php foreach($cartItems as $item): ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex gap-4 items-center transition-all hover:shadow-md">
                            
                            <div class="w-20 h-28 bg-base rounded-xl overflow-hidden flex-shrink-0">
                                <?php if($item['cover_image']): ?>
                                    <img src="/perpus-online/public/uploads/books/<?= htmlspecialchars($item['cover_image']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Cover</div>
                                <?php endif; ?>
                            </div>

                            <div class="flex-1">
                                <h3 class="font-bold text-lg text-main line-clamp-1"><?= htmlspecialchars($item['title']) ?></h3>
                                <p class="text-sm text-gray-500">oleh <?= htmlspecialchars($item['author']) ?></p>
                            </div>

                            <div class="pr-2">
                                <a href="/perpus-online/public/cart/remove?id=<?= $item['cart_id'] ?>" 
                                   onclick="return confirm('Hapus buku ini dari keranjang?')"
                                   class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors" title="Hapus">
                                   🗑️
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?php if(!empty($cartItems)): ?>
            <div class="w-full lg:w-96">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                    <h2 class="text-xl font-bold text-main mb-4 border-b border-gray-100 pb-4">Ringkasan Peminjaman</h2>
                    
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-500">Total Buku</span>
                        <span class="font-bold text-lg text-main"><?= count($cartItems) ?> Buku</span>
                    </div>

                    <?php 
                        $depositPerBuku = 50000;
                        $totalDeposit = count($cartItems) * $depositPerBuku;
                    ?>
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-gray-500">Biaya Deposit/Jaminan</span>
                        <span class="font-bold text-lg text-primary">Rp <?= number_format($totalDeposit, 0, ',', '.') ?></span>
                    </div>

                    <div class="bg-blue-50 text-blue-700 text-xs p-3 rounded-xl mb-6">
                        Deposit akan dikembalikan penuh saat buku dikembalikan tepat waktu tanpa kerusakan.
                    </div>

                    <form action="/perpus-online/public/checkout" method="POST" class="space-y-4">
                        <div class="space-y-2">
                            <label for="pickup_date" class="block font-semibold text-sm text-gray-700">Tanggal Rencana Ambil <span class="text-red-500">*</span></label>
                            <input type="date" id="pickup_date" name="pickup_date" required min="<?= date('Y-m-d') ?>"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors bg-gray-50 focus:bg-white text-sm">
                        </div>

                        <input type="hidden" name="deposit_amount" value="<?= $totalDeposit ?>">

                        <button type="submit" class="w-full bg-accent hover:bg-opacity-90 text-white font-semibold py-3.5 rounded-xl shadow-sm shadow-accent/30 transition-all duration-300 transform hover:-translate-y-1 mt-2 flex justify-center items-center gap-2">
                            Lanjut ke Pembayaran &rarr;
                        </button>
                    </form>

                </div>
            </div>
            <?php endif; ?>

        </div>
    </main>

</body>
</html>