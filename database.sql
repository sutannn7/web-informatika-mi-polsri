-- ============================================
-- DATABASE: db_mi_polsri
-- Manajemen Informatika D4 - POLSRI
-- ============================================

CREATE DATABASE IF NOT EXISTS db_mi_polsri;
USE db_mi_polsri;

-- Tabel dosen
CREATE TABLE IF NOT EXISTS dosen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nidn VARCHAR(20),
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(100),
    gelar_depan VARCHAR(50),
    gelar_belakang VARCHAR(50),
    bidang_keahlian VARCHAR(200),
    email VARCHAR(100),
    urutan INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO dosen (nidn, nama, jabatan, gelar_depan, gelar_belakang, bidang_keahlian, email, urutan) VALUES
('0020108602', 'Sony Oktapriandi', 'Ketua Jurusan', '', 'S.Kom., M.Kom.', 'Manajemen Proyek TI', 'sony.oktapriandi@polsri.ac.id', 1);

-- Tabel mahasiswa
CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) UNIQUE,
    nama VARCHAR(100) NOT NULL,
    angkatan INT,
    prestasi TEXT,
    kegiatan TEXT,
    organisasi TEXT,
    ipk DECIMAL(3,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel galeri
CREATE TABLE IF NOT EXISTS galeri (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    deskripsi TEXT,
    kategori ENUM('kegiatan','seminar','workshop','lainnya') DEFAULT 'kegiatan',
    foto VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel berita
CREATE TABLE IF NOT EXISTS berita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    isi LONGTEXT NOT NULL,
    excerpt VARCHAR(300),
    kategori VARCHAR(50),
    penulis VARCHAR(100),
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO berita (judul, slug, isi, excerpt, kategori, penulis) VALUES
('Selamat Datang Mahasiswa Baru MI POLSRI', 'selamat-datang-maba', '<p>Selamat datang kepada mahasiswa baru Manajemen Informatika D4 POLSRI tahun akademik 2025/2026.</p>', 'Selamat datang mahasiswa baru.', 'Akademik', 'Admin');

-- Tabel pesan_kontak
CREATE TABLE IF NOT EXISTS pesan_kontak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subjek VARCHAR(200),
    pesan TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel settings
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    key_name VARCHAR(100) UNIQUE NOT NULL,
    value TEXT
);

INSERT INTO settings (key_name, value) VALUES
('site_name', 'Manajemen Informatika D4 POLSRI'),
('site_email', 'mi@polsri.ac.id'),
('site_phone', '(0711) 353414'),
('site_address', 'Jl. Sungai Sahang No.3654, Palembang');

SELECT 'Database db_mi_polsri berhasil dibuat!' AS Status;

-- ============================================
-- TAMBAHAN TABEL UNTUK INDEX.PHP
-- ============================================

-- Tabel statistik
CREATE TABLE IF NOT EXISTS statistik (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(100) NOT NULL,
    nilai VARCHAR(50) NOT NULL,
    ikon VARCHAR(10),
    urutan INT DEFAULT 0
);

INSERT INTO statistik (label, nilai, ikon, urutan) VALUES
('Dosen Profesional', '20+', '👨‍🏫', 1),
('Mahasiswa Aktif', '500+', '👨‍🎓', 2),
('Mata Kuliah', '15+', '📚', 3),
('Mitra Industri', '30+', '🤝', 4);

-- Tabel keunggulan
CREATE TABLE IF NOT EXISTS keunggulan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    deskripsi TEXT,
    ikon VARCHAR(10),
    urutan INT DEFAULT 0
);

INSERT INTO keunggulan (judul, deskripsi, ikon, urutan) VALUES
('Kurikulum berbasis industri', 'Kurikulum selalu diperbarui sesuai kebutuhan industri dan teknologi terkini.', '📖', 1),
('Dosen berpengalaman', 'Dosen berasal dari praktisi profesional dan akademisi berpengalaman.', '👨‍🏫', 2),
('Fasilitas laboratorium modern', 'Lab komputer dengan spesifikasi tinggi untuk praktikum.', '💻', 3),
('Kesempatan magang', 'Magang di perusahaan ternama nasional dan internasional.', '🌐', 4);

-- Tambah kolom ke tabel berita
ALTER TABLE berita ADD COLUMN status ENUM('draft','published') DEFAULT 'published';
ALTER TABLE berita ADD COLUMN gambar VARCHAR(255) NULL;
ALTER TABLE berita ADD COLUMN views INT DEFAULT 0;

-- Update data berita yang sudah ada menjadi published
UPDATE berita SET status = 'published';

