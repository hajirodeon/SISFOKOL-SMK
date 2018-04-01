CREATE TABLE IF NOT EXISTS `guru_rpp` (
  `kd` varchar(50) NOT NULL,
  `kd_guru_prog_pddkn` varchar(50) NOT NULL,
  `kd_smt` varchar(50) NOT NULL,
  `isi` longtext NOT NULL,
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `guru_silabus` (
  `kd` varchar(50) NOT NULL,
  `kd_guru_prog_pddkn` varchar(50) NOT NULL,
  `kd_smt` varchar(50) NOT NULL,
  `isi` longtext NOT NULL,
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `m_prog_pddkn_deskripsi` (
  `kd` varchar(50) NOT NULL,
  `kd_tapel` varchar(50) NOT NULL,
  `kd_kelas` varchar(50) NOT NULL,
  `kd_prog_pddkn` varchar(50) NOT NULL,
  `kd_smt` varchar(50) NOT NULL,
  `p_isi` longtext NOT NULL,
  `k_isi` longtext NOT NULL,
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




CREATE TABLE IF NOT EXISTS `siswa_nh` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `kd_siswa_kelas` varchar(50) NOT NULL DEFAULT '',
  `kd_smt` varchar(50) NOT NULL DEFAULT '',
  `kd_prog_pddkn` varchar(50) NOT NULL,
  `nilkd` varchar(15) NOT NULL DEFAULT '',
  `nilai` char(3) NOT NULL DEFAULT '0',
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `siswa_tugas` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `kd_siswa_kelas` varchar(50) NOT NULL DEFAULT '',
  `kd_smt` varchar(50) NOT NULL DEFAULT '',
  `kd_prog_pddkn` varchar(50) NOT NULL,
  `nilkd` varchar(15) NOT NULL DEFAULT '',
  `nilai` char(3) NOT NULL DEFAULT '0',
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





ALTER TABLE `siswa_nilai_raport` ADD `nil_tugas` VARCHAR( 5 ) NOT NULL;


ALTER TABLE `siswa_nilai_raport` ADD `nil_pengetahuan_sangat` LONGTEXT NOT NULL ,
ADD `nil_pengetahuan_kurang` LONGTEXT NOT NULL;




CREATE TABLE IF NOT EXISTS `siswa_folio` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `kd_siswa_kelas` varchar(50) NOT NULL DEFAULT '',
  `kd_smt` varchar(50) NOT NULL DEFAULT '',
  `kd_prog_pddkn` varchar(50) NOT NULL,
  `nilkd` varchar(15) NOT NULL DEFAULT '',
  `nilai` char(3) NOT NULL DEFAULT '0',
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `siswa_praktek` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `kd_siswa_kelas` varchar(50) NOT NULL DEFAULT '',
  `kd_smt` varchar(50) NOT NULL DEFAULT '',
  `kd_prog_pddkn` varchar(50) NOT NULL,
  `nilkd` varchar(15) NOT NULL DEFAULT '',
  `nilai` char(3) NOT NULL DEFAULT '0',
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




CREATE TABLE IF NOT EXISTS `siswa_proyek` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `kd_siswa_kelas` varchar(50) NOT NULL DEFAULT '',
  `kd_smt` varchar(50) NOT NULL DEFAULT '',
  `kd_prog_pddkn` varchar(50) NOT NULL,
  `nilkd` varchar(15) NOT NULL DEFAULT '',
  `nilai` char(3) NOT NULL DEFAULT '0',
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

 


ALTER TABLE `siswa_nilai_raport` ADD `nil_praktek_p` VARCHAR( 5 ) NOT NULL ,
ADD `nil_folio_p` VARCHAR( 5 ) NOT NULL ,
ADD `nil_proyek_p` VARCHAR( 5 ) NOT NULL ,
ADD `nil_praktek_k` LONGTEXT NOT NULL ,
ADD `nil_folio_k` LONGTEXT NOT NULL ,
ADD `nil_proyek_k` LONGTEXT NOT NULL ;



ALTER TABLE `siswa_nilai_raport` ADD `nil_praktek` VARCHAR( 5 ) NOT NULL ;




CREATE TABLE IF NOT EXISTS `siswa_observasi` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `kd_siswa_kelas` varchar(50) NOT NULL DEFAULT '',
  `kd_smt` varchar(50) NOT NULL DEFAULT '',
  `kd_prog_pddkn` varchar(50) NOT NULL,
  `nilkd` varchar(15) NOT NULL DEFAULT '',
  `nilai` char(3) NOT NULL DEFAULT '0',
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



ALTER TABLE `siswa_sikap_antarteman` ADD `nilai` VARCHAR( 5 ) NOT NULL ;



ALTER TABLE `siswa_sikap_dirisendiri` ADD `nilai` VARCHAR( 5 ) NOT NULL ;


ALTER TABLE `siswa_sikap_observasi` ADD `nilai` VARCHAR( 5 ) NOT NULL ;


ALTER TABLE `siswa_nilai_raport` ADD `nil_sikap_observasi` VARCHAR( 5 ) NOT NULL ,
ADD `nil_sikap_observasi1` VARCHAR( 5 ) NOT NULL ,
ADD `nil_sikap_observasi2` VARCHAR( 5 ) NOT NULL ,
ADD `nil_sikap_observasi3` VARCHAR( 5 ) NOT NULL ,
ADD `nil_sikap_observasi4` VARCHAR( 5 ) NOT NULL ,
ADD `rata_sikap_a` VARCHAR( 5 ) NOT NULL ,
ADD `rata_sikap_p` VARCHAR( 5 ) NOT NULL ;




ALTER TABLE `jadwal` ADD `postdate` DATETIME NOT NULL ;


ALTER TABLE `jadwal` ADD `kd_ruang1` VARCHAR( 50 ) NOT NULL ,
ADD `kd_ruang2` VARCHAR( 50 ) NOT NULL ;


