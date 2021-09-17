/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 10.5.9-MariaDB-log : Database - manajement-proyek
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`manajement-proyek` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*Table structure for table `alat` */

DROP TABLE IF EXISTS `alat`;

CREATE TABLE `alat` (
  `id_alat` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_alat`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `alat` */

insert  into `alat`(`id_alat`,`nama`,`deskripsi`,`created_at`,`updated_at`) values 
(1,'Dosser','-','2021-09-14 22:06:32','2021-09-14 22:07:36'),
(4,'Excavator','-','2021-09-14 22:07:54','2021-09-14 22:08:29'),
(5,'Truck','alat angkut barang / tanah','2021-09-14 22:08:23','2021-09-14 22:08:23'),
(6,'Crane','','2021-09-14 22:08:45','2021-09-14 22:08:45');

/*Table structure for table `barang` */

DROP TABLE IF EXISTS `barang`;

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `barang` */

insert  into `barang`(`id_barang`,`nama`,`deskripsi`,`created_at`,`updated_at`) values 
(1,'Semen Padang','desc','2021-09-08 20:42:57','2021-09-14 21:47:01'),
(2,'Batu Bata','-','2021-09-08 20:46:34','2021-09-14 21:47:09'),
(3,'Pasir Kasar','-','2021-09-14 21:23:37','2021-09-14 21:24:10'),
(4,'Pasir Halus','-','2021-09-14 21:24:05','2021-09-14 21:24:05');

/*Table structure for table `beli_barang` */

DROP TABLE IF EXISTS `beli_barang`;

CREATE TABLE `beli_barang` (
  `id_beli_barang` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyek` int(11) NOT NULL,
  `id_suplier` int(11) NOT NULL,
  `tgl_beli_barang` date NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `grand_total` bigint(20) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_beli_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `beli_barang` */

insert  into `beli_barang`(`id_beli_barang`,`id_proyek`,`id_suplier`,`tgl_beli_barang`,`deskripsi`,`grand_total`,`created_at`,`updated_at`) values 
(2,1,2,'2021-09-16','asd',189839694,'2021-09-16 20:23:35','2021-09-17 09:51:11');

/*Table structure for table `beli_barang_detail` */

DROP TABLE IF EXISTS `beli_barang_detail`;

CREATE TABLE `beli_barang_detail` (
  `id_beli_barang_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_beli_barang` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `harga` bigint(20) DEFAULT NULL,
  `total` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_beli_barang_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `beli_barang_detail` */

insert  into `beli_barang_detail`(`id_beli_barang_detail`,`id_beli_barang`,`id_barang`,`satuan`,`qty`,`harga`,`total`) values 
(7,2,4,'Kubik',132,1323236,174667152),
(8,2,2,'pcs',123,123123,15144129),
(11,2,3,'kubik',123,231,28413);

/*Table structure for table `kas_masuk` */

DROP TABLE IF EXISTS `kas_masuk`;

CREATE TABLE `kas_masuk` (
  `id_kas_masuk` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyek` int(11) DEFAULT NULL,
  `jumlah` bigint(20) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tgl_kas_masuk` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_kas_masuk`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `kas_masuk` */

insert  into `kas_masuk`(`id_kas_masuk`,`id_proyek`,`jumlah`,`deskripsi`,`tgl_kas_masuk`,`created_at`,`updated_at`) values 
(1,3,60000000,'Uang Masok','2021-09-14','2021-09-14 22:49:24','2021-09-14 22:55:49'),
(2,3,5599999,'uang masuk lagi','2021-09-14','2021-09-14 22:53:50','2021-09-14 22:54:45');

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(50) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Data for the table `menu` */

insert  into `menu`(`id_menu`,`nama_menu`,`url`,`icon`) values 
(1,'Dashboard','/','fas fa-fire'),
(2,'Data Master',NULL,'fas fa-columns'),
(3,'User / Pengguna','user','fas fa-users'),
(6,'Suplier','suplier',NULL),
(7,'Proyek','proyek','fas fa-briefcase'),
(8,'Barang / Material','barang',NULL),
(9,'Validasi SPJ','validasi_spj','fas fa-briefcase'),
(10,'Histori Validasi SPJ','histori_spj','fas fa-history'),
(11,'Alat','alat','fas fa-tools'),
(14,'Transaksi',NULL,'fas fa-th'),
(15,'Kas Masuk','kas_masuk',NULL),
(16,'Peminjaman Alat','pinjam_alat',NULL),
(17,'Pembelian Barang','beli_barang',NULL),
(18,'Laporan',NULL,'fas fa-file'),
(19,'Daftar Proyek','laporan/proyek',NULL),
(20,'Kas Masuk','laporan/kas_masuk',NULL),
(21,'Peminjaman Alat','laporan/pinjam_alat',NULL),
(22,'Pembelian barang','laporan/beli_barang',NULL);

/*Table structure for table `menu_group` */

DROP TABLE IF EXISTS `menu_group`;

CREATE TABLE `menu_group` (
  `id_menu_group` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) DEFAULT NULL,
  `level` enum('administrator','manager') NOT NULL DEFAULT 'administrator',
  `parent_menu` int(11) DEFAULT 0,
  `urutan_menu` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_menu_group`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

/*Data for the table `menu_group` */

insert  into `menu_group`(`id_menu_group`,`id_menu`,`level`,`parent_menu`,`urutan_menu`) values 
(1,2,'administrator',0,2),
(2,3,'administrator',0,6),
(5,1,'administrator',0,1),
(6,1,'manager',0,1),
(7,6,'administrator',2,3),
(8,7,'administrator',0,3),
(9,8,'administrator',2,1),
(14,11,'administrator',2,2),
(17,14,'administrator',0,4),
(18,15,'administrator',14,1),
(19,16,'administrator',14,2),
(20,17,'administrator',14,3),
(27,18,'administrator',0,5),
(28,19,'administrator',18,1),
(29,20,'administrator',18,2),
(30,21,'administrator',18,3),
(31,22,'administrator',18,4),
(32,18,'manager',0,2),
(33,19,'manager',18,1),
(34,20,'manager',18,2),
(35,21,'manager',18,3),
(36,22,'manager',18,4);

/*Table structure for table `pinjam_alat` */

DROP TABLE IF EXISTS `pinjam_alat`;

CREATE TABLE `pinjam_alat` (
  `id_pinjam_alat` int(11) NOT NULL AUTO_INCREMENT,
  `id_alat` int(11) DEFAULT NULL,
  `id_proyek` int(11) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_pinjam_alat`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `pinjam_alat` */

insert  into `pinjam_alat`(`id_pinjam_alat`,`id_alat`,`id_proyek`,`deskripsi`,`status`,`created_at`,`updated_at`) values 
(1,1,1,'-',1,'2021-09-14 23:09:34','2021-09-16 21:44:14'),
(2,4,1,'',0,'2021-09-14 23:12:33','2021-09-14 23:12:33'),
(3,5,1,'',0,'2021-09-14 23:12:44','2021-09-14 23:12:57');

/*Table structure for table `proyek` */

DROP TABLE IF EXISTS `proyek`;

CREATE TABLE `proyek` (
  `id_proyek` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `no_spk` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `lama` int(11) DEFAULT NULL,
  `mulai` date DEFAULT NULL,
  `selesai` date DEFAULT NULL,
  `nilai_kontrak` bigint(20) NOT NULL DEFAULT 0,
  `status` enum('aktif','selesai') DEFAULT 'aktif',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_proyek`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `proyek` */

insert  into `proyek`(`id_proyek`,`nama`,`no_spk`,`alamat`,`lama`,`mulai`,`selesai`,`nilai_kontrak`,`status`,`created_at`,`updated_at`) values 
(1,'Jembatan','007/B2/K31231/081','Jalan Lintas Timur, KM 70 Kec. Pangkalan Kerinci, Kab. Pelalawan',100,'2021-09-07','2021-12-30',7000000000,'aktif','2021-09-07 23:12:52','2021-09-14 22:16:17'),
(3,'Proyek Jembatan Ratulagi KM 50 Desa Bukit Barisan','1231/1513/B/13123',' Ratulagi KM 50 Desa Bukit Barisan',NULL,'2021-10-13','2022-01-12',500000000,'aktif','2021-09-12 10:51:59','2021-09-12 10:51:59');

/*Table structure for table `proyek_detail_pekerjaan` */

DROP TABLE IF EXISTS `proyek_detail_pekerjaan`;

CREATE TABLE `proyek_detail_pekerjaan` (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyek` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `satuan` varchar(20) DEFAULT NULL,
  `harga_satuan` int(11) NOT NULL DEFAULT 0,
  `total_harga` bigint(20) NOT NULL DEFAULT 0,
  `tipe` enum('header','detail') NOT NULL DEFAULT 'detail',
  `parent_detail` int(11) NOT NULL DEFAULT 0,
  `summary` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `proyek_detail_pekerjaan` */

insert  into `proyek_detail_pekerjaan`(`id_detail`,`id_proyek`,`deskripsi`,`qty`,`satuan`,`harga_satuan`,`total_harga`,`tipe`,`parent_detail`,`summary`) values 
(3,1,'Besi Angker',20,'pcs',50000,1000000,'detail',1,NULL),
(4,1,'Pasir',5,'unit',750000,3750000,'detail',1,NULL),
(5,1,'Material Non MDU',0,'0',0,0,'header',0,'material'),
(6,1,'Testing1',1,'pcs',500000,500000,'detail',5,NULL),
(7,1,'SUTM',0,'0',0,0,'header',0,'jasa'),
(8,1,'Testing2',4,'unit',700000,2800000,'detail',5,NULL),
(9,1,'SUTM Testing1',5,'kilogram',30000,150000,'detail',7,NULL),
(10,1,'SUTM Testing2',2,'lusin',5000000,10000000,'detail',7,NULL),
(12,3,'Material Habis Pakai',0,NULL,0,0,'header',0,'material'),
(13,3,'Jasa Pemasangan',0,NULL,0,0,'header',0,'jasa'),
(14,3,'Test1',5,'unit',5000000,25000000,'detail',12,NULL),
(15,3,'Test2',2,'lusin',5000000,10000000,'detail',12,NULL),
(16,3,'Test3',1,'unit',20000000,20000000,'detail',12,NULL),
(17,3,'Testing Jasa 1',1,'pcs',60000000,60000000,'detail',13,NULL),
(18,3,'Bangunan',1,'pcs',200000000,200000000,'detail',13,NULL);

/*Table structure for table `spj` */

DROP TABLE IF EXISTS `spj`;

CREATE TABLE `spj` (
  `id_spj` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyek_vendor` int(11) DEFAULT NULL,
  `no_surat` varchar(50) DEFAULT NULL,
  `tgl_surat` date DEFAULT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `lampiran_surat` varchar(100) DEFAULT NULL,
  `sifat_surat` varchar(20) DEFAULT NULL,
  `nilai_kontrak` bigint(20) DEFAULT NULL,
  `pic_vendor` varchar(100) DEFAULT NULL,
  `tembusan` text DEFAULT NULL,
  PRIMARY KEY (`id_spj`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `spj` */

insert  into `spj`(`id_spj`,`id_proyek_vendor`,`no_surat`,`tgl_surat`,`tgl_mulai`,`tgl_selesai`,`lampiran_surat`,`sifat_surat`,`nilai_kontrak`,`pic_vendor`,`tembusan`) values 
(1,1,'22314/1512/133','2021-09-12','2021-09-07','2021-12-30','-','Segera',20020000,'Soekanto Wijaya','-'),
(4,3,'22314/1512/15','2021-09-12','2021-11-05','2022-01-12','-','Segera',286000000,'RICKARD RIMAWADON','-'),
(5,2,'22314/1512/16','2021-09-12','2021-10-13','2022-01-12','-','Segera',60500000,'Soekanto Wijaya','-');

/*Table structure for table `suplier` */

DROP TABLE IF EXISTS `suplier`;

CREATE TABLE `suplier` (
  `id_suplier` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_suplier`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `suplier` */

insert  into `suplier`(`id_suplier`,`nama`,`pic`,`alamat`,`telp`,`fax`,`email`,`created_at`,`updated_at`) values 
(2,'PT Pertama Indonesia','Soekanto Wijaya','Jln Lebak Bulus, Jakarta Utara','1231313323','','pertama@gmail.com','2021-09-07 22:23:53','2021-09-13 19:05:09'),
(3,'PT Kedua Indonesia','RICKARD RIMAWADON','Jln Lebak Bulus, Jakarta Barat','12131261231231','31115123123','kedua@gmail.com','2021-09-12 10:55:05','2021-09-13 19:05:17'),
(5,'PT Dako Indonesia','Jandara the Begining','Jln Air Hitam KM 150','123123','','contact@ptdaco.com','2021-09-14 21:36:03','2021-09-14 21:36:03');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `level` enum('administrator','manager') NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`id_user`,`username`,`password`,`level`,`nama`,`alamat`,`no_telp`,`created_at`,`updated_at`) values 
(2,'admin','$2y$10$kIDY0eokfwPJXMSpC0WxOuCdGOP9pne4dAQu7ceBIWIZu6AGAuq6e','administrator','Administrator','Pekanbaru','082268262017','2021-09-06 21:36:16','2021-09-06 22:12:35'),
(5,'manager','$2y$10$NhJDzdgZ4f1Gywe.Lc/rAOfMm/8MVx8qLf2X.fQ9hazG25qI.rsSO','manager','Manager','-','082268262017','2021-09-12 10:14:07','2021-09-12 10:14:07');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
