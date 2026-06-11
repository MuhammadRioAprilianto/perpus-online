<?php

/**
 * Reusable menu card component.
 *
 * Renders a single menu item card with image, name, description,
 * price, rating, and an add-to-cart form. Expects a $menu variable.
 *
 * @var array $menu The menu item data array.
 */

$ratingModel = new Rating();
$avgRating = $ratingModel->getAverageByMenuId($menu['id']);
$menuImage = getMenuImageUrl($menu['image'] ?? null);
?>

<div class="group bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl overflow-hidden hover:border-amber-500/30 hover:shadow-lg hover:shadow-amber-500/5 transition-all duration-300">
    <div class="relative overflow-hidden aspect-[4/3]">
        <img
            src="<?= $menuImage ?>"
            alt="<?= sanitize($menu['name']) ?>"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            loading="lazy"
        />
        <?php if (isset($menu['category_name']) && $menu['category_name']): ?>
        <span class="absolute top-3 left-3 bg-gray-900/80 backdrop-blur-sm text-amber-400 text-xs font-semibold px-3 py-1 rounded-full border border-amber-500/20">
            <?= sanitize($menu['category_name']) ?>
        </span>
        <?php endif; ?>
    </div>

    <div class="p-5">
        <div class="flex items-start justify-between mb-2">
            <h3 class="text-white font-bold text-lg leading-tight"><?= sanitize($menu['name']) ?></h3>
            <?php if ($avgRating > 0): ?>
            <div class="flex items-center gap-1 flex-shrink-0 ml-2">
                <span class="text-amber-400"><?= renderIcon('star-filled', 'w-4 h-4') ?></span>
                <span class="text-amber-400 text-sm font-semibold"><?= $avgRating ?></span>
            </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($menu['description'])): ?>
        <p class="text-gray-400 text-sm mb-4 line-clamp-2"><?= sanitize(truncateText($menu['description'], 80)) ?></p>
        <?php endif; ?>

        <div class="flex items-center justify-between mt-auto">
            <span class="text-amber-400 font-bold text-xl"><?= formatCurrency($menu['price']) ?></span>

            <?php if (isLoggedIn()): ?>
            <form action="<?= BASE_URL ?>/cart/add" method="POST" class="flex-shrink-0">
                <?= csrfField() ?>
                <input type="hidden" name="menu_id" value="<?= $menu['id'] ?>">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" id="add-to-cart-<?= $menu['id'] ?>" class="bg-amber-500 hover:bg-amber-400 text-gray-900 font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg shadow-amber-500/20">
                    <?= renderIcon('plus', 'w-4 h-4') ?>
                    <span class="text-sm">Add</span>
                </button>
            </form>
            <?php else: ?>
            <a href="<?= BASE_URL ?>/login" class="bg-gray-700 hover:bg-gray-600 text-gray-300 font-medium px-4 py-2.5 rounded-xl flex items-center gap-2 transition-all duration-200 text-sm">
                <?= renderIcon('login', 'w-4 h-4') ?>
                <span>Login</span>
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
