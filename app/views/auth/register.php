<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Member - Perpus Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { base: '#F5F2F2', main: '#2B2A2A', primary: '#5A7ACD', accent: '#FEB05D', } } } }
    </script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-base text-main antialiased selection:bg-primary selection:text-white min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-gray-100 p-8 my-8">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-main mb-2">Pendaftaran Member</h1>
            <p class="text-gray-500 text-sm">Bergabung untuk mulai meminjam buku.</p>
        </div>

        <?php if(isset($_GET['status'])): ?>
            <?php if($_GET['status'] == 'password_mismatch'): ?>
                <div class="mb-6 p-3 bg-red-50 text-red-600 rounded-xl border border-red-100 text-sm text-center">Konfirmasi password tidak cocok!</div>
            <?php elseif($_GET['status'] == 'email_exists'): ?>
                <div class="mb-6 p-3 bg-red-50 text-red-600 rounded-xl border border-red-100 text-sm text-center">Email sudah terdaftar. Gunakan email lain.</div>
            <?php elseif($_GET['status'] == 'error'): ?>
                <div class="mb-6 p-3 bg-red-50 text-red-600 rounded-xl border border-red-100 text-sm text-center">Terjadi kesalahan sistem. Coba lagi.</div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="/perpus-online/public/register" method="POST" class="space-y-4">
            
            <div class="space-y-2">
                <label for="name" class="block font-semibold text-sm text-gray-700">Nama Lengkap</label>
                <input type="text" id="name" name="name" required placeholder="Nama Anda"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors bg-gray-50 focus:bg-white">
            </div>

            <div class="space-y-2">
                <label for="email" class="block font-semibold text-sm text-gray-700">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="nama@email.com"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors bg-gray-50 focus:bg-white">
            </div>

            <div class="space-y-2">
                <label for="password" class="block font-semibold text-sm text-gray-700">Password</label>
                <input type="password" id="password" name="password" required placeholder="Minimal 6 karakter" minlength="6"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors bg-gray-50 focus:bg-white">
            </div>

            <div class="space-y-2">
                <label for="confirm_password" class="block font-semibold text-sm text-gray-700">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Ulangi password"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors bg-gray-50 focus:bg-white">
            </div>

            <button type="submit" class="w-full bg-main hover:bg-black text-white font-semibold py-3 rounded-xl shadow-sm transition-all duration-300 transform hover:-translate-y-1 mt-4">
                Daftar Akun
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-500 pt-6 border-t border-gray-100">
            Sudah punya akun? 
            <a href="/perpus-online/public/login" class="text-primary font-semibold hover:underline">Masuk di sini</a>
        </div>

    </div>

</body>
</html>