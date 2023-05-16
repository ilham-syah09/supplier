-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 16, 2023 at 05:10 AM
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
  `gambar` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kodeBarang`, `namaBarang`, `gambar`, `createdAt`, `updatedAt`) VALUES
(1, 'SPR-0001', 'Kursi', 'ac51b414460aef6d0156a3ff9b339c8a.jpg', '2023-04-27 04:30:43', '2023-04-27 04:32:43'),
(3, 'SPR-0002', 'Meja', 'ac51b414460aef6d0156a3ff9b339c8a.jpg', '2023-04-27 04:30:43', '2023-04-27 04:32:43'),
(4, 'SPR-0003', 'Lemari', 'ac51b414460aef6d0156a3ff9b339c8a.jpg', '2023-04-27 04:30:43', '2023-04-27 04:32:43');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idBarang` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `idKhusus` varchar(29) DEFAULT NULL,
  `namaPT` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `nohp` varchar(14) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `idUser`, `idBarang`, `status`, `idKhusus`, `namaPT`, `alamat`, `nohp`, `createdAt`, `updatedAt`) VALUES
(1, 2, 1, 1, '2-20230428132647', 'PT Mencari Sejati Cinta', 'Jl. Facebook No. 1', '123', '2023-04-28 04:08:19', '2023-05-15 07:51:18'),
(2, 2, 1, 1, '2-20230516041133', 'PT Setia Sampai Putus', 'Jl. Facebook No. 2', '085823421234', '2023-05-10 07:36:53', '2023-05-16 02:11:33'),
(3, 2, 4, 1, '2-20230428132647', 'PT Mencari Sejati Cinta', 'Jl. Facebook No. 1', '123', '2023-05-13 13:36:21', '2023-05-15 07:51:20');

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
(1, 2, '2-20230428132647', 'Menunggu', NULL, NULL, '2023-04-28 06:27:46', '2023-05-02 04:27:30'),
(4, 2, '2-20230516041133', 'Menunggu', NULL, NULL, '2023-05-16 02:11:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
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

INSERT INTO `user` (`id`, `name`, `username`, `image`, `password`, `role_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'administrator', 'admin', 'default.png', '$2y$10$ZdZIpysS8TWn8cTr5Awao.nEY4RXnkUYijO1YWhqSUQGgfrRLzFyi', 1, 0, '2023-04-05 16:13:20', NULL),
(2, 'Ilhamsyah', 'ilham123', 'e07de5913f8b9ebfa14e06116b56446f.png', '$2y$10$iJRFBXFNMSEiEM25OfcoqOZyb6WF1aRxRqx2yzMw4fZcDq7b.51p.', 2, 1, '2023-04-05 16:31:14', '2023-05-10 01:06:20'),
(5, 'Syah', 'syah@gmail.com', 'default.png', '$2y$10$iJRFBXFNMSEiEM25OfcoqOZyb6WF1aRxRqx2yzMw4fZcDq7b.51p.', 2, 1, '2023-04-28 03:50:27', '2023-04-28 03:55:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `progres`
--
ALTER TABLE `progres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
