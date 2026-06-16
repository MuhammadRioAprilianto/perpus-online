<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpus Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { base: '#F5F2F2', main: '#2B2A2A', primary: '#5A7ACD', accent: '#FEB05D', } } } }
    </script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-base text-main antialiased selection:bg-primary selection:text-white min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-primary mb-2">Perpus<span class="text-accent">Online</span></h1>
            <p class="text-gray-500 text-sm">Silakan masuk ke akun Anda.</p>
        </div>

        <?php if(isset($_GET['status'])): ?>
            <?php if($_GET['status'] == 'error'): ?>
                <div class="mb-6 p-3 bg-red-50 text-red-600 rounded-xl border border-red-100 text-sm text-center">
                    Email atau password salah!
                </div>
            <?php elseif($_GET['status'] == 'registered'): ?>
                <div class="mb-6 p-3 bg-green-50 text-green-600 rounded-xl border border-green-100 text-sm text-center">
                    Registrasi berhasil! Silakan login.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="/perpus-online/public/login" method="POST" class="space-y-5">
            <div class="space-y-2">
                <label for="email" class="block font-semibold text-sm text-gray-700">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="nama@email.com"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors bg-gray-50 focus:bg-white">
            </div>

            <div class="space-y-2">
                <label for="password" class="block font-semibold text-sm text-gray-700">Password</label>
                <input type="password" id="password" name="password" required placeholder="••••••••"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors bg-gray-50 focus:bg-white">
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-opacity-90 text-white font-semibold py-3 rounded-xl shadow-sm shadow-primary/30 transition-all duration-300 transform hover:-translate-y-1 mt-2">
                Masuk
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-gray-500">
            Belum punya akun member? <br>
            <a href="/perpus-online/public/register" class="text-primary font-semibold hover:underline mt-1 inline-block">Daftar sekarang</a>
        </div>

    </div>

</body>
</html>