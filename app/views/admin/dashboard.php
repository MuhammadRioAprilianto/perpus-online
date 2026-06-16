<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Perpus Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { base: '#F5F2F2', main: '#2B2A2A', primary: '#5A7ACD', accent: '#FEB05D', } } }
        }
    </script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
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
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight">Selamat Datang, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>! 👋</h1>
                <p class="text-gray-500 mt-1">Berikut adalah ringkasan aktivitas perpustakaan hari ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 transition-transform hover:-translate-y-1 duration-300">
                    <div class="w-14 h-14 bg-primary/10 text-primary rounded-xl flex items-center justify-center text-2xl">📚</div>
                    <div>
                        <p class="text-gray-500 text-sm font-semibold">Total Buku</p>
                        <h3 class="text-2xl font-bold text-main"><?= htmlspecialchars($totalBooks) ?></h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 transition-transform hover:-translate-y-1 duration-300">
                    <div class="w-14 h-14 bg-accent/10 text-accent rounded-xl flex items-center justify-center text-2xl">👥</div>
                    <div>
                        <p class="text-gray-500 text-sm font-semibold">Total Member</p>
                        <h3 class="text-2xl font-bold text-main"><?= htmlspecialchars($totalMembers) ?></h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 transition-transform hover:-translate-y-1 duration-300">
                    <div class="w-14 h-14 bg-red-50 text-red-500 rounded-xl flex items-center justify-center text-2xl">⏰</div>
                    <div>
                        <p class="text-gray-500 text-sm font-semibold">Buku Terlambat</p>
                        <h3 class="text-2xl font-bold text-main"><?= htmlspecialchars($totalLate) ?></h3>
                    </div>
                </div>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-main mb-4">Akses Cepat</h2>
                <div class="flex flex-wrap gap-4">
                    <a href="/perpus-online/public/admin/books/add" class="bg-base hover:bg-gray-200 text-main px-5 py-3 rounded-xl font-medium transition-colors text-sm">
                        + Tambah Buku Baru
                    </a>
                    <a href="/perpus-online/public/admin/loans" class="bg-base hover:bg-gray-200 text-main px-5 py-3 rounded-xl font-medium transition-colors text-sm">
                        Cek Validasi Peminjaman
                    </a>
                </div>
            </div>

        </main>
    </div>

</body>
</html>