<?php ob_start(); ?>

<div class="flex flex-col items-center justify-center min-h-[60vh] px-4 text-center">
    <div class="w-24 h-24 bg-gray-800/50 rounded-3xl flex items-center justify-center mb-8">
        <?= renderIcon('search', 'w-12 h-12 text-gray-600') ?>
    </div>
    <h1 class="text-6xl md:text-8xl font-black text-gray-800 mb-4">404</h1>
    <h2 class="text-2xl font-bold text-white mb-4">Page Not Found</h2>
    <p class="text-gray-400 mb-8 max-w-md">The page you are looking for does not exist or has been moved.</p>
    <a href="<?= BASE_URL ?>/" class="px-6 py-3 bg-amber-500 hover:bg-amber-400 text-gray-900 font-bold rounded-xl transition-all hover:scale-105 active:scale-95 inline-flex items-center gap-2">
        <?= renderIcon('home', 'w-5 h-5') ?>
        Back to Home
    </a>
</div>

<?php
$content = ob_get_clean();
require APP_ROOT . '/views/layouts/main.php';
?>
