<?php
$page_title = 'Detail Berita';
require_once 'includes/db.php';
require_once 'includes/header.php';

// KOREKSI: ambil slug dari GET, gunakan prepared statement bukan escape string langsung ke query
$slug = trim($_GET['slug'] ?? '');

if (empty($slug)) {
    header('Location: berita.php');
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM berita WHERE slug = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 's', $slug);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$data) {
    header('Location: berita.php');
    exit;
}

// Update views dengan prepared statement
$stmt2 = mysqli_prepare($conn, "UPDATE berita SET views = views + 1 WHERE id = ?");
mysqli_stmt_bind_param($stmt2, 'i', $data['id']);
mysqli_stmt_execute($stmt2);
mysqli_stmt_close($stmt2);
?>

<div class="page-hero berita-detail-hero">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Home</a> <span>›</span>
            <a href="berita.php">Berita</a> <span>›</span>
            <span><?= htmlspecialchars($data['judul']) ?></span>
        </div>
        <h1 class="berita-detail__title"><?= htmlspecialchars($data['judul']) ?></h1>
        <div class="berita-detail__meta">
            <span><i class="bi bi-calendar3"></i> <?= date('d F Y', strtotime($data['created_at'])) ?></span>
            <span><i class="bi bi-tag"></i> <?= htmlspecialchars($data['kategori']) ?></span>
            <span><i class="bi bi-person"></i> <?= htmlspecialchars($data['penulis']) ?></span>
            <span><i class="bi bi-eye"></i> <?= (int)$data['views'] ?> kali dibaca</span>
        </div>
    </div>
</div>

<section class="berita-detail-section">
    <div class="container">
        <div class="berita-detail__wrap">
            <div class="card berita-detail__card">
                <?php if (!empty($data['gambar']) && file_exists('images/' . $data['gambar'])): ?>
                <div class="berita-detail__img">
                    <img src="images/<?= htmlspecialchars($data['gambar']) ?>"
                         alt="<?= htmlspecialchars($data['judul']) ?>"
                         loading="lazy">
                </div>
                <?php endif; ?>

                <div class="berita-detail__content">
                    <?php
                    echo nl2br(htmlspecialchars($data['isi']));
                    ?>
                </div>
            </div>

            <div class="berita-detail__back">
                <a href="berita.php" class="btn btn-outline">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Berita
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.berita-detail-hero { padding: 100px 0 60px; }

.berita-detail__title {
    font-size: clamp(1.4rem, 3vw, 2.2rem);
    margin-top: 16px;
    line-height: 1.3;
}

.berita-detail__meta {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    justify-content: center;
    margin-top: 16px;
    font-size: 0.85rem;
    opacity: 0.85;
}
.berita-detail__meta span {
    display: flex; align-items: center; gap: 6px;
}

.berita-detail-section { padding: 0 0 60px; }

.berita-detail__wrap {
    max-width: 800px;
    margin: 0 auto;
}

.berita-detail__card { padding: 40px; }

.berita-detail__img {
    margin-bottom: 28px;
    border-radius: 16px;
    overflow: hidden;
}
.berita-detail__img img {
    width: 100%; height: auto;
    display: block;
    object-fit: cover;
}

.berita-detail__content {
    color: var(--text-light);
    font-size: 0.95rem;
    line-height: 1.8;
}

.berita-detail__back {
    margin-top: 30px;
    text-align: center;
}

@media (max-width: 600px) {
    .berita-detail__card { padding: 24px 18px; }
}
</style>

<?php require_once 'includes/footer.php'; ?>