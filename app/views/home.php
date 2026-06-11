<?php 
// Menangkap output ke dalam variabel $content untuk disisipkan ke layout utama
ob_start(); 
?>

<div class="mb-8 text-center">
    <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Jelajahi Koleksi Kami</h1>
    <p class="text-gray-600">Temukan buku favoritmu dan ajukan peminjaman secara online.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php foreach($books as $book): ?>
        <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition duration-300 border overflow-hidden flex flex-col">
            
            <div class="h-64 bg-gray-200 overflow-hidden relative">
                <img src="<?= asset('uploads/books/' . $book['cover_image']) ?>" 
                     alt="<?= $book['title'] ?>" 
                     class="w-full h-full object-cover">
                
                <?php if($book['stock'] < 1): ?>
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <span class="text-white font-bold px-3 py-1 bg-red-600 rounded-full">Habis</span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="p-5 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 line-clamp-2"><?= $book['title'] ?></h3>
                    <p class="text-sm text-gray-500 mt-1"><?= $book['author'] ?></p>
                </div>
                
                <div class="mt-4 pt-4 border-t flex justify-between items-center">
                    <span class="text-xs font-semibold text-gray-600">Stok: <?= $book['stock'] ?></span>
                    
                    <form action="<?= BASEURL ?>/loan/request" method="POST">
                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                        <button type="submit" 
                                <?= $book['stock'] < 1 ? 'disabled' : '' ?>
                                class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white text-sm px-4 py-2 rounded transition">
                            Pinjam
                        </button>
                    </form>
                </div>
            </div>

        </div>
    <?php endforeach; ?>
</div>

<?php 
$content = ob_get_clean(); 
require_once 'layouts/main.php'; 
?>