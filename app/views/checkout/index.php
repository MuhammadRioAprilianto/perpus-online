<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Deposit - Perpus Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { base: '#F5F2F2', main: '#2B2A2A', primary: '#5A7ACD', accent: '#FEB05D', } } } }
    </script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-base text-main antialiased selection:bg-primary selection:text-white flex flex-col min-h-screen">

    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/perpus-online/public/" class="font-bold text-2xl text-primary">
                Perpus<span class="text-accent">Online</span>
            </a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-500 mr-2 hidden md:block">Halo, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
                <a href="/perpus-online/public/logout" class="ml-4 text-red-500 hover:text-red-700 font-medium transition-colors text-sm">Logout</a>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        
        <div class="mb-8">
            <a href="/perpus-online/public/cart" class="text-gray-500 hover:text-primary mb-4 inline-block font-medium transition-colors">
                &larr; Kembali ke Keranjang
            </a>
            <h1 class="text-3xl font-bold tracking-tight">Pembayaran Deposit</h1>
            <p class="text-gray-500 mt-1">Selesaikan pembayaran untuk memproses peminjaman buku Anda.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-6 md:p-8 border-b border-gray-100 flex flex-col md:flex-row justify-between md:items-center gap-4 bg-gray-50/50">
                <div>
                    <p class="text-gray-500 text-sm font-semibold mb-1">Total yang harus ditransfer</p>
                    <h2 class="text-3xl font-bold text-primary">Rp <?= number_format($deposit_amount, 0, ',', '.') ?></h2>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-gray-500 text-sm font-semibold mb-1">Tanggal Ambil</p>
                    <p class="font-bold text-main"><?= date('d F Y', strtotime($pickup_date)) ?></p>
                </div>
            </div>

            <div class="p-6 md:p-8">
                <h3 class="font-bold text-lg mb-4">Transfer ke Rekening Berikut:</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <div class="border border-gray-200 rounded-xl p-4 flex gap-4 items-center">
                        <div class="w-16 h-12 bg-blue-100 rounded-lg flex items-center justify-center font-bold text-blue-800 text-sm">BCA</div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Bank BCA</p>
                            <p class="font-bold text-lg tracking-wide">8732 1123 99</p>
                            <p class="text-xs text-gray-500">a.n. PerpusOnline</p>
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-xl p-4 flex gap-4 items-center">
                        <div class="w-16 h-12 bg-orange-100 rounded-lg flex items-center justify-center font-bold text-orange-800 text-sm">BSI</div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Bank BSI</p>
                            <p class="font-bold text-lg tracking-wide">7123 9000 11</p>
                            <p class="text-xs text-gray-500">a.n. PerpusOnline</p>
                        </div>
                    </div>
                </div>

                <form action="/perpus-online/public/loan/request" method="POST" enctype="multipart/form-data">
                    
                    <input type="hidden" name="pickup_date" value="<?= htmlspecialchars($pickup_date) ?>">
                    <input type="hidden" name="deposit_amount" value="<?= htmlspecialchars($deposit_amount) ?>">

                    <div class="space-y-2 mb-8">
                        <label for="deposit_receipt" class="block font-semibold text-sm text-gray-700">Upload Bukti Transfer <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition-colors">
                            <input type="file" id="deposit_receipt" name="deposit_receipt" required accept="image/jpeg, image/png, image/webp"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                            <p class="text-xs text-gray-500 mt-3">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-main hover:bg-black text-white font-bold py-4 rounded-xl shadow-sm transition-all duration-300 transform hover:-translate-y-1">
                        Konfirmasi Pembayaran & Ajukan Pinjaman
                    </button>
                </form>

            </div>
        </div>

    </main>

</body>
</html>