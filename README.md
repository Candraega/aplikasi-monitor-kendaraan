# Aplikasi Pemesanan Kendaraan

Aplikasi web untuk manajemen pemesanan kendaraan operasional dengan alur persetujuan berjenjang. Dibangun dengan Laravel 12, MySQL, dan Tailwind CSS.

---

## ⚙️ **Informasi Teknis**

* **PHP Version**: **8.2+**
* **Database**: **MySQL 8.x**
* **Framework**: **Laravel 12**
* **UI**: **Tailwind CSS (via CDN)**
* **Library Utama**: `maatwebsite/excel` untuk ekspor laporan.

---

## 👤 **Akun Pengguna (Default)**

Gunakan akun berikut untuk login dan melakukan pengujian fungsionalitas aplikasi.

| Nama Pengguna | Email | Password | Peran |
| :--- | :--- | :--- | :--- |
| Admin | `admin@kantor.com` | `@1niadmin` | Admin |
| Manajer | `manajer@kantor.com` | `@1nimanajer` | Approver |
| Kepala Divisi | `kadiv@kantor.com`| `@Inikadiv` | Approver |

---

## 🚀 **Panduan Instalasi**

1.  **Clone Repositori**
    ```bash
    git clone [URL_REPOSITORI_ANDA]
    cd [NAMA_FOLDER_PROYEK]
    ```

2.  **Install Dependensi**
    ```bash
    composer install
    ```

3.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env` dan sesuaikan koneksi database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Migrasi & Seeding Database**
    Perintah ini akan membuat semua tabel dan mengisi data awal (termasuk akun pengguna di atas).
    ```bash
    php artisan migrate --seed
    ```

5.  **Jalankan Aplikasi**
    ```bash
    php artisan serve
    ```
    Aplikasi akan berjalan di `http://127.0.0.1:8000`.
    Atau kamu bisa nggece langsung `https://monitor.adaquran.com`.

---

## 📝 **Panduan Penggunaan**

### **Sebagai Admin (`admin@kantor.com`)**

1.  **Login** sebagai Admin.
2.  **Membuat Pemesanan**: Klik tombol **"Buat Pemesanan"** di dashboard.
3.  **Isi Form**: Lengkapi detail kendaraan, driver, dan tujuan.
4.  **Tentukan Approver**:
    * **Level 1**: Pilih "Manajer".
    * **Level 2**: Pilih "Kepala Divisi".
5.  **Simpan**. Anda dapat memantau statusnya di dashboard.
6.  **Export Laporan**: Klik menu **"Lihat Laporan"**, pilih rentang tanggal, lalu klik tombol download.

### **Sebagai Pihak yang Menyetujui (`manajer@kantor.com`)**

1.  **Login** sebagai Manajer.
2.  **Lihat Permintaan**: Di dashboard, Anda akan melihat daftar pemesanan yang menunggu persetujuan Anda.
3.  **Beri Persetujuan**: Klik tombol **"Setuju"** atau **"Tolak"**.
4.  Setelah Anda setuju, notifikasi akan secara logis diteruskan ke approver level berikutnya.