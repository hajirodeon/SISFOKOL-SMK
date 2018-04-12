CREATE TABLE `m_prog_pddkn_deskripsi` (
  `kd` varchar(50) NOT NULL,
  `kd_tapel` varchar(50) NOT NULL,
  `kd_kelas` varchar(50) NOT NULL,
  `kd_prog_pddkn` varchar(50) NOT NULL,
  `kd_smt` varchar(50) NOT NULL,
  `p_isi` longtext NOT NULL,
  `k_isi` longtext NOT NULL,
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

