<?php
$title = 'Kelola Mahasiswa';
require_once 'includes/admin_header.php';

/** @var mysqli $conn */

$act = $_GET['act'] ?? 'list';
$msg = '';

if ($act == 'hapus' && isset($_GET['id'])) {
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id=".(int)$_GET['id']);
    $msg = 'success:Mahasiswa dihapus';
    $act = 'list';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $angkatan = (int)$_POST['angkatan'];
    $prestasi = mysqli_real_escape_string($conn, $_POST['prestasi']);
    $kegiatan = mysqli_real_escape_string($conn, $_POST['kegiatan']);
    $organisasi = mysqli_real_escape_string($conn, $_POST['organisasi']);
    $ipk = (float)$_POST['ipk'];
    if ($_POST['action'] == 'tambah') {
        mysqli_query($conn, "INSERT INTO mahasiswa (nim, nama, angkatan, prestasi, kegiatan, organisasi, ipk) VALUES ('$nim','$nama',$angkatan,'$prestasi','$kegiatan','$organisasi','$ipk')");
        $msg = 'success:Mahasiswa ditambahkan';
    } elseif ($_POST['action'] == 'edit') {
        $id = (int)$_POST['id'];
        mysqli_query($conn, "UPDATE mahasiswa SET nim='$nim', nama='$nama', angkatan=$angkatan, prestasi='$prestasi', kegiatan='$kegiatan', organisasi='$organisasi', ipk='$ipk' WHERE id=$id");
        $msg = 'success:Mahasiswa diupdate';
    }
    $act = 'list';
}

$edit = null;
if ($act == 'edit' && isset($_GET['id'])) {
    $res = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id=".(int)$_GET['id']);
    $edit = mysqli_fetch_assoc($res);
}

$list = mysqli_query($conn, "SELECT * FROM mahasiswa ORDER BY angkatan DESC, nama ASC");
?>

<?php if ($msg): list($type,$text)=explode(':',$msg); ?>
<div class="alert alert-<?= $type ?>"><?= $text ?></div>
<?php endif; ?>

<?php if ($act == 'list'): ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
    <h2>Daftar Mahasiswa</h2>
    <a href="?act=tambah" class="btn-sm">+ Tambah Mahasiswa</a>
</div>
<table class="admin-table">
    <thead>
        <tr><th>#</th><th>NIM</th><th>Nama</th><th>Angkatan</th><th>IPK</th><th>Aksi</th></tr>
    </thead>
    <tbody>
    <?php $no=1; while($m = mysqli_fetch_assoc($list)): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($m['nim']) ?></td>
        <td><?= htmlspecialchars($m['nama']) ?></td>
        <td><?= $m['angkatan'] ?></td>
        <td><?= number_format($m['ipk'], 2) ?></td>
        <td>
            <a href="?act=edit&id=<?= $m['id'] ?>">✏️ Edit</a>
            <a href="?act=hapus&id=<?= $m['id'] ?>" onclick="return confirm('Yakin hapus?')">🗑️ Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<div class="admin-card">
    <h3><?= $act == 'tambah' ? 'Tambah Mahasiswa' : 'Edit Mahasiswa' ?></h3>
    <form method="POST">
        <input type="hidden" name="action" value="<?= $act ?>">
        <?php if ($edit): ?><input type="hidden" name="id" value="<?= $edit['id'] ?>"><?php endif; ?>
        <div class="form-group"><label>NIM</label><input type="text" name="nim" value="<?= htmlspecialchars($edit['nim'] ?? '') ?>" required></div>
        <div class="form-group"><label>Nama</label><input type="text" name="nama" value="<?= htmlspecialchars($edit['nama'] ?? '') ?>" required></div>
        <div class="form-group"><label>Angkatan</label><input type="number" name="angkatan" value="<?= $edit['angkatan'] ?? date('Y') ?>"></div>
        <div class="form-group"><label>IPK</label><input type="text" name="ipk" step="0.01" value="<?= $edit['ipk'] ?? '' ?>"></div>
        <div class="form-group"><label>Prestasi</label><textarea name="prestasi"><?= htmlspecialchars($edit['prestasi'] ?? '') ?></textarea></div>
        <div class="form-group"><label>Kegiatan</label><textarea name="kegiatan"><?= htmlspecialchars($edit['kegiatan'] ?? '') ?></textarea></div>
        <div class="form-group"><label>Organisasi</label><textarea name="organisasi"><?= htmlspecialchars($edit['organisasi'] ?? '') ?></textarea></div>
        <button type="submit">Simpan</button>
        <a href="?">Batal</a>
    </form>
</div>
<?php endif; ?>

<?php require_once 'includes/admin_footer.php'; ?>