<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpus Online</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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
        }
    </style>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-slate-900 dark:text-slate-100 antialiased selection:bg-primary selection:text-white min-h-screen flex items-center justify-center p-4 relative overflow-hidden transition-colors duration-300">

    <!-- Glowing Background Ornaments -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl -z-10 pointer-events-none"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-accent/5 rounded-full blur-3xl -z-10 pointer-events-none"></div>

    <div class="w-full max-w-md bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-8 md:p-10 relative transition-colors">
        
        <div class="mb-5">
            <a href="<?= BASE_URL ?>/" class="text-slate-400 dark:text-slate-400 hover:text-primary dark:hover:text-indigo-400 font-semibold transition-colors text-xs flex items-center gap-1.5 w-max">
                &larr; Kembali ke Beranda
            </a>
        </div>

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-primary dark:text-indigo-400 mb-2 tracking-tight">Perpus<span class="text-accent">Online</span></h1>
            <p class="text-slate-400 dark:text-slate-400 text-sm font-medium">Masuk untuk mengelola peminjaman buku Anda.</p>
        </div>

        <?php if(isset($_GET['status'])): ?>
            <?php if($_GET['status'] == 'error'): ?>
                <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-950/20 text-rose-700 dark:text-rose-400 rounded-2xl border border-rose-100 dark:border-rose-900/40 text-xs font-bold text-center">
                    Email atau password salah!
                </div>
            <?php elseif($_GET['status'] == 'registered'): ?>
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/20 text-emerald-800 dark:text-emerald-400 rounded-2xl border border-emerald-100 dark:border-emerald-900/40 text-xs font-bold text-center">
                    Registrasi sukses! Silakan login di bawah ini.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/login" method="POST" class="space-y-5">
            <div class="space-y-2">
                <label for="email" class="block font-bold text-xs uppercase tracking-wider text-slate-400 dark:text-slate-400">Alamat Email</label>
                <input type="email" id="email" name="email" required placeholder="nama@email.com"
                    class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm font-semibold">
            </div>

            <div class="space-y-2">
                <label for="password" class="block font-bold text-xs uppercase tracking-wider text-slate-400 dark:text-slate-400">Password</label>
                <input type="password" id="password" name="password" required placeholder="••••••••"
                    class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm font-semibold">
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-opacity-95 hover:shadow-lg hover:shadow-primary/20 text-white font-bold py-4 rounded-2xl transition-all duration-300 transform hover:-translate-y-0.5 mt-4 text-sm">
                Masuk ke Akun
            </button>
        </form>

        <div class="mt-8 text-center text-xs text-slate-400 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700 pt-6">
            Belum punya akun member? <br>
            <a href="<?= BASE_URL ?>/register" class="text-primary dark:text-indigo-400 font-bold hover:underline mt-2 inline-block">Daftar Akun Baru</a>
        </div>

    </div>

</body>
</html>
