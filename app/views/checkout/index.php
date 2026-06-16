<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Deposit - Perpus Online</title>
    <link rel="icon" type="image/png" href="/perpus-online/public/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        base: '#F8FAFC',
                        main: '#0F172A',
                        primary: '#4F46E5',
                        accent: '#F59E0B',
                        card: '#FFFFFF'
                    },
                    borderRadius: {
                        '3xl': '1.5rem',
                        '4xl': '2rem'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;850&display=swap');
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-base text-main antialiased flex flex-col min-h-screen">

    <nav class="glass-nav shadow-sm border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/perpus-online/public/" class="font-extrabold text-2xl text-primary tracking-tight flex items-center gap-2">
                <span>📚 Perpus<span class="text-accent">Online</span></span>
            </a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-500 font-medium hidden md:block">Halo, <span class="font-bold text-slate-800"><?= htmlspecialchars($_SESSION['user_name']) ?></span>!</span>
                <a href="/perpus-online/public/logout" class="text-red-500 hover:text-red-700 font-bold transition-colors text-sm">Logout</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        
        <!-- Progress Tracker -->
        <div class="max-w-3xl mx-auto mb-12">
            <div class="flex items-center justify-between relative">
                <!-- Line -->
                <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-1 bg-slate-200 -z-10 rounded-full"></div>
                <div class="absolute left-0 w-full top-1/2 -translate-y-1/2 h-1 bg-primary -z-10 rounded-full"></div>
                
                <!-- Steps -->
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold shadow-md shadow-primary/20 ring-4 ring-white text-sm">✓</div>
                    <span class="text-xs font-semibold text-slate-400">Keranjang Pinjam</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold shadow-md shadow-primary/20 ring-4 ring-white text-sm">2</div>
                    <span class="text-xs font-bold text-primary">Pembayaran Deposit</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 bg-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold ring-4 ring-white text-sm">3</div>
                    <span class="text-xs font-semibold text-slate-400">Persetujuan Pustakawan</span>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <a href="/perpus-online/public/cart" class="text-slate-400 hover:text-primary mb-3 inline-block font-semibold transition-colors text-sm">
                &larr; Kembali ke Keranjang
            </a>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Pembayaran Deposit</h1>
            <p class="text-slate-400 text-sm mt-1">Selesaikan transfer dana jaminan untuk mengirim permohonan pinjam buku Anda.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-8">
            <div class="p-6 md:p-8 border-b border-slate-100 flex flex-col md:flex-row justify-between md:items-center gap-4 bg-slate-50/50">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Deposit Jaminan</p>
                    <h2 class="text-3xl font-extrabold text-primary">Rp <?= number_format($deposit_amount, 0, ',', '.') ?></h2>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Tanggal Rencana Ambil</p>
                    <p class="font-bold text-slate-800 text-lg"><?= date('d F Y', strtotime($pickup_date)) ?></p>
                </div>
            </div>

            <div class="p-6 md:p-8">
                <h3 class="font-bold text-slate-800 text-base mb-4">Transfer ke Salah Satu Rekening Kami:</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <div class="border border-slate-200 rounded-2xl p-5 flex gap-4 items-center bg-slate-50/25">
                        <div class="w-16 h-12 bg-blue-50 text-blue-700 rounded-xl flex items-center justify-center font-extrabold text-sm border border-blue-100">BCA</div>
                        <div>
                            <p class="text-xs text-slate-400 font-semibold">Bank BCA</p>
                            <p class="font-bold text-slate-800 text-base tracking-wide mt-0.5">8732 1123 99</p>
                            <p class="text-[10px] text-slate-400">a.n. PerpusOnline</p>
                        </div>
                    </div>
                    <div class="border border-slate-200 rounded-2xl p-5 flex gap-4 items-center bg-slate-50/25">
                        <div class="w-16 h-12 bg-amber-50 text-amber-700 rounded-xl flex items-center justify-center font-extrabold text-sm border border-amber-100">BSI</div>
                        <div>
                            <p class="text-xs text-slate-400 font-semibold">Bank BSI</p>
                            <p class="font-bold text-slate-800 text-base tracking-wide mt-0.5">7123 9000 11</p>
                            <p class="text-[10px] text-slate-400">a.n. PerpusOnline</p>
                        </div>
                    </div>
                </div>

                <form action="/perpus-online/public/loan/request" method="POST" enctype="multipart/form-data">
                    
                    <input type="hidden" name="pickup_date" value="<?= htmlspecialchars($pickup_date) ?>">
                    <input type="hidden" name="deposit_amount" value="<?= htmlspecialchars($deposit_amount) ?>">

                    <div class="space-y-2 mb-8">
                        <label for="deposit_receipt" class="block font-bold text-xs uppercase tracking-wider text-slate-450">Upload Bukti Transfer <span class="text-rose-500">*</span></label>
                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center hover:bg-slate-50/50 transition-all duration-300 relative group cursor-pointer">
                            <input type="file" id="deposit_receipt" name="deposit_receipt" required accept="image/jpeg, image/png, image/webp"
                                class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                            <div class="flex flex-col items-center">
                                <span class="text-4xl mb-3 group-hover:scale-110 transition-transform duration-300">📄</span>
                                <p class="text-sm font-bold text-slate-650" id="file_label_text">Klik atau seret file gambar ke sini</p>
                                <p class="text-xs text-slate-400 mt-2 font-medium">Mendukung format JPG, PNG, WEBP. Maksimal ukuran file 2MB.</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-main hover:bg-black text-white font-bold py-4.5 rounded-2xl shadow-lg shadow-slate-900/10 transition-all duration-300 transform hover:-translate-y-0.5 text-sm">
                        Konfirmasi Pembayaran & Ajukan Pinjaman
                    </button>
                </form>

            </div>
        </div>

    </main>

    <footer class="bg-white border-t border-slate-100 py-6 text-center text-xs text-slate-400 font-medium">
        &copy; 2026 PerpusOnline. Seluruh Hak Cipta Dilindungi.
    </footer>

    <script>
        // File input label update
        const fileInput = document.getElementById('deposit_receipt');
        const fileLabelText = document.getElementById('file_label_text');
        fileInput.addEventListener('change', (e) => {
            if (fileInput.files.length > 0) {
                fileLabelText.innerText = "✓ File Terpilih: " + fileInput.files[0].name;
                fileLabelText.classList.remove('text-slate-650');
                fileLabelText.classList.add('text-primary');
            }
        });
    </script>

</body>
</html>