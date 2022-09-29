-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2022 at 12:12 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epayschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id_akun` bigint(15) NOT NULL,
  `id_level` int(3) NOT NULL,
  `email` varchar(25) NOT NULL,
  `passwd` varchar(25) NOT NULL,
  `waktu_dibuat` date NOT NULL,
  `status` varchar(25) DEFAULT NULL,
  `logged_in` datetime DEFAULT NULL,
  `logged_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id_akun`, `id_level`, `email`, `passwd`, `waktu_dibuat`, `status`, `logged_in`, `logged_out`) VALUES
(1, 1, 'admin@gmail', '1', '2021-06-08', 'offline', '2021-07-27 03:12:56', '2021-07-27 10:52:52'),
(1900119990210, 2, 'moh.@samsul', '12345@', '2021-06-16', 'offline', '2021-07-27 03:12:32', '2021-07-27 03:12:49'),
(1901219990210, 2, 'abdi@arkananta', '12345@', '2021-06-09', 'offline', '2021-07-26 09:44:57', '2021-07-26 10:03:29'),
(1901819990210, 2, 'anung@style', '12345@', '2021-06-14', 'offline', '2021-06-14 07:27:39', '2021-06-14 07:31:56');

-- --------------------------------------------------------

--
-- Table structure for table `data_admin`
--

CREATE TABLE `data_admin` (
  `nis` bigint(15) NOT NULL,
  `id_akun` bigint(15) DEFAULT NULL,
  `nama` varchar(25) NOT NULL,
  `jenis_kelamin` enum('laki','perempuan') NOT NULL,
  `waktu_masuk` date NOT NULL,
  `ttl` date NOT NULL,
  `alamat` text NOT NULL,
  `kota` varchar(50) NOT NULL,
  `no_hp` bigint(20) DEFAULT NULL,
  `nm_no` varchar(255) NOT NULL,
  `namapic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_admin`
--

INSERT INTO `data_admin` (`nis`, `id_akun`, `nama`, `jenis_kelamin`, `waktu_masuk`, `ttl`, `alamat`, `kota`, `no_hp`, `nm_no`, `namapic`) VALUES
(31300190122, 1, 'ADMIN SISTEM', 'laki', '2019-04-19', '2001-09-19', 'jl lidah wetan Gg.11 No.24 Rt/Rw : 03/06 Kec. lakarsantri', 'Surabaya', 56, '', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `data_siswa`
--

CREATE TABLE `data_siswa` (
  `nis` bigint(15) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_akun` bigint(15) DEFAULT NULL,
  `nama` varchar(25) NOT NULL,
  `semester` enum('gasal','genap') NOT NULL,
  `jenis_kelamin` enum('laki','perempuan') NOT NULL,
  `ttl` date NOT NULL,
  `waktu_masuk` date NOT NULL,
  `kota` varchar(25) NOT NULL,
  `no_hp` bigint(15) NOT NULL,
  `nm_no` varchar(25) NOT NULL,
  `alamat` text NOT NULL,
  `namapic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_siswa`
--

INSERT INTO `data_siswa` (`nis`, `id_kelas`, `id_akun`, `nama`, `semester`, `jenis_kelamin`, `ttl`, `waktu_masuk`, `kota`, `no_hp`, `nm_no`, `alamat`, `namapic`) VALUES
(3130019001, 313007, 1900119990210, 'RIFQI TOFA', 'gasal', 'laki', '1999-02-10', '2019-06-03', 'Surabaya', 85940841456, 'moh.', 'Madura', ''),
(3130019002, 313007, NULL, 'AHMAD RUDI', 'gasal', 'laki', '1999-02-10', '2019-06-03', 'Surabaya', 85815788795, 'ahmad', '', ''),
(3130019012, 313007, 1901219990210, 'FAHRI HAFIDZ', 'gasal', 'laki', '1999-02-10', '2019-06-03', 'Surabaya', 89699964780, 'abdi', 'lidah wetan Gg 11 Rt 3 Rw 6 no 25', '');

-- --------------------------------------------------------

--
-- Table structure for table `ht_tambah_data`
--

CREATE TABLE `ht_tambah_data` (
  `id` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `waktu_upload` datetime NOT NULL,
  `waktu_import` datetime DEFAULT NULL,
  `ukuran_file` int(11) NOT NULL,
  `extention_file` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ht_tambah_data`
--

INSERT INTO `ht_tambah_data` (`id`, `nama_file`, `waktu_upload`, `waktu_import`, `ukuran_file`, `extention_file`) VALUES
(1, 'CobaImportData.xlsx', '2021-07-23 20:08:11', NULL, 9162, 'xlsx');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(3) NOT NULL,
  `kelas` varchar(15) NOT NULL,
  `sub_kelas` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `kelas`, `sub_kelas`) VALUES
(0, 'alumni', ''),
(313007, '7', ''),
(313008, '8', ''),
(313009, '9', '');

-- --------------------------------------------------------

--
-- Table structure for table `level_user`
--

CREATE TABLE `level_user` (
  `id_level` int(3) NOT NULL,
  `nm_akses` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `level_user`
--

INSERT INTO `level_user` (`id_level`, `nm_akses`) VALUES
(0, 'alumni'),
(1, 'admin'),
(2, 'siswa');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id_msg` bigint(20) NOT NULL,
  `from_user` varchar(255) NOT NULL,
  `nis_from` bigint(20) NOT NULL,
  `to_user` varchar(255) NOT NULL,
  `nis_to` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `baca` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id_msg`, `from_user`, `nis_from`, `to_user`, `nis_to`, `message`, `baca`) VALUES
(1157, 'ABDI ARKANANTA', 31300190122, 'AHMAD FAIRUZABADI', 3130019002, 'selamat datang fairus', '0'),
(1701, 'ABDI ARKANANTA', 31300190122, 'ABDI ARKANANTA SATYA SANC', 3130019012, 'selamat datang abdi\r\n', '1'),
(2264, 'ABDI ARKANANTA', 31300190122, 'ABDI ARKANANTA SATYA SANC', 3130019012, 'selamat datang abdi', '0'),
(2631, 'ABDI ARKANANTA', 31300190122, 'ABDI ARKANANTA SATYA SANC', 3130019012, 'selamat datang abdi', '0'),
(4994, 'ABDI ARKANANTA', 31300190122, 'all', 0, 'hallo semuanya siswa ', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` bigint(15) NOT NULL,
  `id_transaksi` varchar(50) DEFAULT NULL,
  `nis` bigint(15) NOT NULL,
  `nm_tagihan` varchar(50) NOT NULL,
  `nominal` decimal(10,2) NOT NULL,
  `waktu_dibuat` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `id_transaksi`, `nis`, `nm_tagihan`, `nominal`, `waktu_dibuat`) VALUES
(19001129, '19001129', 3130019001, 'SPP', '200000.00', '2022-09-30 00:00:00'),
(19001162, '19001162', 3130019001, 'Buku', '50000.00', '2022-09-30 00:00:00'),
(19001179, '19001179', 3130019001, 'SPP', '1000.00', '2021-07-12 00:00:00'),
(19002108, '19002108', 3130019002, 'SPP', '200000.00', '2022-09-30 00:00:00'),
(19002115, '19002115', 3130019002, 'SPP', '150000.00', '2021-07-16 00:00:00'),
(19012105, '19012105', 3130019012, 'SPP', '200000.00', '2022-09-30 00:00:00'),
(19012134, '9bad2b0a-1095-40b6-8b94-185e782f28fe', 3130019012, 'Buku', '50000.00', '2021-08-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(50) NOT NULL,
  `order_id` bigint(25) NOT NULL,
  `nis` bigint(15) NOT NULL,
  `nominal` decimal(10,2) NOT NULL,
  `token` varchar(50) NOT NULL,
  `status_tr` varchar(15) NOT NULL,
  `status_code` varchar(10) NOT NULL,
  `payment_type` varchar(15) NOT NULL,
  `va_number` varchar(50) NOT NULL,
  `bank` varchar(15) NOT NULL,
  `tr_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `order_id`, `nis`, `nominal`, `token`, `status_tr`, `status_code`, `payment_type`, `va_number`, `bank`, `tr_time`) VALUES
('19001129', 19001129, 3130019001, '200000.00', '', 'settlement', '200', 'cash', '', '', '2022-09-28 10:20:27'),
('19001162', 19001162, 3130019001, '50000.00', '', 'settlement', '200', 'cash', '', '', '2022-09-28 10:52:52'),
('19001179', 19001179, 3130019001, '1000.00', '', 'settlement', '200', 'cash', '', '', '2021-07-31 22:09:42'),
('19002108', 19002108, 3130019002, '200000.00', '', 'settlement', '200', 'cash', '', '', '2022-09-28 10:53:38'),
('19002115', 19002115, 3130019002, '150000.00', '', 'settlement', '200', 'cash', '', '', '2021-07-31 22:14:22'),
('19012105', 19012105, 3130019012, '200000.00', '', 'settlement', '200', 'cash', '', '', '2022-09-28 10:21:10'),
('9bad2b0a-1095-40b6-8b94-185e782f28fe', 19012134, 3130019012, '50000.00', '14053ca7-66d9-497c-ac86-c3bf14038faf', 'pending', '201', 'bank_transfer', '70080306347', 'bca', '2021-08-01 03:15:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`),
  ADD KEY `id_level` (`id_level`);

--
-- Indexes for table `data_admin`
--
ALTER TABLE `data_admin`
  ADD PRIMARY KEY (`nis`),
  ADD KEY `id_akun` (`id_akun`);

--
-- Indexes for table `data_siswa`
--
ALTER TABLE `data_siswa`
  ADD PRIMARY KEY (`nis`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_akun` (`id_akun`);

--
-- Indexes for table `ht_tambah_data`
--
ALTER TABLE `ht_tambah_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `level_user`
--
ALTER TABLE `level_user`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_msg`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `nis` (`nis`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `nis` (`nis`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ht_tambah_data`
--
ALTER TABLE `ht_tambah_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akun`
--
ALTER TABLE `akun`
  ADD CONSTRAINT `akun_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level_user` (`id_level`);

--
-- Constraints for table `data_admin`
--
ALTER TABLE `data_admin`
  ADD CONSTRAINT `data_admin_ibfk_1` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id_akun`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `data_siswa`
--
ALTER TABLE `data_siswa`
  ADD CONSTRAINT `data_siswa_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `data_siswa_ibfk_3` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id_akun`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_ibfk_2` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tagihan_ibfk_3` FOREIGN KEY (`nis`) REFERENCES `data_siswa` (`nis`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `data_siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
