<?php
// admin/lupa_password.php
require_once __DIR__ . '/../includes/db.php';

$message = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');

    if (empty($username)) {
        $error = 'Username harus diisi!';
    } else {
        // KOREKSI: query sebelumnya rentan SQL injection (WHERE username = '$username')
        // Diganti prepared statement
        $stmt = mysqli_prepare($conn, "SELECT id FROM admin WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $check = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        if (mysqli_num_rows($check) > 0) {
            $new_password = 'admin123';
            $hash = password_hash($new_password, PASSWORD_DEFAULT);

            // KOREKSI: update juga pakai prepared statement
            $upd = mysqli_prepare($conn, "UPDATE admin SET password = ? WHERE username = ?");
            mysqli_stmt_bind_param($upd, 'ss', $hash, $username);
            mysqli_stmt_execute($upd);
            mysqli_stmt_close($upd);

            // KOREKSI: jangan tampilkan password baru di halaman produksi.
            // Sebaiknya kirim via email. Untuk keperluan development/praktikum ini masih bisa diterima.
            $message = 'Password telah direset menjadi: <strong>' . htmlspecialchars($new_password) . '</strong>. '
                     . 'Silakan <a href="login.php">login kembali</a> dan segera ganti password.';
        } else {
            $error = 'Username <strong>' . htmlspecialchars($username) . '</strong> tidak ditemukan!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Admin MI POLSRI</title>
    <style>
        body {
            background: linear-gradient(135deg, #1A1A24, #0F0F1A);
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .reset-box {
            background: #1A1A2E;
            padding: 2rem;
            border-radius: 20px;
            width: 400px;
            text-align: center;
            border: 1px solid rgba(224,142,158,0.3);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .reset-box h2 { color: #E08E9E; margin-bottom: 1rem; }
        .reset-box p  { color: #A0A0B0; margin-bottom: 1.5rem; font-size: 0.9rem; }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            background: #0F0F1A;
            border: 1px solid #2E2E3A;
            border-radius: 8px;
            color: #E0E0E0;
            font-size: 1rem;
            box-sizing: border-box;
        }
        input:focus { outline: none; border-color: #E08E9E; }
        button {
            width: 100%;
            padding: 12px;
            background: #E08E9E;
            color: #1A1A24;
            border: none;
            border-radius: 40px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.2s;
        }
        button:hover { background: #F0A6B6; }
        .message {
            background: rgba(16,185,129,0.2);
            border: 1px solid #10B981;
            color: #10B981;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 0.85rem;
        }
        .error-box {
            background: rgba(239,68,68,0.2);
            border: 1px solid #EF4444;
            color: #EF4444;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 0.85rem;
        }
        .back-link { display: block; margin-top: 15px; color: #707080; text-decoration: none; font-size: 0.8rem; }
        .back-link:hover { color: #E08E9E; }
        hr { margin: 20px 0; border-color: #2E2E3A; }
        .message a { color: #E08E9E; }
    </style>
</head>
<body>
<div class="reset-box">
    <h2>🔐 Lupa Password?</h2>
    <p>Masukkan username admin Anda, password akan direset ke default.</p>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="error-box">⚠️ <?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username admin" required autocomplete="username">
        <button type="submit">Reset Password</button>
    </form>

    <hr>
    <a href="login.php" class="back-link">← Kembali ke Halaman Login</a>
</div>
</body>
</html>