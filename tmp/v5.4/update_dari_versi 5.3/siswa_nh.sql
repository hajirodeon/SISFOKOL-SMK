CREATE TABLE `siswa_nh` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `kd_siswa_kelas` varchar(50) NOT NULL DEFAULT '',
  `kd_smt` varchar(50) NOT NULL DEFAULT '',
  `kd_prog_pddkn` varchar(50) NOT NULL,
  `nilkd` varchar(15) NOT NULL DEFAULT '',
  `nilai` char(3) NOT NULL DEFAULT '0',
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
