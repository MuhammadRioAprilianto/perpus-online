<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Buku - Admin Perpustakaan</title>
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
    </style>
</head>
<body class="bg-base text-main antialiased selection:bg-primary selection:text-white">
    
    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-white shadow-sm border-r border-slate-100 min-h-screen p-6 flex flex-col">
            <div class="font-extrabold text-2xl text-primary mb-10 tracking-tight">
                📚 Perpus<span class="text-accent">Online</span>
            </div>
            
            <nav class="space-y-2 flex-grow">
                <a href="/perpus-online/public/admin/dashboard" 
                   class="block p-3.5 rounded-2xl font-bold transition-all duration-300 <?= (strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' ?>">
                    📊 Dashboard
                </a>
                <a href="/perpus-online/public/admin/books" 
                   class="block p-3.5 rounded-2xl font-bold transition-all duration-300 <?= (strpos($_SERVER['REQUEST_URI'], 'books') !== false) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' ?>">
                    📖 Manajemen Buku
                </a>
                <a href="/perpus-online/public/admin/loans" 
                   class="block p-3.5 rounded-2xl font-bold transition-all duration-300 <?= (strpos($_SERVER['REQUEST_URI'], 'loans') !== false) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' ?>">
                    📋 Validasi Peminjaman
                </a>
            </nav>
            
            <div class="pt-6 border-t border-slate-100">
                <a href="/perpus-online/public/logout" class="block p-3.5 rounded-2xl text-red-500 hover:bg-red-50 transition-all font-bold text-sm">
                    🚪 Logout Admin
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-12">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">
                <div>
                    <span class="bg-primary/10 text-primary text-xs font-bold px-3.5 py-1.5 rounded-xl uppercase tracking-wider mb-2.5 inline-block">
                        Inventaris Buku
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Daftar Koleksi Buku</h1>
                    <p class="text-slate-400 text-sm mt-1.5">Kelola data buku, kategori, dan jumlah stok di perpustakaan.</p>
                </div>
                <a href="/perpus-online/public/admin/books/add" class="bg-primary hover:bg-opacity-95 hover:shadow-lg hover:shadow-primary/20 text-white px-6 py-3.5 rounded-2xl font-bold transition-all duration-300 hover:-translate-y-0.5 text-sm flex items-center gap-2">
                    <span>+ Tambah Buku</span>
                </a>
            </div>

            <!-- Alerts -->
            <?php if(isset($_GET['status'])): ?>
                <?php if($_GET['status'] == 'success'): ?>
                    <div class="mb-8 p-5 bg-emerald-50 text-emerald-800 rounded-3xl border border-emerald-100 flex items-center gap-2 text-sm font-semibold">
                        <span>✅</span> Data buku berhasil diperbarui!
                    </div>
                <?php else: ?>
                    <div class="mb-8 p-5 bg-rose-50 text-rose-800 rounded-3xl border border-rose-100 flex items-center gap-2 text-sm font-semibold">
                        <span>❌</span> Terjadi kegagalan memproses operasi. Silakan periksa kembali.
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Table Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="p-5 font-bold text-slate-500 text-xs uppercase tracking-wider">Sampul</th>
                                <th class="p-5 font-bold text-slate-500 text-xs uppercase tracking-wider">Judul & Penulis</th>
                                <th class="p-5 font-bold text-slate-500 text-xs uppercase tracking-wider">Kategori</th>
                                <th class="p-5 font-bold text-slate-500 text-xs uppercase tracking-wider text-center">Stok</th>
                                <th class="p-5 font-bold text-slate-500 text-xs uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            
                            <?php if(empty($books)): ?>
                                <tr>
                                    <td colspan="5" class="p-16 text-center text-slate-450 font-medium">
                                        <div class="flex flex-col items-center justify-center">
                                            <span class="text-5xl mb-4">📚</span>
                                            <p>Katalog buku kosong.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($books as $book): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors duration-200">
                                    <td class="p-5">
                                        <?php if($book['cover_image']): ?>
                                            <img src="/perpus-online/public/uploads/books/<?= htmlspecialchars($book['cover_image']) ?>" alt="Cover" class="w-14 h-20 object-cover rounded-xl shadow-sm aspect-[3/4] bg-slate-100">
                                        <?php else: ?>
                                            <div class="w-14 h-20 bg-slate-100 rounded-xl border border-dashed border-slate-200 flex items-center justify-center text-slate-400 text-[10px] font-bold">No Cover</div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-5">
                                        <p class="font-bold text-slate-800 text-base leading-snug"><?= htmlspecialchars($book['title']) ?></p>
                                        <p class="text-xs text-slate-450 font-medium mt-1">oleh <?= htmlspecialchars($book['author']) ?></p>
                                    </td>
                                    <td class="p-5">
                                        <span class="bg-primary/10 text-primary px-3 py-1.5 rounded-xl text-[10px] font-extrabold uppercase tracking-wider">
                                            <?= htmlspecialchars($book['category_name'] ?? 'Umum') ?>
                                        </span>
                                    </td>
                                    <td class="p-5 text-center">
                                        <span class="font-bold text-base <?= $book['stock'] < 3 ? 'text-rose-500' : 'text-slate-800' ?>">
                                            <?= htmlspecialchars($book['stock']) ?>
                                        </span>
                                    </td>
                                    <td class="p-5 text-center space-x-2">
                                        <a href="/perpus-online/public/admin/books/edit?id=<?= $book['id'] ?>" class="inline-block bg-slate-100 text-slate-700 px-4 py-2 rounded-xl hover:bg-slate-200 transition-all text-xs font-bold">Edit</a>
                                        <a href="/perpus-online/public/admin/books/delete?id=<?= $book['id'] ?>" onclick="return confirm('Yakin ingin menghapus buku ini?')" class="inline-block bg-rose-50 text-rose-600 px-4 py-2 rounded-xl hover:bg-rose-100 transition-all text-xs font-bold">Hapus</a>
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