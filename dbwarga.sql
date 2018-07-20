/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 10.1.29-MariaDB : Database - dbwarga
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbwarga` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `dbwarga`;

/*Table structure for table `as_disease` */

DROP TABLE IF EXISTS `as_disease`;

CREATE TABLE `as_disease` (
  `disease_id` int(11) DEFAULT NULL,
  `disease_name` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_userid` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `as_disease` */

insert  into `as_disease`(`disease_id`,`disease_name`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(NULL,'Tuberculosis','2018-07-21 01:33:51',1,'0000-00-00 00:00:00',0),
(NULL,'stel','2018-07-21 01:37:23',1,'0000-00-00 00:00:00',0);

/*Table structure for table `as_family` */

DROP TABLE IF EXISTS `as_family`;

CREATE TABLE `as_family` (
  `family_id` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(19) NOT NULL,
  `sortno` varchar(4) NOT NULL,
  `kepala_keluarga` int(11) NOT NULL,
  `tanggal_nikah` date NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `photo` text NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`family_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `as_family` */

insert  into `as_family`(`family_id`,`nik`,`sortno`,`kepala_keluarga`,`tanggal_nikah`,`alamat`,`photo`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(1,'0001-GBIAWN-04-2018','0001',497,'2016-07-16','Sultan Residence H-9, Jl. Nyimas Gandasari - Kel. Jungjang, Kec. Arjawinangun - Kab. Cirebon','','2018-04-13 13:08:52',1,'0000-00-00 00:00:00',0),
(2,'0002-GBIAWN-07-2018','0002',499,'2018-07-01','GTB BSB A1 No.1','','2018-07-19 12:59:13',1,'0000-00-00 00:00:00',0),
(3,'0003-GBIAWN-07-2018','0003',500,'2018-07-03','GTB','','2018-07-19 13:12:57',1,'0000-00-00 00:00:00',0);

/*Table structure for table `as_family_child` */

DROP TABLE IF EXISTS `as_family_child`;

CREATE TABLE `as_family_child` (
  `family_child_id` int(11) NOT NULL AUTO_INCREMENT,
  `family_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`family_child_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `as_family_child` */

insert  into `as_family_child`(`family_child_id`,`family_id`,`child_id`,`status`,`keterangan`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(1,1,498,2,'','2018-04-13 13:09:51',1,'0000-00-00 00:00:00',0),
(3,1,499,3,'','2018-04-13 13:56:23',1,'0000-00-00 00:00:00',0),
(4,2,500,1,'','2018-07-19 13:12:04',1,'0000-00-00 00:00:00',0);

/*Table structure for table `as_funeral` */

DROP TABLE IF EXISTS `as_funeral`;

CREATE TABLE `as_funeral` (
  `funeral_id` int(11) NOT NULL AUTO_INCREMENT,
  `funeral_name` varchar(100) NOT NULL,
  `funeral_address` varchar(150) NOT NULL,
  `status` char(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`funeral_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `as_funeral` */

insert  into `as_funeral`(`funeral_id`,`funeral_name`,`funeral_address`,`status`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(1,'Bong Arjawinangun','Jl. Raya Arjawinangun - Gegesik','Y','2014-06-24 11:42:06',1,'2017-06-24 12:13:21',6),
(3,'Krematorium (Kremasi)','Cirebon','Y','2014-06-24 11:48:26',1,'2017-06-24 12:13:26',6);

/*Table structure for table `as_grade` */

DROP TABLE IF EXISTS `as_grade`;

CREATE TABLE `as_grade` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(100) NOT NULL,
  `status` char(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `as_grade` */

insert  into `as_grade`(`grade_id`,`grade_name`,`status`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(1,'< Rp. 1.000.000','Y','2014-06-24 15:13:04',1,'0000-00-00 00:00:00',0),
(2,'Rp. 1.000.001 - Rp. 2.500.000','Y','2014-06-24 15:13:29',1,'2014-06-24 15:16:08',1),
(3,'Rp. 2.500.001 - Rp. 5.000.000','Y','2014-06-24 15:13:46',1,'2014-06-24 15:15:59',1),
(4,'Rp. 5.000.001 - Rp. 10.000.000','Y','2014-06-24 15:14:02',1,'0000-00-00 00:00:00',0),
(5,'Rp. 10.000.001 - Rp. 25.000.000','Y','2014-06-24 15:16:33',1,'0000-00-00 00:00:00',0),
(6,'> Rp. 25.000.000','Y','2014-06-24 15:16:50',1,'0000-00-00 00:00:00',0);

/*Table structure for table `as_individu` */

DROP TABLE IF EXISTS `as_individu`;

CREATE TABLE `as_individu` (
  `individu_id` int(11) NOT NULL AUTO_INCREMENT,
  `no_induk` varchar(4) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `nick_name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `hp` varchar(20) NOT NULL,
  `gender` char(1) NOT NULL,
  `blood_type` char(2) NOT NULL,
  `place_of_birth` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `death_status` char(1) NOT NULL,
  `death_date` date NOT NULL,
  `funeral_id` int(11) NOT NULL,
  `religion` int(11) NOT NULL,
  `disability` char(1) NOT NULL,
  `father_id` varchar(100) NOT NULL,
  `mother_id` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `status` char(1) NOT NULL,
  `negara` varchar(150) NOT NULL,
  `pendidikan_terakhir` int(11) NOT NULL,
  `nama_lembaga` varchar(200) NOT NULL,
  `job_id` int(11) NOT NULL,
  `side_job` text NOT NULL,
  `grade_id` int(11) NOT NULL,
  `hobi` text NOT NULL,
  `bakat` text NOT NULL,
  `pasangan_id` varchar(150) NOT NULL,
  `tanggal_nikah` date NOT NULL,
  `status_nikah` char(1) NOT NULL,
  PRIMARY KEY (`individu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=504 DEFAULT CHARSET=latin1;

/*Data for the table `as_individu` */

insert  into `as_individu`(`individu_id`,`no_induk`,`full_name`,`nick_name`,`address`,`telepon`,`hp`,`gender`,`blood_type`,`place_of_birth`,`date_of_birth`,`death_status`,`death_date`,`funeral_id`,`religion`,`disability`,`father_id`,`mother_id`,`photo`,`email`,`status`,`negara`,`pendidikan_terakhir`,`nama_lembaga`,`job_id`,`side_job`,`grade_id`,`hobi`,`bakat`,`pasangan_id`,`tanggal_nikah`,`status_nikah`) values 
(497,'0001','Agus Saputra, A.Md., S.Kom.','Agus','Arjawinangun','-','08562121141','L','A','Cirebon','1989-08-15','N','0000-00-00',0,2,'N','-','-','gbiawn_20180404112250asfasolution_agussaputra.jpg','takehikoboyz@gmail.com','Y','',3,'STMIK CIC Cirebon',58,'Penulis',6,'-','-','Feni Agustin, A.Md., S.Kom.','2016-07-16','3'),
(498,'0002','Feni Agustin, A.Md., S.Kom.','Feni','Arjawinangun','','','P','B','Cirebon','1988-08-08','N','0000-00-00',0,2,'N','-','-','','','Y','',3,'STMIK CIC Cirebon',15,'',3,'','','Agus Saputra, A.Md., S.Kom.','2016-07-16','3'),
(499,'0003','Jason Adriel Saputra','Jason','Arjawinangun','','','L','A','Cirebon','2018-01-29','N','0000-00-00',0,2,'N','Agus Saputra, A.Md., S.Kom.','Feni Agustin, A.Md., S.Kom.','','','Y','',0,'',0,'',0,'','','','0000-00-00',''),
(500,'0004','Mikael Adi S.H','Miki','GTB BSB AA6 No.8','081519428961','081519428961','L','O','Semarang','1997-12-18','N','0000-00-00',0,2,'N','a','b','','mikaeladisetiawan@gmail.com','Y','Indonesia',3,'udinus',1,'',1,'RACING','Menyanyi','','0000-00-00','1'),
(501,'0005','Nikola esla',' Tesla','','','','L','O','Semarang','2018-07-19','N','0000-00-00',0,1,'N','','','','','Y','',0,'',0,'',0,'','','','0000-00-00',''),
(502,'0006','Elisa Sari','Sasa','','','','P','O','Semarang','2000-12-20','N','0000-00-00',0,1,'N','','','','','Y','',0,'',0,'',0,'','','','0000-00-00',''),
(503,'0007','Thomas Eka Setiawan','Tommy','','','','L','B','Semarang','2008-11-23','N','0000-00-00',0,2,'N','Widyo Wibowo','Cwasti Mitayani','','','Y','',0,'',0,'',0,'','','','0000-00-00','');

/*Table structure for table `as_jobs` */

DROP TABLE IF EXISTS `as_jobs`;

CREATE TABLE `as_jobs` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_name` varchar(100) NOT NULL,
  `status` char(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

/*Data for the table `as_jobs` */

insert  into `as_jobs`(`job_id`,`job_name`,`status`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(1,'Belum/Tidak Bekerja','Y','2014-06-24 12:36:11',1,'2014-06-24 12:50:17',1),
(2,'Mengurus (Bapak/Ibu) Rumah Tangga','Y','2014-06-24 12:36:27',1,'2014-06-24 12:41:52',1),
(3,'Pelajar / Mahasiswa','Y','2014-06-24 12:36:36',1,'0000-00-00 00:00:00',0),
(4,'Pensiunan','Y','2014-06-24 12:36:46',1,'0000-00-00 00:00:00',0),
(5,'PNS','Y','2014-06-24 12:36:56',1,'0000-00-00 00:00:00',0),
(6,'TNI','Y','2014-06-24 12:37:09',1,'2014-06-24 12:37:19',1),
(7,'Kepolisian RI','Y','2014-06-24 12:37:30',1,'0000-00-00 00:00:00',0),
(8,'Perdagangan','Y','2014-06-24 12:37:38',1,'0000-00-00 00:00:00',0),
(9,'Petani / Pekebun','Y','2014-06-24 12:37:47',1,'0000-00-00 00:00:00',0),
(10,'Peternak','Y','2014-06-24 12:37:56',1,'0000-00-00 00:00:00',0),
(11,'Nelayan / Perikanan','Y','2014-06-24 12:38:06',1,'0000-00-00 00:00:00',0),
(12,'Industri','Y','2014-06-24 12:38:15',1,'0000-00-00 00:00:00',0),
(13,'Konstruksi','Y','2014-06-24 12:38:21',1,'0000-00-00 00:00:00',0),
(14,'Transportasi','Y','2014-06-24 12:38:32',1,'0000-00-00 00:00:00',0),
(15,'Karyawan Swasta','Y','2014-06-24 12:38:38',1,'0000-00-00 00:00:00',0),
(16,'Karyawan BUMN','Y','2014-06-24 12:38:47',1,'0000-00-00 00:00:00',0),
(17,'Karyawan BUMD','Y','2014-06-24 12:38:53',1,'0000-00-00 00:00:00',0),
(18,'Karyawan Honorer','Y','2014-06-24 12:39:07',1,'0000-00-00 00:00:00',0),
(19,'Buruh Harian Lepas','Y','2014-06-24 12:39:18',1,'0000-00-00 00:00:00',0),
(20,'Pembantu Rumah Tangga','Y','2014-06-24 12:39:39',1,'0000-00-00 00:00:00',0),
(21,'Anggota DPR - RI','Y','2014-06-24 12:39:51',1,'2014-06-24 12:42:26',1),
(22,'Pendeta','Y','2014-06-24 12:39:59',1,'2014-06-24 12:42:45',1),
(23,'Wartawan','Y','2014-06-24 12:40:15',1,'2014-06-24 12:43:01',1),
(24,'Anggota DPD','Y','2014-06-24 12:40:21',1,'2014-06-24 12:43:20',1),
(25,'Anggota BPK','Y','2014-06-24 12:40:30',1,'2014-06-24 12:43:32',1),
(26,'Presiden','Y','2014-06-24 12:40:41',1,'2014-06-24 12:43:54',1),
(27,'Wakil Presiden','Y','2014-06-24 12:40:55',1,'2014-06-24 12:44:08',1),
(28,'Anggota Mahkama Konstitusi','Y','2014-06-24 12:41:01',1,'2014-06-24 12:44:33',1),
(29,'Anggota Kabinet / Kementrian','Y','2014-06-24 12:41:09',1,'2014-06-24 12:44:52',1),
(30,'Duta Besar','Y','2014-06-24 12:41:14',1,'2014-06-24 12:45:09',1),
(31,'Gubernur','Y','2014-06-24 12:41:22',1,'2014-06-24 12:45:22',1),
(32,'Wakil Gubernur','Y','2014-06-24 12:41:26',1,'2014-06-24 12:45:35',1),
(33,'Walikota','Y','2014-06-24 12:45:41',1,'0000-00-00 00:00:00',0),
(34,'Wakil Walikota','Y','2014-06-24 12:45:46',1,'0000-00-00 00:00:00',0),
(35,'Bupati','Y','2014-06-24 12:45:49',1,'0000-00-00 00:00:00',0),
(36,'Wakil Bupati','Y','2014-06-24 12:45:53',1,'0000-00-00 00:00:00',0),
(37,'Anggota DPRD Propinsi','Y','2014-06-24 12:46:09',1,'0000-00-00 00:00:00',0),
(38,'Anggota DPRD Kabupaten / Kota','Y','2014-06-24 12:46:29',1,'0000-00-00 00:00:00',0),
(39,'Dosen','Y','2014-06-24 12:46:46',1,'0000-00-00 00:00:00',0),
(40,'Guru','Y','2014-06-24 12:46:53',1,'0000-00-00 00:00:00',0),
(41,'Pilot','Y','2014-06-24 12:46:57',1,'0000-00-00 00:00:00',0),
(42,'Pengacara','Y','2014-06-24 12:47:06',1,'0000-00-00 00:00:00',0),
(43,'Notaris','Y','2014-06-24 12:47:13',1,'0000-00-00 00:00:00',0),
(44,'Arsitek','Y','2014-06-24 12:47:17',1,'0000-00-00 00:00:00',0),
(45,'Akuntan','Y','2014-06-24 12:47:24',1,'0000-00-00 00:00:00',0),
(46,'Konsultan','Y','2014-06-24 12:47:28',1,'0000-00-00 00:00:00',0),
(47,'Dokter','Y','2014-06-24 12:47:35',1,'0000-00-00 00:00:00',0),
(48,'Bidan','Y','2014-06-24 12:47:39',1,'0000-00-00 00:00:00',0),
(49,'Perawat','Y','2014-06-24 12:47:47',1,'0000-00-00 00:00:00',0),
(50,'Apoteker','Y','2014-06-24 12:47:50',1,'0000-00-00 00:00:00',0),
(51,'Psikiater / Psikolog','Y','2014-06-24 12:48:00',1,'0000-00-00 00:00:00',0),
(52,'Penyiar Televisi','Y','2014-06-24 12:48:09',1,'0000-00-00 00:00:00',0),
(53,'Penyiar Radio','Y','2014-06-24 12:48:18',1,'0000-00-00 00:00:00',0),
(54,'Pelaut','Y','2014-06-24 12:48:24',1,'0000-00-00 00:00:00',0),
(55,'Peneliti','Y','2014-06-24 12:48:27',1,'0000-00-00 00:00:00',0),
(56,'Sopir','Y','2014-06-24 12:48:34',1,'0000-00-00 00:00:00',0),
(57,'Pedagang','Y','2014-06-24 12:48:46',1,'0000-00-00 00:00:00',0),
(58,'Wiraswasta','Y','2014-06-24 12:48:58',1,'0000-00-00 00:00:00',0),
(59,'Pengusaha','Y','2014-06-24 12:50:09',1,'0000-00-00 00:00:00',0),
(60,'Ibu Rumah Tangga','Y','2014-08-12 11:27:49',6,'0000-00-00 00:00:00',0),
(61,'Tambal Ban','Y','2014-09-12 15:25:58',6,'0000-00-00 00:00:00',0),
(62,'Driver','Y','2018-07-21 01:27:13',1,'0000-00-00 00:00:00',0);

/*Table structure for table `as_komisi` */

DROP TABLE IF EXISTS `as_komisi`;

CREATE TABLE `as_komisi` (
  `komisi_id` int(11) NOT NULL AUTO_INCREMENT,
  `komisi_periode_id` int(11) NOT NULL,
  `nama_komisi` varchar(100) NOT NULL,
  `status` char(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`komisi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `as_komisi` */

insert  into `as_komisi`(`komisi_id`,`komisi_periode_id`,`nama_komisi`,`status`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(1,2,'Pemuda','Y','0000-00-00 00:00:00',1,'0000-00-00 00:00:00',0),
(2,2,'Remaja','Y','0000-00-00 00:00:00',1,'0000-00-00 00:00:00',0),
(4,4,'Pemuda & Anak','Y','0000-00-00 00:00:00',1,'0000-00-00 00:00:00',0),
(5,4,'Komisi Kaum Pria','Y','0000-00-00 00:00:00',1,'0000-00-00 00:00:00',0),
(6,4,'Komisi Kaum Wanita','Y','0000-00-00 00:00:00',1,'0000-00-00 00:00:00',0);

/*Table structure for table `as_komisi_anggota` */

DROP TABLE IF EXISTS `as_komisi_anggota`;

CREATE TABLE `as_komisi_anggota` (
  `komisi_anggota_id` int(11) NOT NULL AUTO_INCREMENT,
  `komisi_id` int(11) NOT NULL,
  `anggota_id` int(11) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`komisi_anggota_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `as_komisi_anggota` */

insert  into `as_komisi_anggota`(`komisi_anggota_id`,`komisi_id`,`anggota_id`,`jabatan`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(16,4,497,'Ketua Komisi','2018-04-13 15:28:03',1,'0000-00-00 00:00:00',0),
(17,4,498,'Wakil Ketua','2018-04-13 15:28:13',1,'0000-00-00 00:00:00',0);

/*Table structure for table `as_komisi_periode` */

DROP TABLE IF EXISTS `as_komisi_periode`;

CREATE TABLE `as_komisi_periode` (
  `komisi_periode_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_periode` varchar(20) NOT NULL,
  `status` char(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`komisi_periode_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `as_komisi_periode` */

insert  into `as_komisi_periode`(`komisi_periode_id`,`nama_periode`,`status`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(3,'2014 - 2015','Y','2014-06-26 10:40:40',1,'2014-08-05 22:43:59',6),
(4,'2017 - 2018','Y','2018-04-13 14:17:06',1,'2018-04-13 14:17:11',1);

/*Table structure for table `as_majelis` */

DROP TABLE IF EXISTS `as_majelis`;

CREATE TABLE `as_majelis` (
  `majelis_id` int(11) NOT NULL AUTO_INCREMENT,
  `majelis_periode_id` int(11) NOT NULL,
  `nama_majelis` varchar(100) NOT NULL,
  `status` char(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`majelis_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `as_majelis` */

insert  into `as_majelis`(`majelis_id`,`majelis_periode_id`,`nama_majelis`,`status`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(1,1,'Diaken','Y','0000-00-00 00:00:00',1,'2014-06-26 15:23:44',1),
(2,1,'Diakonia','Y','0000-00-00 00:00:00',1,'0000-00-00 00:00:00',0),
(3,3,'Diakonia','Y','0000-00-00 00:00:00',1,'0000-00-00 00:00:00',0);

/*Table structure for table `as_majelis_anggota` */

DROP TABLE IF EXISTS `as_majelis_anggota`;

CREATE TABLE `as_majelis_anggota` (
  `majelis_anggota_id` int(11) NOT NULL AUTO_INCREMENT,
  `majelis_id` int(11) NOT NULL,
  `anggota_id` int(11) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`majelis_anggota_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `as_majelis_anggota` */

insert  into `as_majelis_anggota`(`majelis_anggota_id`,`majelis_id`,`anggota_id`,`jabatan`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(1,3,497,'Ketua','2018-04-13 19:53:43',1,'0000-00-00 00:00:00',0),
(2,3,498,'Wakil Ketua','2018-04-13 19:53:53',1,'0000-00-00 00:00:00',0);

/*Table structure for table `as_majelis_periode` */

DROP TABLE IF EXISTS `as_majelis_periode`;

CREATE TABLE `as_majelis_periode` (
  `majelis_periode_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_periode` varchar(20) NOT NULL,
  `status` char(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`majelis_periode_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `as_majelis_periode` */

insert  into `as_majelis_periode`(`majelis_periode_id`,`nama_periode`,`status`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(2,'2014 - 2015','Y','2014-06-26 15:07:26',1,'0000-00-00 00:00:00',0),
(3,'2017 - 2018','Y','2018-04-13 19:26:54',1,'2018-04-13 19:26:58',1);

/*Table structure for table `as_medicine` */

DROP TABLE IF EXISTS `as_medicine`;

CREATE TABLE `as_medicine` (
  `medicine_id` int(11) DEFAULT NULL,
  `medicine_name` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_userid` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `as_medicine` */

/*Table structure for table `as_staffs` */

DROP TABLE IF EXISTS `as_staffs`;

CREATE TABLE `as_staffs` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `anggota_id` int(11) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `status` char(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `as_staffs` */

insert  into `as_staffs`(`staff_id`,`anggota_id`,`jabatan`,`tanggal_mulai`,`tanggal_keluar`,`status`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(1,497,'Ketua','2018-04-01','0000-00-00','Y','2018-04-13 20:53:43',1,'0000-00-00 00:00:00',0),
(2,500,'Wakil Ketua Management','2016-04-01','0000-00-00','Y','2018-04-13 20:53:54',1,'2018-07-19 13:53:36',1);

/*Table structure for table `as_tokoh_masyarakat` */

DROP TABLE IF EXISTS `as_tokoh_masyarakat`;

CREATE TABLE `as_tokoh_masyarakat` (
  `tokoh_id` int(11) NOT NULL AUTO_INCREMENT,
  `anggota_id` int(11) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `tanggal_tasbih` date NOT NULL,
  `status` char(1) NOT NULL,
  `biografi` text NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`tokoh_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `as_tokoh_masyarakat` */

insert  into `as_tokoh_masyarakat`(`tokoh_id`,`anggota_id`,`jabatan`,`tanggal_tasbih`,`status`,`biografi`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(9,497,'Ketua','2018-04-01','Y','--','2018-04-13 21:08:27',1,'2018-04-13 21:10:24',1);

/*Table structure for table `as_users` */

DROP TABLE IF EXISTS `as_users`;

CREATE TABLE `as_users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `gender` char(1) NOT NULL,
  `position` varchar(100) NOT NULL,
  `handPhone` varchar(20) NOT NULL,
  `status` char(1) NOT NULL,
  `blocked` char(1) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `as_users` */

insert  into `as_users`(`userID`,`fullName`,`address`,`gender`,`position`,`handPhone`,`status`,`blocked`,`username`,`password`,`created_date`,`created_userid`,`modified_date`,`modified_userid`) values 
(1,'Web Master Administrator','Jl. Pegadaian No. 38 RT. 01 RW. 01 Arjawinangun - Cirebon 45162','L','Web Master','08562121141','Y','N','admin','21232f297a57a5a743894a0e4a801fc3','0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),
(5,'Agus Saputra, S.Kom.','Jl. Pegadaian No. 38 RT. 01 RW. 01 Arjawinangun Cirebon 45162','L','Web Master','08562121141','Y','N','agus.saputra','d1e565e7bb5ddd9f9d5e0eade171f7ed','2014-08-04 01:02:37',1,'0000-00-00 00:00:00',0),
(6,'Martin Budi Wijaya','Jl. Pahlawan Arjawinangun','L','Multimedia','085353832331','Y','N','budi','e10adc3949ba59abbe56e057f20f883e','2014-08-04 01:03:19',1,'0000-00-00 00:00:00',0),
(13,'Mikael Adi Setiawan Hutabarat','GTB BSB AA6/8','L','Mahasiswa','081519428961','Y','N','MikaelAdi','d41d8cd98f00b204e9800998ecf8427e','2018-07-20 22:00:26',1,'0000-00-00 00:00:00',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
