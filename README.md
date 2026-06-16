# Perpustakaan Online (Perpus Online)

Perpustakaan Online adalah platform berbasis web untuk mengelola katalog, pemesanan, dan transaksi peminjaman buku secara digital. Sistem ini dirancang untuk mempermudah member meminjam buku secara mandiri (self-service) dan memperlancar tugas pustakawan (admin) dalam mengelola persetujuan peminjaman, pencatatan pengembalian, ulasan, serta pemantauan daftar member.

---

## Fitur Utama

### 🧑‍💼 Fitur Member
1. **Landing Page Premium**: Dilengkapi dengan visual ilustrasi dinamis, statistik real-time koleksi perpustakaan, dan scroll reveal animations.
2. **Katalog Buku & Pencarian Instan**: Halaman `/catalog` yang responsif, dilengkapi efek **Pulsing Skeleton Cards** saat memfilter/mencari buku secara real-time.
3. **Menu Profil Dropdown**: Navbar yang rapi yang secara otomatis mendeteksi status login member untuk mengelompokkan halaman **Pinjamanku**, **Keranjang**, dan tombol **Keluar** dalam satu menu dropdown interaktif.
4. **Pembayaran Deposit**: Mengajukan peminjaman buku (maksimal 3 buku sekaligus) dengan menyertakan bukti transfer pembayaran jaminan (deposit).
5. **Sistem Ulasan Buku**: Memberikan rating bintang (1-5) dan komentar ulasan pada buku yang telah berhasil dikembalikan.
6. **Mode Terang/Gelap (Light/Dark Mode)**: Mengubah preferensi visual seluruh halaman secara instan dengan efek transisi micro-animations.

### 👑 Fitur Admin (Pustakawan)
1. **Dashboard Admin**: Ringkasan visual tentang total koleksi buku, total peminjaman aktif, member terdaftar, dan jumlah ulasan masuk.
2. **Manajemen Buku (CRUD)**: Menambah, mengubah, mencari, dan menghapus koleksi buku lengkap dengan unggah sampul buku.
3. **Manajemen Peminjaman**: Memantau seluruh antrean transaksi peminjaman, menyetujui transaksi dengan melihat bukti jaminan, serta mengonfirmasi pengembalian buku dan denda keterlambatan secara otomatis.
4. **Daftar Member & Riwayat**: Memantau data seluruh member, tanggal pendaftaran, total buku yang sedang dipinjam, serta denda terakumulasi.
5. **Moderasi Ulasan**: Melihat daftar seluruh ulasan member dan berhak menghapus ulasan yang mengandung konten tidak pantas.

---

## Teknologi & Konfigurasi

Sistem ini dibangun dengan arsitektur **MVC (Model-View-Controller) buatan sendiri (Custom MVC)** menggunakan PHP murni tanpa framework eksternal untuk efisiensi performa yang optimal.

* **Core**: PHP >= 7.4 (PDO Extension diaktifkan)
* **Database**: MySQL / MariaDB
* **Styling**: Tailwind CSS (via CDN) dengan HSL Custom Color Palette
* **Server**: Apache (menggunakan modul `.htaccess` untuk menulis ulang URL / URL Rewriting)

### Konfigurasi Otomatis (Local vs cPanel)
Sistem ini secara pintar mendeteksi lingkungan jalannya aplikasi (`$isLocal`) berdasarkan `HTTP_HOST`:
* **Localhost (Development)**:
  * URL Akses: `http://localhost/perpus-online/public`
  * Database: Host `localhost`, User `root`, Password ``, DB `perpus-online`
* **cPanel (Production)**:
  * URL Akses: Mengikuti domain cPanel Anda (contoh: `https://perpus-online.pdwtiumy.click`)
  * Database: Disesuaikan dengan kredensial cPanel yang tersimpan di `app/config/database.php`.

---

## Struktur Folder Project

Berikut adalah peta struktur folder dan file di dalam project **perpus-online**:

```text
perpus-online/
├── app/                        # 🔒 Kode aplikasi yang dilindungi (tidak dapat diakses langsung oleh publik)
│   ├── config/                 #    Konfigurasi aplikasi dan database
│   │   ├── app.php             #    Deklarasi konstanta dasar (Base URL, Timezone)
│   │   ├── database.php        #    Konfigurasi database (Local/Production) & Wrapper PDO
│   │   └── routes.php          #    Daftar pemetaan URL ke Controller & Action
│   │
│   ├── controllers/            #    Logika Request Handler
│   │   ├── AdminController.php #    Handler dashboard admin, member list, dan ulasan
│   │   ├── AuthController.php  #    Handler proses registrasi, login, dan logout
│   │   ├── BookController.php  #    Handler pencarian buku dan CRUD buku oleh admin
│   │   ├── CartController.php  #    Handler pengelolaan keranjang belanja sementara
│   │   ├── CheckoutController.php # Handler halaman pembayaran deposit
│   │   ├── HomeController.php  #    Handler halaman depan landing page & katalog buku
│   │   └── LoanController.php  #    Handler transaksi peminjaman, persetujuan, & ulasan
│   │
│   ├── helpers/                #    Fungsi bantuan utilitas global
│   │   ├── env.php             #    Helper deteksi environment
│   │   └── functions.php       #    Fungsi render ikon SVG, filter XSS, dan format rupiah
│   │
│   ├── models/                 #    Layer Akses Data (Database Query)
│   │   ├── Book.php            #    Model data buku
│   │   ├── Cart.php            #    Model data keranjang
│   │   └── UserModel.php       #    Model data user/member
│   │
│   └── views/                  #    Layer Presentasi (HTML/PHP UI template)
│       ├── admin/              #    Views khusus admin (dashboard, members, reviews)
│       │   ├── books/          #    Views CRUD buku (add, edit, list)
│       │   └── loans/          #    Views pengelolaan transaksi peminjaman (list)
│       ├── auth/               #    Halaman login dan pendaftaran member baru
│       ├── books/              #    Views detail ulasan buku
│       ├── cart/               #    Views halaman keranjang pinjam
│       ├── checkout/           #    Views halaman unggah bukti jaminan deposit
│       ├── components/         #    Potongan UI reusable (alert, footer, icons, menu-card)
│       ├── home/               #    Views utama (landing page & katalog pencarian)
│       ├── layouts/            #    Layout pembungkus (admin sidebar & client main layout)
│       ├── loans/              #    Views riwayat peminjaman member (my_loans)
│       └── 404.php             #    Halaman penanganan error 404 jika URL tidak terdaftar
│
├── public/                     # 🌐 Root direktori yang diakses langsung oleh Web Server
│   ├── css/                    #    Tempat aset stylesheets
│   ├── js/                     #    Tempat file JavaScript interaktif client-side
│   ├── uploads/                #    Penyimpanan berkas unggahan pengguna
│   │   ├── books/              #    Sampul gambar buku yang diunggah admin
│   │   └── receipts/           #    Berkas bukti transfer jaminan/deposit yang diunggah member
│   ├── .htaccess               #    Pencegahan directory listing & penulisan ulang URL lokal
│   ├── favicon.png             #    Ikon tab browser aplikasi
│   ├── debug.php               #    Perkakas untuk pengujian status database lokal
│   └── index.php               #    Entry point utama aplikasi & inisialisator router MVC
│
├── .env.example                #    Contoh berkas konfigurasi environment aplikasi
├── .gitignore                  #    Daftar berkas yang diabaikan oleh git tracker
├── .htaccess                   #    Rewrite root URL otomatis ke folder public/ & force HTTPS
├── database.sql                #    Skema database lengkap (DDL & DML awal)
└── README.md                   #    Dokumentasi panduan proyek
```

---

## Panduan Instalasi di Localhost

1. **Persiapan Folder**:
   Salin folder `perpus-online` ke direktori root web server Anda:
   * **Windows (XAMPP)**: `C:\xampp\htdocs\perpus-online`
   * **macOS (MAMP)**: `/Applications/MAMP/htdocs/perpus-online`
   * **Linux (LAMP)**: `/var/www/html/perpus-online`

2. **Impor Database**:
   * Jalankan MySQL di control panel server Anda (misal: XAMPP).
   * Buka browser dan akses **phpMyAdmin** (`http://localhost/phpmyadmin`).
   * Buat database baru bernama `perpus-online`.
   * Klik tab **Import**, pilih file `database.sql` yang ada di root direktori project ini, lalu klik **Go** / **Kirim**.

3. **Verifikasi Apache Rewrite Modul**:
   * Pastikan module `mod_rewrite` telah aktif di konfigurasi `httpd.conf` Apache server Anda agar penulisan URL MVC tanpa `index.php` berjalan dengan lancar.

4. **Akses Aplikasi**:
   * Buka browser Anda dan navigasikan ke: `http://localhost/perpus-online` (Secara otomatis Anda akan diarahkan ke Landing Page melalui file `.htaccess` di root).

---

## Akun Login Default (Seed Data)

Untuk masuk dan mencoba fitur sebagai administrator (pustakawan), gunakan data berikut:

* **Email Admin**: `admin@perpus.com`
* **Password Admin**: `password`

*Catatan: Member baru dapat mendaftarkan akunnya secara langsung melalui form pendaftaran di aplikasi.*
