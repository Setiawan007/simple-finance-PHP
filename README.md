# Sistem Keuangan Menggunakan PHP dan AdminLTE

Sistem keuangan ini adalah sebuah aplikasi web sederhana yang dikembangkan menggunakan PHP dan AdminLTE. Aplikasi ini dirancang untuk membantu pengguna dalam mengelola transaksi keuangan mereka, membuat laporan, dan mengelola berbagai aspek keuangan lainnya.
Fitur Utama

    Dashboard
        Ringkasan keuangan dengan saldo, total pemasukan, total pengeluaran, dan grafik aliran kas.

    Transaksi
        Tambah transaksi baru dengan pilihan jenis (pemasukan atau pengeluaran).
        Daftar transaksi dengan fitur pencarian, filter, dan sorting.
        Edit dan hapus transaksi yang sudah ada.

    Laporan
        Generate laporan dalam format PDF dan Excel.
        Laporan keuangan bulanan, triwulanan, dan tahunan.
        Laporan pendapatan dan pengeluaran dengan rincian kategori.

    Anggaran
        Tetapkan anggaran untuk kategori tertentu dan lacak pengeluaran terhadap anggaran tersebut.
        Analisis anggaran untuk melihat seberapa baik target anggaran tercapai.

    Utang dan Piutang
        Manajemen utang untuk melacak pinjaman yang harus dibayar.
        Manajemen piutang untuk melacak uang yang harus diterima.

    Investasi
        Portofolio investasi untuk melacak investasi yang dimiliki.
        Analisis performa investasi dengan laporan kinerja.

    Pengaturan
        Profil pengguna untuk mengelola informasi akun pengguna.
        Pengaturan aplikasi untuk mengkonfigurasi bahasa, mata uang, dan preferensi lainnya.

Instalasi

    Persyaratan Sistem
        PHP versi 7.x atau yang lebih baru.
        MySQL atau database lain yang mendukung PDO.

    Langkah Instalasi
        Clone repositori ini ke direktori web server Anda (htdocs untuk XAMPP).
        Buat database baru di MySQL dan import file database.sql untuk membuat struktur tabel.
        Konfigurasi koneksi database di file includes/db.php.
        Pastikan Composer terinstal di sistem Anda.
        Jalankan composer install untuk menginstal library yang diperlukan.

    Konfigurasi
        Sesuaikan pengaturan umum aplikasi di file config.php jika diperlukan (misalnya, timezone, nama aplikasi).

Penggunaan

    Login
        Akses aplikasi melalui browser dan login menggunakan akun yang sudah terdaftar.

    Dashboard
        Lihat ringkasan keuangan dan grafik aliran kas.

    Transaksi
        Tambahkan, edit, dan hapus transaksi.
        Lihat daftar transaksi dengan filter dan sorting.

    Laporan
        Generate laporan dalam format PDF atau Excel.
        Lihat laporan keuangan berdasarkan periode waktu tertentu.

    Anggaran, Utang & Piutang, Investasi
        Gunakan fitur-fitur ini untuk mengelola aspek keuangan yang relevan.

    Pengaturan
        Atur profil pengguna dan pengaturan aplikasi sesuai kebutuhan.

Kontribusi

Anda dapat berkontribusi pada pengembangan aplikasi ini dengan mengirimkan pull request atau melaporkan isu di GitHub repository ini.
Lisensi

Proyek ini dilisensikan di bawah MIT License.
