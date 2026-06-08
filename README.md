# Web To Do List

Aplikasi pencatatan tugas (To-Do List) sederhana berbasis Native PHP dan MySQL. Aplikasi ini dirancang untuk mempermudah manajemen tugas harian lengkap dengan fitur pelacakan tenggat waktu (deadline), riwayat evaluasi tugas terlewat, serta fitur interaktif pengubah tema.

## Features

- **Manajemen Tugas (CRUD)**: Menambah, melihat, mengedit, dan menghapus daftar tugas.
- **Pelacakan Tenggat Waktu (Deadline)**: Sistem otomatis memisahkan tampilan tugas aktif dan tugas yang telah melewati tenggat waktu.
- **Sistem Refleksi Tugas**: Menginput teks refleksi/komentar khusus untuk tugas-tugas yang statusnya terlewat (missed).
- **Panel Riwayat**: Menampilkan daftar tugas yang telah selesai (`Selesai`) dan daftar tugas yang terlewat (`Terlewat`) secara terpisah.
- **Easter Egg Night Mode**: Fitur interaktif untuk mengubah tema tampilan (Siang/Malam) hanya dengan mengklik komponen logo pada header aplikasi, didukung penyimpanan status lewat `localStorage`.
- **Responsive UI**: Desain antarmuka responsif yang memanfaatkan Bootstrap 5 dan pustaka ikon Ionicons.

## Tech Stack

- **Backend**: Native PHP
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5, Ionicons
- **Database**: MySQL

## Installation

1. Clone repositori ini:
   ```bash
   git clone [https://github.com/mbaasith12/web_to_do_list.git](https://github.com/mbaasith12/web_to_do_list.git)

```

2. Pindahkan folder proyek ke dalam direktori server lokal Anda (misalnya `htdocs` untuk XAMPP atau `www` untuk WampServer).
3. Masuk ke folder proyek:
```bash
cd web_to_do_list

```



## Database Setup

1. Aktifkan MySQL server melalui kontrol panel lokal Anda (seperti XAMPP).
2. Buka `phpMyAdmin` atau klien database pilihan Anda, lalu buat database baru dengan nama:
```
db_app_to_do_list

```


3. Buat tabel bernama `list` dengan struktur kolom minimal yang mencakup:
* `id` (INT, Primary Key, Auto Increment)
* `judul` (VARCHAR/TEXT)
* `deadline` (DATE, Nullable)
* `status_selesai` (INT/TINYINT, Default 0)
* `komentar` (TEXT, Nullable)


4. Konfigurasi koneksi database dapat Anda sesuaikan langsung pada file `koneksi.php`:
```php
$host = "localhost";
$user = "root";
$password = "";
$database = "db_app_to_do_list";

```



## Running the Application

1. Pastikan Apache dan MySQL pada server lokal Anda (XAMPP) sudah berjalan.
2. Buka browser dan akses URL berikut:
```
http://localhost/web_to_do_list/

```



## Project Structure

```text
web_to_do_list/
│
├── css/
│   └── bootstrap.min.css         # Sumber gaya Bootstrap 5
├── js/
│   └── bootstrap.bundle.min.js   # Sumber interaksi Bootstrap 5
│
├── index.php                     # Halaman utama / dashboard aplikasi
├── koneksi.php                   # Konfigurasi koneksi ke basis data MySQL
├── tambah.php                    # Form / Logika penambahan data tugas
├── simpan_data.php               # Memproses penyimpanan data tugas baru
├── frm_edit.php                  # Form modal untuk menyunting tugas
├── edit_data.php                 # Memproses pembaruan data tugas yang disunting
├── set_selesai.php               # Mengubah status tugas menjadi selesai
├── simpan_komentar.php           # Menyimpan refleksi untuk tugas yang terlewat
├── hapus.php                     # Menghapus satu tugas tertentu
├── hapus_semua_selesai.php       # Menghapus semua riwayat tugas selesai
├── hapus_semua_terlewat.php      # Menghapus semua riwayat tugas terlewat
│
├── Aurora.otf                    # Dokumen font lokal aset antarmuka
├── handwriting-black-draft_DEMO.otf # Dokumen font judul aplikasi
├── logo.png                      # Aset gambar komponen logo utama
├── siang.png                     # Aset gambar latar belakang tema siang
└── malam.png                     # Aset gambar latar belakang tema malam

```

## Author

**Baasith**

* GitHub: (https://github.com/mbaasith12)

## License

Proyek ini bersifat open-source dan tersedia untuk tujuan pembelajaran edukasional.

```

```
