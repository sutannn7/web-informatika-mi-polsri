<?php
/**
 * Admin Galeri - POLSRI Manajemen Informatika
 * FIXED + MODERN DESIGN
 *
 * Perbaikan:
 * - Path upload menggunakan __DIR__ absolut
 * - Validasi MIME type & ukuran file (max 5MB)
 * - Nama file unik (uniqid + random bytes)
 * - Desain card grid modern, responsif
 */

$title = 'Kelola Galeri';
require_once 'includes/admin_header.php';

// =========================================================
// Konfigurasi path absolut & relatif
// =========================================================
define('IMAGE_DIR', dirname(__DIR__, 2) . '/images/');
define('IMAGE_URL', '../../images/');

/**
 * Upload foto dengan validasi ketat
 */
function uploadFoto($file, $prefix = 'galeri') {
    if (!$file || !is_array($file)) return false;
    if ($file['error'] !== UPLOAD_ERR_OK) {
        error_log("Upload error code: " . $file['error']);
        return false;
    }

    // Maks 5MB
    if ($file['size'] > 5 * 1024 * 1024) {
        error_log("Upload gagal: ukuran >5MB");
        return false;
    }

    $allowedMime = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);
    if (!array_key_exists($mimeType, $allowedMime)) {
        error_log("Tipe file tidak diizinkan: $mimeType");
        return false;
    }

    $ext = $allowedMime[$mimeType];
    $nama = $prefix . '_' . uniqid() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $target = IMAGE_DIR . $nama;

    if (!is_dir(IMAGE_DIR)) {
        mkdir(IMAGE_DIR, 0755, true);
    }

    if (!is_writable(IMAGE_DIR)) {
        error_log("Folder IMAGE_DIR tidak writable: " . IMAGE_DIR);
        return false;
    }

    return move_uploaded_file($file['tmp_name'], $target) ? $nama : false;
}

// =========================================================
// Proses CRUD
// =========================================================
$act = $_GET['act'] ?? 'list';
$msg = '';

// Hapus
if ($act == 'hapus' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $res = mysqli_query($conn, "SELECT foto FROM galeri WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    if ($row && $row['foto']) {
        $filePath = IMAGE_DIR . $row['foto'];
        if (file_exists($filePath)) unlink($filePath);
    }
    mysqli_query($conn, "DELETE FROM galeri WHERE id=$id");
    $msg = 'success:Galeri berhasil dihapus';
    $act = 'list';
}

// Tambah / Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul     = mysqli_real_escape_string($conn, trim($_POST['judul'] ?? ''));
    $deskripsi = mysqli_real_escape_string($conn, trim($_POST['deskripsi'] ?? ''));
    $kategori  = mysqli_real_escape_string($conn, trim($_POST['kategori'] ?? ''));
    $action    = $_POST['action'] ?? '';

    $fotoUpload = uploadFoto($_FILES['foto'] ?? null, 'galeri');

    if ($action === 'tambah') {
        if ($fotoUpload) {
            $sql = "INSERT INTO galeri (judul, deskripsi, kategori, foto) 
                    VALUES ('$judul','$deskripsi','$kategori','$fotoUpload')";
            $ok = mysqli_query($conn, $sql);
            $msg = $ok ? 'success:Galeri berhasil ditambahkan' : 'error:Gagal menyimpan ke database';
        } else {
            $msg = 'error:Gagal upload foto. Maks 5MB, format JPG/PNG/GIF/WEBP';
        }
    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        if ($fotoUpload) {
            // Hapus foto lama
            $oldRes = mysqli_query($conn, "SELECT foto FROM galeri WHERE id=$id");
            $old = mysqli_fetch_assoc($oldRes);
            if ($old && $old['foto']) {
                $oldPath = IMAGE_DIR . $old['foto'];
                if (file_exists($oldPath)) unlink($oldPath);
            }
            $sql = "UPDATE galeri SET judul='$judul', deskripsi='$deskripsi', 
                    kategori='$kategori', foto='$fotoUpload' WHERE id=$id";
        } else {
            $sql = "UPDATE galeri SET judul='$judul', deskripsi='$deskripsi', 
                    kategori='$kategori' WHERE id=$id";
        }
        mysqli_query($conn, $sql);
        $msg = 'success:Galeri berhasil diupdate';
    }
    $act = 'list';
}

// Data untuk form edit
$edit = null;
if ($act === 'edit' && isset($_GET['id'])) {
    $res = mysqli_query($conn, "SELECT * FROM galeri WHERE id=" . (int)$_GET['id']);
    $edit = mysqli_fetch_assoc($res);
    if (!$edit) $act = 'list';
}

// Semua data galeri
$list = mysqli_query($conn, "SELECT * FROM galeri ORDER BY created_at DESC");

// Parsing pesan
$msgType = $msgText = '';
if ($msg) {
    [$msgType, $msgText] = explode(':', $msg, 2);
}
?>

<style>
/* ========== DESAIN ADMIN GALERI MODERN ========== */
.admin-galeri-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 1rem 1.5rem;
}
.admin-header-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}
.admin-header-bar h1 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.btn-add {
    background: var(--primary);
    color: #fff;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 40px;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}
.btn-add:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}
.alert {
    padding: 0.85rem 1.2rem;
    border-radius: 14px;
    margin-bottom: 1.5rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.6rem;
}
.alert-success {
    background: rgba(107,158,143,0.15);
    border: 1px solid rgba(107,158,143,0.3);
    color: #7EC8B5;
}
.alert-error {
    background: rgba(224,142,158,0.15);
    border: 1px solid rgba(224,142,158,0.3);
    color: var(--primary);
}
.galeri-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}
.galeri-card {
    background: var(--bg-card);
    border-radius: 20px;
    border: 1px solid var(--border);
    overflow: hidden;
    transition: transform 0.2s, border-color 0.2s;
}
.galeri-card:hover {
    transform: translateY(-4px);
    border-color: var(--primary);
}
.galeri-img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    background: #2a2a36;
}
.galeri-placeholder {
    width: 100%;
    height: 180px;
    background: linear-gradient(135deg, #2a2a36, #1e1e28);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 0.5rem;
    color: var(--text-muted);
    font-size: 2rem;
}
.galeri-placeholder span {
    font-size: 0.7rem;
}
.galeri-info {
    padding: 1rem;
}
.galeri-info h4 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.4rem 0;
    color: var(--text-dark);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.galeri-kategori {
    display: inline-block;
    background: var(--primary-soft);
    color: var(--primary);
    padding: 0.2rem 0.7rem;
    border-radius: 30px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: capitalize;
    margin-bottom: 0.8rem;
}
.galeri-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.8rem;
}
.btn-edit, .btn-delete {
    flex: 1;
    text-align: center;
    padding: 0.4rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-edit {
    background: rgba(224,142,158,0.1);
    color: var(--primary);
    border: 1px solid rgba(224,142,158,0.2);
}
.btn-edit:hover {
    background: var(--primary);
    color: #fff;
}
.btn-delete {
    background: rgba(255,70,70,0.1);
    color: #f87171;
    border: 1px solid rgba(255,70,70,0.2);
}
.btn-delete:hover {
    background: rgba(255,70,70,0.3);
    border-color: #f87171;
}
.form-card {
    background: var(--bg-card);
    border-radius: 24px;
    border: 1px solid var(--border);
    padding: 1.8rem;
    max-width: 700px;
    margin: 0 auto;
}
.form-card h2 {
    font-size: 1.3rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-dark);
}
.form-group {
    margin-bottom: 1.2rem;
}
.form-group label {
    display: block;
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--text-light);
    margin-bottom: 0.3rem;
}
.form-group input, 
.form-group textarea, 
.form-group select {
    width: 100%;
    padding: 0.7rem 0.9rem;
    background: rgba(255,255,255,0.05);
    border: 1px solid var(--border);
    border-radius: 12px;
    color: var(--text);
    font-family: inherit;
    font-size: 0.85rem;
    transition: 0.2s;
}
.form-group input:focus, 
.form-group textarea:focus, 
.form-group select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 2px var(--primary-soft);
}
.form-group textarea {
    min-height: 80px;
    resize: vertical;
}
.preview-img {
    margin-top: 0.6rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    background: rgba(255,255,255,0.03);
    padding: 0.6rem;
    border-radius: 12px;
}
.preview-img img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.8rem;
}
.btn-submit {
    background: var(--primary);
    color: white;
    border: none;
    padding: 0.6rem 1.5rem;
    border-radius: 40px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
}
.btn-submit:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}
.btn-cancel {
    background: transparent;
    border: 1px solid var(--border);
    color: var(--text-light);
    padding: 0.6rem 1.5rem;
    border-radius: 40px;
    text-decoration: none;
    font-weight: 500;
    transition: 0.2s;
}
.btn-cancel:hover {
    border-color: var(--text);
    color: var(--text);
}
.empty-state {
    text-align: center;
    padding: 3rem;
    background: var(--bg-card);
    border-radius: 24px;
    color: var(--text-muted);
}
.empty-state .icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}
@media (max-width: 640px) {
    .admin-galeri-container {
        padding: 1rem;
    }
    .galeri-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="admin-galeri-container">
    <!-- Notifikasi -->
    <?php if ($msgText): ?>
    <div class="alert alert-<?= $msgType === 'success' ? 'success' : 'error' ?>">
        <?= $msgType === 'success' ? '✓' : '⚠️' ?> <?= htmlspecialchars($msgText) ?>
    </div>
    <?php endif; ?>

    <?php if ($act == 'list'): ?>
        <!-- HEADER LIST -->
        <div class="admin-header-bar">
            <h1>🖼️ Kelola Galeri</h1>
            <a href="?act=tambah" class="btn-add">+ Tambah Foto Baru</a>
        </div>

        <?php if (mysqli_num_rows($list) > 0): ?>
        <div class="galeri-grid">
            <?php while ($g = mysqli_fetch_assoc($list)): ?>
            <div class="galeri-card">
                <?php 
                $fotoPath = IMAGE_DIR . $g['foto'];
                if ($g['foto'] && file_exists($fotoPath)): ?>
                    <img class="galeri-img" src="<?= IMAGE_URL . htmlspecialchars($g['foto']) ?>" alt="<?= htmlspecialchars($g['judul']) ?>">
                <?php else: ?>
                    <div class="galeri-placeholder">
                        📷
                        <span>Foto tidak tersedia</span>
                    </div>
                <?php endif; ?>
                <div class="galeri-info">
                    <h4><?= htmlspecialchars($g['judul']) ?></h4>
                    <span class="galeri-kategori"><?= htmlspecialchars($g['kategori']) ?></span>
                    <?php if (!empty($g['deskripsi'])): ?>
                        <p style="font-size:0.75rem; color:var(--text-light); margin:0.3rem 0;"><?= htmlspecialchars(substr($g['deskripsi'], 0, 60)) ?>...</p>
                    <?php endif; ?>
                    <div class="galeri-actions">
                        <a href="?act=edit&id=<?= $g['id'] ?>" class="btn-edit">✏ Edit</a>
                        <a href="?act=hapus&id=<?= $g['id'] ?>" class="btn-delete" onclick="return confirm('Yakin hapus galeri ini?')">🗑 Hapus</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <div class="icon">📭</div>
            <p>Belum ada foto di galeri.</p>
            <a href="?act=tambah" class="btn-add" style="display:inline-flex; margin-top:1rem;">Upload Foto Pertama</a>
        </div>
        <?php endif; ?>

    <?php else: ?>
        <!-- FORM TAMBAH / EDIT -->
        <div class="admin-header-bar">
            <h1><?= $act == 'tambah' ? '➕' : '✏️' ?> <?= $act == 'tambah' ? 'Tambah Foto Baru' : 'Edit Galeri' ?></h1>
            <a href="?" class="btn-cancel">← Kembali ke Daftar</a>
        </div>

        <div class="form-card">
            <h2><?= $act == 'tambah' ? '🖼 Unggah Foto' : '📝 Perbarui Informasi' ?></h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="<?= $act ?>">
                <?php if ($edit): ?>
                    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Judul Foto</label>
                    <input type="text" name="judul" value="<?= htmlspecialchars($edit['judul'] ?? '') ?>" placeholder="Contoh: Seminar Teknologi 2025" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi (opsional)</label>
                    <textarea name="deskripsi" placeholder="Cerita singkat tentang foto ini..."><?= htmlspecialchars($edit['deskripsi'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori">
                        <?php foreach (['kegiatan','seminar','workshop','akademik'] as $kat): ?>
                            <option value="<?= $kat ?>" <?= (isset($edit['kategori']) && $edit['kategori'] == $kat) ? 'selected' : '' ?>>
                                <?= ucfirst($kat) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>
                        File Foto
                        <?= !$edit ? '<span style="color:var(--primary);"> *wajib</span>' : '<span style="color:var(--text-muted);"> (kosongkan jika tidak ingin mengganti)</span>' ?>
                    </label>
                    <input type="file" name="foto" accept="image/jpeg,image/png,image/gif,image/webp" <?= !$edit ? 'required' : '' ?>>
                    <?php if ($edit && $edit['foto'] && file_exists(IMAGE_DIR . $edit['foto'])): ?>
                        <div class="preview-img">
                            <img src="<?= IMAGE_URL . htmlspecialchars($edit['foto']) ?>" alt="preview">
                            <small style="color:var(--text-muted);">Foto saat ini: <?= htmlspecialchars($edit['foto']) ?></small>
                        </div>
                    <?php endif; ?>
                    <small style="color:var(--text-muted); display:block; margin-top:0.3rem;">Format: JPG, PNG, GIF, WEBP. Maksimal 5MB.</small>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">✓ Simpan</button>
                    <a href="?" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/admin_footer.php'; ?>