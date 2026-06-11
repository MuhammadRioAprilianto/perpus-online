<?php
ob_start();

$statusSteps = ['pending', 'confirmed', 'cooking', 'ready', 'delivered'];
$currentStepIndex = array_search($order['status'], $statusSteps);
if ($currentStepIndex === false) $currentStepIndex = -1;

$statusIcons = [
    'pending'   => 'clock',
    'confirmed' => 'check-circle',
    'cooking'   => 'fire',
    'ready'     => 'check',
    'delivered' => 'truck',
];

$paymentStatusColors = [
    'unpaid'   => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
    'uploaded' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
    'verified' => 'bg-green-500/10 text-green-400 border-green-500/20',
    'rejected' => 'bg-red-500/10 text-red-400 border-red-500/20',
];
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-3 mb-8">
        <a href="<?= BASE_URL ?>/orders" class="text-gray-400 hover:text-white transition-colors">
            <?= renderIcon('arrow-left', 'w-5 h-5') ?>
        </a>
        <h1 class="text-2xl md:text-3xl font-black text-white">Order #<?= sanitize($order['order_number']) ?></h1>
    </div>

    <!-- Status Tracker -->
    <?php if ($order['status'] !== 'cancelled'): ?>
    <div class="bg-gray-800/30 border border-gray-700/50 rounded-2xl p-6 mb-6">
        <h2 class="text-lg font-bold text-white mb-6">Order Status</h2>
        <div class="flex items-center justify-between relative">
            <div class="absolute top-5 left-0 right-0 h-0.5 bg-gray-700/50"></div>
            <div class="absolute top-5 left-0 h-0.5 bg-amber-500 transition-all duration-500"
                 style="width: <?= $currentStepIndex >= 0 ? ($currentStepIndex / (count($statusSteps) - 1) * 100) : 0 ?>%"></div>

            <?php foreach ($statusSteps as $i => $step): ?>
            <div class="relative flex flex-col items-center gap-2 z-10">
                <div class="w-10 h-10 rounded-full flex items-center justify-center <?= $i <= $currentStepIndex ? 'bg-amber-500 text-gray-900' : 'bg-gray-800 text-gray-600 border-2 border-gray-700' ?> transition-all">
                    <?= renderIcon($statusIcons[$step], 'w-5 h-5') ?>
                </div>
                <span class="text-xs font-semibold <?= $i <= $currentStepIndex ? 'text-amber-400' : 'text-gray-600' ?> hidden sm:block">
                    <?= ucfirst($step) ?>
                </span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-6 mb-6 flex items-center gap-3">
        <?= renderIcon('x-circle', 'w-6 h-6 text-red-400') ?>
        <span class="text-red-400 font-bold">This order has been cancelled.</span>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Items -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-gray-800/30 border border-gray-700/50 rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-4">Items Ordered</h2>
                <div class="space-y-4">
                    <?php foreach ($orderItems as $item): ?>
                    <div class="flex items-center justify-between py-3 border-b border-gray-700/30 last:border-0">
                        <div class="flex items-center gap-3">
                            <span class="bg-amber-500/10 text-amber-400 font-bold text-sm w-8 h-8 rounded-lg flex items-center justify-center"><?= $item['quantity'] ?>x</span>
                            <div>
                                <p class="text-white font-medium"><?= sanitize($item['menu_name']) ?></p>
                                <p class="text-sm text-gray-500"><?= formatCurrency($item['menu_price']) ?> each</p>
                            </div>
                        </div>
                        <span class="text-white font-semibold"><?= formatCurrency($item['subtotal']) ?></span>
                    </div>

                    <?php if ($order['status'] === 'delivered' && $item['menu_id'] && !(isset($itemRatings[$item['menu_id']]) && $itemRatings[$item['menu_id']])): ?>
                    <div class="ml-11 pb-3">
                        <form action="<?= BASE_URL ?>/rating" method="POST" class="bg-gray-900/50 border border-gray-700/30 rounded-xl p-4" id="rating-form-<?= $item['menu_id'] ?>">
                            <?= csrfField() ?>
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <input type="hidden" name="menu_id" value="<?= $item['menu_id'] ?>">
                            <p class="text-sm font-semibold text-gray-300 mb-2">Rate this item</p>
                            <div class="flex items-center gap-1 mb-3 star-rating" data-menu-id="<?= $item['menu_id'] ?>">
                                <?php for ($s = 1; $s <= 5; $s++): ?>
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="<?= $s ?>" class="hidden" required>
                                    <span class="text-gray-600 hover:text-amber-400 transition-colors"><?= renderIcon('star', 'w-6 h-6') ?></span>
                                </label>
                                <?php endfor; ?>
                            </div>
                            <textarea name="review" rows="2" placeholder="Write a review (optional)"
                                      class="w-full px-3 py-2 bg-gray-800/50 border border-gray-700/50 rounded-lg text-white text-sm placeholder-gray-600 focus:outline-none focus:border-amber-500/50 resize-none mb-3"></textarea>
                            <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-400 text-gray-900 font-bold text-sm rounded-lg transition-all">
                                Submit Review
                            </button>
                        </form>
                    </div>
                    <?php elseif ($order['status'] === 'delivered' && $item['menu_id'] && isset($itemRatings[$item['menu_id']]) && $itemRatings[$item['menu_id']]): ?>
                    <div class="ml-11 pb-3 flex items-center gap-2 text-emerald-400 text-sm">
                        <?= renderIcon('check-circle', 'w-4 h-4') ?>
                        <span class="font-medium">Reviewed</span>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Payment Proof Upload -->
            <?php if ($order['payment_status'] === 'unpaid' || $order['payment_status'] === 'rejected'): ?>
            <div class="bg-gray-800/30 border border-amber-500/20 rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-2 flex items-center gap-2">
                    <?= renderIcon('upload', 'w-5 h-5 text-amber-400') ?>
                    Upload Payment Proof
                </h2>
                <p class="text-sm text-gray-400 mb-4">
                    <?= $order['payment_status'] === 'rejected' ? 'Your previous payment was rejected. Please upload a new proof.' : 'Please upload your transfer receipt to process your order.' ?>
                </p>

                <form action="<?= BASE_URL ?>/checkout/payment/<?= $order['id'] ?>" method="POST" enctype="multipart/form-data" id="payment-upload-form">
                    <?= csrfField() ?>
                    <div class="border-2 border-dashed border-gray-700/50 rounded-xl p-6 text-center hover:border-amber-500/30 transition-colors" id="upload-dropzone">
                        <div class="mb-3"><?= renderIcon('image', 'w-10 h-10 text-gray-600 mx-auto') ?></div>
                        <p class="text-sm text-gray-400 mb-3">Drag & drop or click to select</p>
                        <input type="file" name="payment_proof" accept="image/*" required
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-500/10 file:text-amber-400 hover:file:bg-amber-500/20 file:cursor-pointer" id="payment-proof-input">
                        <div id="payment-preview" class="mt-4 hidden">
                            <img id="payment-preview-img" src="" alt="Preview" class="max-h-48 mx-auto rounded-lg">
                        </div>
                    </div>
                    <button type="submit" class="mt-4 w-full py-3 bg-amber-500 hover:bg-amber-400 text-gray-900 font-bold rounded-xl transition-all hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2">
                        <?= renderIcon('upload', 'w-5 h-5') ?>
                        Upload Payment Proof
                    </button>
                </form>
            </div>
            <?php elseif ($order['payment_proof']): ?>
            <div class="bg-gray-800/30 border border-gray-700/50 rounded-2xl p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <?= renderIcon('image', 'w-5 h-5 text-amber-400') ?>
                    Payment Proof
                    <span class="<?= $paymentStatusColors[$order['payment_status']] ?> border text-xs font-bold px-3 py-1 rounded-full ml-2"><?= ucfirst($order['payment_status']) ?></span>
                </h2>
                <img src="<?= PAYMENT_UPLOAD_URL . $order['payment_proof'] ?>" alt="Payment proof" class="max-w-full rounded-xl border border-gray-700/50">
            </div>
            <?php endif; ?>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-gray-800/30 border border-gray-700/50 rounded-2xl p-6 sticky top-24 space-y-5">
                <h2 class="text-lg font-bold text-white">Order Details</h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Order Number</span>
                        <span class="text-white font-medium"><?= sanitize($order['order_number']) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Date</span>
                        <span class="text-white"><?= date('d M Y', strtotime($order['created_at'])) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Time</span>
                        <span class="text-white"><?= date('H:i', strtotime($order['created_at'])) ?></span>
                    </div>
                </div>

                <div class="border-t border-gray-700/50 pt-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="text-white"><?= formatCurrency($order['total_amount']) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tax</span>
                        <span class="text-white"><?= formatCurrency($order['tax_amount']) ?></span>
                    </div>
                    <div class="border-t border-gray-700/50 pt-3 flex justify-between">
                        <span class="font-bold text-white">Grand Total</span>
                        <span class="font-bold text-amber-400 text-lg"><?= formatCurrency($order['grand_total']) ?></span>
                    </div>
                </div>

                <?php if ($order['customer_name']): ?>
                <div class="border-t border-gray-700/50 pt-4 space-y-2 text-sm">
                    <p class="text-gray-500 font-semibold uppercase tracking-wider text-xs">Delivery To</p>
                    <p class="text-white"><?= sanitize($order['customer_name']) ?></p>
                    <?php if ($order['customer_phone']): ?>
                    <p class="text-gray-400 flex items-center gap-1"><?= renderIcon('phone', 'w-3 h-3') ?> <?= sanitize($order['customer_phone']) ?></p>
                    <?php endif; ?>
                    <?php if ($order['customer_address']): ?>
                    <p class="text-gray-400 flex items-center gap-1"><?= renderIcon('location', 'w-3 h-3') ?> <?= sanitize($order['customer_address']) ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if ($order['notes']): ?>
                <div class="border-t border-gray-700/50 pt-4 text-sm">
                    <p class="text-gray-500 font-semibold uppercase tracking-wider text-xs mb-1">Notes</p>
                    <p class="text-gray-300"><?= sanitize($order['notes']) ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require APP_ROOT . '/views/layouts/main.php';
?>
