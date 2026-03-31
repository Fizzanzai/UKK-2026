-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Mar 2026 pada 21.47
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_aspirasi_siswa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_aspirasi`
--

CREATE TABLE `tb_aspirasi` (
  `id_aspirasi` int(11) NOT NULL,
  `status` enum('Menunggu','Proses','Selesai') DEFAULT 'Menunggu',
  `id_pelaporan` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_aspirasi`
--

INSERT INTO `tb_aspirasi` (`id_aspirasi`, `status`, `id_pelaporan`, `feedback`) VALUES
(1, 'Selesai', 1, 'belum'),
(2, 'Selesai', 2, 'sudah dibersihkan'),
(3, 'Menunggu', 3, NULL),
(4, 'Selesai', 4, 'Harga sudah disesuaikan'),
(5, 'Proses', 5, 'Sedang pengadaan'),
(6, 'Menunggu', 6, NULL),
(7, 'Selesai', 7, 'Sudah dibeli'),
(8, 'Proses', 8, 'Sedang evaluasi'),
(9, 'Menunggu', 9, NULL),
(10, 'Selesai', 10, 'Sudah diperbaiki'),
(11, 'Menunggu', 11, 'malas'),
(12, 'Selesai', 12, 'malas'),
(14, 'Menunggu', 16, NULL),
(15, 'Menunggu', 17, NULL),
(16, 'Selesai', 18, ''),
(17, 'Menunggu', 19, NULL),
(19, 'Menunggu', 21, NULL),
(20, 'Proses', 22, 'bentar'),
(22, 'Selesai', 24, 'Sudah diperbaiki\r\n'),
(23, 'Selesai', 25, 'selesai'),
(24, 'Menunggu', 26, NULL),
(29, 'Selesai', 31, 'sudHH'),
(31, 'Menunggu', 33, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_input_aspirasi`
--

CREATE TABLE `tb_input_aspirasi` (
  `id_pelaporan` int(11) NOT NULL,
  `nis` int(11) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `lokasi` varchar(50) DEFAULT NULL,
  `ket` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_input_aspirasi`
--

INSERT INTO `tb_input_aspirasi` (`id_pelaporan`, `nis`, `id_kategori`, `lokasi`, `ket`, `created_at`) VALUES
(4, 1004, 4, 'Kantin', 'Harga mahal', '2026-03-02 10:25:02'),
(5, 1005, 5, 'Perpus', 'Buku kurang lengkap', '2026-03-02 10:25:02'),
(7, 1007, 7, 'Lapangan', 'Alat kurang', '2026-03-02 10:25:02'),
(9, 1009, 9, 'Parkiran', 'Sempit', '2026-03-02 10:25:02'),
(10, 1010, 10, 'Umum', 'Perlu perbaikan', '2026-03-02 10:25:02'),
(16, 1001, 11, 'lab', 'jorok', '2026-03-03 10:35:05'),
(17, 1004, 9, 'lab', 'rame', '2026-03-04 12:09:18'),
(18, 1020, 9, 'belakang', 'berantakan parkiran nya woii', '2026-03-05 12:47:46'),
(19, 1010, 4, 'belakang', 'makanan kurang enak', '2026-03-10 12:02:41'),
(21, 1020, 9, 'belakang', 'ada seng yang lepas', '2026-03-28 22:57:27'),
(24, 1092, 5, 'tempat duduk di sofa', 'meja rusak', '2026-03-29 02:01:53'),
(31, 1001, 21, '1', '1', '2026-03-30 00:24:45'),
(33, 1003, 4, 'wc laki di dekat kantin', 'ada siswa merokok', '2026-03-30 00:40:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kategori` int(11) NOT NULL,
  `ket_kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kategori`, `ket_kategori`) VALUES
(2, 'Kebersihan'),
(4, 'Kantin'),
(5, 'Perpustakaan'),
(6, 'Keamanan'),
(7, 'Ekstrakurikuler'),
(9, 'Parkiran'),
(10, 'Lainnya'),
(11, 'Lab RPS 1'),
(12, 'Lab RPS 2'),
(19, 'Fasilitas'),
(21, 'WC');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `nis` int(11) NOT NULL,
  `kelas` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_siswa`
--

INSERT INTO `tb_siswa` (`nis`, `kelas`) VALUES
(1001, 'XII-RPL-1'),
(1002, 'XII-RPL-2'),
(1003, 'XII-RPL-3'),
(1004, 'XII-RPL-4'),
(1005, 'XII-RPL-5'),
(1006, 'XII-RPL-6'),
(1007, 'XII-RPL-7'),
(1008, 'XII-RPL-8'),
(1009, 'XII-RPL-9'),
(1010, 'XII-RPL-10'),
(1020, 'XII-TKJ-1'),
(1029, 'XII-RPL-1'),
(1032, 'XII-TJA-4'),
(1040, 'XII-TJA-3'),
(1044, 'XII-PF-1'),
(1045, 'XII-PF-2'),
(1088, 'XII-PF-2'),
(1092, 'XII-TJA-3'),
(1111, 'XII-PF-1'),
(1112, 'XII-TJA-3');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `tb_aspirasi`
--
ALTER TABLE `tb_aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`);

--
-- Indeks untuk tabel `tb_input_aspirasi`
--
ALTER TABLE `tb_input_aspirasi`
  ADD PRIMARY KEY (`id_pelaporan`);

--
-- Indeks untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`nis`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_aspirasi`
--
ALTER TABLE `tb_aspirasi`
  MODIFY `id_aspirasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `tb_input_aspirasi`
--
ALTER TABLE `tb_input_aspirasi`
  MODIFY `id_pelaporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
