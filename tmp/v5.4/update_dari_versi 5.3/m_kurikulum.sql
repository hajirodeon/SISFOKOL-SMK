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
('c4ca4238a0b923820dcc509a6f75849b', '1', 'KTSP', 'false'),
('c81e728d9d4c2f636f067f89cc14862c', '2', 'Kurikulum 2013', 'true');
