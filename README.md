# CRUD PHP Native

CRUD (Create, Read, Update, Delete) sederhana menggunakan PHP Native, dengan fitur tambahan seperti searching, pagination, dan cetak dokumen menggunakan mPDF.

## Fitur
- **CRUD**: Operasi dasar untuk membuat, membaca, memperbarui, dan menghapus data.
- **Searching**: Pencarian data berdasarkan kata kunci tertentu.
- **Pagination**: Pembagian halaman untuk memudahkan navigasi pada data yang banyak.
- **mPDF Integration**: Cetak data ke dalam format PDF.

## Instalasi

### Persyaratan Sistem
- PHP 7.0 atau lebih baru
- MySQL/MariaDB
- Composer untuk mengelola dependensi (mPDF)

### Langkah-langkah Instalasi
1. Clone repositori ini atau download file zip.
2. Pastikan Anda memiliki `composer` terinstal di sistem Anda.
3. Jalankan perintah berikut untuk menginstal dependensi:
   ```bash
   composer install
   ```
4. Buat database baru di MySQL dan import file SQL yang ada di folder `db`.
5. Konfigurasi koneksi database di file `functions.php`:
   ```php
   $conn = mysqli_connect("localhost", "username", "password", "nama_database");
   ```

## Penggunaan

1. **CRUD**:
   - Tambah data: Melalui form `tambah.php`.
   - Edit data: Melalui `ubah.php`.
   - Hapus data: Melalui `hapus.php`.
   
2. **Searching**: Gunakan fitur pencarian pada halaman utama (`index.php`) untuk mencari data tertentu.
   
3. **Pagination**: Navigasi data dipecah menjadi beberapa halaman menggunakan pagination yang terintegrasi di halaman utama.

4. **Cetak PDF**: Klik tombol cetak di halaman utama untuk mengunduh data dalam format PDF menggunakan mPDF (`cetak.php`).

## Struktur Direktori
- `db/`: Folder untuk menyimpan file database.
- `img/`: Folder untuk menyimpan file gambar.
- `vendor/`: Folder yang dihasilkan oleh composer untuk menyimpan dependensi pihak ketiga.
- `cetak.php`: File untuk mencetak data dalam bentuk PDF.
- `functions.php`: File yang berisi fungsi-fungsi utama termasuk koneksi database.
- `index.php`: Halaman utama yang menampilkan data dengan pagination.
- `tambah.php`, `ubah.php`, `hapus.php`: Halaman untuk menambah, mengedit, dan menghapus data.
- `registrasi.php`, `login.php`, `logout.php`: Halaman untuk registrasi, login, dan logout pengguna.

## Lisensi
Proyek ini dilisensikan di bawah MIT License. Lihat [LICENSE](LICENSE) untuk detail lebih lanjut.

## Kontribusi
Jika Anda ingin berkontribusi pada proyek ini, silakan lakukan pull request atau ajukan issue di halaman GitHub.

## Kontak
Jika ada pertanyaan, silakan hubungi aliprizky12345@gmail.com.
