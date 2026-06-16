<footer class="bg-slate-900 text-slate-300 border-t border-slate-800 pt-16 pb-8 mt-auto dark:bg-slate-950 dark:border-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
            <!-- Column 1: Brand Info -->
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-extrabold text-white tracking-tight">Perpus<span class="text-amber-500">Online</span></span>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Sistem peminjaman buku perpustakaan jarak jauh modern. Pesan buku pilihan Anda secara online, ambil fisik buku di lokasi tanpa mengantre.
                </p>
            </div>
            
            <!-- Column 2: Quick Links -->
            <div>
                <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Navigasi</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="<?= BASE_URL ?>/catalog" class="text-slate-400 hover:text-white transition-colors">Katalog Buku</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <li><a href="<?= BASE_URL ?>/admin/dashboard" class="text-slate-400 hover:text-white transition-colors">Dashboard Admin</a></li>
                        <?php else: ?>
                            <li><a href="<?= BASE_URL ?>/loans" class="text-slate-400 hover:text-white transition-colors">Pinjamanku</a></li>
                            <li><a href="<?= BASE_URL ?>/cart" class="text-slate-400 hover:text-white transition-colors">Keranjang</a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><a href="<?= BASE_URL ?>/login" class="text-slate-400 hover:text-white transition-colors">Masuk / Login</a></li>
                        <li><a href="<?= BASE_URL ?>/register" class="text-slate-400 hover:text-white transition-colors">Daftar Akun</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Column 3: Operating Hours -->
            <div>
                <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Jam Layanan</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li>Senin - Jumat: 08:00 - 16:00</li>
                    <li>Sabtu: 09:00 - 13:00</li>
                    <li class="text-amber-500 font-semibold">Minggu & Hari Libur: Tutup</li>
                </ul>
            </div>

            <!-- Column 4: Contact details -->
            <div class="space-y-3">
                <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Kontak Kami</h4>
                <div class="flex items-start gap-2.5 text-sm text-slate-400">
                    <span class="text-amber-500 mt-0.5 w-5 h-5 flex-shrink-0">
                        <?= renderIcon('location', 'w-5 h-5') ?>
                    </span>
                    <span>Jl. Ring Road Selatan, Geblagan, Tamantirto, Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta</span>
                </div>
                <div class="flex items-center gap-2.5 text-sm text-slate-400">
                    <span class="text-amber-500 w-5 h-5 flex-shrink-0">
                        <?= renderIcon('phone', 'w-5 h-5') ?>
                    </span>
                    <span>(0361) 701954</span>
                </div>
                <div class="flex items-center gap-2.5 text-sm text-slate-400">
                    <span class="text-amber-500 w-5 h-5 flex-shrink-0">
                        <?= renderIcon('mail', 'w-5 h-5') ?>
                    </span>
                    <span>info@perpusonline.my.id</span>
                </div>
            </div>
        </div>
        
        <!-- Bottom copyright -->
        <div class="border-t border-slate-800 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <p>&copy; <?= date('Y') ?> PerpusOnline. Seluruh Hak Cipta Dilindungi.</p>
            <p>Dikembangkan dengan ketulusan oleh Kelompok 5</p>
        </div>
    </div>
</footer>
