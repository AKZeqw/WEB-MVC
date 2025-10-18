# Proyek Registrasi Pengguna Sederhana (PHP MVC)

Proyek ini adalah aplikasi web sederhana yang dibangun menggunakan PHP dengan pola arsitektur Model-View-Controller (MVC) murni (native). Aplikasi ini mengelola registrasi pengguna, login, dan manajemen data pengguna (CRUD) melalui dashboard.

Fitur unik dari proyek ini adalah keharusan bagi pengguna untuk mengunggah foto profil dan memberikan tanda tangan digital menggunakan canvas (Signature Pad) saat mendaftar.

## ✨ Fitur Utama

* **Autentikasi Pengguna**: Sistem registrasi dan login yang aman menggunakan session PHP.
* **Validasi Formulir**:
    * Validasi sisi server di `AuthController` (email unik, format email, panjang nomor telepon, semua field wajib diisi).
    * Validasi sisi klien (HTML5 & JavaScript) di formulir registrasi.
* **Upload File**: Pengguna harus mengunggah foto profil saat mendaftar.
* **Tanda Tangan Digital**: Pengguna harus memberikan tanda tangan menggunakan `SignaturePad.js` yang disimpan sebagai gambar PNG di server.
* **Dropdown Bertingkat**: Formulir registrasi memiliki dropdown provinsi dan kota yang saling bergantung (data diambil dari objek JavaScript).
* **Dashboard Manajemen Pengguna**:
    * Tampilan tabel semua pengguna terdaftar.
    * Fungsi **Edit** data pengguna (termasuk update foto dan password).
    * Fungsi **Hapus** pengguna dengan konfirmasi (SweetAlert2).
* **Halaman Profil**: Halaman khusus bagi pengguna untuk melihat detail profil mereka sendiri.
* **Notifikasi**: Menggunakan SweetAlert2 untuk notifikasi sukses dan error yang user-friendly.
* **Routing Sederhana**: Menggunakan router kustom untuk mengarahkan URL (misal: `/auth/login`) ke Controller dan Method yang sesuai.

## 🛠️ Teknologi yang Digunakan

* **Backend**: PHP (Native)
* **Frontend**: HTML5, CSS, JavaScript
* **Database**: MySQL (menggunakan ekstensi PDO)
* **Arsitektur**: Model-View-Controller (MVC)
* **UI Framework**: Bootstrap 5
* **JavaScript Libraries**:
    * SweetAlert2 (Untuk notifikasi pop-up)
    * SignaturePad.js (Untuk input tanda tangan di canvas)
* **Web Server**: Apache (menggunakan `.htaccess` untuk URL rewriting)

## Prasyarat Instalasi

* Web Server (XAMPP, WAMP, MAMP, atau sejenisnya)
* PHP 8.3 atau lebih baru
* Database MySQL
* Web Browser

## 🚀 Instalasi & Konfigurasi

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/username/repository-name.git](https://github.com/username/repository-name.git)
    ```
    Atau unduh dan ekstrak file ZIP ke direktori web server Anda (misal: `C:/xampp/htdocs/`).

2.  **Database Setup**
    * Buka `phpMyAdmin` atau klien database Anda.
    * Buat database baru dengan nama `mvc`.
    * Jalankan kueri SQL berikut untuk membuat tabel `users`:
        ```sql
        CREATE TABLE `users` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `nama_lengkap` varchar(255) NOT NULL,
          `email` varchar(255) NOT NULL,
          `password` varchar(255) NOT NULL,
          `nomor_telepon` varchar(15) NOT NULL,
          `provinsi` varchar(100) NOT NULL,
          `kota` varchar(100) NOT NULL,
          `foto_profil` varchar(255) NOT NULL,
          `tanda_tangan` varchar(255) NOT NULL,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          PRIMARY KEY (`id`),
          UNIQUE KEY `email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ```

3.  **Konfigurasi Koneksi**
    * Buka file `config/database.php`.
    * Sesuaikan nilai `$host`, `$db_name`, `$username`, dan `$password` agar sesuai dengan pengaturan database MySQL Anda.
        ```php
        class Database {
            private $host = "localhost"; // Sesuaikan jika perlu
            private $db_name = "mvc";    // Nama database yang Anda buat
            private $username = "root";  // Username database Anda
            private $password = "";    // Password database Anda
            // ...
        }
        ```

4.  **Konfigurasi BASEURL**
    * Buka file `public/index.php`.
    * Ubah nilai konstanta `BASEURL` agar sesuai dengan URL proyek Anda di server lokal.
        ```php
        // Contoh jika Anda meletakkannya di folder 'proyek-mvc' di htdocs
        define('BASEURL', 'http://localhost/proyek-mvc/');
        
        // Contoh jika Anda menggunakan virtual host
        // define('BASEURL', '[http://mvc.cihuy/](http://mvc.cihuy/)');
        ```

5.  **Jalankan Aplikasi**
    * Buka web browser Anda dan akses `BASEURL` yang telah Anda atur (misal: `http://localhost/proyek-mvc/`).
    * Anda akan diarahkan ke halaman login.

## 📂 Struktur Proyek

```
.
├── app
│   ├── controllers     # Logika bisnis (Auth, Dashboard)
│   ├── models          # Interaksi database (User.php)
│   └── views           # File tampilan/UI (login, register, dashboard)
├── config
│   └── database.php    # Konfigurasi koneksi database
├── core
│   ├── Controller.php  # Controller dasar
│   └── Router.php      # Penanganan URL/Routing
├── public
│   ├── uploads
│   │   ├── fotoprofil  # Tempat menyimpan foto profil
│   │   └── tandatangan # Tempat menyimpan gambar tanda tangan
│   ├── .htaccess       # Pengaturan URL rewriting (untuk Apache)
│   └── index.php       # Entry point/Front controller
└── .htaccess           # Pengaturan root (jika diperlukan)
```
