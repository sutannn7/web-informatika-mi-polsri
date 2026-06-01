<?php
$title = 'Riwayat Login';
require_once 'includes/admin_header.php';

$query = "SELECT l.*, a.username 
          FROM admin_login_log l 
          LEFT JOIN admin a ON l.admin_id = a.id 
          ORDER BY l.login_time DESC";
$result = mysqli_query($conn, $query);
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
    <h2>Riwayat Login Admin</h2>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Waktu</th>
            <th>Admin</th>
            <th>IP</th>
            <th>Perangkat/Browser</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['login_time']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['login_ip']) ?></td>
                    <td style="max-width: 300px; word-wrap: break-word;"><?= htmlspecialchars($row['user_agent']) ?></td>
                    <td><?= ($row['status'] == 'success') ? '<span style="color: green;">Berhasil</span>' : '<span style="color: red;">Gagal</span>' ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Belum ada riwayat login. Silakan login terlebih dahulu.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once 'includes/admin_footer.php'; ?>