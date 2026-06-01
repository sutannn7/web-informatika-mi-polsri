<?php
$title = 'Dashboard';
require_once 'includes/admin_header.php';

$total_dosen = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM dosen"))[0];
$total_mahasiswa = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM mahasiswa"))[0];
$total_berita = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM berita"))[0];
$total_pesan = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM pesan_kontak"))[0];
$total_galeri = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM galeri"))[0];
?>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="admin-card" style="text-align: center;">
        <i class="fas fa-chalkboard-user" style="font-size: 2rem; color: #E08E9E;"></i>
        <div style="font-size: 2rem; font-weight: bold; margin: 0.5rem 0;"><?= $total_dosen ?></div>
        <div>Dosen</div>
    </div>
    <div class="admin-card" style="text-align: center;">
        <i class="fas fa-user-graduate" style="font-size: 2rem; color: #E08E9E;"></i>
        <div style="font-size: 2rem; font-weight: bold; margin: 0.5rem 0;"><?= $total_mahasiswa ?></div>
        <div>Mahasiswa</div>
    </div>
    <div class="admin-card" style="text-align: center;">
        <i class="fas fa-newspaper" style="font-size: 2rem; color: #E08E9E;"></i>
        <div style="font-size: 2rem; font-weight: bold; margin: 0.5rem 0;"><?= $total_berita ?></div>
        <div>Berita</div>
    </div>
    <div class="admin-card" style="text-align: center;">
        <i class="fas fa-envelope" style="font-size: 2rem; color: #E08E9E;"></i>
        <div style="font-size: 2rem; font-weight: bold; margin: 0.5rem 0;"><?= $total_pesan ?></div>
        <div>Pesan Masuk</div>
    </div>
</div>
<div class="admin-card">
    <h3>Selamat datang, <?= $_SESSION['admin_nama'] ?>!</h3>
    <p>Gunakan menu di samping untuk mengelola konten website. Anda dapat menambah, mengedit, atau menghapus data dosen, mahasiswa, galeri, berita, serta melihat pesan kontak.</p>
    <p style="margin-top: 1rem;">Total galeri: <strong><?= $total_galeri ?></strong> foto.</p>
</div>
<?php require_once 'includes/admin_footer.php'; ?>