-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 27 Jan 2016 pada 23.51
-- Versi Server: 10.1.9-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urip_smk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_kurikulum`
--

CREATE TABLE `m_kurikulum` (
  `kd` varchar(50) NOT NULL,
  `no` varchar(1) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `aktif` enum('true','false') NOT NULL DEFAULT 'false'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_kurikulum`
--

INSERT INTO `m_kurikulum` (`kd`, `no`, `nama`, `aktif`) VALUES
('c4ca4238a0b923820dcc509a6f75849b', '1', 'KTSP', 'true'),
('c81e728d9d4c2f636f067f89cc14862c', '2', 'Kurikulum 2013', 'false');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
