<?php
// includes/footer.php
// KOREKSI: link Bootstrap Icons dihapus dari sini karena sudah dipindah ke header.php
//          Memuatnya dua kali (header + footer) adalah duplikasi yang tidak perlu.
?>

<footer>
    <div class="footer-grid">

        <!-- Brand -->
        <div class="footer-brand">
            <div class="footer-logo-row">
                <img src="images/logo-himpunai.jpg" alt="Logo HIMPUNAI">
                <div>
                    <div class="footer-logo-name">Manajemen Informatika</div>
                    <div class="footer-logo-sub">HIMPUNAI &bull; POLSRI</div>
                </div>
            </div>
            <p>
                Program studi vokasi unggulan di bidang teknologi informasi
                Politeknik Negeri Sriwijaya yang berfokus pada inovasi,
                teknologi digital, dan pengembangan mahasiswa.
            </p>
        </div>

        <!-- Navigasi -->
        <div class="footer-col">
            <h4>Navigasi</h4>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="about.php">Profil Jurusan</a></li>
                <li><a href="dosen.php">Data Dosen</a></li>
                <li><a href="mahasiswa.php">Mahasiswa</a></li>
            </ul>
        </div>

        <!-- Informasi -->
        <div class="footer-col">
            <h4>Informasi</h4>
            <ul>
                <li><a href="galeri.php">Galeri Kegiatan</a></li>
                <li><a href="berita.php">Berita &amp; Artikel</a></li>
                <li><a href="kontak.php">Hubungi Kami</a></li>
                <li><a href="https://manajemeninformatika.polsri.ac.id" target="_blank" rel="noopener noreferrer">Website Resmi</a></li>
            </ul>
        </div>

        <!-- Kontak -->
        <div class="footer-col">
            <h4>Kontak</h4>
            <ul>
                <li>
                    <a href="https://maps.google.com/?q=Politeknik+Negeri+Sriwijaya" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-geo-alt-fill"></i>
                        Jl. Sungai Sahang No.3654, Palembang
                    </a>
                </li>
                <li>
                    <a href="tel:+62711353414">
                        <i class="bi bi-telephone-fill"></i>
                        (0711) 353414
                    </a>
                </li>
                <li>
                    <a href="mailto:mi@polsri.ac.id">
                        <i class="bi bi-envelope-fill"></i>
                        mi@polsri.ac.id
                    </a>
                </li>
                <li>
                    <a href="https://manajemeninformatika.polsri.ac.id" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-globe2"></i>
                        mi.polsri.ac.id
                    </a>
                </li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        <span>&copy; <?= date('Y') ?> HIMPUNAI - Manajemen Informatika | Politeknik Negeri Sriwijaya</span>
        <span><i class="bi bi-heart-fill"></i> Dibuat untuk Praktikum Desain &amp; Pemrograman Web</span>
    </div>
</footer>

<!-- Back to top -->
<button id="scrollTop" aria-label="Scroll to top">
    <i class="bi bi-arrow-up"></i>
</button>

<!-- Lightbox -->
<div class="lightbox" id="lightbox">
    <button class="lightbox-close" id="lightboxClose" aria-label="Tutup">
        <i class="bi bi-x-lg"></i>
    </button>
    <img src="" id="lightboxImg" alt="Preview gambar">
</div>

<script src="js/main.js"></script>
</body>
</html>