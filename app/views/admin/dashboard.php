<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Perpus Online</title>
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
                <span class="bg-primary/10 text-primary text-xs font-bold px-3.5 py-1.5 rounded-xl uppercase tracking-wider mb-2.5 inline-block">
                    Pustakawan Panel
                </span>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Selamat Datang, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>! 👋</h1>
                <p class="text-slate-400 mt-1.5 text-sm">Monitor aktivitas transaksi peminjaman dan pengelolaan inventaris buku.</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
                
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 transition-all hover:shadow-md hover:border-slate-200/55 duration-300">
                    <div class="w-14 h-14 bg-primary/10 text-primary rounded-2xl flex items-center justify-center text-3xl">📚</div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Koleksi Buku</p>
                        <h3 class="text-3xl font-extrabold text-slate-850 mt-1"><?= htmlspecialchars($totalBooks) ?></h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 transition-all hover:shadow-md hover:border-slate-200/55 duration-300">
                    <div class="w-14 h-14 bg-amber-50 text-accent rounded-2xl flex items-center justify-center text-3xl">👥</div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Akun Member</p>
                        <h3 class="text-3xl font-extrabold text-slate-850 mt-1"><?= htmlspecialchars($totalMembers) ?></h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 transition-all hover:shadow-md hover:border-slate-200/55 duration-300">
                    <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center text-3xl">⏰</div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Buku Terlambat</p>
                        <h3 class="text-3xl font-extrabold text-rose-600 mt-1"><?= htmlspecialchars($totalLate) ?></h3>
                    </div>
                </div>

            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                <h2 class="text-lg font-bold text-slate-900 mb-5">Pintasan Manajemen</h2>
                <div class="flex flex-wrap gap-4">
                    <a href="/perpus-online/public/admin/books/add" class="bg-primary hover:bg-opacity-95 hover:shadow-lg hover:shadow-primary/20 text-white px-6 py-3.5 rounded-2xl font-bold transition-all duration-300 hover:-translate-y-0.5 text-sm">
                        + Tambah Koleksi Buku
                    </a>
                    <a href="/perpus-online/public/admin/loans" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3.5 rounded-2xl font-bold transition-all duration-300 hover:-translate-y-0.5 text-sm">
                        Kelola Persetujuan Peminjaman
                    </a>
                </div>
            </div>

        </main>
    </div>

</body>
</html>