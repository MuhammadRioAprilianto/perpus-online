<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpus Online</title>
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
<body class="bg-base text-main antialiased selection:bg-primary selection:text-white min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Glowing Background Ornaments -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl -z-10 pointer-events-none"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-accent/5 rounded-full blur-3xl -z-10 pointer-events-none"></div>

    <div class="w-full max-w-md bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-10 relative">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-primary mb-2 tracking-tight">📚 Perpus<span class="text-accent">Online</span></h1>
            <p class="text-slate-400 text-sm font-medium">Masuk untuk mengelola peminjaman buku Anda.</p>
        </div>

        <?php if(isset($_GET['status'])): ?>
            <?php if($_GET['status'] == 'error'): ?>
                <div class="mb-6 p-4 bg-rose-50 text-rose-700 rounded-2xl border border-rose-100 text-xs font-bold text-center">
                    Email atau password salah!
                </div>
            <?php elseif($_GET['status'] == 'registered'): ?>
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-800 rounded-2xl border border-emerald-100 text-xs font-bold text-center">
                    Registrasi sukses! Silakan login di bawah ini.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="/perpus-online/public/login" method="POST" class="space-y-5">
            <div class="space-y-2">
                <label for="email" class="block font-bold text-xs uppercase tracking-wider text-slate-400">Alamat Email</label>
                <input type="email" id="email" name="email" required placeholder="nama@email.com"
                    class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white text-sm font-semibold">
            </div>

            <div class="space-y-2">
                <label for="password" class="block font-bold text-xs uppercase tracking-wider text-slate-400">Password</label>
                <input type="password" id="password" name="password" required placeholder="••••••••"
                    class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white text-sm font-semibold">
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-opacity-95 hover:shadow-lg hover:shadow-primary/20 text-white font-bold py-4 rounded-2xl transition-all duration-300 transform hover:-translate-y-0.5 mt-4 text-sm">
                Masuk ke Akun
            </button>
        </form>

        <div class="mt-8 text-center text-xs text-slate-400 border-t border-slate-100 pt-6">
            Belum punya akun member? <br>
            <a href="/perpus-online/public/register" class="text-primary font-bold hover:underline mt-2 inline-block">Daftar Akun Baru</a>
        </div>

    </div>

</body>
</html>