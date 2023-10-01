-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jun 2023 pada 06.49
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mini_project2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detailkegiatan`
--

CREATE TABLE `detailkegiatan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `namaKegiatan` varchar(100) DEFAULT NULL,
  `tglMulai` date DEFAULT NULL,
  `tglSelesai` date DEFAULT NULL,
  `lvlPenting` enum('biasa','sedang','sangat penting') DEFAULT NULL,
  `durasiKegiatan` time DEFAULT NULL,
  `lokasiKegiatan` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detailkegiatan`
--

INSERT INTO `detailkegiatan` (`id`, `user_id`, `namaKegiatan`, `tglMulai`, `tglSelesai`, `lvlPenting`, `durasiKegiatan`, `lokasiKegiatan`, `gambar`) VALUES
(1, 1, 'Jalan-jalan', '2023-05-20', '2023-05-20', 'biasa', '01:30:00', 'Location 1', 'image1.jpg'),
(2, 1, 'Latihan lomba catur', '2023-05-21', '2023-05-22', 'sedang', '02:00:00', 'Location 2', 'image2.jpg'),
(3, 1, 'Jalan-jalan', '2023-05-23', '2023-05-23', 'biasa', '01:15:00', 'Location 3', 'image3.jpg'),
(4, 1, 'Lomba Catur', '2023-05-24', '2023-05-26', 'sangat penting', '03:30:00', 'Location 4', 'image4.jpg'),
(5, 1, 'Menjenguk orang tua', '2023-05-27', '2023-05-27', 'sedang', '01:45:00', 'Location 5', 'image5.jpg'),
(6, 1, 'Reuni', '2023-06-21', '2023-06-25', 'sedang', '01:00:00', 'Location 7', 'image7.jpg'),
(7, 2, 'Menghadiri pernikahan saudara', '2023-05-27', '2023-05-27', 'sangat penting', '00:45:00', 'Location 6', 'image6.jpg'),
(8, 2, 'awdawd', '2023-05-09', '2023-05-09', 'biasa', '06:34:00', 'wdawdaw', 'img/JADWAL TI.png'),
(9, 2, 'wadaw', '2023-05-09', '2023-05-09', 'sangat penting', '06:47:00', 'awdawd', 'img/Screenshot 2022-10-20 103338.png'),
(10, 2, 'wadaw', '2023-05-09', '2023-05-09', 'sangat penting', '06:47:00', 'awdawd', 'img/Screenshot 2022-10-20 103338.png'),
(13, 2, 'fssfs', '2023-05-03', '2023-05-09', 'sedang', '22:26:00', 'gsgsg', 'img/AutoSave_6fe87_7e61b400_4292c0f.png'),
(26, 2, 'fafaf', '2023-06-07', '2023-06-07', 'sedang', '11:51:00', 'awfafa', 'img/JADWAL TI.png'),
(27, 2, 'fafa', '2023-06-07', '2023-06-07', 'sedang', '13:41:00', 'afafa', 'img/JADWAL TI.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `name`, `password`) VALUES
(1, 'budi', 'budi123'),
(2, 'halo', 'haloges');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detailkegiatan`
--
ALTER TABLE `detailkegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detailkegiatan`
--
ALTER TABLE `detailkegiatan`
  ADD CONSTRAINT `detailkegiatan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
