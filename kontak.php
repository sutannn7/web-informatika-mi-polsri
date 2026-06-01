<?php
$page_title = 'Hubungi Kami';
require_once 'includes/db.php';
require_once 'includes/header.php';

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // KOREKSI: ambil raw input dulu, lalu validasi, baru escape saat insert
    // Urutan sebelumnya: escape dulu lalu validasi — menyebabkan validasi strlen
    // bekerja pada string yang sudah di-escape (bisa meleset untuk input dengan karakter khusus)
    $nama   = trim($_POST['nama']   ?? '');
    $email  = trim($_POST['email']  ?? '');
    $subjek = trim($_POST['subjek'] ?? '');
    $pesan  = trim($_POST['pesan']  ?? '');

    if (strlen($nama) < 3) {
        $error = 'Nama minimal 3 karakter.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email tidak valid.';
    } elseif (strlen($pesan) < 10) {
        $error = 'Pesan minimal 10 karakter.';
    } else {
        // KOREKSI: gunakan prepared statement, bukan string interpolation
        // Query sebelumnya: INSERT ... VALUES ('$nama','$email',...) — rentan SQL injection
        $stmt = mysqli_prepare($conn, "INSERT INTO pesan_kontak (nama, email, subjek, pesan) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssss', $nama, $email, $subjek, $pesan);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $success = 'Pesan berhasil dikirim! Kami akan merespon segera.';
        // KOREKSI: reset POST agar form kosong setelah kirim
        $nama = $email = $subjek = $pesan = '';
    }
}
?>

<div class="page-hero">
    <div class="container">
        <h1>Hubungi Kami</h1>
        <p>Kami siap membantu Anda</p>
        <div class="breadcrumb">
            <a href="index.php">Home</a> <span>›</span> <span>Kontak</span>
        </div>
    </div>
</div>

<section>
    <div class="container">
        <div class="kontak-grid">
            <!-- Info Kontak -->
            <div class="kontak-info">
                <div class="section-tag">
                    <i class="bi bi-telephone-fill"></i> Kontak
                </div>
                <h2>Mari Terhubung</h2>
                <p>Ada pertanyaan? Kami senang mendengar dari Anda. Kirim pesan atau kunjungi kami.</p>

                <div class="info-list">
                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div class="info-detail">
                            <strong>Alamat</strong>
                            <span>Jl. Sungai Sahang No.3654, Lorok Pakjo<br>Kec. Ilir Bar. I, Kota Palembang<br>Sumatera Selatan 30151</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div class="info-detail">
                            <strong>Telepon</strong>
                            <span>(0711) 353414</span>
                            <span class="small">WhatsApp: 0812-0000-0000</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div class="info-detail">
                            <strong>Email</strong>
                            <span>mi@polsri.ac.id</span>
                            <span class="small">info.mi@polsri.ac.id</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-clock-fill"></i></div>
                        <div class="info-detail">
                            <strong>Jam Operasional</strong>
                            <span>Senin &ndash; Jumat: 08.00 &ndash; 16.00 WIB</span>
                        </div>
                    </div>
                </div>

                <!-- KOREKSI: tag <a> sebelumnya broken — ada duplikat atribut target dan class di luar tag -->
                <a href="https://www.google.com/maps/place/Manajemen+informatika+D4+POLITEKNIK+NEGERI+SRIWIJAYA/@-2.979557,104.7285566,17z"
                   target="_blank" rel="noopener noreferrer" class="map-link">
                    <i class="bi bi-map"></i>
                    Buka di Google Maps
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Form Kontak -->
            <div class="kontak-form">
                <div class="form-card">
                    <h3>Kirim Pesan</h3>

                    <?php if ($success): ?>
                        <!-- KOREKSI: sebelumnya $success di-echo sebagai PHP string literal, bukan HTML -->
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill"></i>
                            <?= htmlspecialchars($success) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="alert alert-error">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" id="kontakForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap *</label>
                                <input type="text" id="nama" name="nama"
                                       placeholder="Masukkan nama Anda"
                                       value="<?= htmlspecialchars($nama ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email"
                                       placeholder="email@anda.com"
                                       value="<?= htmlspecialchars($email ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subjek">Subjek</label>
                            <input type="text" id="subjek" name="subjek"
                                   placeholder="Topik pesan Anda"
                                   value="<?= htmlspecialchars($subjek ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="pesan">Pesan *</label>
                            <textarea id="pesan" name="pesan" rows="5"
                                      placeholder="Tulis pesan Anda di sini..." required><?= htmlspecialchars($pesan ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send-fill"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Peta -->
        <div class="map-container">
            <div class="section-header">
                <div class="section-tag">
                    <i class="bi bi-geo-alt-fill"></i> Lokasi
                </div>
                <h2>Temukan Kami</h2>
            </div>
            <div class="map-wrapper">
                <!-- KOREKSI: tambahkan title pada iframe untuk aksesibilitas -->
                <iframe
                    title="Lokasi Manajemen Informatika D4 POLSRI"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.2994924995437!2d104.7285566!3d-2.979557!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b75eb0503a7c3%3A0x28ea9ddd3efd54fd!2sManajemen%20informatika%20D4%20POLITEKNIK%20NEGERI%20SRIWIJAYA!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                    width="100%" height="350" style="border:0; border-radius:20px;"
                    allowfullscreen loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>

<style>
.kontak-grid {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 40px;
    margin-bottom: 60px;
}
.kontak-info {
    background: var(--bg-card);
    border-radius: 24px;
    padding: 32px;
    border: 1px solid var(--border);
}
.kontak-info h2 {
    font-size: 1.8rem;
    margin: 16px 0 12px;
    color: var(--text-dark);
    font-family: 'Playfair Display', serif;
}
.kontak-info > p { color: var(--text-light); margin-bottom: 28px; }

.info-list { display: flex; flex-direction: column; gap: 24px; margin-bottom: 32px; }
.info-item { display: flex; gap: 16px; align-items: flex-start; }
.info-icon {
    width: 48px; height: 48px;
    background: var(--primary-soft);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; color: var(--primary);
    flex-shrink: 0;
}
.info-detail { flex: 1; }
.info-detail strong { display: block; color: var(--text-dark); font-size: 0.9rem; margin-bottom: 4px; }
.info-detail span  { display: block; color: var(--text-light); font-size: 0.85rem; line-height: 1.4; }
.info-detail .small { font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; }

.map-link {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--primary-soft); color: var(--primary);
    padding: 12px 20px; border-radius: 40px;
    text-decoration: none; font-weight: 500;
    transition: var(--transition);
}
.map-link:hover { background: var(--primary); color: white; }

.kontak-form .form-card {
    background: var(--bg-card);
    border-radius: 24px; padding: 32px;
    border: 1px solid var(--border);
}
.kontak-form h3 {
    font-size: 1.5rem; margin-bottom: 24px;
    color: var(--text-dark); font-family: 'Playfair Display', serif;
}
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.form-group { margin-bottom: 20px; }
.form-group label {
    display: block; margin-bottom: 8px;
    font-weight: 500; font-size: 0.85rem; color: var(--text-light);
}
.form-group input,
.form-group textarea {
    width: 100%; padding: 12px 16px;
    border: 1px solid var(--border); border-radius: 16px;
    background: var(--bg); color: var(--text);
    font-family: inherit; transition: var(--transition);
    box-sizing: border-box;
}
.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-soft);
}
.map-container { margin-top: 20px; }
.map-wrapper {
    border-radius: 24px; overflow: hidden;
    border: 1px solid var(--border);
    background: var(--bg-card); padding: 10px;
}
@media (max-width: 992px) {
    .kontak-grid { grid-template-columns: 1fr; }
    .form-row    { grid-template-columns: 1fr; }
}
</style>

<?php require_once 'includes/footer.php'; ?>