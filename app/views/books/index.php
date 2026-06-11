<?php ob_start(); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-white mb-2">
                <?= isset($keyword) ? 'Search Results' : 'Our Menu' ?>
            </h1>
            <p class="text-gray-400">
                <?= isset($keyword) ? 'Showing results for "' . sanitize($keyword) . '"' : 'Discover our delicious offerings' ?>
            </p>
        </div>

        <!-- Search Bar -->
        <form action="<?= BASE_URL ?>/menu/search" method="GET" class="flex-shrink-0" id="menu-search-form">
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                    <?= renderIcon('search', 'w-5 h-5') ?>
                </span>
                <input type="text" name="q" id="menu-search-input"
                       class="w-full md:w-80 pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-700/50 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/20 transition-all"
                       placeholder="Search menu..." value="<?= sanitize($keyword ?? '') ?>">
            </div>
        </form>
    </div>

    <!-- Category Tabs -->
    <?php if (!empty($categories) && !isset($keyword)): ?>
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="<?= BASE_URL ?>/menu" id="category-all"
           class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 <?= !isset($selectedCategory) || $selectedCategory === null ? 'bg-amber-500 text-gray-900 shadow-lg shadow-amber-500/20' : 'bg-gray-800/50 text-gray-400 hover:bg-gray-800 hover:text-white border border-gray-700/50' ?>">
            All
        </a>
        <?php foreach ($categories as $category): ?>
        <a href="<?= BASE_URL ?>/menu?category=<?= $category['id'] ?>" id="category-<?= $category['id'] ?>"
           class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 <?= (isset($selectedCategory) && $selectedCategory === (int)$category['id']) ? 'bg-amber-500 text-gray-900 shadow-lg shadow-amber-500/20' : 'bg-gray-800/50 text-gray-400 hover:bg-gray-800 hover:text-white border border-gray-700/50' ?>">
            <?= sanitize($category['name']) ?>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Menu Grid -->
    <?php if (!empty($menus)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php foreach ($menus as $menu): ?>
            <?php require APP_ROOT . '/views/components/menu-card.php'; ?>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-20">
        <div class="w-20 h-20 bg-gray-800/50 rounded-3xl flex items-center justify-center mx-auto mb-6">
            <?= renderIcon('search', 'w-10 h-10 text-gray-600') ?>
        </div>
        <h3 class="text-xl font-bold text-gray-400 mb-2">No menu items found</h3>
        <p class="text-gray-600">
            <?= isset($keyword) ? 'Try a different search term.' : 'Check back later for new items.' ?>
        </p>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require APP_ROOT . '/views/layouts/main.php';
?>
