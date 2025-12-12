-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2025 at 04:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parfum`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `detail_id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `harga_saat_beli` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) GENERATED ALWAYS AS (`jumlah` * `harga_saat_beli`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_aroma`
--

CREATE TABLE `jenis_aroma` (
  `aroma_id` int(11) NOT NULL,
  `nama_aroma` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `metode_id` int(11) NOT NULL,
  `nama_metode` varchar(50) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `pembayaran_id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `metode_id` int(11) DEFAULT NULL,
  `tanggal_pembayaran` datetime DEFAULT NULL,
  `jumlah_dibayar` decimal(12,2) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status_pembayaran` enum('Menunggu','Berhasil','Gagal') DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `pengiriman_id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `alamat_kirim` text NOT NULL,
  `kurir` varchar(50) DEFAULT NULL,
  `nomor_resi` varchar(100) DEFAULT NULL,
  `tanggal_pengiriman` date DEFAULT NULL,
  `perkiraan_tiba` date DEFAULT NULL,
  `status_pengiriman` varchar(50) DEFAULT 'Belum Dikirim',
  `biaya_pengiriman` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk_parfum`
--

CREATE TABLE `produk_parfum` (
  `produk_id` int(11) NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `gambar` varchar(255) DEFAULT NULL,
  `aroma_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transaksi_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal_transaksi` datetime DEFAULT current_timestamp(),
  `total_harga` decimal(12,2) NOT NULL DEFAULT 0.00,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `status_pembayaran` varchar(50) DEFAULT 'Menunggu',
  `status_transaksi` varchar(50) DEFAULT 'Baru',
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `password`, `alamat`, `jenis_kelamin`, `role`) VALUES
(9, 'sugi', 'sugi@gmail.com', '$2y$10$Ku6PUYGylY8yOYGY9tvPcO6Rz6bEumOL4JVsVfgDu0tY6YwkjaE5O', 'cibodas', 'laki-laki', ''),
(11, 'budi', 'budi@gmail.com', '$2y$10$KELQ1RG/W6uxzOToR0jkU.jmcZsgKlIDnCXnNNSc8c2J/i1JWWQuC', 'bandung', 'laki-laki', 'user'),
(12, 'mail', 'mail@gmail.com', '$2y$10$EtMYpt.OhpPtrBOTP58SM.M6OxBMXFbJHbmbq24VwRHc90Vf4MRkO', 'kp.durian runtuh', 'laki-laki', 'user'),
(13, 'Rio ganteng 123', 'riopkbanget@gmail.com', 'rio1122\r\n', 'Cigugur WKWKWK', 'laki-laki', 'admin'),
(15, 'andika', 'Andika1122@gmail.com', 'Andika1122', 'kalimantan', 'laki-laki', 'user'),
(17, 'Andika1144', 'Andika1144@gmail.com', '$2y$10$47Xk486DAlDKK9qHA6z40OpehfYhuFkVUQasDAr2XIAs/cT2Bu35i', 'jakarta', 'laki-laki', 'admin'),
(18, 'Andika1155', 'Andika1155@gmail.com', '$2y$10$QWspUbeQX0bPX6BSNV0vHujmxeH1Y62XqLbCeE9KTX5grqAVYGsV2', 'cibabat', 'laki-laki', 'user'),
(19, 'Andika1166', 'anieshebat11@gmail.com', '$2y$10$Nd5DXt2BXbLpkNSzuYBCyOnUVh07P1Gumd9qTVcu2ojs.7b.IWPju', 'bogor', 'laki-laki', 'user'),
(20, 'raminez', 'raminez@gmail.com', '$2y$10$THvXxUK1HDV4zaIcJZS9NOdhbyD83Vy4o6mDEuho5iqYaGWqOCFTa', 'broklin', 'laki-laki', 'user'),
(21, 'volcom', 'vocom@gmail.com', '$2y$10$UkRfvM4klMUVRK8dQlwKGOMcEC85SRlrHxaNZmkWw3VTFW4kkld5i', 'jakarta', 'laki-laki', 'user'),
(22, 'budi', 'budi@gmail.com', '$2y$10$mLEofS1MoRwnuYzj6pGuoOb6SUXZ59NP95PWF.4.6zRDyIhTsJod2', 'bandung', 'laki-laki', 'user'),
(23, 'mamat', 'mamat45@gmail.com', '$2y$10$/NjWKcDU/qHUgsxEQY7g0ekp85a9ViImQ1L0e/y230l622KMMM31a', 'bandung', 'perempuan', 'user'),
(24, 'hajinuni', 'hajinuni456@gmail.comm', '$2y$10$rZKWzRMRVsJZ9zRYLkbdPOrJk8zMBWcZu8AA3sC5byiy48c2vKJV2', 'cibabat', 'perempuan', 'user'),
(25, 'Andika000', 'Andika00@gmail.com', '$2y$10$jLEjermU9x3TwvvQNPIqKetF9sO4/sC.3Z3t.qf.8WtszxSuR784i', 'jakarta', 'laki-laki', 'user'),
(26, 'kiko', 'kiko@gmail.com', '$2y$10$BH9XzvUvsXQnU1hAQaAvqezT.J4cSO8Nh4OOeZXfN6TMG6.aurO4W', 'kalimantan', 'perempuan', 'user'),
(27, 'budi', 'budi@gmail.com', '$2y$10$XmIXtkzZh775wsYeWZPGpOn2yGB7mayC/w5eKg.Z6wevvZgwxUGqu', 'bandung', 'laki-laki', 'user'),
(28, 'hajinuni', 'budi432@gmail.com', '$2y$10$1JSNa1r.vmhw./y2YBXgL.TiApGauxF2Y.vr/s1Asg2JdmxW7PrYi', 'kalimantan', 'laki-laki', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `fk_detail_transaksi_transaksi` (`transaksi_id`),
  ADD KEY `fk_detail_transaksi_produk` (`produk_id`);

--
-- Indexes for table `jenis_aroma`
--
ALTER TABLE `jenis_aroma`
  ADD PRIMARY KEY (`aroma_id`);

--
-- Indexes for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`metode_id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`pembayaran_id`),
  ADD KEY `fk_pembayaran_transaksi` (`transaksi_id`),
  ADD KEY `fk_pembayaran_metode` (`metode_id`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`pengiriman_id`),
  ADD KEY `fk_pengiriman_transaksi` (`transaksi_id`);

--
-- Indexes for table `produk_parfum`
--
ALTER TABLE `produk_parfum`
  ADD PRIMARY KEY (`produk_id`),
  ADD KEY `fk_produk_aroma` (`aroma_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaksi_id`),
  ADD KEY `fk_transaksi_user` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_aroma`
--
ALTER TABLE `jenis_aroma`
  MODIFY `aroma_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `metode_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `pengiriman_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk_parfum`
--
ALTER TABLE `produk_parfum`
  MODIFY `produk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `transaksi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `fk_detail_transaksi_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk_parfum` (`produk_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_transaksi_transaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`transaksi_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_metode` FOREIGN KEY (`metode_id`) REFERENCES `metode_pembayaran` (`metode_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pembayaran_transaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`transaksi_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `fk_pengiriman_transaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`transaksi_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produk_parfum`
--
ALTER TABLE `produk_parfum`
  ADD CONSTRAINT `fk_produk_aroma` FOREIGN KEY (`aroma_id`) REFERENCES `jenis_aroma` (`aroma_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
