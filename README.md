# Web Programming 1 - Modul 08
## Form Handling, Validation & CRUD: Integrating PHP, MySQL and JavaScript

Repositori ini telah dirapikan dan distrukturkan sesuai panduan **Modul 08: Form Handling, Validation & CRUD: Integrating PHP, MySQL and JavaScript** pada mata kuliah Web Programming 1.

---

### 📁 Struktur Folder Project

```text
web_programming_1/
|
+-- assets/
|   +-- css/
|   |   +-- style.css           <-- Styling utama + komponen CRUD
|   +-- images/
|   |   +-- foto.jpg            <-- Foto profil
|   |   +-- profile.jpg         <-- Foto profil alternatif
|   +-- js/
|       +-- crud.js             <-- BARU: Validasi client-side, search/filter, confirm delete, alert
|
+-- config/
|   +-- auth.php                <-- Session guard & proteksi halaman
|   +-- koneksi.php             <-- Koneksi database MySQLi
|
+-- database/
|   +-- database.sql            <-- Backup skema dan data latihan awal
|
+-- pages/
|   +-- dashboard.php           <-- Dashboard utama setelah login
|   +-- data_mahasiswa.php      <-- Tabel data mahasiswa modul lama
|   +-- form_mahasiswa.php      <-- TETAP: Form tambah mahasiswa lama (tidak diubah)
|   +-- index.php               <-- Biodata publik
|   +-- layout.php              <-- Eksperimen Box Model (Layout Lab)
|   +-- login.php               <-- Halaman login
|
+-- crud/                       <-- BARU: Fitur CRUD Lanjutan
|   +-- index.php               <-- READ: Tabel mahasiswa CRUD, toolbar search & tombol action
|   +-- tambah.php              <-- CREATE: Form input dengan validasi bertingkat
|   +-- edit.php                <-- UPDATE: Form edit record berdasarkan GET id
|
+-- proses/
|   +-- buat_user.php           <-- Inisialisasi user admin awal
|   +-- logout.php              <-- Pemroses logout & penghancur session
|   +-- proses_login.php        <-- Pemroses autentikasi login
|   +-- proses_tambah.php       <-- Pemroses tambah form lama (tetap)
|   +-- proses_crud_tambah.php  <-- BARU: Server-side validation & prepared INSERT
|   +-- proses_update.php       <-- BARU: Server-side validation & prepared UPDATE (WHERE id = ?)
|   +-- proses_hapus.php        <-- BARU: Server-side validation & prepared DELETE (WHERE id = ?)
|
+-- .htaccess                   <-- Pengaturan Apache (Options -Indexes)
+-- index.php                   <-- Root router (redirect ke dashboard / login)
+-- README.md                   <-- Dokumentasi proyek
```

---

### 🚀 Alur Operasi CRUD (Create, Read, Update, Delete)

| Operasi | SQL | File UI / Form | File Proses Backend | HTTP Method |
| :--- | :--- | :--- | :--- | :--- |
| **Create** | `INSERT INTO mahasiswa ...` | `crud/tambah.php` | `proses/proses_crud_tambah.php` | `POST` |
| **Read** | `SELECT ... FROM mahasiswa ORDER BY id DESC` | `crud/index.php` | *(langsung di halaman)* | `GET` |
| **Update** | `UPDATE mahasiswa SET ... WHERE id = ?` | `crud/edit.php?id=X` | `proses/proses_update.php` | `GET` lalu `POST` |
| **Delete** | `DELETE FROM mahasiswa WHERE id = ?` | `crud/index.php` (tombol hapus) | `proses/proses_hapus.php` | `POST` |

---

### 🛡️ Lapisan Validasi & Keamanan (Defense-in-Depth)

1. **Client-Side (HTML & JavaScript)**:
   - Metadata input: `required`, `type="email"`.
   - `assets/js/crud.js` memeriksa nilai input kosong, format email (`checkValidity()`), menandai field dengan `.is-invalid`, menampilkan pesan `.form-error`, membatalkan submit dengan `event.preventDefault()`, serta memunculkan `alert()`.
2. **Server-Side (PHP)**:
   - Tidak pernah percaya data dari client semata.
   - Pengecekan `$_SERVER["REQUEST_METHOD"] === "POST"`.
   - Validasi data kosong dengan `trim()`.
   - Validasi email dengan `filter_var(..., FILTER_VALIDATE_EMAIL)`.
3. **Database Layer (MySQL & Prepared Statements)**:
   - Menghindari SQL Injection dengan selalu memisahkan struktur query dan data menggunakan `$stmt = $conn->prepare(...)` dan `bind_param(...)`.
   - Primary Key `id` stabil untuk operasi `UPDATE` dan `DELETE` berbasis `WHERE id = ?`.
4. **Session Guard (`config/auth.php`)**:
   - Memastikan pengguna yang belum login dialihkan ke `pages/login.php?pesan=belum_login`.

---

### 📋 Checklist Pengujian Sesuai Modul (Checkpoint 11)

1. **Akses tanpa login**: Buka `crud/index.php` -> Otomatis diarahkan ke `pages/login.php`.
2. **Login**: Masuk dengan akun `admin` / `123`.
3. **Buka Menu CRUD Mahasiswa**: Tabel data tampil urut dari yang terbaru.
4. **Search Real-Time**: Ketik nama/NIM di kolom pencarian -> Row terfilter seketika tanpa reload.
5. **Validasi Tambah Kosong**: Buka `crud/tambah.php`, klik Simpan tanpa mengisi -> Muncul pesan error & alert popup dari JavaScript.
6. **Tambah Data Sukses**: Isi form dengan benar -> Data tersimpan via Prepared INSERT, redirect ke `crud/index.php?status=tambah`, dan muncul alert sukses.
7. **Edit Data**: Klik Edit pada baris record -> Data lama terisi pada form, ubah data dan simpan -> Hanya record tersebut yang berubah.
8. **Konfirmasi Hapus**: Klik tombol Hapus -> Muncul konfirmasi `confirm("Yakin ingin menghapus data ini?")`.
   - Jika Cancel: Data tidak terhapus.
   - Jika OK: Data terhapus via `proses/proses_hapus.php` dengan query DELETE berparameter `id`.
9. **Halaman Lama Tetap Utuh**: Menu *Data Mahasiswa* dan *Tambah Mahasiswa* versi lama tetap berfungsi normal.
