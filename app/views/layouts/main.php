<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?= BASEURL ?>" class="text-2xl font-bold text-blue-600">PerpusLine</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= BASEURL ?>" class="text-gray-700 hover:text-blue-600 transition">Katalog</a>
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <?php if($_SESSION['role'] === 'admin'): ?>
                            <a href="<?= BASEURL ?>/admin/dashboard" class="text-gray-700 hover:text-blue-600 transition">Dashboard Admin</a>
                        <?php else: ?>
                            <a href="<?= BASEURL ?>/loans" class="text-gray-700 hover:text-blue-600 transition">Pinjamanku</a>
                        <?php endif; ?>
                        <a href="<?= BASEURL ?>/logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition">Logout</a>
                    <?php else: ?>
                        <a href="<?= BASEURL ?>/login" class="text-gray-700 hover:text-blue-600 transition">Login</a>
                        <a href="<?= BASEURL ?>/register" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">Daftar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <?= $content ?? '' ?> 
    </main>

    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center text-gray-500">
            &copy; 2026 <?= APP_NAME ?> - Dikembangkan oleh Kelompok 6.
        </div>
    </footer>

</body>
</html>