-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 13, 2023 at 06:16 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_supplier`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kodeBarang` varchar(8) NOT NULL,
  `namaBarang` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(5) NOT NULL,
  `gambar` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kodeBarang`, `namaBarang`, `deskripsi`, `harga`, `stok`, `gambar`, `createdAt`, `updatedAt`) VALUES
(1, 'SPR-0001', 'Kursi', 'Ini adalah deskripsi', 100000, 10, 'ac51b414460aef6d0156a3ff9b339c8a.jpg', '2023-04-27 04:30:43', '2023-07-13 03:01:22'),
(3, 'SPR-0002', 'Meja', 'Ini deskripsi lagi', 350000, 7, 'ac51b414460aef6d0156a3ff9b339c8a.jpg', '2023-04-27 04:30:43', '2023-07-13 03:01:48'),
(4, 'SPR-0003', 'Lemari', 'Ini juga deskripsi', 2800000, 5, 'ac51b414460aef6d0156a3ff9b339c8a.jpg', '2023-04-27 04:30:43', '2023-07-13 03:01:33');

-- --------------------------------------------------------

--
-- Table structure for table `ongkir`
--

CREATE TABLE `ongkir` (
  `id` int(11) NOT NULL,
  `kota` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ongkir`
--

INSERT INTO `ongkir` (`id`, `kota`, `harga`, `createdAt`, `updatedAt`) VALUES
(1, 'Tegal', 20000, '2023-07-13 02:19:50', NULL),
(2, 'Brebes', 30000, '2023-07-13 02:20:37', '2023-07-13 02:21:09');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idBarang` int(11) NOT NULL,
  `jumlah` int(3) NOT NULL DEFAULT 1,
  `totalBiaya` int(11) DEFAULT NULL,
  `idRekening` int(11) DEFAULT NULL,
  `idOngkir` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `idKhusus` varchar(29) DEFAULT NULL,
  `namaPT` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `nohp` varchar(14) NOT NULL,
  `bukti` text DEFAULT NULL,
  `statusPembayaran` int(1) NOT NULL DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `idUser`, `idBarang`, `jumlah`, `totalBiaya`, `idRekening`, `idOngkir`, `status`, `idKhusus`, `namaPT`, `alamat`, `nohp`, `bukti`, `statusPembayaran`, `createdAt`, `updatedAt`) VALUES
(1, 2, 1, 2, 930000, 2, 2, 1, '2-20230713053658', 'PT Setia Sampai Putus', 'Tegal', '123454321232', '1aa5b8bff7c4cb791029f64c223c12ba.jpg', 1, '2023-07-13 03:04:58', '2023-07-13 04:11:18'),
(2, 2, 3, 2, 930000, 2, 2, 1, '2-20230713053658', 'PT Setia Sampai Putus', 'Tegal', '123454321232', '1aa5b8bff7c4cb791029f64c223c12ba.jpg', 1, '2023-07-13 03:05:00', '2023-07-13 04:11:18');

-- --------------------------------------------------------

--
-- Table structure for table `progres`
--

CREATE TABLE `progres` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idKhusus` varchar(29) NOT NULL,
  `status` varchar(30) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `progres`
--

INSERT INTO `progres` (`id`, `idUser`, `idKhusus`, `status`, `tanggal`, `ket`, `createdAt`, `updateAt`) VALUES
(2, 2, '2-20230713053658', 'Menunggu', '2023-07-13', NULL, '2023-07-13 04:11:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rekening`
--

CREATE TABLE `rekening` (
  `id` int(11) NOT NULL,
  `namaBank` varchar(50) NOT NULL,
  `noRek` varchar(50) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rekening`
--

INSERT INTO `rekening` (`id`, `namaBank`, `noRek`, `createdAt`, `updatedAt`) VALUES
(1, 'BRI', '12345678', '2023-07-13 02:11:33', NULL),
(2, 'BNI', '87654321', '2023-07-13 02:13:30', NULL),
(4, 'BCA', '13254768', '2023-07-13 02:14:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `noHp` varchar(14) DEFAULT NULL,
  `ktp` text DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `image` varchar(50) NOT NULL DEFAULT 'default.png',
  `password` varchar(100) NOT NULL,
  `role_id` int(1) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `noHp`, `ktp`, `alamat`, `image`, `password`, `role_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'administrator', 'admin', NULL, NULL, NULL, 'default.png', '$2y$10$ZdZIpysS8TWn8cTr5Awao.nEY4RXnkUYijO1YWhqSUQGgfrRLzFyi', 1, 0, '2023-04-05 16:13:20', NULL),
(2, 'Ilhamsyah', 'ilham123', '123454321232', 'e435ab776651ede5955a407be2a3b8b4.jpg', 'Tegal', 'e07de5913f8b9ebfa14e06116b56446f.png', '$2y$10$iJRFBXFNMSEiEM25OfcoqOZyb6WF1aRxRqx2yzMw4fZcDq7b.51p.', 2, 1, '2023-04-05 16:31:14', '2023-07-13 02:54:01'),
(5, 'Syah', 'syah@gmail.com', NULL, NULL, NULL, 'default.png', '$2y$10$iJRFBXFNMSEiEM25OfcoqOZyb6WF1aRxRqx2yzMw4fZcDq7b.51p.', 2, 1, '2023-04-28 03:50:27', '2023-04-28 03:55:59'),
(15, 'Dalban', 'dalban@gmail.com', '081232123454', '5be1ac84035217de396c228039658233.jpg', 'Jl. Dalban', 'default.png', '$2y$10$P6DgUdqf2iTAMkNSohVaZ..xt/MdBtLjItqNbXIO3XJfOxS1iHq6O', 2, 1, '2023-07-13 02:48:28', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ongkir`
--
ALTER TABLE `ongkir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `progres`
--
ALTER TABLE `progres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ongkir`
--
ALTER TABLE `ongkir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `progres`
--
ALTER TABLE `progres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rekening`
--
ALTER TABLE `rekening`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
