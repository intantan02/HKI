-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2025 at 05:58 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `website hki`
--

-- --------------------------------------------------------

--
-- Table structure for table `data pribadi dosen`
--

CREATE TABLE `data pribadi dosen` (
  `Nama` varchar(30) NOT NULL,
  `Alamat` varchar(1000) NOT NULL,
  `Kode Pos` int(5) NOT NULL,
  `Nomer Telepon` int(16) NOT NULL,
  `Program Studi` varchar(100) NOT NULL,
  `Fakultas` varchar(100) NOT NULL,
  `Alamat E-mail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `data pribadi mahasiswa`
--

CREATE TABLE `data pribadi mahasiswa` (
  `Nama` varchar(30) NOT NULL,
  `Alamat` varchar(1000) NOT NULL,
  `Kode Pos` int(5) NOT NULL,
  `Nomer Telepon` int(16) NOT NULL,
  `Program Studi` varchar(100) NOT NULL,
  `Fakultas` varchar(100) NOT NULL,
  `Alamat E-mail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `Username` varchar(30) NOT NULL,
  `Password` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
