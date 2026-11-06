# Web Programming 1 - Modul 10
## Multimedia CRUD & File Handling: PHP Upload, Validation, JavaScript DOM and Media Preview

Repositori ini merupakan implementasi tugas praktik mata kuliah **Web Programming 1** yang mencakup sistem autentikasi berbasis session, pengelolaan data mahasiswa (CRUD Teks - Modul 08), serta pengelolaan data multimedia mahasiswa (CRUD Media - Modul 10).

---

### Struktur Direktori Proyek

```text
web_programming_1/
|
+-- assets/
|   +-- css/
|   |   +-- style.css                 # Stylesheet utama aplikasi (Box Model, Form, Tabel, CRUD, Media)
|   +-- images/
|   |   +-- foto.jpg                  # Foto profil utama
|   |   +-- profile.jpg               # Foto profil cadangan
|   +-- js/
|       +-- crud.js                   # Validasi client-side, pencarian tabel, dan konfirmasi hapus (Modul 08)
|       +-- media.js                  # Preview DOM media, validasi ukuran/tipe file, dan pencarian (Modul 10)
|
+-- config/
|   +-- auth.php                      # Session guard untuk proteksi halaman internal
|   +-- koneksi.php                   # Koneksi database MySQLi dan inisialisasi skema tabel otomatis
|   +-- media_helper.php              # Fungsi helper uploadMedia() dan hapusMediaJikaAda()
|
+-- database/
|   +-- database.sql                  # Skema database users dan mahasiswa beserta data awal
|
+-- pages/
|   +-- dashboard.php                 # Halaman ringkasan utama setelah login
|   +-- data_mahasiswa.php            # Halaman tampil data mahasiswa (Modul 3B/4B)
|   +-- form_mahasiswa.php            # Halaman formulir tambah mahasiswa (Modul 4B)
|   +-- index.php                     # Halaman biodata publik
|   +-- layout.php                    # Halaman demonstrasi CSS Box Model (Modul 4A)
|   +-- login.php                     # Halaman autentikasi pengguna (Modul 5B)
|
+-- crud/                             # Modul 08: CRUD Data Mahasiswa (Berbasis Teks)
|   +-- index.php                     # Daftar data mahasiswa dengan fitur pencarian dan aksi CRUD
|   +-- tambah.php                    # Formulir tambah data mahasiswa
|   +-- edit.php                      # Formulir pembaruan data mahasiswa
|
+-- crud-media/                       # Modul 10: CRUD Data Mahasiswa dengan File Multimedia
|   +-- index.php                     # Daftar mahasiswa dengan pratinjau foto, pemutar audio, dan tautan PDF
|   +-- tambah.php                    # Formulir input data dan unggah file dengan pratinjau DOM
|   +-- edit.php                      # Formulir pembaruan data dan penggantian file media opsional
|
+-- proses/
|   +-- crud-media/                   # Pemroses Backend CRUD Media (Modul 10)
|   |   +-- tambah.php                # Validasi server, unggah file, simpan database, dan rollback file
|   |   +-- update.php                # Unggah file baru opsional, perbarui database, dan hapus file lama
|   |   +-- hapus.php                 # Hapus record database dan bersihkan seluruh file fisik terkait
|   +-- buat_user.php                 # Utilitas inisialisasi tabel dan akun administrator awal
|   +-- logout.php                    # Pemroses pengakhiran sesi pengguna
|   +-- proses_login.php              # Pemroses autentikasi login pengguna
|   +-- proses_tambah.php             # Pemroses tambah data mahasiswa (Modul 4B)
|   +-- proses_crud_tambah.php        # Pemroses tambah data mahasiswa (Modul 08)
|   +-- proses_update.php             # Pemroses pembaruan data mahasiswa (Modul 08)
|   +-- proses_hapus.php              # Pemroses penghapusan data mahasiswa beserta pembersihan media
|
+-- uploads/                          # Direktori penyimpanan fisik file media
|   +-- images/                       # Penyimpanan file foto (JPG, PNG, WEBP)
|   +-- audio/                        # Penyimpanan file audio (MP3, WAV)
|   +-- documents/                    # Penyimpanan file dokumen (PDF)
|
+-- .gitignore
+-- .htaccess
+-- index.php
+-- README.md
```

---

### Spesifikasi Skema Database

Tabel `mahasiswa` mendukung penyimpanan atribut akademik beserta referensi nama file multimedia:

```sql
CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    program_studi VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    foto VARCHAR(255) NULL,
    audio VARCHAR(255) NULL,
    dokumen VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

Apabila tabel `mahasiswa` sudah dibuat pada sesi sebelumnya, pembaruan struktur tabel dapat dilakukan dengan perintah berikut:

```sql
ALTER TABLE mahasiswa
ADD foto VARCHAR(255) NULL,
ADD audio VARCHAR(255) NULL,
ADD dokumen VARCHAR(255) NULL;
```

---

### Spesifikasi Alur CRUD Media (Modul 10)

| Operasi | Antarmuka Pengguna | Pemroses Backend | Deskripsi Fungsional |
| :--- | :--- | :--- | :--- |
| **Read** | `crud-media/index.php` | Integrasi langsung | Menampilkan daftar mahasiswa beserta pratinjau foto, pemutar audio HTML5, tautan dokumen PDF, dan filter pencarian langsung. |
| **Create** | `crud-media/tambah.php` | `proses/crud-media/tambah.php` | Pratinjau file di sisi klien menggunakan `URL.createObjectURL()`, validasi tipe MIME menggunakan `finfo`, batas ukuran maksimal 2 MB, penamaan unik dengan `random_bytes()`, serta penghapusan otomatis jika penyimpanan database gagal. |
| **Update** | `crud-media/edit.php` | `proses/crud-media/update.php` | Penggantian file bersifat opsional. Apabila file baru diunggah, file lama akan dihapus secara otomatis setelah pembaruan database berhasil. |
| **Delete** | `crud-media/index.php` | `proses/crud-media/hapus.php` | Konfirmasi penghapusan di sisi klien, penghapusan baris data dari tabel MySQL, serta penghapusan seluruh file fisik terkait pada direktori `uploads/`. |

---

### Petunjuk Penggunaan

1. Pastikan layanan **Apache** dan **MySQL** pada Laragon telah aktif.
2. Impor file `database/database.sql` ke MySQL atau akses halaman `http://localhost/web_programming_1/proses/buat_user.php` untuk menginisialisasi tabel dan akun administrator secara otomatis.
3. Masuk melalui halaman login menggunakan kredensial bawaan:
   - **Username:** `admin`
   - **Password:** `123`
