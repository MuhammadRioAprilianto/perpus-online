<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PesanInAja Admin Dashboard - Manage your restaurant operations.">
    <title><?= sanitize($pageTitle ?? 'Dashboard') ?> - Admin | <?= APP_NAME ?></title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-950 text-gray-100 font-sans min-h-screen antialiased">

<?php
$adminOrderModel = new Order();
$adminActiveCount = $adminOrderModel->countAllActive();
$adminPendingActions = $adminOrderModel->countPendingActions();
$adminRecentPending = $adminOrderModel->getRecentPending(3);
?>

<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900/80 backdrop-blur-xl border-r border-gray-800/50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <div class="flex flex-col h-full">
            <!-- Logo -->
            <div class="h-16 flex items-center px-6 border-b border-gray-800/50">
                <a href="<?= BASE_URL ?>/admin" class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                        <?= renderIcon('fire', 'w-5 h-5 text-gray-900') ?>
                    </div>
                    <div>
                        <span class="text-lg font-extrabold bg-gradient-to-r from-amber-400 to-orange-400 bg-clip-text text-transparent"><?= APP_NAME ?></span>
                        <span class="text-xs text-gray-500 block -mt-1">Admin Panel</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <p class="px-3 mb-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Main</p>
                <a href="<?= BASE_URL ?>/admin" id="sidebar-dashboard" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all">
                    <?= renderIcon('dashboard', 'w-5 h-5') ?>
                    <span>Dashboard</span>
                </a>

                <p class="px-3 mb-3 mt-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Management</p>
                <a href="<?= BASE_URL ?>/admin/menus" id="sidebar-menus" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all">
                    <?= renderIcon('tag', 'w-5 h-5') ?>
                    <span>Menu Items</span>
                </a>
                <a href="<?= BASE_URL ?>/admin/categories" id="sidebar-categories" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all">
                    <?= renderIcon('clipboard', 'w-5 h-5') ?>
                    <span>Categories</span>
                </a>
                <a href="<?= BASE_URL ?>/admin/orders" id="sidebar-orders" class="sidebar-link flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all">
                    <span class="flex items-center gap-3">
                        <?= renderIcon('clipboard', 'w-5 h-5') ?>
                        <span>Orders</span>
                    </span>
                    <?php if ($adminActiveCount > 0): ?>
                    <span class="bg-amber-500 text-gray-900 text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center badge-pulse"><?= $adminActiveCount ?></span>
                    <?php endif; ?>
                </a>

                <p class="px-3 mb-3 mt-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Other</p>
                <a href="<?= BASE_URL ?>/menu" id="sidebar-view-site" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all">
                    <?= renderIcon('eye', 'w-5 h-5') ?>
                    <span>View Site</span>
                </a>
                <a href="<?= BASE_URL ?>/profile" id="sidebar-profile" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all">
                    <?= renderIcon('user', 'w-5 h-5') ?>
                    <span>My Profile</span>
                </a>
            </nav>

            <!-- User Info -->
            <div class="px-4 py-4 border-t border-gray-800/50">
                <div class="flex items-center gap-3 px-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                        <?= strtoupper(substr($_SESSION['full_name'] ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate"><?= sanitize($_SESSION['full_name'] ?? '') ?></p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <a href="<?= BASE_URL ?>/logout" class="text-gray-500 hover:text-red-400 transition-colors" title="Logout">
                        <?= renderIcon('logout', 'w-5 h-5') ?>
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm hidden lg:hidden" onclick="toggleAdminSidebar()"></div>

    <!-- Main Content Area -->
    <div class="flex-1 lg:ml-64">
        <!-- Top Bar -->
        <header class="sticky top-0 z-30 h-16 bg-gray-950/80 backdrop-blur-xl border-b border-gray-800/50 flex items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center">
                <button id="sidebar-toggle" onclick="toggleAdminSidebar()" class="lg:hidden p-2 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800/50 transition-all mr-4">
                    <?= renderIcon('menu-catalog', 'w-6 h-6') ?>
                </button>
                <h1 class="text-lg font-bold text-white"><?= sanitize($pageTitle ?? 'Dashboard') ?></h1>
            </div>
            <?php if ($adminPendingActions > 0): ?>
            <a href="<?= BASE_URL ?>/admin/orders?status=pending" class="flex items-center gap-2 px-3 py-1.5 bg-amber-500/10 border border-amber-500/20 rounded-xl text-amber-400 text-sm font-medium hover:bg-amber-500/20 transition-all">
                <?= renderIcon('bell', 'w-4 h-4') ?>
                <span><?= $adminPendingActions ?> pending</span>
            </a>
            <?php endif; ?>
        </header>

        <?php if (!empty($adminRecentPending)): ?>
        <div class="mx-4 sm:mx-6 lg:mx-8 mt-4">
            <div class="bg-amber-500/5 border border-amber-500/20 rounded-2xl p-4">
                <div class="flex items-center gap-2 mb-3">
                    <?= renderIcon('bell', 'w-5 h-5 text-amber-400') ?>
                    <span class="text-amber-400 font-bold text-sm">New Orders Awaiting Action</span>
                </div>
                <div class="space-y-2">
                    <?php foreach ($adminRecentPending as $pending): ?>
                    <a href="<?= BASE_URL ?>/admin/orders/<?= $pending['id'] ?>" class="flex items-center justify-between py-2 px-3 rounded-xl hover:bg-amber-500/10 transition-all group">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-amber-400 badge-pulse"></span>
                            <span class="text-sm text-gray-300 group-hover:text-white"><?= sanitize($pending['user_full_name']) ?></span>
                            <span class="text-xs text-gray-600">#<?= sanitize($pending['order_number']) ?></span>
                        </div>
                        <span class="text-sm font-semibold text-amber-400"><?= formatCurrency($pending['grand_total']) ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Page Content -->
        <main class="p-4 sm:p-6 lg:p-8">
            <?php require APP_ROOT . '/views/components/alert.php'; ?>
            <?= $content ?? '' ?>
        </main>
    </div>
</div>

<script>
    function toggleAdminSidebar() {
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>
<script src="<?= BASE_URL ?>/js/app.js"></script>
</body>
</html>
