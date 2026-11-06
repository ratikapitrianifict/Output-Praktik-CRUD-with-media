<?php
/**
 * Helper Upload & Cleanup Media (config/media_helper.php)
 * Modul 10 - Web Programming 1
 * Fitur: Validasi MIME (finfo), ukuran file, penamaan unik (random_bytes), & hapus file fisik.
 */

/**
 * Mengunggah file media dengan validasi server-side ketat.
 *
 * @param array  $file         Data dari $_FILES['field']
 * @param array  $allowedMimes Daftar MIME yang diizinkan ['mime/type' => 'ext']
 * @param int    $maxSize      Ukuran maksimal dalam byte
 * @param string $targetDir    Folder tujuan penyimpanan fisik
 * @param string $prefix       Awalan nama file unik (misal: img, aud, doc)
 * @return string|null         Nama file baru yang tersimpan, atau null jika tidak ada file diunggah
 * @throws RuntimeException    Jika validasi gagal atau file gagal dipindahkan
 */
function uploadMedia(
    array $file,
    array $allowedMimes,
    int $maxSize,
    string $targetDir,
    string $prefix = "media"
): ?string {
    // Jika input file kosong atau tidak ada file yang dipilih
    if (empty($file) || !isset($file["error"]) || $file["error"] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    // Cek kode error upload bawaan PHP
    if ($file["error"] !== UPLOAD_ERR_OK) {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE   => "Ukuran file melebihi batas upload_max_filesize di konfigurasi PHP.",
            UPLOAD_ERR_FORM_SIZE  => "Ukuran file melebihi batas MAX_FILE_SIZE pada form.",
            UPLOAD_ERR_PARTIAL    => "File hanya terunggah sebagian.",
            UPLOAD_ERR_NO_TMP_DIR => "Folder temporary server tidak ditemukan.",
            UPLOAD_ERR_CANT_WRITE => "Gagal menulis file ke disk server.",
            UPLOAD_ERR_EXTENSION  => "Upload file dihentikan oleh ekstensi PHP."
        ];
        $msg = $errorMessages[$file["error"]] ?? "Terjadi kesalahan saat mengunggah file (Kode: " . (int) $file["error"] . ").";
        throw new RuntimeException($msg);
    }

    // Validasi keberadaan file temporary hasil upload HTTP POST
    if (empty($file["tmp_name"]) || !is_uploaded_file($file["tmp_name"])) {
        throw new RuntimeException("File upload tidak valid atau bukan hasil HTTP POST.");
    }

    // Validasi ukuran file (maksimal sesuai $maxSize, misal 2 MB)
    $fileSize = (int) ($file["size"] ?? 0);
    if ($fileSize <= 0) {
        throw new RuntimeException("File yang diunggah kosong (0 byte).");
    }
    if ($fileSize > $maxSize) {
        $maxMb = round($maxSize / (1024 * 1024), 1);
        throw new RuntimeException("Ukuran file melebihi batas maksimal {$maxMb} MB.");
    }

    // Validasi MIME Type asli menggunakan finfo (bukan hanya dari ekstensi / $_FILES['type'])
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file["tmp_name"]);

    if ($mimeType === false || !isset($allowedMimes[$mimeType])) {
        $allowedList = strtoupper(implode(", ", array_unique(array_values($allowedMimes))));
        throw new RuntimeException(
            "Format file tidak diizinkan (deteksi MIME: " . htmlspecialchars((string) $mimeType) . "). Format yang didukung: {$allowedList}."
        );
    }

    // Pastikan direktori tujuan tersedia
    if (!is_dir($targetDir)) {
        if (!mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
            throw new RuntimeException("Gagal membuat direktori penyimpanan upload.");
        }
    }

    // Buat nama file unik menggunakan random_bytes agar aman dari bentrok & path traversal
    $extension = $allowedMimes[$mimeType];
    try {
        $randomHex = bin2hex(random_bytes(8));
    } catch (Exception $e) {
        $randomHex = uniqid("", true);
    }

    $safePrefix = preg_replace('/[^a-zA-Z0-9_-]/', '', $prefix) ?: "media";
    $newFileName = sprintf("%s_%s_%s.%s", $safePrefix, date("Ymd_His"), $randomHex, $extension);
    $destination = rtrim($targetDir, "/\\") . DIRECTORY_SEPARATOR . $newFileName;

    if (!move_uploaded_file($file["tmp_name"], $destination)) {
        throw new RuntimeException("Gagal memindahkan file ke folder tujuan upload.");
    }

    return $newFileName;
}

/**
 * Menghapus file media fisik dari folder upload jika file tersebut ada.
 *
 * @param string|null $fileName  Nama file yang tersimpan di database
 * @param string      $targetDir Direktori tempat file disimpan
 * @return void
 */
function hapusMediaJikaAda(?string $fileName, string $targetDir): void
{
    if ($fileName === null || trim($fileName) === "") {
        return;
    }

    // Gunakan basename() untuk mencegah celah keamanan directory traversal
    $safeName = basename($fileName);
    if ($safeName === "" || $safeName === "." || $safeName === "..") {
        return;
    }

    $filePath = rtrim($targetDir, "/\\") . DIRECTORY_SEPARATOR . $safeName;

    if (is_file($filePath)) {
        @unlink($filePath);
    }
}
?>

