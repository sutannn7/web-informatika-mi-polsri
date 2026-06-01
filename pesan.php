<?php
$title = 'Pesan Kontak';
require_once 'includes/admin_header.php';

/** @var mysqli $conn */

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $conn->query("DELETE FROM pesan_kontak WHERE id = $id");
    header('Location: pesan.php?msg=deleted');
    exit;
}

$result = $conn->query("SELECT * FROM pesan_kontak ORDER BY created_at DESC");
$pesan_list = [];
while ($row = $result->fetch_assoc()) {
    $pesan_list[] = $row;
}
?>
<!-- sisanya sama seperti kode Anda -->

<?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
<div class="alert alert-success">✅ Pesan berhasil dihapus</div>
<?php endif; ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
    <h2>Daftar Pesan Masuk</h2>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Subjek</th>
            <th>Pesan</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($pesan_list) > 0): ?>
            <?php $no = 1; foreach ($pesan_list as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['subjek'] ?: '-') ?></td>
                    <td><?= nl2br(htmlspecialchars(substr($row['pesan'], 0, 100))) ?>...</td>
                    <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                    <td>
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?= urlencode($row['email']) ?>&su=<?= urlencode('Balasan: ' . ($row['subjek'] ?: 'Pesan dari website')) ?>" 
                            target="_blank" class="btn-sm" style="background: #10B981;">📧 Balas Pesan</a>
                        <a href="?hapus=<?= $row['id'] ?>" class="btn-sm" style="background: #EF4444;" onclick="return confirm('Yakin hapus pesan ini?')">🗑️ Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Belum ada pesan masuk.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
function copyEmail(email, subjek) {
    const text = `Email: ${email}\nSubjek: ${subjek}`;
    navigator.clipboard.writeText(text).then(() => {
        alert("Alamat email dan subjek telah disalin ke clipboard.\nSilakan buka email Anda dan tempelkan.");
    }).catch(() => {
        alert("Gagal menyalin. Silakan manual:\n" + text);
    });
}
</script>

<?php require_once 'includes/admin_footer.php'; ?>