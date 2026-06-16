<?php ob_start(); ?>

<div class="flex flex-col items-center justify-center min-h-[65vh] px-4 text-center">
    <div class="w-24 h-24 bg-indigo-50 dark:bg-slate-800 text-primary dark:text-indigo-400 rounded-3xl flex items-center justify-center mb-8 shadow-sm">
        <?= renderIcon('search', 'w-12 h-12') ?>
    </div>
    <h1 class="text-7xl md:text-8xl font-black text-slate-800 dark:text-white mb-4 tracking-tight">404</h1>
    <h2 class="text-2xl font-bold text-slate-700 dark:text-slate-200 mb-3">Halaman Tidak Ditemukan</h2>
    <p class="text-slate-400 dark:text-slate-400 mb-8 max-w-md text-sm font-medium leading-relaxed">
        Maaf, halaman yang Anda tuju tidak tersedia, telah dihapus, atau sedang dipindahkan oleh pustakawan kami.
    </p>
    <a href="<?= BASE_URL ?>/" class="px-6 py-3.5 bg-primary hover:bg-opacity-95 text-white font-bold rounded-2xl transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 inline-flex items-center gap-2 text-sm shadow-md">
        <?= renderIcon('home', 'w-5 h-5') ?>
        <span>Kembali ke Beranda</span>
    </a>
</div>

<?php
$content = ob_get_clean();
require APP_ROOT . '/views/layouts/main.php';
?>

