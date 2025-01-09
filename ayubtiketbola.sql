-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 09, 2025 at 04:39 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ayubtiketbola`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_event`
--

CREATE TABLE `tb_event` (
  `id_event` int NOT NULL,
  `nama_event` varchar(255) NOT NULL,
  `tanggal_event` date NOT NULL,
  `waktu_event` time NOT NULL,
  `lokasi_event` text NOT NULL,
  `deskripsi_event` text NOT NULL,
  `gambar_event` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_event`
--

INSERT INTO `tb_event` (`id_event`, `nama_event`, `tanggal_event`, `waktu_event`, `lokasi_event`, `deskripsi_event`, `gambar_event`) VALUES
(3, 'SPAIN VS CROATIA', '2024-12-15', '10:31:00', 'Stadion GBK', 'Saksikan Pertandingan ini!!!', '675a2f0ac8527.jpg'),
(5, 'SENEGAL VS SERBIA', '2024-12-16', '02:37:00', 'Stadion GBK', 'Saksikan Segera!!', '675a2f727f8c4.jpg'),
(6, 'SOUTH KOREA VS NETHERLANDS', '2024-12-16', '10:45:00', 'Stadion GBK', 'Jangan Lupa Untuk Saksikan !!', '675a2fad304c4.jpg'),
(7, 'PORTUGAL VS SERBIA', '2024-12-20', '05:35:00', 'Stadion GBK', 'Jangan lupa untuk menyaksikan!!!', '675a2fef71837.jpg'),
(8, 'NETHERLANDS VS PORTUGAL', '2024-12-26', '12:36:00', 'Stadion GBK', 'Saksikan dan ramaikan!!', '675a30317b6c3.jpg'),
(9, 'NETHERLANDS VS SERBIA', '2024-12-28', '10:38:00', 'Stadion GBK', 'Jangan sampai ketinggalan ', '675a30c148fb1.jpg'),
(10, 'PORTUGAL VS SENEGAL', '2025-01-01', '05:40:00', 'Stadion GBK', 'Ramaikan ', '675a3127d40d3.jpg'),
(11, 'CROATIA VS SERBIA', '2025-01-02', '20:41:00', 'Stadion GBK', 'Saksikan Pertandingannya !!', '675a315a9c7ca.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id_pembayaran` int NOT NULL,
  `id_pemesanan` int NOT NULL,
  `metode_pembayaran` varchar(255) NOT NULL,
  `bukti_pembayaran` varchar(255) NOT NULL,
  `status_pembayaran` varchar(255) NOT NULL,
  `tanggal_pembayaran` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`id_pembayaran`, `id_pemesanan`, `metode_pembayaran`, `bukti_pembayaran`, `status_pembayaran`, `tanggal_pembayaran`) VALUES
(10, 7, 'BNI', 'akun git.png', 'Sukses', '2024-12-18 10:24:32'),
(11, 8, 'BRI', 'clustering-1.png', 'Sukses', '2024-12-18 10:42:28'),
(14, 10, 'BRI', 'akun git.png', 'Sukses', '2024-12-18 11:13:11'),
(16, 12, 'BRI', 'akun git.png', 'Sukses', '2024-12-18 18:16:52'),
(17, 11, 'DANA', 'duku.jpg', 'Sukses', '2024-12-26 00:26:36');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pemesanan`
--

CREATE TABLE `tb_pemesanan` (
  `id_pemesanan` int NOT NULL,
  `id_user` int NOT NULL,
  `id_tiket` int NOT NULL,
  `jumlah_tiket` int NOT NULL,
  `total_harga` double NOT NULL,
  `status_pemesanan` varchar(255) NOT NULL,
  `tanggal_pemesanan` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_pemesanan`
--

INSERT INTO `tb_pemesanan` (`id_pemesanan`, `id_user`, `id_tiket`, `jumlah_tiket`, `total_harga`, `status_pemesanan`, `tanggal_pemesanan`) VALUES
(7, 2, 8, 1, 100000, 'Diterima', '2024-12-18 18:00:00'),
(8, 2, 9, 4, 300000, 'Diterima', '2024-12-18 18:40:00'),
(10, 3, 9, 1, 75000, 'Diterima', '2024-12-18 19:05:00'),
(11, 3, 9, 1, 75000, 'Diterima', '2024-12-18 19:15:00'),
(12, 2, 9, 1, 75000, 'Diterima', '2024-12-19 02:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tiket`
--

CREATE TABLE `tb_tiket` (
  `id_tiket` int NOT NULL,
  `id_event` int NOT NULL,
  `kategori_tiket` varchar(255) NOT NULL,
  `harga_tiket` int NOT NULL,
  `stok_tiket` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_tiket`
--

INSERT INTO `tb_tiket` (`id_tiket`, `id_event`, `kategori_tiket`, `harga_tiket`, `stok_tiket`) VALUES
(6, 3, 'Ekonomi', 50000, 3),
(8, 7, 'VVIP', 100000, 5),
(9, 8, 'VIP', 75000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama`, `email`, `password`, `no_hp`, `alamat`, `role`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$refn8NZZPeo0JsI46MEIIuqRv7/UDFj857ns/ZhGuxg47mI/rbAcy', '081262210147', 'Sukaria 13', 'admin'),
(2, 'ayub', 'ayub@gmail.com', '$2y$10$j0pIyPR.xl6zSZJO0Bn13OQfWd38Uvgy2pgqLN3h9lMeFPjHiO77u', '082512345678', 'Cendrawasi', 'user'),
(3, 'Muh Abdul Rozzaq', 'oca@gmail.com', '$2y$10$pyegl8y6FDmu58vxqybLDu1mBoLFHGOM5GjFs0KmYNK/ZrE69a8D6', '085255015464', 'Jalan Ir Suekarno No 97', 'user'),
(4, 'oca', 'ocatampan@gmail.com', '$2y$10$Pknkp0gYht9VIarFSPCH6u6RJ99nYWp5.woLgqVlqrsVsM6FskC2y', '09887788909', 'Unaaha', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_event`
--
ALTER TABLE `tb_event`
  ADD PRIMARY KEY (`id_event`);

--
-- Indexes for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `tb_pembayaran_ibfk_1` (`id_pemesanan`);

--
-- Indexes for table `tb_pemesanan`
--
ALTER TABLE `tb_pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `tb_pemesanan_ibfk_2` (`id_user`),
  ADD KEY `id_tiket` (`id_tiket`);

--
-- Indexes for table `tb_tiket`
--
ALTER TABLE `tb_tiket`
  ADD PRIMARY KEY (`id_tiket`),
  ADD KEY `tb_tiket_ibfk_1` (`id_event`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_event`
--
ALTER TABLE `tb_event`
  MODIFY `id_event` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  MODIFY `id_pembayaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tb_pemesanan`
--
ALTER TABLE `tb_pemesanan`
  MODIFY `id_pemesanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_tiket`
--
ALTER TABLE `tb_tiket`
  MODIFY `id_tiket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD CONSTRAINT `tb_pembayaran_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `tb_pemesanan` (`id_pemesanan`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `tb_pemesanan`
--
ALTER TABLE `tb_pemesanan`
  ADD CONSTRAINT `tb_pemesanan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `tb_pemesanan_ibfk_3` FOREIGN KEY (`id_tiket`) REFERENCES `tb_tiket` (`id_tiket`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tb_tiket`
--
ALTER TABLE `tb_tiket`
  ADD CONSTRAINT `tb_tiket_ibfk_1` FOREIGN KEY (`id_event`) REFERENCES `tb_event` (`id_event`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
