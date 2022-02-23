-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Feb 2022 pada 04.53
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eraport`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `final_nilai_keterampilan`
--

CREATE TABLE `final_nilai_keterampilan` (
  `id_final_nk` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL,
  `nilai_akhir` int(11) NOT NULL,
  `predikat` varchar(2) NOT NULL,
  `deskripsi` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `final_nilai_keterampilan`
--

INSERT INTO `final_nilai_keterampilan` (`id_final_nk`, `id_siswa`, `id_mapel`, `semester`, `tahun_ajaran`, `nilai_akhir`, `predikat`, `deskripsi`) VALUES
(1, 1, 1, 1, '2021/2022', 85, 'B', 'Yuliyanti baik dalam mempraktikkan ajaran Tri Parartha untuk mencapai keharmonisan, baik dalam mempraktikkan ajaran Tri Parartha untuk mencapai keharmonisan.'),
(4, 2, 1, 1, '2021/2022', 75, 'B', 'Nita Satrini sangat baik dalam mempraktikkan ajaran Tri Parartha untuk mencapai keharmonisan, cukup dalam mencontohkan ajaran Daiwi Sampad dan Asuri Sampad.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `final_nilai_pengetahuan`
--

CREATE TABLE `final_nilai_pengetahuan` (
  `id_final_np` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL,
  `nilai_akhir` int(11) NOT NULL,
  `predikat` varchar(2) NOT NULL,
  `deskripsi` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `final_nilai_pengetahuan`
--

INSERT INTO `final_nilai_pengetahuan` (`id_final_np`, `id_siswa`, `id_mapel`, `semester`, `tahun_ajaran`, `nilai_akhir`, `predikat`, `deskripsi`) VALUES
(7, 2, 2, 1, '2021/2022', 82, 'B', 'Nita Satrini sangat baik dalam menjelaskan makna keberagaman karakteristik individu, baik dalam memahami arti gambar pada lambang negara.'),
(8, 1, 1, 1, '2021/2022', 73, 'C', 'Yuliyanti baik dalam mengenal ajaran Tri Parartha untuk mencapai keharmonisan, cukup dalam mengenal ajaran Daiwi Sampad dan Asuri Sampad.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keterampilan`
--

CREATE TABLE `keterampilan` (
  `id_kt` int(11) NOT NULL,
  `nama_keterampilan` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `keterampilan`
--

INSERT INTO `keterampilan` (`id_kt`, `nama_keterampilan`) VALUES
(1, 'Kinerja (Praktik)'),
(2, 'Kinerja (Produk)'),
(3, 'Proyek');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kompetensi_dasar`
--

CREATE TABLE `kompetensi_dasar` (
  `id_kd` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `kode_kd` varchar(5) NOT NULL,
  `kategori_kd` varchar(25) NOT NULL,
  `deskripsi_kd` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kompetensi_dasar`
--

INSERT INTO `kompetensi_dasar` (`id_kd`, `id_mapel`, `kode_kd`, `kategori_kd`, `deskripsi_kd`) VALUES
(17, 1, '3.1', 'pengetahuan', 'mengenal ajaran Tri Parartha untuk mencapai keharmonisan'),
(18, 1, '3.2', 'pengetahuan', 'mengenal ajaran Daiwi Sampad dan Asuri Sampad'),
(19, 1, '3.3', 'pengetahuan', 'memahami tokoh-tokoh utama Mahabharata '),
(20, 1, '4.1', 'keterampilan', 'mempraktikkan ajaran Tri Parartha untuk mencapai keharmonisan'),
(21, 1, '4.2', 'keterampilan', 'mencontohkan ajaran Daiwi Sampad dan Asuri Sampad'),
(22, 1, '4.3', 'keterampilan', 'menceritakan secara singkat tokoh-tokoh utama Mahabharata'),
(23, 2, '3.1', 'pengetahuan', 'memahami arti gambar pada lambang negara'),
(24, 2, '3.2', 'pengetahuan', 'mengidentifikasi kewajiban dan hak'),
(25, 2, '3.3', 'pengetahuan', 'menjelaskan makna keberagaman karakteristik individu'),
(26, 2, '3.4', 'pengetahuan', 'memahami makna bersatu dalam keberagaman'),
(27, 2, '4.1', 'keterampilan', 'menceritakan arti gambar pada lambang negara'),
(28, 2, '4.2', 'keterampilan', 'menyajikan hasil identifikasi kewajiban dan hak'),
(29, 2, '4.3', 'keterampilan', 'menyajikan makna keberagaman karakteristik individu'),
(30, 2, '4.4', 'keterampilan', 'menyajikan bentuk-bentuk kebersatuan dalam keberagaman'),
(31, 3, '3.1', 'pengetahuan', 'menggali informasi tentang konsep perubahan wujud benda'),
(32, 3, '3.4', 'pengetahuan', 'mencermati kosakata dalam teks tentang konsep makhluk hidup'),
(33, 3, '3.5', 'pengetahuan', 'menggali informasi tentang cara-cara perawatan tumbuhan dan hewan'),
(34, 3, '3.8', 'pengetahuan', 'menguraikan pesan dalam dongeng yang disajikan secara lisan, tulis, dan visual'),
(35, 3, '3.10', 'pengetahuan', 'mencermati ungkapan atau kalimat saran, masukan, dan penyelesaian masalah'),
(36, 3, '4.1', 'keterampilan', 'menyajikan hasil informasi tentang konsep perubahan wujud benda'),
(37, 3, '4.4', 'keterampilan', 'menyajikan laporan tentang konsep makhluk hidup'),
(38, 3, '4.5', 'keterampilan', 'menyajikan hasil wawancara tentang cara-cara perawatan tumbuhan dan hewan'),
(39, 3, '4.8', 'keterampilan', 'memeragakan pesan dalam dongeng sebagai bentuk ungkapan diri'),
(40, 3, '4.10', 'keterampilan', 'memeragakan ungkapan atau kalimat saran, masukan, dan penyelesaian masalah'),
(41, 4, '3.1', 'pengetahuan', 'menjelaskan sifat-sifat operasi hitung pada bilangan cacah'),
(42, 4, '3.2', 'pengetahuan', 'menjelaskan bilangan cacah dan pecahan sederhana'),
(43, 4, '3.3', 'pengetahuan', 'menyatakan suatu bilangan sebagai jumlah, selisih, hasil kali, atau hasil bagi'),
(44, 4, '3.7', 'pengetahuan', 'mendeskripsikan dan menentukan hubungan antar satuan baku'),
(45, 4, '4.1', 'keterampilan', 'menyelesaikan masalah yang melibatkan penggunaan sifat-sifat operasi hitung'),
(46, 4, '4.2', 'keterampilan', 'menggunakan penyajian bilangan cacah dan pecahan sederhanam'),
(47, 4, '4.3', 'keterampilan', 'menilai apakah suatu bilangan dapat dinyatakan sebagai jumlah, selisih, hasil kali, atau hasil bagi'),
(48, 4, '4.7', 'keterampilan', 'menyelesaikan masalah yang berkaitan dengan hubungan antarsatuan baku');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int(11) NOT NULL,
  `nama_mapel` varchar(255) NOT NULL,
  `kkm` int(11) NOT NULL,
  `is_mulok` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `nama_mapel`, `kkm`, `is_mulok`) VALUES
(1, 'Agama Hindu', 75, 0),
(2, 'PPKn', 75, 0),
(3, 'Bahasa Indonesia', 65, 0),
(4, 'Matematika', 60, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_keterampilan`
--

CREATE TABLE `nilai_keterampilan` (
  `id_nk` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_kd` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL,
  `id_kt` int(11) NOT NULL,
  `nilai_kt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `nilai_keterampilan`
--

INSERT INTO `nilai_keterampilan` (`id_nk`, `id_siswa`, `id_mapel`, `id_kd`, `semester`, `tahun_ajaran`, `id_kt`, `nilai_kt`) VALUES
(2, 1, 1, 20, 1, '2021/2022', 1, 90),
(3, 1, 1, 20, 1, '2021/2022', 2, 80),
(10, 2, 1, 20, 1, '2021/2022', 1, 90),
(11, 2, 1, 21, 1, '2021/2022', 1, 60);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_pengetahuan`
--

CREATE TABLE `nilai_pengetahuan` (
  `id_np` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_tema` int(11) DEFAULT NULL,
  `id_kd` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL,
  `is_nph` tinyint(1) DEFAULT NULL,
  `is_npts` tinyint(1) DEFAULT NULL,
  `is_npas` tinyint(1) DEFAULT NULL,
  `nilai_kd` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `nilai_pengetahuan`
--

INSERT INTO `nilai_pengetahuan` (`id_np`, `id_siswa`, `id_mapel`, `id_tema`, `id_kd`, `semester`, `tahun_ajaran`, `is_nph`, `is_npts`, `is_npas`, `nilai_kd`) VALUES
(30, 2, 2, 1, 23, 1, '2021/2022', 1, 0, 0, 75),
(31, 2, 2, 4, 24, 1, '2021/2022', 1, 0, 0, 80),
(32, 2, 2, 1, 25, 1, '2021/2022', 1, 0, 0, 90),
(33, 1, 1, 0, 17, 1, '2021/2022', 1, 0, 0, 85),
(34, 1, 1, 0, 18, 1, '2021/2022', 1, 0, 0, 60);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sekolah`
--

CREATE TABLE `sekolah` (
  `id_sekolah` int(11) NOT NULL,
  `nama_sekolah` varchar(255) NOT NULL,
  `telp` varchar(255) NOT NULL,
  `alamat` varchar(500) NOT NULL,
  `kelurahan` varchar(255) NOT NULL,
  `kecamatan` varchar(255) NOT NULL,
  `kabupaten` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sekolah`
--

INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `telp`, `alamat`, `kelurahan`, `kecamatan`, `kabupaten`, `provinsi`, `logo`) VALUES
(1, 'SD Negeri 3 Panji', '036142453', 'Banjar Dinas Dangin Pura, Desa Panji, Kecamatan Sukasada, Buleleng', 'Panji', 'Sukasada', 'Buleleng', 'Bali', 'sdn3panji.jpg'),
(2, 'SD Negeri 4 Kemenuh', '036123443', 'Jl. Ir. Soetami, Kemenuh', 'Kemenuh', 'Sukawati', 'Gianyar', 'Bali', 'sdn4kemenuh.jpg'),
(3, 'SD Negeri 1 Mengwi', '03615456', 'Jl. Mengwi, No.1', 'Mengwi', 'Mengwi', 'Badung', 'Bali', 'sdn1mengwi.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sikap_sosial`
--

CREATE TABLE `sikap_sosial` (
  `id_sosial` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `semester` int(2) NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL,
  `jujur` varchar(255) NOT NULL,
  `disiplin` varchar(255) NOT NULL,
  `tanggung_jawab` varchar(255) NOT NULL,
  `santun` varchar(255) NOT NULL,
  `peduli` varchar(255) NOT NULL,
  `percaya_diri` varchar(255) NOT NULL,
  `deskripsi` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sikap_sosial`
--

INSERT INTO `sikap_sosial` (`id_sosial`, `id_siswa`, `semester`, `tahun_ajaran`, `jujur`, `disiplin`, `tanggung_jawab`, `santun`, `peduli`, `percaya_diri`, `deskripsi`) VALUES
(4, 1, 1, '2021/2022', 'B', 'B', 'B', 'B', 'B', 'B', 'Yuliyanti baik dalam jujur, disiplin, tanggung jawab, santun, peduli, percaya diri.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sikap_spiritual`
--

CREATE TABLE `sikap_spiritual` (
  `id_spiritual` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `semester` int(2) NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL,
  `ketaatan_beribadah` varchar(255) NOT NULL,
  `berprilaku_bersyukur` varchar(255) NOT NULL,
  `berdoa` varchar(255) NOT NULL,
  `toleransi` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sikap_spiritual`
--

INSERT INTO `sikap_spiritual` (`id_spiritual`, `id_siswa`, `semester`, `tahun_ajaran`, `ketaatan_beribadah`, `berprilaku_bersyukur`, `berdoa`, `toleransi`, `deskripsi`) VALUES
(11, 1, 1, '2021/2022', 'B', 'B', 'B', 'B', 'Yuliyanti baik dalam ketaatan beribadah, berprilaku bersyukur, berdoa sebelum dan sesudah melakukan kegiatan, toleransi beribadah.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nis` varchar(100) NOT NULL,
  `nisn` varchar(100) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `nama_panggilan` varchar(100) NOT NULL,
  `ttl` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL,
  `agama` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `kelas` int(2) NOT NULL,
  `semester` int(2) NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `id_sekolah`, `username`, `password`, `nis`, `nisn`, `nama_siswa`, `nama_panggilan`, `ttl`, `jenis_kelamin`, `agama`, `alamat`, `kelas`, `semester`, `tahun_ajaran`) VALUES
(1, 1, '1580', '1580', '1580', '3139405467', 'Desak Ketut Yuliyanti', 'Yuliyanti', 'Buleleng, 01 Juli 2013', 'Perempuan', 'Hindu', 'Banjar Dinas Dauh Pura', 3, 1, '2021/2022'),
(2, 1, '1581', '1581', '1581', '3111472670', 'Desak Nita Satrini', 'Nita Satrini', 'Buleleng, 18 Mei 2011', 'Perempuan', 'Hindu', 'Banjar Dinas Mandul', 3, 1, '2021/2022'),
(3, 1, '1582', '1582', '1582', '0137038460', 'Gede Rama Wikantara', 'Rama Wikantara', 'Panji, 03 Juli 2013', 'Laki-laki', 'Hindu', 'Banjar Dinas Dauh Pura', 3, 1, '2021/2022'),
(4, 2, '1583', '1583', '1583', '3126494235', 'Gusti Ayu Kadek Astini', 'Astini', 'Panji, 30 Maret 2012', 'Perempuan', 'Hindu', 'Banjar Dinas Dangin Pura', 3, 1, '2021/2022'),
(5, 2, '1584', '1584', '1584', '0124898194', 'Gusti Ayu Novita Dewi', 'Novita Dewi', 'Panji, 12 Noveber 2012', 'Perempuan', 'Hindu', 'Banjar Dinas Dangin Pura', 3, 1, '2021/2022'),
(6, 2, '1585', '1585', '1585', '0129845091', 'Gusti Ayu Putu Abdi Ningsih', 'Abdi Ningsih', 'Singaraja, 25 Oktober 2012', 'Laki-laki', 'Hindu', 'Banjar Dinas Dauh Pura', 3, 1, '2021/2022'),
(7, 3, '1586', '1586', '1586', '3138299792', 'Gusti Ketut Adi Yoga', 'Adi Yoga', 'Buleleng, 07 Juli 2013', 'Laki-laki', 'Hindu', 'Banjar Dinas Dauh Pura', 3, 1, '2021/2022'),
(8, 3, '1587', '1587', '1587', '3125645397', 'Gusti Ketut Alit Sudiadnyana', 'Alit Sudiadnyana', 'Panji, 07 Desember 2012', 'Laki-laki', 'Hindu', 'Banjar Dinas Dangin Pura', 3, 1, '2021/2022'),
(9, 3, '1588', '1588', '1588', '0134394398', 'Gusti Ketut Nakula Prasetya', 'Nakula Prasetya', 'Singaraja, 05 Januari 2013', 'Laki-laki', 'Hindu', 'Banjar Dinas Dauh Pura', 3, 1, '2021/2022');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tema`
--

CREATE TABLE `tema` (
  `id_tema` int(11) NOT NULL,
  `nama_tema` varchar(100) NOT NULL,
  `is_nph` tinyint(1) DEFAULT NULL,
  `is_npts` tinyint(1) DEFAULT NULL,
  `is_npas` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tema`
--

INSERT INTO `tema` (`id_tema`, `nama_tema`, `is_nph`, `is_npts`, `is_npas`) VALUES
(1, 'TEMA 1', 1, 1, 1),
(2, 'TEMA 2', 1, 1, 1),
(3, 'TEMA 3', 1, 0, 1),
(4, 'TEMA 4', 1, 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tema_mapel`
--

CREATE TABLE `tema_mapel` (
  `id_tm` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_tema` int(11) NOT NULL,
  `id_kd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tema_mapel`
--

INSERT INTO `tema_mapel` (`id_tm`, `id_mapel`, `id_tema`, `id_kd`) VALUES
(14, 2, 1, 23),
(15, 2, 1, 25),
(16, 2, 1, 26),
(17, 2, 2, 23),
(18, 2, 2, 25),
(19, 2, 3, 23),
(20, 2, 3, 25),
(21, 2, 3, 26),
(22, 2, 4, 24),
(23, 3, 1, 32),
(24, 3, 2, 34),
(25, 3, 2, 33),
(26, 3, 3, 31),
(27, 3, 4, 35),
(28, 4, 1, 41),
(29, 4, 2, 41),
(30, 4, 2, 42),
(31, 4, 3, 44),
(32, 4, 4, 43);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `id_sekolah` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `id_sekolah`, `email`, `username`, `password`, `firstname`, `lastname`, `role`) VALUES
(1, 1, 'admin@gmail.com', 'admin', 'admin', 'admin', 'admin', 'admin'),
(2, 1, 'aldy@gmail.com', 'aldyoka', 'aldyoka', 'Aldy', 'Oka', 'guru'),
(3, 3, 'yuli@gmail.com', 'yulicahyani', 'yalicahyani', 'yuli', 'cahyani', 'guru'),
(4, 2, 'arisurya@gmail.com', 'arisurya', 'arisurya', 'Kadek Ari', 'Surya', 'guru');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `final_nilai_keterampilan`
--
ALTER TABLE `final_nilai_keterampilan`
  ADD PRIMARY KEY (`id_final_nk`),
  ADD KEY `Final_nilai_keterampilan_fk0` (`id_siswa`),
  ADD KEY `Final_nilai_keterampilan_fk1` (`id_mapel`);

--
-- Indeks untuk tabel `final_nilai_pengetahuan`
--
ALTER TABLE `final_nilai_pengetahuan`
  ADD PRIMARY KEY (`id_final_np`),
  ADD KEY `Final_nilai_pengetahuan_fk0` (`id_siswa`),
  ADD KEY `Final_nilai_pengetahuan_fk1` (`id_mapel`);

--
-- Indeks untuk tabel `keterampilan`
--
ALTER TABLE `keterampilan`
  ADD PRIMARY KEY (`id_kt`);

--
-- Indeks untuk tabel `kompetensi_dasar`
--
ALTER TABLE `kompetensi_dasar`
  ADD PRIMARY KEY (`id_kd`),
  ADD KEY `Kompetensi_dasar_fk1` (`id_mapel`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indeks untuk tabel `nilai_keterampilan`
--
ALTER TABLE `nilai_keterampilan`
  ADD PRIMARY KEY (`id_nk`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_kd` (`id_kd`),
  ADD KEY `id_kt` (`id_kt`);

--
-- Indeks untuk tabel `nilai_pengetahuan`
--
ALTER TABLE `nilai_pengetahuan`
  ADD PRIMARY KEY (`id_np`),
  ADD KEY `Nilai_pengetahuan_fk0` (`id_siswa`),
  ADD KEY `Nilai_pengetahuan_fk1` (`id_mapel`);

--
-- Indeks untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id_sekolah`);

--
-- Indeks untuk tabel `sikap_sosial`
--
ALTER TABLE `sikap_sosial`
  ADD PRIMARY KEY (`id_sosial`),
  ADD KEY `Sikap_sosial_fk0` (`id_siswa`);

--
-- Indeks untuk tabel `sikap_spiritual`
--
ALTER TABLE `sikap_spiritual`
  ADD PRIMARY KEY (`id_spiritual`),
  ADD KEY `Sikap_spiritual_fk0` (`id_siswa`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `siswa_fk0` (`id_sekolah`);

--
-- Indeks untuk tabel `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`id_tema`);

--
-- Indeks untuk tabel `tema_mapel`
--
ALTER TABLE `tema_mapel`
  ADD PRIMARY KEY (`id_tm`),
  ADD KEY `Tema_mapel_fk0` (`id_mapel`),
  ADD KEY `id_kd` (`id_kd`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `User_fk0` (`id_sekolah`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `final_nilai_keterampilan`
--
ALTER TABLE `final_nilai_keterampilan`
  MODIFY `id_final_nk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `final_nilai_pengetahuan`
--
ALTER TABLE `final_nilai_pengetahuan`
  MODIFY `id_final_np` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `keterampilan`
--
ALTER TABLE `keterampilan`
  MODIFY `id_kt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kompetensi_dasar`
--
ALTER TABLE `kompetensi_dasar`
  MODIFY `id_kd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `nilai_keterampilan`
--
ALTER TABLE `nilai_keterampilan`
  MODIFY `id_nk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `nilai_pengetahuan`
--
ALTER TABLE `nilai_pengetahuan`
  MODIFY `id_np` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id_sekolah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `sikap_sosial`
--
ALTER TABLE `sikap_sosial`
  MODIFY `id_sosial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `sikap_spiritual`
--
ALTER TABLE `sikap_spiritual`
  MODIFY `id_spiritual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tema`
--
ALTER TABLE `tema`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tema_mapel`
--
ALTER TABLE `tema_mapel`
  MODIFY `id_tm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `final_nilai_keterampilan`
--
ALTER TABLE `final_nilai_keterampilan`
  ADD CONSTRAINT `Final_nilai_keterampilan_fk0` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`),
  ADD CONSTRAINT `Final_nilai_keterampilan_fk1` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`);

--
-- Ketidakleluasaan untuk tabel `final_nilai_pengetahuan`
--
ALTER TABLE `final_nilai_pengetahuan`
  ADD CONSTRAINT `Final_nilai_pengetahuan_fk0` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`),
  ADD CONSTRAINT `Final_nilai_pengetahuan_fk1` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`);

--
-- Ketidakleluasaan untuk tabel `kompetensi_dasar`
--
ALTER TABLE `kompetensi_dasar`
  ADD CONSTRAINT `Kompetensi_dasar_fk1` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`);

--
-- Ketidakleluasaan untuk tabel `nilai_keterampilan`
--
ALTER TABLE `nilai_keterampilan`
  ADD CONSTRAINT `nilai_keterampilan_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`),
  ADD CONSTRAINT `nilai_keterampilan_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`),
  ADD CONSTRAINT `nilai_keterampilan_ibfk_3` FOREIGN KEY (`id_kt`) REFERENCES `keterampilan` (`id_kt`),
  ADD CONSTRAINT `nilai_keterampilan_ibfk_4` FOREIGN KEY (`id_kd`) REFERENCES `kompetensi_dasar` (`id_kd`);

--
-- Ketidakleluasaan untuk tabel `nilai_pengetahuan`
--
ALTER TABLE `nilai_pengetahuan`
  ADD CONSTRAINT `Nilai_pengetahuan_fk0` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`),
  ADD CONSTRAINT `Nilai_pengetahuan_fk1` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`);

--
-- Ketidakleluasaan untuk tabel `sikap_sosial`
--
ALTER TABLE `sikap_sosial`
  ADD CONSTRAINT `Sikap_sosial_fk0` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`);

--
-- Ketidakleluasaan untuk tabel `sikap_spiritual`
--
ALTER TABLE `sikap_spiritual`
  ADD CONSTRAINT `Sikap_spiritual_fk0` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`);

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_fk0` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`);

--
-- Ketidakleluasaan untuk tabel `tema_mapel`
--
ALTER TABLE `tema_mapel`
  ADD CONSTRAINT `Tema_mapel_fk0` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`),
  ADD CONSTRAINT `tema_mapel_ibfk_1` FOREIGN KEY (`id_kd`) REFERENCES `kompetensi_dasar` (`id_kd`),
  ADD CONSTRAINT `tema_mapel_ibfk_2` FOREIGN KEY (`id_tema`) REFERENCES `tema` (`id_tema`);

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `User_fk0` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
