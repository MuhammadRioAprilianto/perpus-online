<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Member - Perpus Online</title>
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

    <div class="w-full max-w-md bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-10 my-8 relative">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pendaftaran Member</h1>
            <p class="text-slate-400 text-sm font-medium mt-1">Buat akun untuk mulai meminjam buku perpustakaan.</p>
        </div>

        <?php if(isset($_GET['status'])): ?>
            <?php if($_GET['status'] == 'password_mismatch'): ?>
                <div class="mb-6 p-4 bg-rose-50 text-rose-700 rounded-2xl border border-rose-100 text-xs font-bold text-center">
                    Konfirmasi password tidak cocok!
                </div>
            <?php elseif($_GET['status'] == 'email_exists'): ?>
                <div class="mb-6 p-4 bg-rose-50 text-rose-700 rounded-2xl border border-rose-100 text-xs font-bold text-center">
                    Email sudah terdaftar. Silakan gunakan email lain.
                </div>
            <?php elseif($_GET['status'] == 'error'): ?>
                <div class="mb-6 p-4 bg-rose-50 text-rose-700 rounded-2xl border border-rose-100 text-xs font-bold text-center">
                    Terjadi kesalahan sistem. Silakan coba kembali.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="/perpus-online/public/register" method="POST" class="space-y-4">
            
            <div class="space-y-2">
                <label for="name" class="block font-bold text-xs uppercase tracking-wider text-slate-400">Nama Lengkap</label>
                <input type="text" id="name" name="name" required placeholder="Nama lengkap Anda"
                    class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white text-sm font-semibold">
            </div>

            <div class="space-y-2">
                <label for="email" class="block font-bold text-xs uppercase tracking-wider text-slate-400">Alamat Email</label>
                <input type="email" id="email" name="email" required placeholder="nama@email.com"
                    class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white text-sm font-semibold">
            </div>

            <div class="space-y-2">
                <label for="password" class="block font-bold text-xs uppercase tracking-wider text-slate-400">Password</label>
                <input type="password" id="password" name="password" required placeholder="Minimal 6 karakter" minlength="6"
                    class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white text-sm font-semibold">
            </div>

            <div class="space-y-2">
                <label for="confirm_password" class="block font-bold text-xs uppercase tracking-wider text-slate-400">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Ulangi password"
                    class="w-full px-4 py-3.5 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all bg-slate-50 focus:bg-white text-sm font-semibold">
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-opacity-95 hover:shadow-lg hover:shadow-primary/20 text-white font-bold py-4 rounded-2xl transition-all duration-300 transform hover:-translate-y-0.5 mt-4 text-sm">
                Daftar Akun Baru
            </button>
        </form>

        <div class="mt-8 text-center text-xs text-slate-400 border-t border-slate-100 pt-6">
            Sudah memiliki akun? 
            <a href="/perpus-online/public/login" class="text-primary font-bold hover:underline">Masuk di sini</a>
        </div>

    </div>

</body>
</html>