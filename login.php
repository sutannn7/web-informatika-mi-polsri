<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

// Fungsi IP (tetap sama)
function getClientIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Bisa berisi beberapa IP dipisah koma, ambil yang pertama
        return trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
    }
    return $_SERVER['REMOTE_ADDR'];
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // KOREKSI: query sebelumnya langsung interpolasi $username ke string SQL — rentan SQL injection
    // Contoh: username = "admin' OR '1'='1" bisa bypass login
    // Diganti dengan prepared statement
    $stmt = mysqli_prepare($conn, "SELECT * FROM admin WHERE username = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if (password_verify($password, $admin['password'])) {
            // Login sukses — regenerate session ID untuk mencegah session fixation
            session_regenerate_id(true);

            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id']        = $admin['id'];
            $_SESSION['admin_nama']      = $admin['nama'];

            // Catat login history (sudah pakai prepared statement — ✓)
            $admin_id   = $admin['id'];
            $ip         = getClientIP();
            $user_agent = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);
            $status     = 'success';
            $log = mysqli_prepare($conn, "INSERT INTO admin_login_log (admin_id, login_ip, user_agent, status) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($log, 'isss', $admin_id, $ip, $user_agent, $status);
            mysqli_stmt_execute($log);
            mysqli_stmt_close($log);

            header('Location: index.php');
            exit;
        } else {
            $error = 'Password salah!';
            // Log gagal
            $ip         = getClientIP();
            $user_agent = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);
            $log = mysqli_prepare($conn, "INSERT INTO admin_login_log (admin_id, login_ip, user_agent, status) VALUES (0, ?, ?, 'failed')");
            mysqli_stmt_bind_param($log, 'ss', $ip, $user_agent);
            mysqli_stmt_execute($log);
            mysqli_stmt_close($log);
        }
    } else {
        $error = 'Username tidak ditemukan!';
        // Log gagal
        $ip         = getClientIP();
        $user_agent = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);
        $log = mysqli_prepare($conn, "INSERT INTO admin_login_log (admin_id, login_ip, user_agent, status) VALUES (0, ?, ?, 'failed')");
        mysqli_stmt_bind_param($log, 'ss', $ip, $user_agent);
        mysqli_stmt_execute($log);
        mysqli_stmt_close($log);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - MI POLSRI</title>
    <style>
        body {
            background: #1A1A24;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }
        .login-box {
            background: #22222E;
            padding: 2rem;
            border-radius: 16px;
            width: 350px;
            border: 1px solid rgba(224,142,158,0.2);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .login-box h2 {
            text-align: center;
            color: #E0E0E0;
            margin-bottom: 1.5rem;
        }
        input {
            width: 100%;
            padding: 10px 14px;
            margin: 8px 0;
            border-radius: 8px;
            border: 1px solid #2E2E3A;
            background: #1A1A24;
            color: white;
            font-size: 0.9rem;
            box-sizing: border-box;
        }
        input:focus { outline: none; border-color: #E08E9E; }
        button {
            width: 100%;
            padding: 10px;
            background: #E08E9E;
            color: #1A1A24;
            border: none;
            border-radius: 40px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 8px;
            transition: 0.2s;
        }
        button:hover { background: #F0A6B6; }
        .error {
            color: #EF4444;
            text-align: center;
            margin-bottom: 12px;
            font-size: 0.85rem;
        }
        .info {
            text-align: center;
            margin-top: 15px;
            color: #707080;
            font-size: 0.8rem;
        }
        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 12px;
            color: #E08E9E;
            font-size: 0.78rem;
            text-decoration: none;
        }
        .forgot-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Login Admin MI POLSRI</h2>

    <?php if ($error): ?>
        <!-- KOREKSI: htmlspecialchars pada $error untuk mencegah XSS -->
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
        <input type="text"     name="username" placeholder="Username" required autocomplete="username">
        <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
        <button type="submit">Login</button>
    </form>

    <!-- KOREKSI: hapus baris "Default: admin / admin123" di produksi — bocorkan kredensial default -->
    <!-- <div class="info">Default: admin / admin123</div> -->

    <a href="lupa_password.php" class="forgot-link">Lupa Password?</a>
</div>
</body>
</html>