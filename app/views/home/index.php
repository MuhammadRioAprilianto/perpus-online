<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog - Perpus Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { base: '#F5F2F2', main: '#2B2A2A', primary: '#5A7ACD', accent: '#FEB05D', } } } }
    </script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-base text-main antialiased selection:bg-primary selection:text-white flex flex-col min-h-screen">

    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="font-bold text-2xl text-primary">
                Perpus<span class="text-accent">Online</span>
            </div>
            
            <div class="flex items-center gap-4">
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <a href="/perpus-online/public/login" class="text-gray-500 hover:text-primary font-medium transition-colors">Masuk</a>
                    <a href="/perpus-online/public/register" class="bg-primary hover:bg-opacity-90 text-white px-5 py-2.5 rounded-xl font-semibold shadow-sm transition-all hover:-translate-y-0.5">Daftar</a>
                <?php else: ?>
                    <span class="text-sm text-gray-500 mr-2 hidden md:block">Halo, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
                    
                    <?php if($_SESSION['user_role'] == 'admin'): ?>
                        <a href="/perpus-online/public/admin/dashboard" class="bg-accent hover:bg-opacity-90 text-white px-5 py-2.5 rounded-xl font-semibold shadow-sm transition-all hover:-translate-y-0.5">Dashboard Admin</a>
                    <?php else: ?>
                        <a href="/perpus-online/public/cart" class="text-main hover:text-primary font-medium transition-colors relative flex items-center gap-2">
                            🛒 Keranjang
                            </a>
                    <?php endif; ?>
                    
                    <a href="/perpus-online/public/logout" class="ml-4 text-red-500 hover:text-red-700 font-medium transition-colors text-sm">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        
        <div class="bg-primary text-white rounded-3xl p-8 md:p-12 mb-10 shadow-md shadow-primary/20 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">Jelajahi Dunia Lewat Halaman Buku.</h1>
                <p class="text-primary-50 opacity-90 text-lg mb-0">Pinjam koleksi buku terbaik kami secara online, ambil di perpustakaan tanpa perlu antre panjang.</p>
            </div>
            <div class="text-6xl md:text-8xl drop-shadow-lg">📚</div>
        </div>

        <form method="GET" action="/perpus-online/public/" class="mb-10 bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4 items-center">
            
            <div class="flex-1 w-full relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">🔍</span>
                <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                    placeholder="Cari judul buku atau penulis..." 
                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors bg-gray-50 focus:bg-white text-sm">
            </div>
            
            <div class="w-full md:w-64">
                <select name="category" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors bg-gray-50 focus:bg-white text-sm cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit" class="w-full md:w-auto bg-main hover:bg-black text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:-translate-y-0.5 text-sm">
                Cari Buku
            </button>
            
            <?php if(!empty($_GET['search']) || !empty($_GET['category'])): ?>
                <a href="/perpus-online/public/" class="w-full md:w-auto bg-red-50 text-red-500 hover:bg-red-100 px-6 py-3 rounded-xl font-semibold transition-colors text-sm text-center">
                    Reset
                </a>
            <?php endif; ?>
            
        </form>

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold tracking-tight">Koleksi Terbaru</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if(empty($books)): ?>
                <div class="col-span-full py-10 text-center text-gray-500">
                    Belum ada buku di perpustakaan ini.
                </div>
            <?php else: ?>
                <?php foreach($books as $book): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col transition-transform duration-300 hover:-translate-y-2 hover:shadow-md group">
                        
                        <div class="relative bg-base aspect-[3/4] overflow-hidden flex items-center justify-center">
                            <?php if($book['cover_image']): ?>
                                <img src="/perpus-online/public/uploads/books/<?= htmlspecialchars($book['cover_image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <?php else: ?>
                                <span class="text-gray-400 text-sm">No Cover</span>
                            <?php endif; ?>
                            
                            <?php if($book['stock'] > 0): ?>
                                <span class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                                    Sisa <?= htmlspecialchars($book['stock']) ?>
                                </span>
                            <?php else: ?>
                                <span class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                                    Habis
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="p-5 flex flex-col flex-1">
                            <span class="text-xs font-bold text-primary uppercase tracking-wider mb-2 block">
                                <?= htmlspecialchars($book['category_name'] ?? 'Umum') ?>
                            </span>
                            <h3 class="font-bold text-lg leading-snug mb-1 line-clamp-2 text-main flex-1">
                                <?= htmlspecialchars($book['title']) ?>
                            </h3>
                            <p class="text-sm text-gray-500 mb-4 line-clamp-1">
                                oleh <?= htmlspecialchars($book['author']) ?>
                            </p>
                            
                            <?php if($book['stock'] > 0): ?>
                                <a href="/perpus-online/public/cart/add?id=<?= $book['id'] ?>" class="w-full block text-center bg-base hover:bg-accent hover:text-white text-main font-semibold py-2.5 rounded-xl transition-colors duration-300">
                                    Tambah ke Keranjang
                                </a>
                            <?php else: ?>
                                <button disabled class="w-full block text-center bg-gray-100 text-gray-400 font-semibold py-2.5 rounded-xl cursor-not-allowed">
                                    Stok Habis
                                </button>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </main>

</body>
</html>