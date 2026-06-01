<?php
$title = 'Balas Pesan';
require_once 'includes/admin_header.php';

$id = (int)$_GET['id'];
$query = "SELECT * FROM pesan_kontak WHERE id = $id";
$result = mysqli_query($conn, $query);
$pesan = mysqli_fetch_assoc($result);

if (!$pesan) {
    echo "<div class='alert alert-error'>Pesan tidak ditemukan.</div>";
    require_once 'includes/admin_footer.php';
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $balasan = trim(mysqli_real_escape_string($conn, $_POST['balasan']));
    if (empty($balasan)) {
        $error = 'Balasan tidak boleh kosong!';
    } else {
        $insert = "INSERT INTO pesan_balasan (pesan_id, balasan) VALUES ($id, '$balasan')";
        if (mysqli_query($conn, $insert)) {
            $success = "✅ Balasan telah dikirim (tersimpan di database). Pengirim akan diinformasikan.";
        } else {
            $error = "❌ Gagal menyimpan balasan: " . mysqli_error($conn);
        }
    }
}
?>
<div class="admin-card">
    <h2>Balas Pesan dari: <?= htmlspecialchars($pesan['nama']) ?></h2>
    <p><strong>Email:</strong> <?= htmlspecialchars($pesan['email']) ?></p>
    <p><strong>Subjek:</strong> <?= htmlspecialchars($pesan['subjek'] ?: '-') ?></p>
    <div style="background: var(--bg); padding: 1rem; border-radius: 12px; margin-bottom: 1rem;">
        <strong>Pesan asli:</strong><br>
        <?= nl2br(htmlspecialchars($pesan['pesan'])) ?>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Balasan Anda</label>
            <textarea name="balasan" rows="6" class="form-control" required placeholder="Tulis balasan Anda di sini..."></textarea>
        </div>
        <button type="submit" class="btn-sm">📨 Kirim Balasan</button>
        <a href="pesan.php" class="btn-sm" style="background: gray;">Kembali</a>
    </form>
</div>
<?php require_once 'includes/admin_footer.php'; ?>