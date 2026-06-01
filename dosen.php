<?php
$title = 'Kelola Dosen';
require_once 'includes/admin_header.php';

/** @var mysqli $conn */

$act = $_GET['act'] ?? 'list';
$msg = '';

// Hapus
if ($act === 'hapus' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    // KOREKSI: sebelumnya DELETE langsung interpolasi — sudah aman karena (int) cast,
    // tapi lebih eksplisit dengan prepared statement
    $stmt = mysqli_prepare($conn, "DELETE FROM dosen WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $msg = 'success:Data dosen dihapus';
    $act = 'list';
}

// Tambah & Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // KOREKSI: sebelumnya semua field dimasukkan langsung ke query string — rentan SQL injection
    // Diganti prepared statement untuk tambah dan edit
    $nama    = trim($_POST['nama']            ?? '');
    $nidn    = trim($_POST['nidn']            ?? '');
    $jabatan = trim($_POST['jabatan']         ?? '');
    $bidang  = trim($_POST['bidang_keahlian'] ?? '');
    $email   = trim($_POST['email']           ?? '');

    if ($_POST['action'] === 'tambah') {
        $stmt = mysqli_prepare($conn, "INSERT INTO dosen (nama, nidn, jabatan, bidang_keahlian, email) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sssss', $nama, $nidn, $jabatan, $bidang, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $msg = 'success:Dosen ditambahkan';
    } elseif ($_POST['action'] === 'edit') {
        $id = (int)$_POST['id'];
        $stmt = mysqli_prepare($conn, "UPDATE dosen SET nama=?, nidn=?, jabatan=?, bidang_keahlian=?, email=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'sssssi', $nama, $nidn, $jabatan, $bidang, $email, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $msg = 'success:Dosen diupdate';
    }
    $act = 'list';
}

$edit = null;
if ($act === 'edit' && isset($_GET['id'])) {
    $id   = (int)$_GET['id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM dosen WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $edit = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
}

$list = mysqli_query($conn, "SELECT * FROM dosen ORDER BY nama ASC");
?>

<?php if ($msg): [$type, $text] = explode(':', $msg, 2); ?>
    <div class="alert alert-<?= htmlspecialchars($type) ?>"><?= htmlspecialchars($text) ?></div>
<?php endif; ?>

<?php if ($act === 'list'): ?>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
        <h2>Daftar Dosen</h2>
        <a href="?act=tambah" class="btn-sm">+ Tambah Dosen</a>
    </div>
    <table class="admin-table">
        <thead>
            <tr><th>#</th><th>Nama</th><th>NIDN</th><th>Jabatan</th><th>Email</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php $no = 1; while ($d = mysqli_fetch_assoc($list)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($d['nama']) ?></td>
            <td><?= htmlspecialchars($d['nidn']) ?></td>
            <td><?= htmlspecialchars($d['jabatan']) ?></td>
            <td><?= htmlspecialchars($d['email']) ?></td>
            <td>
                <a href="?act=edit&id=<?= (int)$d['id'] ?>" class="btn-sm">✏️ Edit</a>
                <a href="?act=hapus&id=<?= (int)$d['id'] ?>" class="btn-sm"
                   style="background:#EF4444;"
                   onclick="return confirm('Yakin hapus dosen ini?')">🗑️ Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="admin-card">
        <h3><?= $act === 'tambah' ? 'Tambah Dosen' : 'Edit Dosen' ?></h3>
        <form method="POST">
            <input type="hidden" name="action" value="<?= htmlspecialchars($act) ?>">
            <?php if ($edit): ?>
                <input type="hidden" name="id" value="<?= (int)$edit['id'] ?>">
            <?php endif; ?>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($edit['nama'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>NIDN</label>
                <input type="text" name="nidn" value="<?= htmlspecialchars($edit['nidn'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Jabatan</label>
                <input type="text" name="jabatan" value="<?= htmlspecialchars($edit['jabatan'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Bidang Keahlian</label>
                <input type="text" name="bidang_keahlian" value="<?= htmlspecialchars($edit['bidang_keahlian'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($edit['email'] ?? '') ?>">
            </div>
            <button type="submit">Simpan</button>
            <a href="?" style="margin-left:10px;color:#A0A0B0;font-size:0.85rem;">Batal</a>
        </form>
    </div>
<?php endif; ?>

<?php require_once 'includes/admin_footer.php'; ?>