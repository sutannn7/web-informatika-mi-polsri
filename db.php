<?php
// includes/db.php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_mi_polsri');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    // KOREKSI: jangan tampilkan detail error ke user di produksi
    // Ganti dengan pesan umum; error asli bisa di-log ke file
    error_log('DB connect error: ' . mysqli_connect_error());
    die('Terjadi masalah koneksi. Silakan coba beberapa saat lagi.');
}

mysqli_set_charset($conn, 'utf8mb4');

/**
 * Ambil nilai dari tabel settings.
 * KOREKSI: query sebelumnya rentan SQL injection karena $key langsung dimasukkan
 * ke string query tanpa escape. Diganti dengan prepared statement.
 */
function getSetting($key, $default = '') {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT value FROM settings WHERE key_name = ? LIMIT 1");
    if (!$stmt) return $default;
    mysqli_stmt_bind_param($stmt, 's', $key);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row ? $row['value'] : $default;
}