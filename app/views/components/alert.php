<?php

/**
 * Flash message alert component.
 *
 * Renders styled alert banners for success, error, warning,
 * and info flash messages stored in the session. Also consumes
 * and displays file-based customer order status notifications.
 */

$flash = getFlash();
if ($flash):
    $alertStyles = [
        'success' => 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400',
        'error'   => 'bg-red-500/10 border-red-500/30 text-red-400',
        'warning' => 'bg-amber-500/10 border-amber-500/30 text-amber-400',
        'info'    => 'bg-blue-500/10 border-blue-500/30 text-blue-400',
    ];
    $alertIcons = [
        'success' => 'check-circle',
        'error'   => 'x-circle',
        'warning' => 'warning',
        'info'    => 'info',
    ];
    $type = $flash['type'];
    $style = $alertStyles[$type] ?? $alertStyles['info'];
    $icon = $alertIcons[$type] ?? 'info';
?>
<div id="flash-alert" class="fixed top-24 right-4 z-50 max-w-md animate-slide-in">
    <div class="<?= $style ?> border rounded-xl px-5 py-4 backdrop-blur-sm flex items-start gap-3 shadow-2xl">
        <span class="flex-shrink-0 mt-0.5"><?= renderIcon($icon, 'w-5 h-5') ?></span>
        <p class="text-sm font-medium flex-1"><?= sanitize($flash['message']) ?></p>
        <button onclick="this.closest('#flash-alert').remove()" class="flex-shrink-0 opacity-60 hover:opacity-100 transition-opacity">
            <?= renderIcon('x', 'w-4 h-4') ?>
        </button>
    </div>
</div>
<?php endif; ?>

<?php
if (isLoggedIn() && !isAdmin()):
    $customerNotifs = getCustomerNotifications(getCurrentUserId());
    if (!empty($customerNotifs)):
?>
<div class="fixed bottom-6 right-6 z-50 max-w-sm w-full space-y-2 animate-slide-in" id="customer-notifications">
    <?php foreach ($customerNotifs as $notifMsg): ?>
    <div class="bg-blue-500/10 border border-blue-500/30 text-blue-400 rounded-xl px-5 py-4 backdrop-blur-sm flex items-start gap-3 shadow-2xl">
        <span class="flex-shrink-0 mt-0.5"><?= renderIcon('bell', 'w-5 h-5') ?></span>
        <p class="text-sm font-medium flex-1"><?= sanitize($notifMsg) ?></p>
        <button onclick="this.parentElement.remove()" class="flex-shrink-0 opacity-60 hover:opacity-100 transition-opacity">
            <?= renderIcon('x', 'w-4 h-4') ?>
        </button>
    </div>
    <?php endforeach; ?>
</div>
<?php
    endif;
endif;
?>
