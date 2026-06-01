<?php
require_once __DIR__ . '/../includes/db.php';

$new_password = 'admin123';
$hash = password_hash($new_password, PASSWORD_DEFAULT);

$query = "UPDATE admin SET password = '$hash' WHERE username = 'admin'";

if (mysqli_query($conn, $query)) {
    echo "✅ Password berhasil direset menjadi: <strong>$new_password</strong><br>";
    echo "<a href='login.php'>Klik di sini untuk login</a>";
} else {
    echo "❌ Gagal: " . mysqli_error($conn);
}
?>