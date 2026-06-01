<?php
session_start();
// KOREKSI: redirect sebelumnya ke '../login.php' — path salah karena login.php ada di dalam /admin/
// Seharusnya 'login.php' (relatif terhadap folder admin/)
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
$current_page = basename($_SERVER['PHP_SELF']);
require_once __DIR__ . '/../../includes/db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Admin' ?> - MI POLSRI</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0F0F1A;
            color: #E0E0E0;
            line-height: 1.5;
        }

        .admin-wrapper { display: flex; min-height: 100vh; }

        /* Sidebar */
        .admin-sidebar {
            width: 260px;
            background: #1A1A2E;
            border-right: 1px solid rgba(224,142,158,0.2);
            padding: 1.75rem 1rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 100;
        }
        .admin-sidebar h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            color: #E08E9E;
            text-align: center;
            margin-bottom: 1.75rem;
            letter-spacing: 1px;
        }
        .admin-sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.65rem 1rem;
            color: #B0B0C0;
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 0.25rem;
            transition: all 0.2s ease;
            font-size: 0.88rem;
        }
        .admin-sidebar a i { width: 20px; font-size: 1rem; opacity: 0.8; }
        .admin-sidebar a:hover,
        .admin-sidebar a.active {
            background: rgba(224,142,158,0.15);
            color: #E08E9E;
        }
        .admin-sidebar a[href="logout.php"]       { color: #f87171; }
        .admin-sidebar a[href="logout.php"]:hover  { background: rgba(248,113,113,0.15); color: #ef4444; }
        .sidebar-divider { margin: 1rem 0; border-color: rgba(224,142,158,0.2); }

        /* Main */
        .admin-main {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
            background: #0F0F1A;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(224,142,158,0.2);
        }
        .admin-header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            background: linear-gradient(135deg, #E08E9E, #F0A6B6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #1A1A2E;
            padding: 0.4rem 1rem;
            border-radius: 40px;
        }
        .user-info i   { color: #E08E9E; }
        .user-info span { font-size: 0.85rem; font-weight: 500; }

        /* Cards */
        .admin-card {
            background: #1A1A2E;
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(224,142,158,0.15);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }
        .admin-card h2,
        .admin-card h3 {
            margin-bottom: 1rem;
            font-weight: 600;
            color: #E8E8F0;
        }

        /* Table */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
        }
        .admin-table th {
            background: #22223B;
            color: #E08E9E;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.83rem;
        }
        .admin-table td {
            padding: 10px 15px;
            border-bottom: 1px solid rgba(224,142,158,0.08);
            color: #C0C0D0;
            font-size: 0.83rem;
            vertical-align: top;
        }
        .admin-table tr:last-child td { border-bottom: none; }
        .admin-table tr:hover td { background: rgba(224,142,158,0.05); }
        /* Kolom teks panjang tidak melar */
        .admin-table td:nth-child(4) { max-width: 240px; word-wrap: break-word; white-space: normal; }

        /* Buttons */
        .btn-sm {
            background: #E08E9E;
            color: #0F0F1A;
            padding: 0.35rem 0.9rem;
            border-radius: 40px;
            font-size: 0.78rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn-sm:hover { background: #F0A6B6; transform: translateY(-1px); }

        button {
            background: #E08E9E;
            color: #0F0F1A;
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }
        button:hover { background: #F0A6B6; transform: translateY(-1px); }

        /* Forms */
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.3rem; color: #C0C0D0; font-size: 0.83rem; }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.6rem 1rem;
            background: #0F0F1A;
            border: 1px solid rgba(224,142,158,0.25);
            border-radius: 10px;
            color: #E0E0E0;
            font-family: inherit;
            font-size: 0.88rem;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #E08E9E;
        }

        /* Alerts */
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            font-size: 0.85rem;
        }
        .alert-success { background: rgba(16,185,129,0.15);  border: 1px solid #10B981; color: #10B981; }
        .alert-error   { background: rgba(239,68,68,0.15);   border: 1px solid #EF4444; color: #EF4444; }

        /* Gallery grid */
        .gallery-grid-admin {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
        }
        .gallery-item-admin {
            background: #1A1A2E;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid rgba(224,142,158,0.15);
            transition: 0.2s;
        }
        .gallery-item-admin:hover { transform: translateY(-3px); border-color: #E08E9E; }
        .gallery-item-admin img   { width: 100%; height: 140px; object-fit: cover; }
        .gallery-item-admin .info { padding: 0.75rem; }
        .gallery-item-admin .info strong { color: #E8E8F0; font-size: 0.85rem; }
        .gallery-item-admin .info small  { color: #A0A0B0; font-size: 0.75rem; }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.open { transform: translateX(0); }
            .admin-main { margin-left: 0; }
        }
    </style>
</head>
<body>
<div class="admin-wrapper">
    <div class="admin-sidebar" id="adminSidebar">
        <h3><i class="fas fa-crown"></i> Admin MI</h3>
        <a href="index.php"       class="<?= $current_page == 'index.php'         ? 'active' : '' ?>"><i class="fas fa-tachometer-alt"></i>    Dashboard</a>
        <a href="dosen.php"       class="<?= $current_page == 'dosen.php'         ? 'active' : '' ?>"><i class="fas fa-chalkboard-user"></i>   Dosen</a>
        <a href="mahasiswa.php"   class="<?= $current_page == 'mahasiswa.php'     ? 'active' : '' ?>"><i class="fas fa-user-graduate"></i>     Mahasiswa</a>
        <a href="galeri.php"      class="<?= $current_page == 'galeri.php'        ? 'active' : '' ?>"><i class="fas fa-images"></i>            Galeri</a>
        <a href="berita.php"      class="<?= $current_page == 'berita.php'        ? 'active' : '' ?>"><i class="fas fa-newspaper"></i>         Berita</a>
        <a href="pesan.php"       class="<?= $current_page == 'pesan.php'         ? 'active' : '' ?>"><i class="fas fa-envelope"></i>          Pesan Kontak</a>
        <a href="login_history.php" class="<?= $current_page == 'login_history.php' ? 'active' : '' ?>"><i class="fas fa-history"></i>        Riwayat Login</a>
        <hr class="sidebar-divider">
        <a href="../index.php" target="_blank" rel="noopener noreferrer"><i class="fas fa-globe"></i> Lihat Website</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="admin-main">
        <div class="admin-header">
            <h1><?= isset($title) ? htmlspecialchars($title) : 'Dashboard' ?></h1>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <!-- KOREKSI: htmlspecialchars pada nama sesi untuk mencegah XSS -->
                <span><?= htmlspecialchars($_SESSION['admin_nama']) ?></span>
            </div>
        </div>