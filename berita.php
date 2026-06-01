<?php
$title = 'Kelola Berita';
require_once 'includes/admin_header.php';

/** @var mysqli $conn */

function makeSlug($str) {
    $str = strtolower(trim($str));
    $str = preg_replace('/[^a-z0-9\s-]/', '', $str);
    $str = preg_replace('/[\s-]+/', '-', $str);
    return $str . '-' . substr(uniqid(), -4);
}

$act = $_GET['act'] ?? 'list';
$msg = '';

if ($act === 'hapus' && isset($_GET['id'])) {
    $id   = (int)$_GET['id'];
    $stmt = mysqli_prepare($conn, "DELETE FROM berita WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $msg = 'success:Berita dihapus';
    $act = 'list';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // KOREKSI: semua field pakai prepared statement, bukan string interpolation
    $judul    = trim($_POST['judul']   ?? '');
    $isi      = trim($_POST['isi']     ?? '');
    $excerpt  = substr(strip_tags($isi), 0, 200);
    $kategori = trim($_POST['kategori'] ?? 'Umum');
    $penulis  = trim($_POST['penulis']  ?? 'Admin');
    $tanggal  = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');
    $slug     = makeSlug($judul);
    $status   = 'published';

    if ($_POST['action'] === 'tambah') {
        $stmt = mysqli_prepare($conn, "INSERT INTO berita (judul, slug, isi, excerpt, kategori, penulis, tanggal, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssssssss', $judul, $slug, $isi, $excerpt, $kategori, $penulis, $tanggal, $status);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $msg = 'success:Berita ditambahkan';
    } elseif ($_POST['action'] === 'edit') {
        $id   = (int)$_POST['id'];
        $stmt = mysqli_prepare($conn, "UPDATE berita SET judul=?, isi=?, excerpt=?, kategori=?, penulis=?, tanggal=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'ssssssi', $judul, $isi, $excerpt, $kategori, $penulis, $tanggal, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $msg = 'success:Berita diupdate';
    }
    $act = 'list';
}

$edit = null;
if ($act === 'edit' && isset($_GET['id'])) {
    $id   = (int)$_GET['id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM berita WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $edit = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
}

$list = mysqli_query($conn, "SELECT * FROM berita ORDER BY created_at DESC");
?>

<?php if ($msg): [$type, $text] = explode(':', $msg, 2); ?>
    <div class="alert alert-<?= htmlspecialchars($type) ?>"><?= htmlspecialchars($text) ?></div>
<?php endif; ?>

<?php if ($act === 'list'): ?>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
        <h3>Daftar Berita</h3>
        <a href="?act=tambah" class="btn-sm">+ Tambah Berita</a>
    </div>
    <table class="admin-table">
        <thead>
            <tr><th>#</th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Tanggal</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php $no = 1; while ($b = mysqli_fetch_assoc($list)):
            $tgl = (!empty($b['tanggal'])) ? date('d M Y', strtotime($b['tanggal'])) : '-';
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($b['judul']) ?></td>
            <td><?= htmlspecialchars($b['kategori']) ?></td>
            <td><?= htmlspecialchars($b['penulis']) ?></td>
            <td><?= $tgl ?></td>
            <td>
                <a href="?act=edit&id=<?= (int)$b['id'] ?>" class="btn-sm">✏️ Edit</a>
                <a href="?act=hapus&id=<?= (int)$b['id'] ?>" class="btn-sm"
                   style="background:#EF4444;"
                   onclick="return confirm('Yakin hapus berita ini?')">🗑️ Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="admin-card">
        <h3><?= $act === 'tambah' ? 'Tambah Berita' : 'Edit Berita' ?></h3>
        <form method="POST">
            <input type="hidden" name="action" value="<?= htmlspecialchars($act) ?>">
            <?php if ($edit): ?>
                <input type="hidden" name="id" value="<?= (int)$edit['id'] ?>">
            <?php endif; ?>
            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="judul" value="<?= htmlspecialchars($edit['judul'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="kategori" value="<?= htmlspecialchars($edit['kategori'] ?? 'Umum') ?>">
            </div>
            <div class="form-group">
                <label>Penulis</label>
                <input type="text" name="penulis" value="<?= htmlspecialchars($edit['penulis'] ?? 'Admin') ?>">
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="<?= htmlspecialchars($edit['tanggal'] ?? date('Y-m-d')) ?>">
            </div>
            <div class="form-group">
                <label>Isi Berita</label>
                <textarea name="isi" rows="10" required><?= htmlspecialchars($edit['isi'] ?? '') ?></textarea>
            </div>
            <button type="submit">Simpan</button>
            <a href="?" style="margin-left:10px;color:#A0A0B0;font-size:0.85rem;">Batal</a>
        </form>
    </div>
<?php endif; ?>

<?php require_once 'includes/admin_footer.php'; ?>