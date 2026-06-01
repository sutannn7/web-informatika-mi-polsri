<?php
$page_title = 'Profil Jurusan';
require_once 'includes/db.php';
require_once 'includes/header.php';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- PAGE HERO -->
<div class="page-hero profil-hero">
    <div class="profil-hero__bg-pattern"></div>
    <div class="container profil-hero__inner">
        <div class="profil-hero__badge">
            <i class="bi bi-building"></i>
            <span>Politeknik Negeri Sriwijaya</span>
        </div>
        <h1 class="profil-hero__title">Profil Jurusan</h1>
        <p class="profil-hero__sub">Manajemen Informatika — Politeknik Negeri Sriwijaya</p>
        <div class="breadcrumb">
            <a href="index.php">Home</a> <span>›</span> <span>Profil Jurusan</span>
        </div>
    </div>
</div>

<section class="profil-section">
    <div class="container">
        <div class="profile-grid">

            <!-- ===== SIDEBAR KIRI ===== -->
            <div class="profile-sidebar">
                <div class="info-card">
                    <div class="info-card__logo-wrap">
                        <img src="images/logo-himpunai.jpg" alt="Logo HIMPUNAI">
                    </div>
                    <h3>Manajemen Informatika</h3>
                    <p>Politeknik Negeri Sriwijaya</p>
                    <div class="akreditasi">
                        <span class="badge badge--unggul"><i class="bi bi-patch-check-fill"></i> Unggul</span>
                        <span class="badge badge--banpt">BAN-PT</span>
                    </div>
                    <div class="info-rows">
                        <div class="info-row">
                            <div class="info-icon"><i class="bi bi-calendar3"></i></div>
                            <div class="info-text">Tahun Berdiri: <strong>2014</strong></div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><i class="bi bi-mortarboard"></i></div>
                            <div class="info-text">Jenjang: <strong>D4 / Sarjana Terapan</strong></div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><i class="bi bi-people"></i></div>
                            <div class="info-text">Mahasiswa: <strong>390+</strong></div>
                        </div>
                        <div class="info-row info-row--last">
                            <div class="info-icon"><i class="bi bi-person-workspace"></i></div>
                            <div class="info-text">Dosen: <strong>84+</strong></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== KONTEN UTAMA KANAN ===== -->
            <div class="profile-content">

                <!-- Quote Ketua Jurusan -->
                <div class="quote-card">
                    <div class="quote-card__mark">"</div>
                    <p>Kami percaya teknologi bukan sekadar alat, tapi jalan untuk menciptakan perubahan yang berarti—dan itulah yang kami tanamkan di Manajemen Informatika Polsri.</p>
                    <div class="quote-author">
                        Sony Oktapriandi, S.Kom., M.Kom.
                        <span>Ketua Jurusan Manajemen Informatika</span>
                    </div>
                </div>

                <!-- Sejarah -->
                <div class="section-title">
                    <i class="bi bi-clock-history"></i> Sejarah Jurusan
                </div>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-year">2014</div>
                        <div class="timeline-body">
                            <div class="timeline-dot"></div>
                            <div class="timeline-text">Pendirian Program Studi Manajemen Informatika sebagai respons terhadap kebutuhan tenaga ahli TI di Sumatera Selatan.</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-year">2018</div>
                        <div class="timeline-body">
                            <div class="timeline-dot"></div>
                            <div class="timeline-text">Akreditasi B dari BAN-PT, peningkatan fasilitas laboratorium komputer.</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-year">2022</div>
                        <div class="timeline-body">
                            <div class="timeline-dot"></div>
                            <div class="timeline-text">Meraih akreditasi UNGGUL, kerja sama dengan industri nasional dan internasional.</div>
                        </div>
                    </div>
                    <div class="timeline-item timeline-item--last">
                        <div class="timeline-year">2024</div>
                        <div class="timeline-body">
                            <div class="timeline-dot"></div>
                            <div class="timeline-text">Visi internasional: menjadi program studi vokasi terkemuka di bidang Manajemen Informatika.</div>
                        </div>
                    </div>
                </div>

                <!-- Visi & Misi -->
                <div class="visi-misi-grid">
                    <div class="visi-card">
                        <div class="vm-icon"><i class="bi bi-bullseye"></i></div>
                        <h3>Visi</h3>
                        <p>Pada tahun 2024 menjadi penyelenggara pendidikan vokasi yang unggul dan terkemuka di bidang Manajemen Informatika berstandar internasional.</p>
                    </div>
                    <div class="misi-card">
                        <div class="vm-icon"><i class="bi bi-diagram-3"></i></div>
                        <h3>Misi</h3>
                        <ul>
                            <li>Pendidikan vokasi berbasis outcome yang diakui internasional</li>
                            <li>Penelitian terapan dan kolaborasi internasional</li>
                            <li>Program magang dan pertukaran pelajar ke industri luar negeri</li>
                            <li>Inovasi dan kewirausahaan digital dengan inkubator global</li>
                        </ul>
                    </div>
                </div>

                <!-- Akreditasi & Struktur Organisasi -->
                <div class="info-grid">
                    <div class="info-block">
                        <div class="info-block__icon"><i class="bi bi-award"></i></div>
                        <h3>Akreditasi</h3>
                        <div class="info-block__rows">
                            <p><strong>UNGGUL</strong> — BAN-PT</p>
                            <p>Nomor SK: 1234/SK/BAN-PT/Akred/D4/XII/2024</p>
                            <p>Berlaku: 2024 – 2029</p>
                        </div>
                    </div>
                    <div class="info-block">
                        <div class="info-block__icon"><i class="bi bi-diagram-2"></i></div>
                        <h3>Struktur Organisasi</h3>
                        <ul>
                            <li><strong>Ketua Jurusan:</strong> Sony Oktapriandi, S.Kom., M.Kom.</li>
                            <li><strong>Sekretaris Jurusan:</strong> —</li>
                            <li><strong>Kepala Lab Komputer:</strong> —</li>
                            <li><strong>Koordinator Kemahasiswaan:</strong> —</li>
                        </ul>
                    </div>
                </div>

                <!-- Kompetensi Lulusan -->
                <div class="kompetensi">
                    <h3><i class="bi bi-cpu"></i> Kompetensi Lulusan</h3>
                    <div class="kompetensi-grid">
                        <div class="kompetensi-item"><i class="bi bi-globe2"></i><span>Web Development</span></div>
                        <div class="kompetensi-item"><i class="bi bi-bar-chart"></i><span>Data Analytics</span></div>
                        <div class="kompetensi-item"><i class="bi bi-shield-lock"></i><span>Cyber Security</span></div>
                        <div class="kompetensi-item"><i class="bi bi-cloud"></i><span>Cloud Computing</span></div>
                        <div class="kompetensi-item"><i class="bi bi-cpu"></i><span>AI & Machine Learning</span></div>
                        <div class="kompetensi-item"><i class="bi bi-phone"></i><span>Mobile Development</span></div>
                    </div>
                </div>

            </div><!-- /.profile-content -->
        </div><!-- /.profile-grid -->
    </div>
</section>

<style>
/* ============================================
   PROFIL PAGE — POLISHED STYLES
   ============================================ */

/* --- Hero --- */
.profil-hero {
    position: relative;
    overflow: hidden;
}
.profil-hero__bg-pattern {
    position: absolute;
    inset: 0;
    background-image:
        radial-gradient(circle at 10% 60%, rgba(255,255,255,0.07) 0%, transparent 50%),
        radial-gradient(circle at 90% 15%, rgba(255,255,255,0.07) 0%, transparent 45%);
    pointer-events: none;
}
.profil-hero__inner { position: relative; z-index: 1; }

.profil-hero__badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    color: #fff;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    padding: 5px 14px;
    border-radius: 30px;
    margin-bottom: 16px;
    backdrop-filter: blur(4px);
}
.profil-hero__title {
    font-size: clamp(2rem, 5vw, 3.2rem);
    font-weight: 800;
    margin-bottom: 10px;
}
.profil-hero__sub {
    font-size: 1rem;
    opacity: 0.85;
    margin-bottom: 20px;
}

/* --- Section wrapper --- */
.profil-section { padding: 60px 0 80px; }

/* --- Two-column layout --- */
.profile-grid {
    display: grid;
    grid-template-columns: 1fr 2.2fr;
    gap: 40px;
    align-items: start;
}

/* ===========================
   SIDEBAR
   =========================== */
.profile-sidebar .info-card {
    background: var(--bg-card);
    border-radius: 24px;
    padding: 28px;
    text-align: center;
    border: 1px solid var(--border);
    position: sticky;
    top: 100px;
}

.info-card__logo-wrap {
    width: 90px;
    height: 90px;
    margin: 0 auto 16px;
    border-radius: 20px;
    overflow: hidden;
    background: var(--bg-elevated);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--border);
}
.info-card__logo-wrap img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 8px;
}

.info-card h3 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 4px;
    color: var(--text-dark);
}
.info-card > p {
    color: var(--text-light);
    font-size: 0.82rem;
    margin-bottom: 18px;
}

.akreditasi {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-bottom: 20px;
}
.badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 12px;
    border-radius: 30px;
    font-size: 0.73rem;
    font-weight: 600;
}
.badge--unggul {
    background: var(--primary-soft);
    color: var(--primary);
}
.badge--banpt {
    background: var(--bg-elevated);
    color: var(--text-muted);
    border: 1px solid var(--border);
}

.info-rows { margin-top: 4px; }

.info-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 0;
    border-bottom: 1px solid var(--border);
    text-align: left;
}
.info-row--last { border-bottom: none; }

.info-icon {
    width: 32px;
    flex-shrink: 0;
    font-size: 1rem;
    color: var(--primary);
    opacity: 0.8;
    text-align: center;
}
.info-text {
    color: var(--text-light);
    font-size: 0.82rem;
    line-height: 1.4;
}
.info-text strong { color: var(--text-dark); }

/* ===========================
   CONTENT RIGHT
   =========================== */

/* Quote */
.quote-card {
    background: linear-gradient(135deg, var(--primary-soft), var(--secondary-soft));
    border-radius: 20px;
    padding: 32px 32px 28px;
    margin-bottom: 44px;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.04);
}
.quote-card__mark {
    position: absolute;
    top: -10px;
    left: 20px;
    font-size: 7rem;
    font-family: 'Playfair Display', serif;
    color: var(--primary);
    opacity: 0.12;
    line-height: 1;
    pointer-events: none;
    user-select: none;
}
.quote-card p {
    font-size: 1rem;
    line-height: 1.7;
    color: var(--text-dark);
    font-style: italic;
    margin-bottom: 18px;
    position: relative;
}
.quote-author {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--primary-dark, var(--primary));
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.quote-author span {
    font-weight: 400;
    font-size: 0.78rem;
    color: var(--text-muted);
}

/* Section title */
.section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.2rem;
    font-weight: 700;
    margin: 0 0 20px;
    color: var(--text-dark);
    font-family: 'Playfair Display', serif;
}
.section-title i { color: var(--primary); font-size: 1.1rem; }

/* Timeline */
.timeline {
    position: relative;
    margin-bottom: 44px;
    padding-left: 4px;
}
.timeline::before {
    content: '';
    position: absolute;
    left: 56px;
    top: 10px;
    bottom: 10px;
    width: 2px;
    background: var(--border);
    border-radius: 2px;
}

.timeline-item {
    display: flex;
    gap: 0;
    margin-bottom: 8px;
}
.timeline-item--last { margin-bottom: 0; }

.timeline-year {
    width: 56px;
    flex-shrink: 0;
    font-weight: 800;
    font-size: 0.82rem;
    color: var(--primary);
    padding-top: 13px;
    text-align: right;
    padding-right: 0;
    letter-spacing: 0.02em;
}

.timeline-body {
    flex: 1;
    display: flex;
    gap: 16px;
    align-items: flex-start;
    padding: 10px 16px;
    background: var(--bg-card);
    border-radius: 14px;
    border: 1px solid var(--border);
    margin-left: 20px;
    position: relative;
    transition: border-color 0.2s;
}
.timeline-body:hover { border-color: var(--primary); }

.timeline-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--primary);
    flex-shrink: 0;
    margin-top: 4px;
    opacity: 0.7;
}
.timeline-text {
    color: var(--text-light);
    font-size: 0.875rem;
    line-height: 1.55;
}

/* Visi & Misi */
.visi-misi-grid {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 24px;
    margin-bottom: 44px;
}
.visi-card, .misi-card {
    background: var(--bg-card);
    border-radius: 20px;
    padding: 26px;
    border: 1px solid var(--border);
    display: flex;
    flex-direction: column;
}
.vm-icon {
    font-size: 1.6rem;
    color: var(--primary);
    margin-bottom: 12px;
    opacity: 0.8;
}
.visi-card h3, .misi-card h3 {
    font-size: 1.05rem;
    font-weight: 700;
    margin-bottom: 12px;
    color: var(--text-dark);
}
.visi-card p {
    color: var(--text-light);
    font-size: 0.875rem;
    line-height: 1.65;
    margin: 0;
}
.misi-card ul {
    padding-left: 18px;
    color: var(--text-light);
    font-size: 0.875rem;
    line-height: 1.65;
    margin: 0;
}
.misi-card li { margin-bottom: 7px; }
.misi-card li:last-child { margin-bottom: 0; }

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 44px;
}
.info-block {
    background: var(--bg-card);
    border-radius: 20px;
    padding: 24px;
    border: 1px solid var(--border);
}
.info-block__icon {
    font-size: 1.6rem;
    color: var(--primary);
    margin-bottom: 12px;
    opacity: 0.8;
}
.info-block h3 {
    font-size: 1.05rem;
    font-weight: 700;
    margin-bottom: 14px;
    color: var(--text-dark);
}
.info-block__rows p {
    color: var(--text-light);
    font-size: 0.83rem;
    line-height: 1.55;
    margin: 0 0 6px;
}
.info-block__rows p:last-child { margin-bottom: 0; }
.info-block ul {
    padding-left: 18px;
    margin: 0;
    color: var(--text-light);
    font-size: 0.83rem;
    line-height: 1.55;
}
.info-block li { margin-bottom: 7px; }
.info-block li:last-child { margin-bottom: 0; }

/* Kompetensi */
.kompetensi {
    background: var(--bg-card);
    border-radius: 20px;
    padding: 28px;
    border: 1px solid var(--border);
}
.kompetensi h3 {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: var(--text-dark);
}
.kompetensi h3 i { color: var(--primary); }
.kompetensi-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}
.kompetensi-item {
    display: flex;
    align-items: center;
    gap: 9px;
    background: var(--primary-soft);
    padding: 11px 14px;
    border-radius: 12px;
    font-size: 0.82rem;
    font-weight: 500;
    color: var(--primary-dark, var(--primary));
    border: 1px solid transparent;
    transition: background 0.2s, color 0.2s, transform 0.2s, border-color 0.2s;
    cursor: default;
}
.kompetensi-item i { font-size: 1rem; flex-shrink: 0; }
.kompetensi-item:hover {
    transform: translateY(-2px);
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
}

/* ===========================
   RESPONSIVE
   =========================== */
@media (max-width: 1024px) {
    .profile-grid {
        grid-template-columns: 1fr;
    }
    .profile-sidebar .info-card {
        position: static;
        max-width: 420px;
        margin: 0 auto;
    }
    .visi-misi-grid { grid-template-columns: 1fr; }
    .info-grid      { grid-template-columns: 1fr; }
}

@media (max-width: 640px) {
    .profil-section      { padding: 40px 0 60px; }
    .kompetensi-grid     { grid-template-columns: repeat(2, 1fr); }
    .timeline::before    { left: 46px; }
    .timeline-year       { width: 46px; font-size: 0.75rem; }
    .quote-card          { padding: 24px 22px 20px; }
}

@media (max-width: 400px) {
    .kompetensi-grid { grid-template-columns: 1fr; }
}
</style>

<?php require_once 'includes/footer.php'; ?>