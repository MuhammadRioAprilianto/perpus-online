<?php ob_start(); ?>

<div class="max-w-md mx-auto mt-10 bg-white p-8 border rounded-xl shadow-sm">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Selamat Datang</h2>
        <p class="text-gray-500 mt-2">Silakan masuk untuk melanjutkan</p>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm text-center">
            <?php 
                if($_GET['error'] == 'invalid_credentials') echo "Username atau Password salah!";
                else echo "Terjadi kesalahan saat login.";
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success']) && $_GET['success'] == 'registered'): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm text-center">
            Pendaftaran berhasil! Silakan login.
        </div>
    <?php endif; ?>

    <form action="<?= BASEURL ?>/login" method="POST" class="space-y-6">
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" name="username" id="username" required 
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" required 
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition">
        </div>

        <input type="hidden" name="action" value="login">

        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
            Masuk
        </button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
        Belum punya akun? 
        <a href="<?= BASEURL ?>/register" class="font-medium text-blue-600 hover:text-blue-500 transition">Daftar sekarang</a>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require_once '../app/views/layouts/main.php'; 
?>