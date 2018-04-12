

ALTER TABLE `siswa_nilai_raport` ADD `nil_tugas` VARCHAR(5) NOT NULL AFTER `postdate`;

ALTER TABLE `siswa_nilai_raport` ADD `nil_pengetahuan_sangat` LONGTEXT NOT NULL AFTER `nil_tugas`, ADD `nil_pengetahuan_kurang` LONGTEXT NOT NULL AFTER `nil_pengetahuan_sangat`;

ALTER TABLE `siswa_nilai_raport` ADD `nil_praktek_p` VARCHAR(5) NOT NULL AFTER `nil_pengetahuan_kurang`, ADD `nil_praktek_k` VARCHAR(5) NOT NULL AFTER `nil_praktek_p`, ADD `nil_proyek_p` VARCHAR(50) NOT NULL AFTER `nil_praktek_k`, ADD `nil_proyek_k` VARCHAR(5) NOT NULL AFTER `nil_proyek_p`, ADD `nil_folio_p` VARCHAR(5) NOT NULL AFTER `nil_proyek_k`, ADD `nil_folio_k` VARCHAR(5) NOT NULL AFTER `nil_folio_p`;

ALTER TABLE `siswa_nilai_raport` ADD `nil_praktek` VARCHAR(5) NOT NULL AFTER `nil_folio_k`;

ALTER TABLE `siswa_nilai_raport` ADD `nil_sikap_observasi` VARCHAR(5) NOT NULL AFTER `nil_praktek`, ADD `nil_sikap_observasi1` VARCHAR(5) NOT NULL AFTER `nil_sikap_observasi`, ADD `nil_sikap_observasi2` VARCHAR(5) NOT NULL AFTER `nil_sikap_observasi1`, ADD `nil_sikap_observasi3` VARCHAR(5) NOT NULL AFTER `nil_sikap_observasi2`, ADD `nil_sikap_observasi4` VARCHAR(5) NOT NULL AFTER `nil_sikap_observasi3`, ADD `nil_sikap_observasi5` VARCHAR(5) NOT NULL AFTER `nil_sikap_observasi4`, ADD `rata_sikap_a` VARCHAR(5) NOT NULL AFTER `nil_sikap_observasi5`, ADD `rata_sikap_p` VARCHAR(5) NOT NULL AFTER `rata_sikap_a`;

ALTER TABLE `siswa_sikap_dirisendiri` ADD `nilai` VARCHAR(5) NOT NULL AFTER `postdate`;

ALTER TABLE `siswa_sikap_antarteman` ADD `nilai` VARCHAR(5) NOT NULL AFTER `postdate`;
