<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Admin Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { base: '#F5F2F2', main: '#2B2A2A', primary: '#5A7ACD', accent: '#FEB05D', } } } }
    </script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-base text-main antialiased selection:bg-primary selection:text-white">
    <div class="min-h-screen flex flex-col md:flex-row">
        
        <aside class="w-full md:w-64 bg-white shadow-sm border-r border-gray-100 flex flex-col">
            <div class="p-6 font-bold text-2xl text-primary border-b border-gray-100">Perpus<span class="text-accent">Online</span></div>
            <nav class="p-4 space-y-2 flex-1">
                <a href="/perpus-online/public/admin/dashboard" class="block p-3 rounded-xl hover:bg-base hover:text-primary transition-all text-gray-500 font-medium">Dashboard</a>
                <a href="/perpus-online/public/admin/books" class="block p-3 rounded-xl bg-primary text-white shadow-md shadow-primary/30 font-medium">Manajemen Buku</a>
            </nav>
        </aside>

        <main class="flex-1 p-6 md:p-10">
            <div class="mb-8">
                <a href="/perpus-online/public/admin/books" class="text-gray-500 hover:text-primary mb-4 inline-block font-medium transition-colors">&larr; Kembali</a>
                <h1 class="text-3xl font-bold tracking-tight">Edit Buku</h1>
                <p class="text-gray-500 mt-1">Ubah informasi untuk buku <strong><?= htmlspecialchars($book['title']) ?></strong>.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 max-w-3xl">
                <form action="/perpus-online/public/admin/books/edit?id=<?= $book['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="space-y-2 md:col-span-2">
                            <label for="title" class="block font-semibold text-sm text-gray-700">Judul Buku</label>
                            <input type="text" id="title" name="title" required value="<?= htmlspecialchars($book['title']) ?>"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors bg-gray-50 focus:bg-white">
                        </div>

                        <div class="space-y-2">
                            <label for="author" class="block font-semibold text-sm text-gray-700">Penulis</label>
                            <input type="text" id="author" name="author" required value="<?= htmlspecialchars($book['author']) ?>"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors bg-gray-50 focus:bg-white">
                        </div>

                        <div class="space-y-2">
                            <label for="category_id" class="block font-semibold text-sm text-gray-700">Kategori</label>
                            <select id="category_id" name="category_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors bg-gray-50 focus:bg-white">
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= ($category['id'] == $book['category_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="stock" class="block font-semibold text-sm text-gray-700">Jumlah Stok</label>
                            <input type="number" id="stock" name="stock" required min="0" value="<?= htmlspecialchars($book['stock']) ?>"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors bg-gray-50 focus:bg-white">
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label for="cover_image" class="block font-semibold text-sm text-gray-700">Gambar Sampul Baru (Opsional)</label>
                            <input type="file" id="cover_image" name="cover_image" accept="image/jpeg, image/png, image/webp"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary cursor-pointer">
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti gambar.</p>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                        <a href="/perpus-online/public/admin/books" class="px-6 py-3 font-medium text-gray-500 hover:text-main">Batal</a>
                        <button type="submit" class="bg-primary hover:bg-opacity-90 text-white px-8 py-3 rounded-xl shadow-sm shadow-primary/30 font-semibold">
                            Update Buku
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>