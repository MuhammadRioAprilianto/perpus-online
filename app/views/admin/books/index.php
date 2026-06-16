<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Buku - Admin Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        base: '#F5F2F2',
                        main: '#2B2A2A',
                        primary: '#5A7ACD',
                        accent: '#FEB05D',
                    }
                }
            }
        }
    </script>
    <style>
        /* Impor font inter agar lebih modern */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-base text-main antialiased selection:bg-primary selection:text-white">
    
    <div class="min-h-screen flex flex-col md:flex-row">
        
       <aside class="w-full md:w-64 bg-white shadow-sm border-r border-gray-100 min-h-screen p-6">
            <div class="font-bold text-2xl text-primary mb-8">
                Perpus<span class="text-accent">Online</span>
            </div>
            <nav class="space-y-2">
                <a href="/perpus-online/public/admin/dashboard" 
                class="block p-3 rounded-xl transition-all <?= (strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false) ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-gray-500 hover:bg-base' ?>">
                Dashboard
                </a>
                <a href="/perpus-online/public/admin/books" 
                class="block p-3 rounded-xl transition-all <?= (strpos($_SERVER['REQUEST_URI'], 'books') !== false) ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-gray-500 hover:bg-base' ?>">
                Manajemen Buku
                </a>
                <a href="/perpus-online/public/admin/loans" 
                class="block p-3 rounded-xl transition-all <?= (strpos($_SERVER['REQUEST_URI'], 'loans') !== false) ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-gray-500 hover:bg-base' ?>">
                Peminjaman
                </a>
            </nav>
            <div class="mt-auto pt-8 border-t border-gray-100">
                <a href="/perpus-online/public/logout" class="block p-3 rounded-xl text-red-500 hover:bg-red-50 transition-all font-medium">
                    Logout
                </a>
            </div>
        </aside>

        <main class="flex-1 p-6 md:p-10">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Katalog Buku</h1>
                    <p class="text-gray-500 mt-1">Kelola inventaris dan stok buku perpustakaan.</p>
                </div>
                <a href="/perpus-online/public/admin/books/add" class="bg-accent hover:bg-opacity-90 text-white px-6 py-3 rounded-xl shadow-sm shadow-accent/30 transition-all duration-300 transform hover:-translate-y-1 font-semibold flex items-center gap-2">
                    <span>+ Tambah Buku</span>
                </a>
            </div>

            <?php if(isset($_GET['status'])): ?>
                <?php if($_GET['status'] == 'success'): ?>
                    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl border border-green-200 flex items-center gap-2">
                        <span>✅ Operasi buku berhasil dilakukan!</span>
                    </div>
                <?php else: ?>
                    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl border border-red-200 flex items-center gap-2">
                        <span>❌ Terjadi kesalahan. Silakan coba lagi.</span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="p-5 font-semibold text-gray-500 text-sm">Sampul</th>
                                <th class="p-5 font-semibold text-gray-500 text-sm">Judul & Penulis</th>
                                <th class="p-5 font-semibold text-gray-500 text-sm">Kategori</th>
                                <th class="p-5 font-semibold text-gray-500 text-sm text-center">Stok</th>
                                <th class="p-5 font-semibold text-gray-500 text-sm text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            
                            <?php if(empty($books)): ?>
                                <tr>
                                    <td colspan="5" class="p-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <span class="text-4xl mb-3">📚</span>
                                            <p>Belum ada data buku.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($books as $book): ?>
                                <tr class="hover:bg-base/50 transition-colors duration-200">
                                    <td class="p-5">
                                        <?php if($book['cover_image']): ?>
                                            <img src="/perpus-online/public/uploads/books/<?= htmlspecialchars($book['cover_image']) ?>" alt="Cover" class="w-16 h-24 object-cover rounded-lg shadow-sm aspect-[3/4] bg-base">
                                        <?php else: ?>
                                            <div class="w-16 h-24 bg-base rounded-lg border border-dashed border-gray-300 flex items-center justify-center text-gray-400 text-xs">No Cover</div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-5">
                                        <p class="font-bold text-main text-lg"><?= htmlspecialchars($book['title']) ?></p>
                                        <p class="text-sm text-gray-500 mt-1"><?= htmlspecialchars($book['author']) ?></p>
                                    </td>
                                    <td class="p-5">
                                        <span class="bg-primary/10 text-primary px-3 py-1.5 rounded-lg text-xs font-semibold uppercase tracking-wider">
                                            <?= htmlspecialchars($book['category_name'] ?? 'Uncategorized') ?>
                                        </span>
                                    </td>
                                    <td class="p-5 text-center">
                                        <span class="font-bold text-lg <?= $book['stock'] < 3 ? 'text-red-500' : 'text-main' ?>">
                                            <?= htmlspecialchars($book['stock']) ?>
                                        </span>
                                    </td>
                                    <td class="p-5 text-center space-x-2">
                                        <a href="/perpus-online/public/admin/books/edit?id=<?= $book['id'] ?>" class="inline-block bg-base text-main px-4 py-2 rounded-xl hover:bg-gray-200 transition-all text-sm font-semibold">Edit</a>
                                        <a href="/perpus-online/public/admin/books/delete?id=<?= $book['id'] ?>" onclick="return confirm('Yakin ingin menghapus buku ini?')" class="inline-block bg-red-50 text-red-600 px-4 py-2 rounded-xl hover:bg-red-100 transition-all text-sm font-semibold">Hapus</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</body>
</html>