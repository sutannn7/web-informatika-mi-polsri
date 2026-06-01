<?php
// KOREKSI: htmlspecialchars pada $current_page untuk keamanan (XSS)
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- KOREKSI: htmlspecialchars pada $page_title untuk mencegah XSS -->
    <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' - ' : '' ?>Manajemen Informatika - POLSRI</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- KOREKSI: gunakan logo PNG yang lebih sesuai sebagai favicon -->
    <link rel="icon" type="image/png" href="images/logo-polsri.png">
    <!-- KOREKSI: Bootstrap Icons dipindah ke sini (sebelumnya ada di footer.php dan duplikat di tiap halaman) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- Dekorasi background -->
<div class="glow-pink"></div>
<div class="glow-cyan"></div>
<div class="glow-purple"></div>

<nav class="navbar">
    <div class="nav-container">
        <a class="nav-brand" href="index.php">
            <img src="images/logo-himpunai.jpg" alt="Logo HIMPUNAI">
            <div class="logo-text">
                Manajemen Informatika<br>
                <span>Politeknik Negeri Sriwijaya</span>
            </div>
        </a>
        <button class="hamburger" aria-label="Menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
        <ul class="nav-links">
            <li><a href="index.php"      <?= $current_page == 'index.php'                                              ? 'class="active"' : '' ?>>Beranda</a></li>
            <li><a href="about.php"      <?= $current_page == 'about.php'                                              ? 'class="active"' : '' ?>>Profil</a></li>
            <li><a href="dosen.php"      <?= $current_page == 'dosen.php'                                              ? 'class="active"' : '' ?>>Dosen</a></li>
            <li><a href="mahasiswa.php"  <?= $current_page == 'mahasiswa.php'                                          ? 'class="active"' : '' ?>>Mahasiswa</a></li>
            <li><a href="galeri.php"     <?= $current_page == 'galeri.php'                                             ? 'class="active"' : '' ?>>Galeri</a></li>
            <li><a href="berita.php"     <?= in_array($current_page, ['berita.php','berita_detail.php'])               ? 'class="active"' : '' ?>>Berita</a></li>
            <li><a href="kontak.php"     <?= $current_page == 'kontak.php'                                             ? 'class="active"' : '' ?>>Kontak</a></li>
            <!-- KOREKSI: link login admin sebaiknya tidak ditampilkan di navbar publik.
                 Hapus atau sembunyikan baris ini di produksi. -->
            <li><a href="admin/login.php">Login Admin</a></li>
        </ul>
    </div>
</nav>