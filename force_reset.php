<?php
/**
 * FORCE RESET PASSWORD ADMIN
 *
 * ⚠️  PERINGATAN KEAMANAN KRITIS ⚠️
 * File ini TIDAK BOLEH ada di server produksi.
 * Siapapun yang tahu URL file ini bisa mereset password admin tanpa autentikasi.
 * HAPUS file ini setelah digunakan.
 *
 * KOREKSI: tambahkan minimal secret token agar tidak bisa diakses sembarangan.
 * Ganti nilai SECRET_TOKEN di bawah sebelum digunakan, dan hapus file setelah selesai.
 */

define('SECRET_TOKEN', 'ganti_token_rahasia_ini_sebelum_dipakai');

// Validasi token via query string: ?token=ganti_token_rahasia_ini_sebelum_dipakai
if (($_GET['token'] ?? '') !== SECRET_TOKEN) {
    http_response_code(403);
    die('403 Forbidden');
}

require_once __DIR__ . '/../includes/db.php';

$new_password = 'admin123';
$hash = password_hash($new_password, PASSWORD_DEFAULT);

// Gunakan prepared statement
$stmt = mysqli_prepare($conn, "UPDATE admin SET password = ? WHERE username = 'admin'");
mysqli_stmt_bind_param($stmt, 's', $hash);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($ok) {
    echo "<div style='font-family:sans-serif;text-align:center;padding:50px;background:#1A1A24;color:#E0E0E0;min-height:100vh;'>";
    echo "<div style='background:#22222E;padding:30px;border-radius:16px;max-width:420px;margin:50px auto;border:1px solid #E08E9E;'>";
    echo "<h2 style='color:#E08E9E;'>✅ Reset Password Berhasil!</h2>";
    echo "<p>Password direset ke: <strong style='color:#FFD966;'>" . htmlspecialchars($new_password) . "</strong></p>";
    echo "<p>Username: <strong>admin</strong></p>";
    echo "<hr style='margin:20px 0;border-color:#2E2E3A;'>";
    echo "<a href='login.php' style='background:#E08E9E;color:#1A1A24;padding:10px 20px;border-radius:40px;text-decoration:none;font-weight:bold;'>🔐 Login</a>";
    echo "</div>";
    echo "<p style='margin-top:20px;font-size:12px;color:#EF4444;font-weight:bold;'>⚠️ SEGERA HAPUS file force_reset.php dari server!</p>";
    echo "</div>";
} else {
    echo "<p style='color:#EF4444;font-family:sans-serif;text-align:center;padding:50px;'>Gagal: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
}