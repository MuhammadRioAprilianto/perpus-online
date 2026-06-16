<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Admin Perpustakaan</title>
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
            
            <div class="mb-10">
                <a href="/perpus-online/public/admin/books" class="text-slate-400 hover:text-primary mb-3 inline-block font-semibold transition-colors text-sm">
                    &larr; Kembali ke Katalog
                </a>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Tambah Buku Baru</h1>
                <p class="text-slate-400 text-sm mt-1.5">Isi rincian buku fisik di bawah ini untuk didaftarkan ke katalog publik.</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 max-w-3xl">
                <form action="/perpus-online/public/admin/books/add" method="POST" enctype="multipart/form-data" class="space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="space-y-2 md:col-span-2">
                            <label for="title" class="block font-bold text-xs uppercase tracking-wider text-slate-400">Judul Buku <span class="text-rose-500">*</span></label>
                            <input type="text" id="title" name="title" required 
                                class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white placeholder-slate-400 text-sm font-semibold"
                                placeholder="Contoh: Pemrograman Web Lanjut">
                        </div>

                        <div class="space-y-2">
                            <label for="author" class="block font-bold text-xs uppercase tracking-wider text-slate-400">Penulis / Pengarang <span class="text-rose-500">*</span></label>
                            <input type="text" id="author" name="author" required 
                                class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white placeholder-slate-400 text-sm font-semibold"
                                placeholder="Nama penulis buku">
                        </div>

                        <div class="space-y-2">
                            <label for="category_id" class="block font-bold text-xs uppercase tracking-wider text-slate-400">Kategori</label>
                            <select id="category_id" name="category_id" 
                                class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white text-sm font-semibold text-slate-700 cursor-pointer">
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="stock" class="block font-bold text-xs uppercase tracking-wider text-slate-400">Jumlah Stok <span class="text-rose-500">*</span></label>
                            <input type="number" id="stock" name="stock" required min="0" value="0"
                                class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white text-sm font-bold text-slate-700">
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label for="cover_image" class="block font-bold text-xs uppercase tracking-wider text-slate-400">Gambar Sampul Buku</label>
                            <input type="file" id="cover_image" name="cover_image" accept="image/jpeg, image/png, image/webp"
                                class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer text-sm font-semibold text-slate-550">
                            <p class="text-[10px] text-slate-400 mt-1.5 font-medium">Mendukung format JPG, PNG, WEBP. Maksimal ukuran file 2MB.</p>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-4">
                        <a href="/perpus-online/public/admin/books" class="px-6 py-3 font-bold text-slate-400 hover:text-slate-700 transition-colors text-sm">Batal</a>
                        <button type="submit" class="bg-primary hover:bg-opacity-95 hover:shadow-lg hover:shadow-primary/20 text-white px-8 py-3.5 rounded-2xl font-bold transition-all duration-300 hover:-translate-y-0.5 text-sm">
                            Simpan Buku
                        </button>
                    </div>

                </form>
            </div>

        </main>
    </div>

</body>
</html>