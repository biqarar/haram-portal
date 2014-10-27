-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 01, 2014 at 12:59 PM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quran_hadith`
--
CREATE DATABASE IF NOT EXISTS `quran_hadith` DEFAULT CHARACTER SET utf8 COLLATE utf8_persian_ci;
USE `quran_hadith`;

-- --------------------------------------------------------

--
-- Table structure for table `absence`
--

DROP TABLE IF EXISTS `absence`;
CREATE TABLE IF NOT EXISTS `absence` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `classification_id` int(10) NOT NULL,
  `type` enum('delay','leave','unjustified absence','justified absence') COLLATE utf8_persian_ci NOT NULL DEFAULT 'unjustified absence',
  `date` int(8) NOT NULL,
  `because` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `classification_id` (`classification_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

--
-- Triggers `absence`
--
DROP TRIGGER IF EXISTS `absence_delete`;
DELIMITER //
CREATE TRIGGER `absence_delete` AFTER DELETE ON `absence`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'absence','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `absence_insert`;
DELIMITER //
CREATE TRIGGER `absence_insert` AFTER INSERT ON `absence`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'absence','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `absence_update`;
DELIMITER //
CREATE TRIGGER `absence_update` AFTER UPDATE ON `absence`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'absence','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
CREATE TABLE IF NOT EXISTS `branch` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام شعبه',
  `code` int(3) DEFAULT NULL COMMENT 'کد شعبه',
  `gender` enum('male','female','male_female') COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='شعب' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `name`, `code`, `gender`) VALUES
(1, 'اداره آموزش و تربیت برادران', 101, 'male'),
(2, 'اداره آموزش و تربیت خواهران', 102, 'female'),
(3, 'اداره آموزش مجازی و غیر حضوری', 103, 'male_female'),
(4, 'مهد کودک کریمه', 104, 'male_female');

--
-- Triggers `branch`
--
DROP TRIGGER IF EXISTS `branch_delete`;
DELIMITER //
CREATE TRIGGER `branch_delete` AFTER DELETE ON `branch`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'branch','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `branch_insert`;
DELIMITER //
CREATE TRIGGER `branch_insert` AFTER INSERT ON `branch`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'branch','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);


END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `branch_set_code`;
DELIMITER //
CREATE TRIGGER `branch_set_code` BEFORE INSERT ON `branch`
 FOR EACH ROW BEGIN
SET NEW.code = (SELECT AUTO_INCREMENT FROM
                information_schema.TABLES WHERE TABLE_SCHEMA
               =DATABASE() AND TABLE_NAME = 'branch') +100;

END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `branch_update`;
DELIMITER //
CREATE TRIGGER `branch_update` AFTER UPDATE ON `branch`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'branch','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `branch_description`
--

DROP TABLE IF EXISTS `branch_description`;
CREATE TABLE IF NOT EXISTS `branch_description` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `branch_id` int(10) NOT NULL COMMENT 'شماره شعبه',
  `title` enum('buss','address','working hours','phone','branch sections') COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'عنوان',
  `value` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیح',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`branch_id`,`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='مشخصات شعب' AUTO_INCREMENT=1 ;

--
-- Triggers `branch_description`
--
DROP TRIGGER IF EXISTS `branch_description_delete`;
DELIMITER //
CREATE TRIGGER `branch_description_delete` AFTER DELETE ON `branch_description`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'branch_description','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `branch_description_insert`;
DELIMITER //
CREATE TRIGGER `branch_description_insert` AFTER INSERT ON `branch_description`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'branch_description','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `branch_description_update`;
DELIMITER //
CREATE TRIGGER `branch_description_update` AFTER UPDATE ON `branch_description`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'branch_description','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `branch_users_key`
--

DROP TABLE IF EXISTS `branch_users_key`;
CREATE TABLE IF NOT EXISTS `branch_users_key` (
  `pkey` int(3) NOT NULL,
  `key` int(5) unsigned zerofill NOT NULL,
  PRIMARY KEY (`pkey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `branch_users_key`
--

INSERT INTO `branch_users_key` (`pkey`, `key`) VALUES
(393, 00001);

-- --------------------------------------------------------

--
-- Table structure for table `bridge`
--

DROP TABLE IF EXISTS `bridge`;
CREATE TABLE IF NOT EXISTS `bridge` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `users_id` int(10) NOT NULL,
  `title` enum('phone','mobile','email','address') COLLATE utf8_persian_ci NOT NULL DEFAULT 'phone' COMMENT 'عنوان',
  `value` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'مقدار',
  `description` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  PRIMARY KEY (`id`),
  UNIQUE KEY `value` (`users_id`,`title`,`value`) USING BTREE,
  KEY `users_id` (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='پل های ارتباطی' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `bridge`
--

INSERT INTO `bridge` (`id`, `users_id`, `title`, `value`, `description`) VALUES
(10, 238, 'mobile', '09109610612', NULL);

--
-- Triggers `bridge`
--
DROP TRIGGER IF EXISTS `bridge_delete`;
DELIMITER //
CREATE TRIGGER `bridge_delete` AFTER DELETE ON `bridge`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'bridge','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `bridge_insert`;
DELIMITER //
CREATE TRIGGER `bridge_insert` AFTER INSERT ON `bridge`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'bridge','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `bridge_update`;
DELIMITER //
CREATE TRIGGER `bridge_update` AFTER UPDATE ON `bridge`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'bridge','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `certification`
--

DROP TABLE IF EXISTS `certification`;
CREATE TABLE IF NOT EXISTS `certification` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `classification_id` int(10) NOT NULL,
  `date_design` int(8) DEFAULT NULL COMMENT 'تاریخ طراحی',
  `date_print` int(8) DEFAULT NULL COMMENT 'تاریخ چاپ',
  `date_deliver` int(8) DEFAULT NULL COMMENT 'تاریخ تحویل',
  `date_request` int(8) NOT NULL COMMENT 'تاریخ درخواست',
  PRIMARY KEY (`id`),
  KEY `classification_id` (`classification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='گواهی نامه' AUTO_INCREMENT=1 ;

--
-- Triggers `certification`
--
DROP TRIGGER IF EXISTS `certification_delete`;
DELIMITER //
CREATE TRIGGER `certification_delete` AFTER DELETE ON `certification`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'certification','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `certification_insert`;
DELIMITER //
CREATE TRIGGER `certification_insert` AFTER INSERT ON `certification`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'certification','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `certification_unique`;
DELIMITER //
CREATE TRIGGER `certification_unique` BEFORE INSERT ON `certification`
 FOR EACH ROW BEGIN
SET @E = (SELECT COUNT(*) FROM certification WHERE 
         date_request = NEW.date_request AND 
         classification_id = NEW.classification_id);
IF @E > 0 THEN
CALL S_UNIQUE('date_request');
END IF;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `certification_update`;
DELIMITER //
CREATE TRIGGER `certification_update` AFTER UPDATE ON `certification`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'certification','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `province_id` int(10) NOT NULL,
  `name` varchar(32) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`province_id`,`name`),
  KEY `province_id` (`province_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=442 ;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `province_id`, `name`) VALUES
(23, 1, 'آذر شهر'),
(22, 1, 'اسكو'),
(15, 1, 'اهر'),
(27, 1, 'ایلخچی'),
(29, 1, 'باسمنج'),
(20, 1, 'بستان آباد'),
(12, 1, 'بناب'),
(4, 1, 'بندر شرفخانه'),
(2, 1, 'تبريز'),
(14, 1, 'تسوج'),
(9, 1, 'جلفا'),
(28, 1, 'خسروشهر'),
(10, 1, 'سراب'),
(30, 1, 'سهند'),
(7, 1, 'شبستر'),
(26, 1, 'صوفیان'),
(17, 1, 'عجبشير'),
(24, 1, 'قره آغاج'),
(13, 1, 'كليبر'),
(3, 1, 'كندوان'),
(5, 1, 'مراغه'),
(8, 1, 'مرند'),
(19, 1, 'ملكان'),
(25, 1, 'ممقان'),
(6, 1, 'ميانه'),
(21, 1, 'ورزقان'),
(11, 1, 'هاديشهر'),
(16, 1, 'هريس'),
(18, 1, 'هشترود'),
(31, 2, 'اروميه'),
(45, 2, 'اشنويه'),
(39, 2, 'بوكان'),
(47, 2, 'پلدشت'),
(43, 2, 'پيرانشهر'),
(34, 2, 'تكاب'),
(38, 2, 'چالدران'),
(46, 2, 'چایپاره'),
(35, 2, 'خوي'),
(37, 2, 'سر دشت'),
(41, 2, 'سلماس'),
(44, 2, 'سيه چشمه'),
(42, 2, 'شاهين دژ'),
(48, 2, 'شوط'),
(33, 2, 'ماكو'),
(36, 2, 'مهاباد'),
(40, 2, 'مياندوآب'),
(32, 2, 'نقده'),
(49, 3, 'اردبيل'),
(51, 3, 'بيله سوار'),
(52, 3, 'پارس آباد'),
(53, 3, 'خلخال'),
(50, 3, 'سرعين'),
(58, 3, 'كوثر'),
(59, 3, 'كيوي'),
(60, 3, 'گرمي'),
(54, 3, 'مشگين شهر'),
(55, 3, 'مغان'),
(56, 3, 'نمين'),
(57, 3, 'نير'),
(83, 4, 'آران و بيدگل'),
(72, 4, 'اردستان'),
(61, 4, 'اصفهان'),
(84, 4, 'باغ بهادران'),
(91, 4, 'تودشک'),
(69, 4, 'تيران'),
(90, 4, 'حاجي آباد'),
(78, 4, 'خميني شهر'),
(85, 4, 'خوانسار'),
(74, 4, 'درچه'),
(81, 4, 'دولت آباد'),
(66, 4, 'دهاقان'),
(82, 4, 'زرين شهر'),
(73, 4, 'سميرم'),
(79, 4, 'شاهين شهر'),
(77, 4, 'شهرضا'),
(88, 4, 'عسگران'),
(87, 4, 'علويجه'),
(62, 4, 'فريدن'),
(63, 4, 'فريدون شهر'),
(64, 4, 'فلاورجان'),
(71, 4, 'فولاد شهر'),
(75, 4, 'کوهپایه'),
(70, 4, 'كاشان'),
(65, 4, 'گلپايگان'),
(76, 4, 'مباركه'),
(86, 4, 'مهردشت'),
(68, 4, 'نايين'),
(80, 4, 'نجف آباد'),
(67, 4, 'نطنز'),
(89, 4, 'نهضت آباد'),
(92, 4, 'ورزنه'),
(96, 5, 'آبدانان'),
(93, 5, 'ايلام'),
(99, 5, 'ايوان'),
(98, 5, 'دره شهر'),
(95, 5, 'دهلران'),
(100, 5, 'سرابله'),
(97, 5, 'شيروان چرداول'),
(94, 5, 'مهران'),
(111, 6, 'اهرم'),
(112, 6, 'برازجان'),
(117, 6, 'بردخون'),
(101, 6, 'بوشهر'),
(102, 6, 'تنگستان'),
(114, 6, 'جم'),
(113, 6, 'خارك'),
(110, 6, 'خورموج'),
(103, 6, 'دشتستان'),
(109, 6, 'دشتي'),
(104, 6, 'دير'),
(105, 6, 'ديلم'),
(108, 6, 'ريشهر'),
(116, 6, 'عسلویه'),
(115, 6, 'کاکی'),
(106, 6, 'كنگان'),
(107, 6, 'گناوه'),
(123, 7, 'اسلامشهر'),
(134, 7, 'باقرشهر'),
(126, 7, 'بومهن'),
(130, 7, 'پاكدشت'),
(127, 7, 'تجريش'),
(118, 7, 'تهران'),
(131, 7, 'چهاردانگه'),
(122, 7, 'دماوند'),
(136, 7, 'رباط كريم'),
(124, 7, 'رودهن'),
(121, 7, 'ري'),
(132, 7, 'شريف آباد'),
(135, 7, 'شهريار'),
(128, 7, 'فشم'),
(120, 7, 'فيروزكوه'),
(137, 7, 'قدس'),
(133, 7, 'قرچك'),
(129, 7, 'كهريزك'),
(125, 7, 'لواسان'),
(138, 7, 'ملارد'),
(119, 7, 'ورامين'),
(143, 8, 'اردل'),
(141, 8, 'بروجن'),
(142, 8, 'چلگرد'),
(145, 8, 'سامان'),
(139, 8, 'شهركرد'),
(140, 8, 'فارسان'),
(144, 8, 'لردگان'),
(148, 9, 'بيرجند'),
(153, 9, 'درمیان'),
(150, 9, 'سربيشه'),
(151, 9, 'طبس مسینا'),
(147, 9, 'فردوس'),
(146, 9, 'قائن'),
(152, 9, 'قهستان'),
(149, 9, 'نهبندان'),
(166, 10, 'بردسكن'),
(163, 10, 'تايباد'),
(162, 10, 'تربت جام'),
(160, 10, 'تربت حيدريه'),
(168, 10, 'چناران'),
(161, 10, 'خواف'),
(169, 10, 'درگز'),
(156, 10, 'سبزوار'),
(172, 10, 'سر ولایت'),
(165, 10, 'سرخس'),
(159, 10, 'طبس'),
(171, 10, 'طرقبه'),
(167, 10, 'فريمان'),
(164, 10, 'قوچان'),
(157, 10, 'كاشمر'),
(170, 10, 'كلات'),
(158, 10, 'گناباد'),
(154, 10, 'مشهد'),
(155, 10, 'نيشابور'),
(177, 11, 'آشخانه'),
(174, 11, 'اسفراين'),
(173, 11, 'بجنورد'),
(175, 11, 'جاجرم'),
(179, 11, 'ساروج'),
(176, 11, 'شيروان'),
(178, 11, 'گرمه'),
(183, 12, 'آبادان'),
(195, 12, 'اميديه'),
(188, 12, 'انديمشك'),
(180, 12, 'اهواز'),
(186, 12, 'ايذه'),
(181, 12, 'ايرانشهر'),
(198, 12, 'باغ ملك'),
(194, 12, 'بندر امام خميني'),
(193, 12, 'بندر ماهشهر'),
(196, 12, 'بهبهان'),
(202, 12, 'حمیدیه'),
(184, 12, 'خرمشهر'),
(191, 12, 'دزفول'),
(203, 12, 'دغاغله'),
(201, 12, 'رامشیر'),
(197, 12, 'رامهرمز'),
(189, 12, 'سوسنگرد'),
(192, 12, 'شادگان'),
(182, 12, 'شوش'),
(187, 12, 'شوشتر'),
(200, 12, 'لالي'),
(185, 12, 'مسجد سليمان'),
(204, 12, 'ملاثانی'),
(206, 12, 'ویسی'),
(199, 12, 'هنديجان'),
(190, 12, 'هويزه'),
(215, 13, 'آب بر'),
(208, 13, 'ابهر'),
(213, 13, 'ايجرود'),
(209, 13, 'خدابنده'),
(212, 13, 'خرمدره'),
(214, 13, 'زرين آباد'),
(207, 13, 'زنجان'),
(216, 13, 'قيدار'),
(210, 13, 'كارم'),
(211, 13, 'ماهنشان'),
(220, 14, 'ايوانكي'),
(222, 14, 'بسطام'),
(221, 14, 'دامغان'),
(217, 14, 'سمنان'),
(218, 14, 'شاهرود'),
(219, 14, 'گرمسار'),
(230, 15, 'ايرانشهر'),
(224, 15, 'چابهار'),
(225, 15, 'خاش'),
(231, 15, 'راسك'),
(227, 15, 'زابل'),
(223, 15, 'زاهدان'),
(226, 15, 'سراوان'),
(228, 15, 'سرباز'),
(232, 15, 'ميرجاوه'),
(229, 15, 'نيكشهر'),
(239, 16, 'آباده'),
(252, 16, 'اردكان'),
(259, 16, 'ارژن'),
(254, 16, 'ارسنجان'),
(247, 16, 'استهبان'),
(234, 16, 'اقليد'),
(266, 16, 'باب انار/خفر'),
(267, 16, 'بوانات'),
(245, 16, 'جهرم'),
(250, 16, 'حاجي آباد'),
(263, 16, 'خان زنیان'),
(268, 16, 'خرامه'),
(238, 16, 'خرم بيد'),
(269, 16, 'خنج'),
(235, 16, 'داراب'),
(261, 16, 'داريون'),
(265, 16, 'ده بید'),
(262, 16, 'زرقان'),
(242, 16, 'سپيدان'),
(258, 16, 'سروستان'),
(256, 16, 'سوريان'),
(270, 16, 'سیاخ دارنگون'),
(233, 16, 'شيراز'),
(253, 16, 'صفاشهر'),
(257, 16, 'فراشبند'),
(236, 16, 'فسا'),
(244, 16, 'فيروز آباد'),
(255, 16, 'قيروكارزين'),
(264, 16, 'کوار'),
(240, 16, 'كازرون'),
(260, 16, 'گويم'),
(243, 16, 'لار'),
(248, 16, 'لامرد'),
(237, 16, 'مرودشت'),
(241, 16, 'ممسني'),
(249, 16, 'مهر'),
(251, 16, 'نورآباد'),
(246, 16, 'ني ريز'),
(273, 17, 'آبيك'),
(274, 17, 'بوئين زهرا'),
(272, 17, 'تاكستان'),
(271, 17, 'قزوين'),
(275, 18, 'قم'),
(281, 19, 'آسارا'),
(278, 19, 'اشتهارد'),
(283, 19, 'اندیشه'),
(282, 19, 'شهرک گلستان'),
(276, 19, 'طالقان'),
(284, 19, 'كرج'),
(280, 19, 'كن'),
(286, 19, 'گوهردشت'),
(287, 19, 'ماهدشت'),
(288, 19, 'مشکین دشت'),
(285, 19, 'نظر آباد'),
(277, 19, 'نظرآباد'),
(279, 19, 'هشتگرد'),
(291, 20, 'بانه'),
(292, 20, 'بيجار'),
(298, 20, 'حسن آباد'),
(290, 20, 'ديواندره'),
(293, 20, 'سقز'),
(289, 20, 'سنندج'),
(297, 20, 'صلوات آباد'),
(295, 20, 'قروه'),
(294, 20, 'كامياران'),
(296, 20, 'مريوان'),
(302, 21, 'انار'),
(301, 21, 'بابك'),
(305, 21, 'بافت'),
(311, 21, 'بردسير'),
(309, 21, 'بم'),
(310, 21, 'جيرفت'),
(300, 21, 'راور'),
(304, 21, 'رفسنجان'),
(308, 21, 'زرند'),
(306, 21, 'سيرجان'),
(303, 21, 'کوهبنان'),
(299, 21, 'كرمان'),
(307, 21, 'كهنوج'),
(313, 22, 'اسلام آباد غرب'),
(321, 22, 'پاوه'),
(322, 22, 'جوانرود'),
(314, 22, 'سر پل ذهاب'),
(316, 22, 'سنقر'),
(323, 22, 'شاهو'),
(320, 22, 'صحنه'),
(317, 22, 'قصر شيرين'),
(312, 22, 'كرمانشاه'),
(315, 22, 'كنگاور'),
(318, 22, 'گيلان غرب'),
(319, 22, 'هرسين'),
(326, 23, 'دنا'),
(327, 23, 'دوگنبدان'),
(329, 23, 'دهدشت'),
(328, 23, 'سي سخت'),
(325, 23, 'گچساران'),
(330, 23, 'ليكك'),
(324, 23, 'ياسوج'),
(340, 24, 'آزاد شهر'),
(332, 24, 'آق قلا'),
(338, 24, 'بندر گز'),
(336, 24, 'تركمن'),
(341, 24, 'راميان'),
(334, 24, 'علي آباد كتول'),
(337, 24, 'كردكوي'),
(339, 24, 'كلاله'),
(331, 24, 'گرگان'),
(333, 24, 'گنبد كاووس'),
(335, 24, 'مينو دشت'),
(347, 25, 'آستارا'),
(349, 25, 'آستانه اشرفيه'),
(360, 25, 'املش'),
(365, 25, 'بندر کياشهر'),
(353, 25, 'بندرانزلي'),
(346, 25, 'تالش'),
(362, 25, 'خشک بيجار'),
(363, 25, 'خمام'),
(342, 25, 'رشت'),
(356, 25, 'رضوان شهر'),
(345, 25, 'رود سر'),
(350, 25, 'رودبار'),
(359, 25, 'سياهكل'),
(358, 25, 'شفت'),
(352, 25, 'صومعه سرا'),
(351, 25, 'فومن'),
(354, 25, 'كلاچاي'),
(361, 25, 'لاهیجان'),
(364, 25, 'لشت نشا'),
(344, 25, 'لنگرود'),
(357, 25, 'ماسال'),
(348, 25, 'ماسوله'),
(343, 25, 'منجيل'),
(355, 25, 'هشتپر'),
(372, 26, 'ازنا'),
(375, 26, 'الشتر'),
(371, 26, 'اليگودرز'),
(369, 26, 'بروجرد'),
(376, 26, 'پلدختر'),
(366, 26, 'خرم آباد'),
(368, 26, 'دزفول'),
(370, 26, 'دورود'),
(374, 26, 'كوهدشت'),
(367, 26, 'ماهشهر'),
(373, 26, 'نور آباد'),
(378, 27, 'آمل'),
(379, 27, 'بابل'),
(380, 27, 'بابلسر'),
(390, 27, 'بلده'),
(381, 27, 'بهشهر'),
(392, 27, 'پل سفيد'),
(382, 27, 'تنكابن'),
(383, 27, 'جويبار'),
(384, 27, 'چالوس'),
(385, 27, 'رامسر'),
(377, 27, 'ساري'),
(386, 27, 'سواد كوه'),
(394, 27, 'فريدون كنار'),
(387, 27, 'قائم شهر'),
(393, 27, 'محمود آباد'),
(388, 27, 'نكا'),
(389, 27, 'نور'),
(391, 27, 'نوشهر'),
(396, 28, 'آشتيان'),
(395, 28, 'اراك'),
(397, 28, 'تفرش'),
(398, 28, 'خمين'),
(399, 28, 'دليجان'),
(400, 28, 'ساوه'),
(401, 28, 'سربند'),
(403, 28, 'شازند'),
(402, 28, 'محلات'),
(413, 29, 'ابوموسي'),
(411, 29, 'انگهران'),
(408, 29, 'بستك'),
(414, 29, 'بندر جاسك'),
(416, 29, 'بندر خمیر'),
(407, 29, 'بندر لنگه'),
(404, 29, 'بندرعباس'),
(417, 29, 'پارسیان'),
(415, 29, 'تنب بزرگ'),
(409, 29, 'حاجي آباد'),
(410, 29, 'دهبارز'),
(405, 29, 'قشم'),
(406, 29, 'كيش'),
(412, 29, 'ميناب'),
(425, 30, 'اسدآباد'),
(426, 30, 'بهار'),
(421, 30, 'تويسركان'),
(424, 30, 'رزن'),
(423, 30, 'كبودر اهنگ'),
(420, 30, 'ملاير'),
(422, 30, 'نهاوند'),
(419, 30, 'همدان'),
(430, 31, 'ابركوه'),
(429, 31, 'اردكان'),
(435, 31, 'اشكذر'),
(433, 31, 'بافق'),
(428, 31, 'تفت'),
(439, 31, 'حمیدیه شهر'),
(437, 31, 'خضرآباد'),
(441, 31, 'زارچ'),
(440, 31, 'سید میرزا'),
(438, 31, 'شاهديه'),
(432, 31, 'طبس'),
(434, 31, 'مهريز'),
(431, 31, 'ميبد'),
(436, 31, 'هرات'),
(427, 31, 'يزد');

--
-- Triggers `city`
--
DROP TRIGGER IF EXISTS `city_delete`;
DELIMITER //
CREATE TRIGGER `city_delete` AFTER DELETE ON `city`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'city','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `city_insert`;
DELIMITER //
CREATE TRIGGER `city_insert` AFTER INSERT ON `city`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'city','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `city_update`;
DELIMITER //
CREATE TRIGGER `city_update` AFTER UPDATE ON `city`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'city','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `course_id` int(10) NOT NULL COMMENT 'شماره دوره',
  `plan_id` int(10) NOT NULL COMMENT 'شماره طرح',
  `meeting_no` int(3) DEFAULT NULL COMMENT 'تعداد جلسه',
  `teacher` int(10) NOT NULL COMMENT 'استاد',
  `age_range` enum('child','teen','young','adult') COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'مقطع سنی',
  `quality` enum('level one','level two','level three','begginer level','medium','advanced') COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'مقطع درسی',
  `place_id` int(10) DEFAULT NULL COMMENT 'شماره مدرس',
  `start_time` time DEFAULT NULL COMMENT 'ساعت شروع',
  `end_time` time DEFAULT NULL COMMENT 'ساعت پایان',
  `start_date` int(8) DEFAULT NULL COMMENT 'تاریخ شروع',
  `end_date` int(8) DEFAULT NULL COMMENT 'تاریخ پایان',
  `week_days` set('sunday','monday','tuesday','wednesday','thursday','friday','saturday') COLLATE utf8_persian_ci DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL,
  `status` enum('ready','running','done') COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'وضعیت',
  `type` enum('physical','virtual') COLLATE utf8_persian_ci NOT NULL DEFAULT 'physical' COMMENT 'نوع',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`course_id`,`plan_id`,`place_id`,`start_time`,`end_time`,`status`) USING BTREE,
  KEY `course_id` (`course_id`),
  KEY `plan_id` (`plan_id`),
  KEY `teacher` (`teacher`),
  KEY `plase_id` (`place_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='کلاس' AUTO_INCREMENT=22 ;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `course_id`, `plan_id`, `meeting_no`, `teacher`, `age_range`, `quality`, `place_id`, `start_time`, `end_time`, `start_date`, `end_date`, `week_days`, `name`, `status`, `type`) VALUES
(21, 6, 5, 30, 238, 'adult', 'level two', 6, '18:00:00', '19:00:00', 13930701, 13930801, NULL, 'روخوانی طوبی', 'ready', 'physical');

--
-- Triggers `classes`
--
DROP TRIGGER IF EXISTS `class_delete`;
DELIMITER //
CREATE TRIGGER `class_delete` AFTER DELETE ON `classes`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'class','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `class_insert`;
DELIMITER //
CREATE TRIGGER `class_insert` AFTER INSERT ON `classes`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'class','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `class_update`;
DELIMITER //
CREATE TRIGGER `class_update` AFTER UPDATE ON `classes`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'class','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `classification`
--

DROP TABLE IF EXISTS `classification`;
CREATE TABLE IF NOT EXISTS `classification` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `users_id` int(10) NOT NULL COMMENT 'شماره اعضاء',
  `date_entry` int(8) NOT NULL COMMENT 'تاریخ ورود به کلاس',
  `date_delete` int(8) DEFAULT NULL COMMENT 'تاریخ خروج از کلاس',
  `because` enum('absence','cansel','done') COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'علت',
  `mark` float DEFAULT NULL COMMENT 'معدل کل',
  `plan_section_id` int(10) DEFAULT NULL COMMENT 'مقطع درسی',
  `classes_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`users_id`,`classes_id`) USING BTREE,
  KEY `users_id` (`users_id`),
  KEY `classes_id` (`classes_id`),
  KEY `plan_section_id` (`plan_section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='کلاس بندی' AUTO_INCREMENT=36 ;

--
-- Dumping data for table `classification`
--

INSERT INTO `classification` (`id`, `users_id`, `date_entry`, `date_delete`, `because`, `mark`, `plan_section_id`, `classes_id`) VALUES
(35, 238, 1393007009, NULL, NULL, NULL, NULL, 21);

--
-- Triggers `classification`
--
DROP TRIGGER IF EXISTS `classification_delete`;
DELIMITER //
CREATE TRIGGER `classification_delete` AFTER DELETE ON `classification`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'classification','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `classification_insert`;
DELIMITER //
CREATE TRIGGER `classification_insert` AFTER INSERT ON `classification`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'classification','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `classification_update`;
DELIMITER //
CREATE TRIGGER `classification_update` AFTER UPDATE ON `classification`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'classification','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

DROP TABLE IF EXISTS `consultation`;
CREATE TABLE IF NOT EXISTS `consultation` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group` enum('level','consultation','exam') COLLATE utf8_persian_ci DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL,
  `expert` int(10) DEFAULT NULL,
  `branch_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`group`,`name`,`expert`,`branch_id`) USING BTREE,
  KEY `branch_id` (`branch_id`),
  KEY `expert` (`expert`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`id`, `group`, `name`, `expert`, `branch_id`) VALUES
(1, 'consultation', 'مشاوره تخصصی حفظ قرآن کریم', NULL, 1);

--
-- Triggers `consultation`
--
DROP TRIGGER IF EXISTS `consultation_delete`;
DELIMITER //
CREATE TRIGGER `consultation_delete` AFTER DELETE ON `consultation`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'consultation','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `consultation_insert`;
DELIMITER //
CREATE TRIGGER `consultation_insert` AFTER INSERT ON `consultation`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'consoltation','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `consultation_update`;
DELIMITER //
CREATE TRIGGER `consultation_update` AFTER UPDATE ON `consultation`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'consultation','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `consultation_list`
--

DROP TABLE IF EXISTS `consultation_list`;
CREATE TABLE IF NOT EXISTS `consultation_list` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `consultation_id` int(10) DEFAULT NULL,
  `date` int(8) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `users_id` int(10) DEFAULT NULL,
  `plan_id` int(10) DEFAULT NULL,
  `status` enum('free','busy','cancel') COLLATE utf8_persian_ci DEFAULT 'free',
  `result` enum('verify','send_to_other','unverified') COLLATE utf8_persian_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `quality` enum('great','good','medium','bad') COLLATE utf8_persian_ci DEFAULT NULL,
  `good_remember` set('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30') COLLATE utf8_persian_ci DEFAULT '',
  `bad_remember` set('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30') COLLATE utf8_persian_ci DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`,`start_time`,`end_time`,`plan_id`),
  KEY `consultation_id` (`consultation_id`),
  KEY `users_id` (`users_id`),
  KEY `plan_id` (`plan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `consultation_list`
--

INSERT INTO `consultation_list` (`id`, `consultation_id`, `date`, `start_time`, `end_time`, `users_id`, `plan_id`, `status`, `result`, `description`, `quality`, `good_remember`, `bad_remember`) VALUES
(7, NULL, 139369, '14:45:31', NULL, NULL, NULL, '', NULL, NULL, NULL, '', ''),
(8, NULL, 139369, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, '', ''),
(9, NULL, 13930609, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, '', '');

--
-- Triggers `consultation_list`
--
DROP TRIGGER IF EXISTS `consultation_list_delete`;
DELIMITER //
CREATE TRIGGER `consultation_list_delete` AFTER DELETE ON `consultation_list`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'consultation_list','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `consultation_list_insert`;
DELIMITER //
CREATE TRIGGER `consultation_list_insert` AFTER INSERT ON `consultation_list`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'consoltation_list','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `consultation_list_update`;
DELIMITER //
CREATE TRIGGER `consultation_list_update` AFTER UPDATE ON `consultation_list`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'consultation_list','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=225 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`) VALUES
(15, 'آذربایجان'),
(10, 'آرژانتین'),
(12, 'آروبا'),
(185, 'آفریقای جنوبی'),
(2, 'آلبانی'),
(77, 'آلمان'),
(214, 'آمریکا'),
(9, 'آنتیگوا و باربودا'),
(5, 'آندورا'),
(6, 'آنگولا'),
(7, 'آنگویلا'),
(14, 'اتریش'),
(68, 'اتیوپی'),
(103, 'اردن'),
(11, 'ارمنستان'),
(215, 'اروگوئه'),
(66, 'اریتره'),
(216, 'ازبکستان'),
(187, 'اسپانیا'),
(13, 'استرالیا'),
(67, 'استونی'),
(181, 'اسلواکی'),
(182, 'اسلوونی'),
(193, 'اسوالبارد'),
(1, 'افغانستان'),
(62, 'اکوادور'),
(3, 'الجزایر'),
(64, 'السالوادور'),
(212, 'امارات متحده عربی'),
(96, 'اندونزی'),
(213, 'انگلستان'),
(211, 'اوکراین'),
(210, 'اوگاندا'),
(134, 'ایالات فدرال میکرونزیی'),
(100, 'ایتالیا'),
(97, 'ایران'),
(99, 'ایرلند'),
(94, 'ایسلند'),
(19, 'باربادوس'),
(16, 'باهاما'),
(17, 'بحرین'),
(30, 'برزیل'),
(24, 'برمودا'),
(31, 'برونئی دارالسلام'),
(34, 'بروندی'),
(20, 'بلاروس'),
(21, 'بلژیک'),
(32, 'بلغارستان'),
(22, 'بلیز'),
(18, 'بنگلادش'),
(23, 'بنین'),
(25, 'بوتان'),
(28, 'بوتسوانا'),
(33, 'بورکینافاسو'),
(27, 'بوسنی و هرزگوین'),
(26, 'بولیوی'),
(158, 'پاپوآ گینه نو'),
(159, 'پاراگوئه'),
(155, 'پاکستان'),
(156, 'پالائو'),
(157, 'پاناما'),
(164, 'پرتغال'),
(160, 'پرو'),
(165, 'پورتوریکو'),
(162, 'پیتکارین'),
(199, 'تاجیکستان'),
(200, 'تانزانیا'),
(201, 'تایلند'),
(198, 'تایوان'),
(208, 'ترکمنستان'),
(207, 'ترکیه'),
(205, 'ترینیداد و توباگو'),
(203, 'توکلائو'),
(202, 'توگو'),
(206, 'تونس'),
(204, 'تونگا'),
(209, 'تووالو'),
(61, 'تیمور شرق'),
(101, 'جامائیکا'),
(79, 'جبل الطارق'),
(183, 'جزایر سلیمان'),
(70, 'جزایر فارو'),
(69, 'جزایر فالکلند'),
(50, 'جزایر کوک'),
(39, 'جزایر کیمن'),
(128, 'جزایر مارشال'),
(152, 'جزایر ماریانای شمالی'),
(29, 'جزیره بووت'),
(44, 'جزیره کریسمس'),
(151, 'جزیره نورفولک'),
(40, 'جمهوری آفریقای مرکزی'),
(56, 'جمهوری چک'),
(49, 'جمهوری دموکراتیک'),
(60, 'جمهوری دومینیکن'),
(186, 'جورجیای جنوبی'),
(58, 'جیبوتی'),
(41, 'چاد'),
(43, 'چین'),
(57, 'دانمارک'),
(59, 'دومینیکا'),
(167, 'رئونیون'),
(169, 'رواندا'),
(170, 'روسیه'),
(168, 'رومانی'),
(223, 'زامبیا'),
(224, 'زیمباوه'),
(102, 'ژاپن'),
(175, 'سائوتومه و پرینسیپ'),
(52, 'ساحل عاج'),
(4, 'ساموآ'),
(173, 'ساموا'),
(174, 'سان مارینو'),
(188, 'سری لانکا'),
(190, 'سنت پیر و میکلون'),
(171, 'سنت لوسیا'),
(172, 'سنت وینسنت و گرنادین'),
(189, 'سنت هلن'),
(180, 'سنگاپور'),
(177, 'سنگال'),
(194, 'سوازیلند'),
(195, 'سوئد'),
(196, 'سوئیس'),
(191, 'سودان'),
(192, 'سورینام'),
(197, 'سوریه'),
(184, 'سومالی'),
(179, 'سیرالئون'),
(178, 'سیشل'),
(42, 'شیلی'),
(220, 'صحرای غربی'),
(98, 'عراق'),
(176, 'عربستان سعودی'),
(154, 'عمان'),
(78, 'غنا'),
(73, 'فرانسه'),
(72, 'فنلاند'),
(71, 'فیجی'),
(161, 'فیلیپین'),
(55, 'قبرس'),
(110, 'قرقیزستان'),
(104, 'قزاقستان'),
(8, 'قطب جنوب'),
(166, 'قطر'),
(51, 'کاستاریکا'),
(35, 'کامبوج'),
(36, 'کامرون'),
(37, 'کانادا'),
(53, 'کرواسی'),
(108, 'کره جنوبی'),
(107, 'کره شمالی'),
(46, 'کلمبیا'),
(48, 'کنگو'),
(105, 'کنیا'),
(54, 'کوبا'),
(47, 'کومور'),
(109, 'کویت'),
(38, 'کیپ ورد'),
(106, 'کیریباتی'),
(74, 'گابن'),
(75, 'گامبیا'),
(82, 'گرانادا'),
(76, 'گرجستان'),
(81, 'گرینلند'),
(85, 'گواتمالا'),
(83, 'گوادلوپ'),
(84, 'گوام'),
(88, 'گویان'),
(86, 'گینه'),
(65, 'گینه استوایی'),
(87, 'گینه بیسائو'),
(111, 'لائوس'),
(113, 'لبنان'),
(112, 'لتونی'),
(114, 'لسوتو'),
(119, 'لوکزامبورگ'),
(163, 'لهستان'),
(115, 'لیبریا'),
(116, 'لیبی'),
(118, 'لیتوانی'),
(117, 'لیختن اشتاین'),
(122, 'ماداگاسکار'),
(129, 'مارتینیک'),
(120, 'ماکائو'),
(123, 'مالاوی'),
(127, 'مالت'),
(125, 'مالدیو'),
(124, 'مالزی'),
(126, 'مالی'),
(132, 'مایوت'),
(93, 'مجارستان'),
(139, 'مراکش'),
(63, 'مصر'),
(137, 'مغولستان'),
(121, 'مقدونیه'),
(133, 'مکزیک'),
(130, 'موریتانی'),
(131, 'موریس'),
(140, 'موزامبیک'),
(135, 'مولدووا'),
(136, 'موناکو'),
(138, 'مونتسرات'),
(141, 'میانمار'),
(143, 'نائورو'),
(142, 'نامیبیا'),
(144, 'نپال'),
(153, 'نروژ'),
(148, 'نیجر'),
(149, 'نیجریه'),
(147, 'نیکاراگوئه'),
(150, 'نیوئه'),
(146, 'نیوزیلند'),
(90, 'واتیکان'),
(217, 'وانواتو'),
(218, 'ونزوئلا'),
(219, 'ویتنام'),
(89, 'هائیتی'),
(145, 'هلند'),
(95, 'هند'),
(91, 'هندوراس'),
(92, 'هنگ کنگ'),
(221, 'یمن'),
(222, 'یوگسلاوی'),
(80, 'یونان');

--
-- Triggers `country`
--
DROP TRIGGER IF EXISTS `country_delete`;
DELIMITER //
CREATE TRIGGER `country_delete` AFTER DELETE ON `country`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'country','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `country_insert`;
DELIMITER //
CREATE TRIGGER `country_insert` AFTER INSERT ON `country`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'country','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `country_update`;
DELIMITER //
CREATE TRIGGER `country_update` AFTER UPDATE ON `country`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'country','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `begin_time` int(8) DEFAULT NULL COMMENT 'تاریخ شروع',
  `end_time` int(8) DEFAULT NULL COMMENT 'تاریخ پایان',
  `name` varchar(64) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام دوره',
  `expert` int(10) DEFAULT NULL COMMENT 'کارشناس دوره',
  `branch_id` int(10) NOT NULL COMMENT 'شماره شعبه',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`begin_time`,`end_time`,`name`,`branch_id`) USING BTREE,
  KEY `branch_id` (`branch_id`),
  KEY `expert` (`expert`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='دوره ها' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `begin_time`, `end_time`, `name`, `expert`, `branch_id`) VALUES
(4, 13930701, 13930930, 'پاییز 1393', NULL, 1),
(5, 13930401, 13930631, 'تابستان 1393', NULL, 3),
(6, 13931001, 13931229, 'زمستان 1393', NULL, 1);

--
-- Triggers `course`
--
DROP TRIGGER IF EXISTS `course_delete`;
DELIMITER //
CREATE TRIGGER `course_delete` AFTER DELETE ON `course`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'course','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `course_insert`;
DELIMITER //
CREATE TRIGGER `course_insert` AFTER INSERT ON `course`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'course','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `course_update`;
DELIMITER //
CREATE TRIGGER `course_update` AFTER UPDATE ON `course`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'course','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `course_description`
--

DROP TABLE IF EXISTS `course_description`;
CREATE TABLE IF NOT EXISTS `course_description` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `course_id` int(10) NOT NULL COMMENT 'دوره',
  `title` enum('test date','end test date','condition') COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'عنوان',
  `description` text COLLATE utf8_persian_ci NOT NULL COMMENT 'توضیحات',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`course_id`,`title`) USING BTREE,
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='اطلاعات دوره ها' AUTO_INCREMENT=1 ;

--
-- Triggers `course_description`
--
DROP TRIGGER IF EXISTS `course_description_delete`;
DELIMITER //
CREATE TRIGGER `course_description_delete` AFTER DELETE ON `course_description`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'course_description','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `course_description_insert`;
DELIMITER //
CREATE TRIGGER `course_description_insert` AFTER INSERT ON `course_description`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'course_description','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `course_description_update`;
DELIMITER //
CREATE TRIGGER `course_description_update` AFTER UPDATE ON `course_description`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'course_description','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `dev`
--

DROP TABLE IF EXISTS `dev`;
CREATE TABLE IF NOT EXISTS `dev` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` int(8) NOT NULL,
  `description` text COLLATE utf8_persian_ci NOT NULL,
  `adress` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `report` enum('Hasan Salehi','Ahmad Karimi','Reza Mohiti') COLLATE utf8_persian_ci NOT NULL,
  `repair` enum('Hasan Salehi','Ahmad Karimi','Reza Mohiti','') COLLATE utf8_persian_ci NOT NULL,
  `status` enum('report','checking...','test','OK') COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dev`
--

INSERT INTO `dev` (`id`, `date`, `description`, `adress`, `report`, `repair`, `status`) VALUES
(1, 1393007007, 'sdfsdfsdfsdfsdfs', 'test adress', 'Hasan Salehi', 'Hasan Salehi', 'OK'),
(2, 1379, '', 'test adress', 'Hasan Salehi', 'Ahmad Karimi', 'checking...'),
(3, 1379, 'sdssdfdsfsdf', 'sdfdsfsdfds', 'Ahmad Karimi', 'Reza Mohiti', 'checking...');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

DROP TABLE IF EXISTS `education`;
CREATE TABLE IF NOT EXISTS `education` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group` enum('academic','howzah') COLLATE utf8_persian_ci DEFAULT 'academic' COMMENT 'گروه',
  `section` varchar(32) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'مقطع',
  PRIMARY KEY (`id`),
  UNIQUE KEY `section` (`group`,`section`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='تحصیلات' AUTO_INCREMENT=27 ;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `group`, `section`) VALUES
(3, 'academic', 'اول ابتدایی'),
(12, 'academic', 'اول دبیرستان'),
(9, 'academic', 'اول راهنمایی'),
(1, 'academic', 'پنجم ابتدایی'),
(15, 'academic', 'پیش دانشگاهی'),
(4, 'academic', 'چهارم ابتدایی'),
(21, 'academic', 'دکتری'),
(2, 'academic', 'دوم ابتدایی'),
(13, 'academic', 'دوم دبیرستان'),
(10, 'academic', 'دوم راهنمایی'),
(17, 'academic', 'دیپلم'),
(5, 'academic', 'سوم ابتدایی'),
(14, 'academic', 'سوم دبیرستان'),
(11, 'academic', 'سوم راهنمایی'),
(16, 'academic', 'سیکل'),
(6, 'academic', 'ششم ابتدایی'),
(18, 'academic', 'فوق دیپلم'),
(20, 'academic', 'فوق لیسانس'),
(19, 'academic', 'لیسانس'),
(8, 'academic', 'هشتم ابتدایی'),
(7, 'academic', 'هفتم ابتدایی'),
(26, 'howzah', 'سطح چهار'),
(24, 'howzah', 'سطح دو'),
(25, 'howzah', 'سطح سه'),
(23, 'howzah', 'سطح یک'),
(22, 'howzah', 'مقدمات');

--
-- Triggers `education`
--
DROP TRIGGER IF EXISTS `education_delete`;
DELIMITER //
CREATE TRIGGER `education_delete` AFTER DELETE ON `education`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'education','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `education_insert`;
DELIMITER //
CREATE TRIGGER `education_insert` AFTER INSERT ON `education`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'education','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `education_update`;
DELIMITER //
CREATE TRIGGER `education_update` AFTER UPDATE ON `education`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'education','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

DROP TABLE IF EXISTS `experiences`;
CREATE TABLE IF NOT EXISTS `experiences` (
  `id` int(10) NOT NULL,
  `graduate_id` int(10) NOT NULL COMMENT 'فراگیر',
  `short` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان خلاصه',
  `type` enum('experience','recommend','tip') COLLATE utf8_persian_ci NOT NULL COMMENT 'نوع',
  `text` text COLLATE utf8_persian_ci NOT NULL,
  `status` enum('checking','personal','public') COLLATE utf8_persian_ci NOT NULL DEFAULT 'checking' COMMENT 'وضعیت',
  PRIMARY KEY (`id`),
  KEY `graduate_id` (`graduate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Triggers `experiences`
--
DROP TRIGGER IF EXISTS `experiences_delete`;
DELIMITER //
CREATE TRIGGER `experiences_delete` AFTER DELETE ON `experiences`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'experiences','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `experiences_insert`;
DELIMITER //
CREATE TRIGGER `experiences_insert` AFTER INSERT ON `experiences`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'experiences','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `experiences_update`;
DELIMITER //
CREATE TRIGGER `experiences_update` AFTER UPDATE ON `experiences`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'experiences','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) COLLATE utf8_persian_ci NOT NULL,
  `size` float DEFAULT NULL,
  `type` varchar(6) COLLATE utf8_persian_ci DEFAULT NULL,
  `folder` int(4) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`title`,`size`,`type`,`folder`,`description`) USING BTREE,
  KEY `folders_id` (`folder`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1021 ;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `title`, `size`, `type`, `folder`, `description`) VALUES
(1019, '', 0.22, 'png', 1002, ''),
(1015, 'quran', 0.04, 'jpg', 1002, 'قرآن'),
(1020, 'sdfsdf', 0.02, 'jpg', 1002, 'sdfsdfsdf'),
(1018, 'شرکت-بیش-از-27-هزار-نفر-در-کلاس-', 0.05, 'jpg', 1002, '');

--
-- Triggers `files`
--
DROP TRIGGER IF EXISTS `files_delete`;
DELIMITER //
CREATE TRIGGER `files_delete` AFTER DELETE ON `files`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'files','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `files_insert`;
DELIMITER //
CREATE TRIGGER `files_insert` AFTER INSERT ON `files`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'files','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `files_update`;
DELIMITER //
CREATE TRIGGER `files_update` AFTER UPDATE ON `files`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'files','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `set_folder`;
DELIMITER //
CREATE TRIGGER `set_folder` BEFORE INSERT ON `files`
 FOR EACH ROW BEGIN
SET NEW.folder =1000 + CEILING((SELECT AUTO_INCREMENT FROM
                information_schema.TABLES WHERE TABLE_SCHEMA
               =DATABASE() AND TABLE_NAME = 'files')/1000);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `get_price`
--

DROP TABLE IF EXISTS `get_price`;
CREATE TABLE IF NOT EXISTS `get_price` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `price_id` int(10) NOT NULL COMMENT 'شماره شهریه',
  `value` int(7) NOT NULL COMMENT 'مبلغ دریافتی',
  `date_receive` int(8) NOT NULL COMMENT 'تاریخ تحویل',
  `receiver` int(10) NOT NULL COMMENT 'دریافت کننده',
  `type` enum('pose','bank','cash') COLLATE utf8_persian_ci NOT NULL DEFAULT 'pose' COMMENT 'پرداخت از طریق',
  `card` int(16) NOT NULL,
  `transactions` int(32) DEFAULT NULL COMMENT 'شماره تراکنش',
  PRIMARY KEY (`id`),
  UNIQUE KEY `duplicate` (`price_id`,`value`,`date_receive`,`receiver`,`type`,`card`,`transactions`),
  UNIQUE KEY `transactions` (`transactions`),
  KEY `receiver` (`receiver`),
  KEY `price_id` (`price_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='مبالغ دریافتی شهریه' AUTO_INCREMENT=1 ;

--
-- Triggers `get_price`
--
DROP TRIGGER IF EXISTS `get_price_delete`;
DELIMITER //
CREATE TRIGGER `get_price_delete` AFTER DELETE ON `get_price`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'get_price','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `get_price_insert`;
DELIMITER //
CREATE TRIGGER `get_price_insert` AFTER INSERT ON `get_price`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'get_price','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `get_price_update`;
DELIMITER //
CREATE TRIGGER `get_price_update` AFTER UPDATE ON `get_price`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'get_price','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `graduate`
--

DROP TABLE IF EXISTS `graduate`;
CREATE TABLE IF NOT EXISTS `graduate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `users_id` int(10) NOT NULL COMMENT 'فراگیر',
  `status` enum('checking','active','inactive') COLLATE utf8_persian_ci NOT NULL DEFAULT 'checking' COMMENT 'وضعیت',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_id` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

--
-- Triggers `graduate`
--
DROP TRIGGER IF EXISTS `graduate_delete`;
DELIMITER //
CREATE TRIGGER `graduate_delete` AFTER DELETE ON `graduate`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'graduate','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `graduate_insert`;
DELIMITER //
CREATE TRIGGER `graduate_insert` AFTER INSERT ON `graduate`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'graduate','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `graduate_update`;
DELIMITER //
CREATE TRIGGER `graduate_update` AFTER UPDATE ON `graduate`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'graduate','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `graduate_classes`
--

DROP TABLE IF EXISTS `graduate_classes`;
CREATE TABLE IF NOT EXISTS `graduate_classes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `graduate_id` int(10) NOT NULL COMMENT 'فراگیر',
  `classes_id` int(10) NOT NULL COMMENT 'شماره کلاس',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`graduate_id`,`classes_id`) USING BTREE,
  KEY `classes_id` (`classes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

--
-- Triggers `graduate_classes`
--
DROP TRIGGER IF EXISTS `graduate_classes_delete`;
DELIMITER //
CREATE TRIGGER `graduate_classes_delete` AFTER DELETE ON `graduate_classes`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'graduate_classes','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `graduate_classes_insert`;
DELIMITER //
CREATE TRIGGER `graduate_classes_insert` BEFORE INSERT ON `graduate_classes`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'graduate_classes','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `graduate_classes_update`;
DELIMITER //
CREATE TRIGGER `graduate_classes_update` AFTER UPDATE ON `graduate_classes`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'graduate_classes','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام گروه',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='گروه های علمی' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`) VALUES
(4, 'تربیت مربی قرآن کریم'),
(3, 'حفظ قرآن و حیدث'),
(2, 'علوم و فنون قرائات'),
(1, 'معارف قرآن و حدیث');

--
-- Triggers `group`
--
DROP TRIGGER IF EXISTS `gorup_update`;
DELIMITER //
CREATE TRIGGER `gorup_update` AFTER UPDATE ON `group`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'gorup','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `group_delete`;
DELIMITER //
CREATE TRIGGER `group_delete` AFTER DELETE ON `group`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'gorup','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `group_insert`;
DELIMITER //
CREATE TRIGGER `group_insert` AFTER INSERT ON `group`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'gorup','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `group_expert`
--

DROP TABLE IF EXISTS `group_expert`;
CREATE TABLE IF NOT EXISTS `group_expert` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `position_id` int(10) NOT NULL COMMENT 'منصب',
  `users_id` int(10) NOT NULL COMMENT 'کاربر',
  `group_id` int(10) DEFAULT NULL COMMENT 'گروه علمی',
  `start_date` int(8) DEFAULT NULL COMMENT 'تاریخ شروع فعالیت',
  `end_date` int(8) DEFAULT NULL COMMENT 'تاریخ خاتمه فعالیت',
  `status` enum('responsible','expert') COLLATE utf8_persian_ci NOT NULL DEFAULT 'expert' COMMENT 'وضعیت',
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts` (`position_id`,`users_id`,`group_id`) USING BTREE,
  KEY `users_id` (`users_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

--
-- Triggers `group_expert`
--
DROP TRIGGER IF EXISTS `group_expert_delete`;
DELIMITER //
CREATE TRIGGER `group_expert_delete` AFTER DELETE ON `group_expert`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'group_expert','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `group_expert_insert`;
DELIMITER //
CREATE TRIGGER `group_expert_insert` AFTER INSERT ON `group_expert`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'group_expert','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `group_expert_update`;
DELIMITER //
CREATE TRIGGER `group_expert_update` AFTER UPDATE ON `group_expert`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'group_expert','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `group_list`
--

DROP TABLE IF EXISTS `group_list`;
CREATE TABLE IF NOT EXISTS `group_list` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام گروه',
  `description` text COLLATE utf8_persian_ci COMMENT 'توضیحات',
  `expert` int(10) NOT NULL COMMENT 'کارشناس',
  `status` enum('active','inactive') COLLATE utf8_persian_ci NOT NULL DEFAULT 'inactive' COMMENT 'وضعیت',
  PRIMARY KEY (`id`),
  KEY `expert` (`expert`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

--
-- Triggers `group_list`
--
DROP TRIGGER IF EXISTS `group_list_delete`;
DELIMITER //
CREATE TRIGGER `group_list_delete` AFTER DELETE ON `group_list`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'group_list','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `group_list_insert`;
DELIMITER //
CREATE TRIGGER `group_list_insert` AFTER INSERT ON `group_list`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'group_list','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `group_list_update`;
DELIMITER //
CREATE TRIGGER `group_list_update` AFTER UPDATE ON `group_list`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'group_list','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `record_id` int(10) NOT NULL,
  `table` varchar(32) COLLATE utf8_persian_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `query_type` enum('insert','update','delete') COLLATE utf8_persian_ci NOT NULL,
  `users_id` int(10) DEFAULT NULL,
  `ip` varchar(15) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=4677 ;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `record_id`, `table`, `date`, `query_type`, `users_id`, `ip`) VALUES
(13, 1, 'province', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(14, 1, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(15, 2, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(16, 3, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(17, 4, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(18, 5, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(19, 6, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(20, 7, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(21, 8, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(22, 9, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(23, 10, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(24, 11, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(25, 12, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(26, 13, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(27, 2, 'province', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(28, 14, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(29, 15, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(30, 16, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(31, 17, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(32, 18, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(33, 19, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(34, 20, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(35, 21, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(36, 22, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(37, 23, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(38, 24, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(39, 25, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(40, 26, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(41, 27, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(42, 28, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(43, 29, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(44, 30, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(45, 31, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(46, 32, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(47, 33, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(48, 34, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(49, 35, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(50, 36, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(51, 37, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(52, 38, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(53, 39, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(54, 40, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(55, 41, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(56, 42, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(57, 43, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(58, 44, 'city', '2014-03-11 08:30:56', 'insert', 2, '::1'),
(59, 45, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(60, 46, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(61, 47, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(62, 48, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(63, 49, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(64, 50, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(65, 51, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(66, 52, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(67, 53, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(68, 54, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(69, 55, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(70, 56, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(71, 57, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(72, 58, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(73, 59, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(74, 60, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(75, 61, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(76, 3, 'province', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(77, 62, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(78, 63, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(79, 64, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(80, 65, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(81, 66, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(82, 67, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(83, 68, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(84, 69, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(85, 70, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(86, 71, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(87, 4, 'province', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(88, 72, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(89, 73, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(90, 74, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(91, 75, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(92, 76, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(93, 77, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(94, 78, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(95, 79, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(96, 80, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(97, 81, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(98, 82, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(99, 83, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(100, 84, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(101, 85, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(102, 86, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(103, 87, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(104, 88, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(105, 89, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(106, 90, 'city', '2014-03-11 08:30:57', 'insert', 2, '::1'),
(107, 91, 'city', '2014-03-11 08:30:58', 'insert', 2, '::1'),
(108, 92, 'city', '2014-03-11 08:30:58', 'insert', 2, '::1'),
(109, 93, 'city', '2014-03-11 08:30:58', 'insert', 2, '::1'),
(110, 94, 'city', '2014-03-11 08:30:58', 'insert', 2, '::1'),
(111, 95, 'city', '2014-03-11 08:30:58', 'insert', 2, '::1'),
(112, 96, 'city', '2014-03-11 08:30:58', 'insert', 2, '::1'),
(113, 97, 'city', '2014-03-11 08:30:58', 'insert', 2, '::1'),
(114, 98, 'city', '2014-03-11 08:30:58', 'insert', 2, '::1'),
(115, 5, 'province', '2014-03-11 08:30:58', 'insert', 2, '::1'),
(116, 99, 'city', '2014-03-11 08:30:58', 'insert', 2, '::1'),
(117, 100, 'city', '2014-03-11 08:30:58', 'insert', 2, '::1'),
(118, 101, 'city', '2014-03-11 08:30:58', 'insert', 2, '::1'),
(119, 102, 'city', '2014-03-11 08:30:58', 'insert', 2, '::1'),
(120, 103, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(121, 104, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(122, 105, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(123, 106, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(124, 107, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(125, 108, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(126, 109, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(127, 110, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(128, 111, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(129, 112, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(130, 113, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(131, 114, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(132, 115, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(133, 116, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(134, 6, 'province', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(135, 117, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(136, 118, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(137, 119, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(138, 120, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(139, 121, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(140, 122, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(141, 123, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(142, 124, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(143, 125, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(144, 126, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(145, 127, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(146, 128, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(147, 129, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(148, 130, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(149, 131, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(150, 7, 'province', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(151, 132, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(152, 133, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(153, 134, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(154, 135, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(155, 136, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(156, 137, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(157, 138, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(158, 139, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(159, 140, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(160, 141, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(161, 142, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(162, 143, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(163, 144, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(164, 145, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(165, 146, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(166, 147, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(167, 148, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(168, 149, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(169, 150, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(170, 151, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(171, 152, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(172, 153, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(173, 154, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(174, 155, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(175, 156, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(176, 157, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(177, 158, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(178, 159, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(179, 160, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(180, 161, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(181, 162, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(182, 163, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(183, 164, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(184, 165, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(185, 166, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(186, 167, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(187, 168, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(188, 169, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(189, 170, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(190, 171, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(191, 172, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(192, 173, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(193, 174, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(194, 175, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(195, 176, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(196, 177, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(197, 178, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(198, 179, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(199, 180, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(200, 181, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(201, 182, 'city', '2014-03-11 08:30:59', 'insert', 2, '::1'),
(202, 183, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(203, 184, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(204, 185, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(205, 186, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(206, 187, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(207, 188, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(208, 189, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(209, 190, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(210, 191, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(211, 192, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(212, 193, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(213, 194, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(214, 195, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(215, 196, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(216, 197, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(217, 198, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(218, 199, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(219, 200, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(220, 201, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(221, 202, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(222, 203, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(223, 204, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(224, 205, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(225, 206, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(226, 207, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(227, 208, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(228, 209, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(229, 210, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(230, 211, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(231, 212, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(232, 213, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(233, 214, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(234, 215, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(235, 216, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(236, 217, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(237, 218, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(238, 219, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(239, 220, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(240, 221, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(241, 222, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(242, 223, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(243, 224, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(244, 225, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(245, 226, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(246, 227, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(247, 228, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(248, 229, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(249, 230, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(250, 231, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(251, 232, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(252, 233, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(253, 234, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(254, 235, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(255, 236, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(256, 237, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(257, 238, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(258, 239, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(259, 240, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(260, 241, 'city', '2014-03-11 08:31:00', 'insert', 2, '::1'),
(261, 242, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(262, 243, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(263, 244, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(264, 245, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(265, 246, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(266, 247, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(267, 248, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(268, 249, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(269, 250, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(270, 251, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(271, 252, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(272, 253, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(273, 254, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(274, 255, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(275, 256, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(276, 257, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(277, 258, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(278, 259, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(279, 260, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(280, 261, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(281, 262, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(282, 263, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(283, 264, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(284, 8, 'province', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(285, 265, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(286, 266, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(287, 267, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(288, 268, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(289, 269, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(290, 270, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(291, 271, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(292, 272, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(293, 273, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(294, 9, 'province', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(295, 274, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(296, 275, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(297, 276, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(298, 277, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(299, 278, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(300, 279, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(301, 280, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(302, 281, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(303, 282, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(304, 283, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(305, 10, 'province', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(306, 284, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(307, 285, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(308, 286, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(309, 287, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(310, 288, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(311, 289, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(312, 290, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(313, 291, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(314, 292, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(315, 293, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(316, 294, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(317, 295, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(318, 296, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(319, 297, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(320, 298, 'city', '2014-03-11 08:31:01', 'insert', 2, '::1'),
(321, 299, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(322, 300, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(323, 301, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(324, 302, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(325, 303, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(326, 304, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(327, 305, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(328, 11, 'province', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(329, 306, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(330, 307, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(331, 308, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(332, 309, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(333, 12, 'province', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(334, 310, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(335, 311, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(336, 312, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(337, 313, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(338, 314, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(339, 315, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(340, 316, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(341, 317, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(342, 318, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(343, 319, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(344, 320, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(345, 321, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(346, 322, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(347, 323, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(348, 324, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(349, 325, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(350, 326, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(351, 327, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(352, 328, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(353, 329, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(354, 330, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(355, 331, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(356, 332, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(357, 333, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(358, 334, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(359, 335, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(360, 336, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(361, 337, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(362, 338, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(363, 339, 'city', '2014-03-11 08:31:02', 'insert', 2, '::1'),
(364, 340, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(365, 13, 'province', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(366, 341, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(367, 342, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(368, 343, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(369, 344, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(370, 345, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(371, 346, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(372, 347, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(373, 348, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(374, 14, 'province', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(375, 349, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(376, 350, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(377, 351, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(378, 352, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(379, 353, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(380, 354, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(381, 355, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(382, 356, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(383, 15, 'province', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(384, 357, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(385, 358, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(386, 359, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(387, 360, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(388, 361, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(389, 362, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(390, 363, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(391, 364, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(392, 365, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(393, 366, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(394, 367, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(395, 16, 'province', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(396, 368, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(397, 369, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(398, 370, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(399, 371, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(400, 372, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(401, 373, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(402, 374, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(403, 375, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(404, 376, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(405, 377, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(406, 378, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(407, 379, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(408, 380, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(409, 381, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(410, 382, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(411, 383, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(412, 384, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(413, 385, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(414, 386, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(415, 387, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(416, 388, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(417, 389, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(418, 390, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(419, 391, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(420, 392, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(421, 393, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(422, 394, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(423, 395, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(424, 396, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(425, 397, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(426, 398, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(427, 399, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(428, 400, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(429, 401, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(430, 402, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(431, 403, 'city', '2014-03-11 08:31:03', 'insert', 2, '::1'),
(432, 404, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(433, 405, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(434, 17, 'province', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(435, 406, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(436, 407, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(437, 408, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(438, 409, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(439, 410, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(440, 411, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(441, 18, 'province', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(442, 412, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(443, 413, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(444, 414, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(445, 415, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(446, 416, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(447, 19, 'province', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(448, 417, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(449, 418, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(450, 419, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(451, 420, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(452, 421, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(453, 422, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(454, 423, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(455, 424, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(456, 425, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(457, 426, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(458, 427, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(459, 20, 'province', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(460, 428, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(461, 429, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(462, 430, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(463, 431, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(464, 432, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(465, 433, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(466, 434, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(467, 435, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(468, 436, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(469, 437, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(470, 438, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(471, 439, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(472, 440, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(473, 441, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(474, 442, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(475, 443, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(476, 444, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(477, 445, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(478, 446, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(479, 447, 'city', '2014-03-11 08:31:04', 'insert', 2, '::1'),
(480, 448, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(481, 449, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(482, 450, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(483, 451, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(484, 452, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(485, 453, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(486, 454, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(487, 455, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(488, 456, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(489, 21, 'province', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(490, 457, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(491, 458, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(492, 459, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(493, 460, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(494, 461, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(495, 462, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(496, 463, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(497, 464, 'city', '2014-03-11 08:31:05', 'insert', 2, '::1'),
(498, 465, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(499, 466, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(500, 467, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(501, 468, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(502, 469, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(503, 22, 'province', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(504, 470, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(505, 471, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(506, 472, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(507, 473, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(508, 474, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(509, 475, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(510, 23, 'province', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(511, 476, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(512, 477, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(513, 478, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(514, 479, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(515, 480, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(516, 481, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(517, 482, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(518, 483, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(519, 484, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(520, 485, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(521, 486, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(522, 487, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(523, 24, 'province', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(524, 488, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(525, 489, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(526, 490, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(527, 491, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(528, 492, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(529, 493, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(530, 494, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(531, 495, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(532, 496, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(533, 497, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(534, 498, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(535, 499, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(536, 500, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(537, 501, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(538, 502, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(539, 25, 'province', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(540, 503, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(541, 504, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(542, 505, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(543, 506, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(544, 507, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(545, 508, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(546, 509, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(547, 510, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(548, 511, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(549, 26, 'province', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(550, 512, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(551, 513, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(552, 514, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(553, 515, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(554, 516, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(555, 517, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(556, 518, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(557, 519, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(558, 520, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(559, 521, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(560, 522, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(561, 523, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(562, 524, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(563, 525, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(564, 526, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(565, 527, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(566, 528, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(567, 529, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(568, 530, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(569, 531, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(570, 532, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(571, 533, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(572, 534, 'city', '2014-03-11 08:31:06', 'insert', 2, '::1'),
(573, 535, 'city', '2014-03-11 08:31:07', 'insert', 2, '::1'),
(574, 27, 'province', '2014-03-11 08:31:07', 'insert', 2, '::1'),
(575, 536, 'city', '2014-03-11 08:31:07', 'insert', 2, '::1'),
(576, 537, 'city', '2014-03-11 08:31:07', 'insert', 2, '::1'),
(577, 538, 'city', '2014-03-11 08:31:07', 'insert', 2, '::1'),
(578, 539, 'city', '2014-03-11 08:31:07', 'insert', 2, '::1'),
(579, 540, 'city', '2014-03-11 08:31:07', 'insert', 2, '::1'),
(580, 541, 'city', '2014-03-11 08:31:07', 'insert', 2, '::1'),
(581, 542, 'city', '2014-03-11 08:31:07', 'insert', 2, '::1'),
(582, 543, 'city', '2014-03-11 08:31:07', 'insert', 2, '::1'),
(583, 544, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(584, 545, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(585, 546, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(586, 547, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(587, 548, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(588, 28, 'province', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(589, 549, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(590, 550, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(591, 551, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(592, 552, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(593, 553, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(594, 554, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(595, 555, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(596, 556, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(597, 557, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(598, 558, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(599, 559, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(600, 560, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(601, 561, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(602, 562, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(603, 29, 'province', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(604, 563, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(605, 564, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(606, 565, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(607, 566, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(608, 567, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(609, 568, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(610, 569, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(611, 570, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(612, 571, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(613, 572, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(614, 573, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(615, 574, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(616, 575, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(617, 576, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(618, 577, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(619, 30, 'province', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(620, 578, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(621, 579, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(622, 580, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(623, 581, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(624, 582, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(625, 583, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(626, 584, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(627, 585, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(628, 586, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(629, 587, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(630, 588, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(631, 589, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(632, 590, 'city', '2014-03-11 08:31:08', 'insert', 2, '::1'),
(633, 1, 'users', '2014-03-11 15:44:15', 'insert', NULL, NULL),
(634, 2, 'users', '2014-03-11 15:44:42', 'insert', NULL, NULL),
(635, 1, 'branch', '2014-03-12 02:19:02', 'insert', 2, '127.0.0.1'),
(636, 1, 'education', '2014-03-12 02:38:00', 'insert', NULL, NULL),
(637, 2, 'education', '2014-03-12 02:48:54', 'insert', 2, '127.0.0.1'),
(638, 1, 'gorup', '2014-03-12 02:53:31', 'insert', 2, '127.0.0.1'),
(639, 2, 'users', '2014-03-14 06:41:32', 'update', NULL, NULL),
(640, 1, 'users', '2014-03-14 06:44:41', 'update', NULL, NULL),
(641, 31, 'permission', '2014-03-14 06:45:22', 'insert', NULL, NULL),
(642, 3, 'education', '2014-03-14 12:01:02', 'insert', NULL, NULL),
(643, 2, 'branch', '2014-03-17 12:17:01', 'insert', NULL, NULL),
(644, 3, 'branch', '2014-03-17 12:17:27', 'insert', NULL, NULL),
(645, 2, 'branch', '2014-03-17 12:17:58', 'delete', NULL, NULL),
(646, 3, 'branch', '2014-03-17 12:18:00', 'delete', NULL, NULL),
(647, 4, 'branch', '2014-03-17 12:18:06', 'insert', NULL, NULL),
(648, 1, 'branch', '2014-03-17 12:19:24', 'update', NULL, NULL),
(649, 1, 'branch', '2014-03-17 12:19:30', 'update', NULL, NULL),
(650, 1, 'branch', '2014-03-17 12:19:34', 'update', NULL, NULL),
(651, 4, 'branch', '2014-03-17 12:19:40', 'delete', NULL, NULL),
(652, 5, 'branch', '2014-04-08 13:43:11', 'insert', NULL, NULL),
(653, 6, 'branch', '2014-04-08 13:43:25', 'insert', NULL, NULL),
(654, 7, 'branch', '2014-04-08 13:43:38', 'insert', NULL, NULL),
(655, 8, 'branch', '2014-04-08 13:43:56', 'insert', NULL, NULL),
(656, 9, 'branch', '2014-04-08 13:44:25', 'insert', NULL, NULL),
(657, 5, 'branch', '2014-04-08 13:44:36', 'delete', NULL, NULL),
(658, 6, 'branch', '2014-04-08 13:44:36', 'delete', NULL, NULL),
(659, 7, 'branch', '2014-04-08 13:44:36', 'delete', NULL, NULL),
(660, 8, 'branch', '2014-04-08 13:44:36', 'delete', NULL, NULL),
(661, 9, 'branch', '2014-04-08 13:44:36', 'delete', NULL, NULL),
(662, 10, 'branch', '2014-04-08 13:44:40', 'insert', NULL, NULL),
(663, 11, 'branch', '2014-04-08 13:44:44', 'insert', NULL, NULL),
(664, 12, 'branch', '2014-04-08 14:53:20', 'insert', NULL, NULL),
(665, 1, 'place', '2014-04-08 15:35:00', 'insert', NULL, NULL),
(666, 10, 'branch', '2014-04-08 19:22:17', 'delete', NULL, NULL),
(667, 11, 'branch', '2014-04-08 19:22:24', 'delete', NULL, NULL),
(668, 12, 'branch', '2014-04-08 19:22:24', 'delete', NULL, NULL),
(669, 1, 'users', '2014-04-11 17:03:50', 'delete', NULL, NULL),
(670, 2, 'users', '2014-04-11 17:03:53', 'delete', NULL, NULL),
(671, 2, 'branch', '2014-04-11 17:27:47', 'insert', NULL, NULL),
(672, 3, 'branch', '2014-04-11 17:28:00', 'insert', NULL, NULL),
(673, 8, 'absence', '2014-04-11 17:43:46', 'update', NULL, NULL),
(674, 9, 'absence', '2014-04-11 17:44:09', 'update', NULL, NULL),
(675, 2, 'branch', '2014-04-11 17:57:41', 'update', NULL, NULL),
(676, 2, 'abcense', '2014-04-11 18:08:24', 'insert', NULL, NULL),
(677, 1, 'branch_description', '2014-04-11 18:19:07', 'insert', NULL, NULL),
(678, 1, 'bridge', '2014-04-11 18:27:30', 'insert', NULL, NULL),
(679, 2, 'bridge', '2014-04-11 18:27:34', 'insert', NULL, NULL),
(680, 2, 'bridge', '2014-04-11 18:27:37', 'update', NULL, NULL),
(681, 4, 'branch', '2014-04-11 18:56:42', 'insert', NULL, NULL),
(682, 31, 'tables', '2014-04-14 06:03:38', 'insert', NULL, NULL),
(683, 31, 'permission', '2014-04-14 06:26:59', 'update', NULL, NULL),
(684, 1, 'education', '2014-04-18 17:06:22', 'update', NULL, NULL),
(685, 2, 'gorup', '2014-04-18 18:16:24', 'insert', NULL, NULL),
(686, 3, 'abcense', '2014-04-19 14:59:07', 'insert', NULL, NULL),
(687, 4, 'abcense', '2014-04-19 14:59:20', 'insert', NULL, NULL),
(688, 32, 'tables', '2014-04-20 09:36:26', 'insert', NULL, NULL),
(689, 33, 'tables', '2014-04-20 09:36:31', 'insert', NULL, NULL),
(690, 34, 'tables', '2014-04-20 09:36:39', 'insert', NULL, NULL),
(691, 35, 'tables', '2014-04-20 09:36:42', 'insert', NULL, NULL),
(692, 36, 'tables', '2014-04-20 09:36:46', 'insert', NULL, NULL),
(693, 4, 'abcense', '2014-04-20 12:37:39', 'delete', NULL, NULL),
(694, 3, 'abcense', '2014-04-20 12:37:39', 'delete', NULL, NULL),
(695, 2, 'abcense', '2014-04-20 12:37:39', 'delete', NULL, NULL),
(696, 1, 'abcense', '2014-04-20 12:37:39', 'delete', NULL, NULL),
(697, 2, 'bridge', '2014-04-20 12:39:21', 'delete', NULL, NULL),
(698, 1, 'bridge', '2014-04-20 12:39:21', 'delete', NULL, NULL),
(699, 1, 'course', '2014-05-08 20:06:59', 'insert', NULL, NULL),
(700, 1, 'plan', '2014-05-08 20:07:30', 'insert', NULL, NULL),
(701, 158, 'city', '2014-05-09 07:21:45', 'delete', NULL, NULL),
(702, 371, 'city', '2014-05-09 07:22:17', 'delete', NULL, NULL),
(703, 1, 'plan', '2014-05-09 11:29:41', 'update', NULL, NULL),
(704, 2, 'plan', '2014-05-09 11:38:24', 'insert', NULL, NULL),
(705, 2, 'plan', '2014-05-09 11:38:37', 'update', NULL, NULL),
(706, 1, 'plan', '2014-05-13 13:58:10', 'update', NULL, NULL),
(707, 1, 'plan', '2014-05-13 13:58:15', 'update', NULL, NULL),
(708, 2, 'plan', '2014-05-13 13:58:19', 'update', NULL, NULL),
(709, 1, 'course', '2014-05-15 12:51:02', 'update', NULL, NULL),
(710, 1, 'bridge', '2014-05-15 12:52:03', 'insert', NULL, NULL),
(711, 0, '17', '0000-00-00 00:00:00', 'insert', NULL, NULL),
(712, 0, '17', '0000-00-00 00:00:00', 'insert', NULL, NULL),
(713, 0, '17', '0000-00-00 00:00:00', 'insert', NULL, NULL),
(714, 0, '17', '0000-00-00 00:00:00', 'insert', NULL, NULL),
(715, 0, '17', '0000-00-00 00:00:00', 'insert', NULL, NULL),
(716, 0, '17', '0000-00-00 00:00:00', 'insert', NULL, NULL),
(717, 0, '17', '0000-00-00 00:00:00', 'insert', NULL, NULL),
(718, 0, '17', '0000-00-00 00:00:00', 'insert', NULL, NULL),
(719, 0, '17', '0000-00-00 00:00:00', 'insert', NULL, NULL),
(720, 0, '17', '0000-00-00 00:00:00', 'insert', NULL, NULL),
(721, 0, '17', '0000-00-00 00:00:00', 'insert', NULL, NULL),
(722, 0, '17', '0000-00-00 00:00:00', 'insert', NULL, NULL),
(723, 6, 'bridge', '2014-07-15 08:31:48', 'insert', NULL, NULL),
(724, 3, 'class', '2014-07-15 09:01:37', 'insert', NULL, NULL),
(725, 5, 'class', '2014-07-15 09:03:29', 'insert', NULL, NULL),
(726, 5, 'class', '2014-07-15 09:03:31', 'update', NULL, NULL),
(727, 6, 'branch', '2014-07-15 19:02:52', 'insert', NULL, NULL),
(728, 7, 'branch', '2014-08-10 03:11:43', 'insert', NULL, NULL),
(729, 8, 'branch', '2014-08-10 04:41:09', 'insert', NULL, NULL),
(730, 13, 'branch', '2014-08-10 04:45:21', 'insert', NULL, NULL),
(731, 13, 'branch', '2014-08-10 05:39:15', 'delete', NULL, NULL),
(732, 22, 'branch', '2014-08-10 05:39:22', 'insert', NULL, NULL),
(733, 22, 'branch', '2014-08-10 05:39:34', 'delete', NULL, NULL),
(734, 24, 'branch', '2014-08-10 05:39:36', 'insert', NULL, NULL),
(735, 42, 'branch', '2014-08-10 05:52:54', 'insert', NULL, NULL),
(736, 44, 'branch', '2014-08-10 06:01:39', 'insert', NULL, NULL),
(737, 45, 'branch', '2014-08-10 06:01:47', 'insert', NULL, NULL),
(738, 49, 'branch', '2014-08-10 12:51:01', 'insert', NULL, NULL),
(739, 50, 'branch', '2014-08-10 12:51:56', 'insert', NULL, NULL),
(740, 52, 'branch', '2014-08-10 12:52:52', 'insert', NULL, NULL),
(741, 1, 'country', '2014-08-12 07:48:07', 'insert', NULL, NULL),
(742, 3, 'country', '2014-08-12 07:48:20', 'insert', NULL, NULL),
(743, 32, 'province', '2014-08-12 08:11:37', 'insert', NULL, NULL),
(744, 1, 'person', '2014-08-13 07:59:31', 'insert', NULL, NULL),
(745, 2, 'person', '2014-08-13 08:00:36', 'insert', NULL, NULL),
(746, 1, 'tags', '2014-08-14 06:41:04', 'insert', NULL, NULL),
(747, 2, 'tags', '2014-08-14 06:41:50', 'insert', NULL, NULL),
(748, 4, 'tags', '2014-08-14 06:43:26', 'insert', NULL, NULL),
(754, 1, 'person', '2014-08-14 13:07:10', 'update', NULL, NULL),
(755, 6, 'person', '2014-08-14 18:27:31', 'insert', NULL, NULL),
(756, 7, 'person', '2014-08-14 18:30:59', 'insert', NULL, NULL),
(757, 7, 'person', '2014-08-14 18:42:53', 'update', NULL, NULL),
(758, 7, 'person', '2014-08-14 18:45:02', 'update', NULL, NULL),
(759, 8, 'person', '2014-08-14 18:46:27', 'insert', NULL, NULL),
(760, 9, 'person', '2014-08-14 19:17:33', 'insert', NULL, NULL),
(761, 10, 'person', '2014-08-14 19:18:25', 'insert', NULL, NULL),
(762, 1, 'news_group', '2014-08-16 04:53:27', 'insert', NULL, NULL),
(763, 3, 'news', '2014-08-16 04:53:35', 'insert', NULL, NULL),
(771, 15, 'news', '2014-08-16 05:00:05', 'insert', NULL, NULL),
(772, 16, 'news', '2014-08-16 05:02:02', 'insert', NULL, NULL),
(773, 16, 'news', '2014-08-16 05:40:19', 'update', NULL, NULL),
(774, 16, 'news', '2014-08-16 05:40:40', 'update', NULL, NULL),
(775, 5, 'tags', '2014-08-16 06:32:17', 'insert', NULL, NULL),
(776, 6, 'tags', '2014-08-16 06:32:42', 'insert', NULL, NULL),
(777, 6, 'tags', '2014-08-16 06:34:25', 'update', NULL, NULL),
(778, 7, 'tags', '2014-08-16 06:34:47', 'insert', NULL, NULL),
(779, 8, 'tags', '2014-08-16 06:34:57', 'insert', NULL, NULL),
(780, 8, 'tags', '2014-08-16 06:35:18', 'update', NULL, NULL),
(781, 7, 'tags', '2014-08-16 06:35:38', 'update', NULL, NULL),
(782, 7, 'tags', '2014-08-16 06:35:48', 'update', NULL, NULL),
(783, 2, 'news_group', '2014-08-16 07:10:11', 'insert', NULL, NULL),
(784, 3, 'news_group', '2014-08-16 07:10:40', 'insert', NULL, NULL),
(785, 17, 'news', '2014-08-16 07:19:05', 'insert', NULL, NULL),
(786, 16, 'news', '2014-08-16 07:19:38', 'update', NULL, NULL),
(787, 16, 'news', '2014-08-16 07:19:45', 'update', NULL, NULL),
(788, 1, 'person', '2014-08-16 08:58:45', 'update', NULL, NULL),
(789, 8, 'person', '2014-08-16 09:43:51', 'update', NULL, NULL),
(790, 8, 'tags', '2014-08-16 10:30:49', 'update', NULL, NULL),
(791, 0, 'news_tags', '2014-08-16 11:31:39', 'insert', NULL, NULL),
(792, 2, 'news_tags', '2014-08-16 11:34:05', 'insert', NULL, NULL),
(793, 18, 'news', '2014-08-17 05:20:42', 'insert', NULL, NULL),
(794, 18, 'news', '2014-08-17 05:21:20', 'update', NULL, NULL),
(795, 7, 'person', '2014-08-17 05:22:05', 'update', NULL, NULL),
(796, 7, 'person', '2014-08-17 06:14:21', 'update', NULL, NULL),
(797, 33, 'province', '2014-08-17 06:37:56', 'insert', NULL, NULL),
(798, 35, 'province', '2014-08-17 06:39:27', 'insert', NULL, NULL),
(799, 36, 'province', '2014-08-17 06:39:31', 'insert', NULL, NULL),
(800, 32, 'province', '2014-08-17 06:41:09', 'delete', NULL, NULL),
(801, 33, 'province', '2014-08-17 06:41:11', 'delete', NULL, NULL),
(802, 36, 'province', '2014-08-17 06:41:14', 'delete', NULL, NULL),
(803, 35, 'province', '2014-08-17 06:41:16', 'delete', NULL, NULL),
(804, 4, 'country', '2014-08-17 07:12:46', 'insert', NULL, NULL),
(805, 3, 'country', '2014-08-17 07:14:11', 'update', NULL, NULL),
(806, 3, 'country', '2014-08-17 07:14:17', 'update', NULL, NULL),
(808, 4, 'education', '2014-08-17 07:35:37', 'insert', NULL, NULL),
(809, 5, 'education', '2014-08-17 07:35:53', 'insert', NULL, NULL),
(810, 5, 'education', '2014-08-17 07:36:13', 'update', NULL, NULL),
(811, 54, 'branch', '2014-08-17 07:57:39', 'insert', NULL, NULL),
(812, 3, 'branch', '2014-08-17 07:58:14', 'update', NULL, NULL),
(813, 3, 'branch', '2014-08-17 07:58:18', 'update', NULL, NULL),
(814, 3, 'gorup', '2014-08-17 08:54:54', 'insert', NULL, NULL),
(815, 5, 'class', '2014-08-17 11:52:26', 'update', NULL, NULL),
(816, 3, 'class', '2014-08-17 11:52:34', 'update', NULL, NULL),
(817, 5, 'class', '2014-08-17 11:52:42', 'update', NULL, NULL),
(819, 17, 'class', '2014-08-17 11:55:07', 'insert', NULL, NULL),
(820, 1, 'users2class', '2014-08-17 12:34:13', 'insert', NULL, NULL),
(821, 7, 'bridge', '2014-08-17 12:51:30', 'insert', NULL, NULL),
(822, 2, 'place', '2014-08-17 13:07:38', 'insert', NULL, NULL),
(823, 2, 'branch_description', '2014-08-17 18:25:58', 'insert', NULL, NULL),
(824, 2, 'branch_description', '2014-08-17 18:27:49', 'update', NULL, NULL),
(825, 1, 'folders', '2014-08-17 18:45:40', 'insert', NULL, NULL),
(826, 1, 'files', '2014-08-17 18:50:45', 'insert', NULL, NULL),
(827, 2, 'files', '2014-08-17 18:54:48', 'insert', NULL, NULL),
(828, 2, 'files', '2014-08-17 18:55:08', 'update', NULL, NULL),
(829, 2, 'files', '2014-08-17 18:55:24', 'update', NULL, NULL),
(830, 2, 'files', '2014-08-17 18:55:26', 'update', NULL, NULL),
(831, 2, 'files', '2014-08-17 18:55:29', 'update', NULL, NULL),
(832, 2, 'files', '2014-08-17 18:55:36', 'update', NULL, NULL),
(833, 2, 'files', '2014-08-17 18:55:37', 'update', NULL, NULL),
(834, 2, 'files', '2014-08-17 18:55:48', 'update', NULL, NULL),
(835, 1, 'prerequisite', '2014-08-17 19:05:01', 'insert', NULL, NULL),
(836, 1, 'teaching_history', '2014-08-18 06:15:27', 'insert', NULL, NULL),
(837, 1, 'race_history', '2014-08-18 06:27:19', 'insert', NULL, NULL),
(838, 1, 'course_description', '2014-08-18 06:38:21', 'insert', NULL, NULL);
INSERT INTO `history` (`id`, `record_id`, `table`, `date`, `query_type`, `users_id`, `ip`) VALUES
(839, 1, 'tables', '2014-08-18 11:14:06', 'update', NULL, NULL),
(840, 32, 'permission', '2014-08-18 11:31:00', 'insert', NULL, NULL),
(841, 32, 'permission', '2014-08-18 11:31:52', 'update', NULL, NULL),
(842, 0, 'group_list', '2014-08-18 12:37:33', 'insert', NULL, NULL),
(843, 1, 'group_list', '2014-08-18 12:38:41', 'update', NULL, NULL),
(844, 0, 'users_group', '2014-08-18 12:50:48', 'insert', NULL, NULL),
(845, 1, 'users_branch', '2014-08-18 13:04:47', 'insert', NULL, NULL),
(846, 1, 'users_description', '2014-08-18 13:13:54', 'insert', NULL, NULL),
(847, 1, 'graduate', '2014-08-18 20:14:49', 'insert', NULL, NULL),
(848, 0, 'graduate_classes', '2014-08-18 20:24:17', 'insert', NULL, NULL),
(849, 1, 'plan_section', '2014-08-19 03:11:19', 'insert', NULL, NULL),
(850, 1, 'classification', '2014-08-19 03:17:19', 'update', NULL, NULL),
(851, 1, 'classification', '2014-08-19 03:20:10', 'update', NULL, NULL),
(852, 1, 'entry_regulation', '2014-08-19 05:10:32', 'insert', NULL, NULL),
(853, 2, 'entry_regulation', '2014-08-19 05:12:21', 'insert', NULL, NULL),
(854, 1, 'entry_regulation', '2014-08-19 05:12:55', 'update', NULL, NULL),
(855, 1, 'entry_regulation', '2014-08-19 05:18:13', 'update', NULL, NULL),
(856, 1, 'entry_regulation', '2014-08-19 05:18:16', 'update', NULL, NULL),
(857, 1, 'entry_regulation', '2014-08-19 05:19:55', 'update', NULL, NULL),
(860, 1, 'entry_regulation', '2014-08-19 05:26:54', 'update', NULL, NULL),
(861, 1, 'entry_regulation', '2014-08-19 05:27:02', 'update', NULL, NULL),
(862, 2, 'entry_regulation', '2014-08-19 05:27:38', 'update', NULL, NULL),
(863, 2, 'entry_regulation', '2014-08-19 05:27:49', 'update', NULL, NULL),
(864, 2, 'entry_regulation', '2014-08-19 05:28:17', 'update', NULL, NULL),
(865, 2, 'entry_regulation', '2014-08-19 05:28:20', 'update', NULL, NULL),
(866, 3, 'course', '2014-08-19 12:14:39', 'insert', NULL, NULL),
(867, 1, 'course', '2014-08-19 12:27:42', 'update', NULL, NULL),
(868, 3, 'course', '2014-08-19 12:27:44', 'update', NULL, NULL),
(869, 1, 'course', '2014-08-19 12:28:59', 'update', NULL, NULL),
(870, 32, 'city', '2014-08-20 05:46:10', 'delete', NULL, NULL),
(871, 33, 'city', '2014-08-20 05:46:10', 'delete', NULL, NULL),
(872, 53, 'city', '2014-08-20 05:46:10', 'delete', NULL, NULL),
(873, 54, 'city', '2014-08-20 05:46:10', 'delete', NULL, NULL),
(874, 41, 'city', '2014-08-20 05:46:10', 'delete', NULL, NULL),
(875, 30, 'city', '2014-08-20 05:46:10', 'delete', NULL, NULL),
(876, 34, 'city', '2014-08-20 05:46:10', 'delete', NULL, NULL),
(877, 20, 'city', '2014-08-20 05:46:10', 'delete', NULL, NULL),
(878, 42, 'city', '2014-08-20 05:46:10', 'delete', NULL, NULL),
(879, 35, 'city', '2014-08-20 05:46:10', 'delete', NULL, NULL),
(880, 21, 'city', '2014-08-20 05:46:10', 'delete', NULL, NULL),
(881, 55, 'city', '2014-08-20 05:46:10', 'delete', NULL, NULL),
(882, 43, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(883, 36, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(884, 56, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(885, 57, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(886, 58, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(887, 22, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(888, 44, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(889, 59, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(890, 23, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(891, 28, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(892, 24, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(893, 37, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(894, 25, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(895, 26, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(896, 27, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(897, 60, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(898, 61, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(899, 45, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(900, 31, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(901, 68, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(902, 62, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(903, 63, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(904, 69, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(905, 70, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(906, 64, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(907, 65, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(908, 71, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(909, 67, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(910, 66, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(911, 84, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(912, 88, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(913, 72, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(914, 92, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(915, 83, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(916, 73, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(917, 74, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(918, 97, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(919, 94, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(920, 75, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(921, 76, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(922, 93, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(923, 77, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(924, 78, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(925, 85, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(926, 95, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(927, 89, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(928, 79, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(929, 80, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(930, 81, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(931, 86, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(932, 96, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(933, 82, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(934, 87, 'city', '2014-08-20 05:46:11', 'delete', NULL, NULL),
(935, 98, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(936, 90, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(937, 91, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(938, 99, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(939, 112, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(940, 100, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(941, 101, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(942, 102, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(943, 113, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(944, 103, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(945, 104, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(946, 105, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(947, 114, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(948, 111, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(949, 115, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(950, 116, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(951, 106, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(952, 107, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(953, 108, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(954, 109, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(955, 110, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(956, 126, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(957, 125, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(958, 117, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(959, 118, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(960, 127, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(961, 128, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(962, 119, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(963, 129, 'city', '2014-08-20 05:46:12', 'delete', NULL, NULL),
(964, 120, 'city', '2014-08-20 05:46:13', 'delete', NULL, NULL),
(965, 121, 'city', '2014-08-20 05:46:13', 'delete', NULL, NULL),
(966, 123, 'city', '2014-08-20 05:46:13', 'delete', NULL, NULL),
(967, 124, 'city', '2014-08-20 05:46:13', 'delete', NULL, NULL),
(968, 122, 'city', '2014-08-20 05:46:13', 'delete', NULL, NULL),
(969, 131, 'city', '2014-08-20 05:46:13', 'delete', NULL, NULL),
(970, 130, 'city', '2014-08-20 05:46:13', 'delete', NULL, NULL),
(971, 164, 'city', '2014-08-20 05:46:13', 'delete', NULL, NULL),
(972, 1, 'person', '2014-08-20 05:47:02', 'delete', NULL, NULL),
(973, 2, 'person', '2014-08-20 05:47:02', 'delete', NULL, NULL),
(974, 6, 'person', '2014-08-20 05:47:02', 'delete', NULL, NULL),
(975, 7, 'person', '2014-08-20 05:47:02', 'delete', NULL, NULL),
(976, 8, 'person', '2014-08-20 05:47:02', 'delete', NULL, NULL),
(977, 9, 'person', '2014-08-20 05:47:03', 'delete', NULL, NULL),
(978, 10, 'person', '2014-08-20 05:47:03', 'delete', NULL, NULL),
(979, 165, 'city', '2014-08-20 05:48:08', 'delete', NULL, NULL),
(980, 146, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(981, 132, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(982, 166, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(983, 167, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(984, 168, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(985, 169, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(986, 170, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(987, 171, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(988, 172, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(989, 173, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(990, 174, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(991, 175, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(992, 176, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(993, 177, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(994, 178, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(995, 133, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(996, 179, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(997, 180, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(998, 181, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(999, 182, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1000, 183, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1001, 184, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1002, 185, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1003, 187, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1004, 142, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1005, 186, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1006, 147, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1007, 189, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1008, 190, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1009, 191, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1010, 192, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1011, 193, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1012, 194, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1013, 195, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1014, 196, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1015, 197, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1016, 198, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1017, 199, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1018, 200, 'city', '2014-08-20 05:48:09', 'delete', NULL, NULL),
(1019, 201, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1020, 202, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1021, 203, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1022, 204, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1023, 163, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1024, 205, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1025, 206, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1026, 207, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1027, 208, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1028, 162, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1029, 209, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1030, 210, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1031, 211, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1032, 144, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1033, 157, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1034, 161, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1035, 212, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1036, 213, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1037, 214, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1038, 215, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1039, 216, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1040, 217, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1041, 218, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1042, 219, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1043, 134, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1044, 135, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1045, 136, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1046, 220, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1047, 160, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1048, 221, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1049, 222, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1050, 223, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1051, 224, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1052, 225, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1053, 226, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1054, 227, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1055, 228, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1056, 229, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1057, 230, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1058, 231, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1059, 232, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1060, 233, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1061, 234, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1062, 235, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1063, 236, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1064, 159, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1065, 237, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1066, 238, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1067, 239, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1068, 240, 'city', '2014-08-20 05:48:10', 'delete', NULL, NULL),
(1069, 241, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1070, 242, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1071, 243, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1072, 244, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1073, 245, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1074, 246, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1075, 145, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1076, 247, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1077, 141, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1078, 248, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1079, 249, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1080, 250, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1081, 251, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1082, 252, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1083, 253, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1084, 254, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1085, 255, 'city', '2014-08-20 05:48:11', 'delete', NULL, NULL),
(1086, 256, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1087, 257, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1088, 258, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1089, 259, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1090, 260, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1091, 261, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1092, 262, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1093, 263, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1094, 264, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1095, 156, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1096, 137, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1097, 188, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1098, 143, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1099, 155, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1100, 138, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1101, 139, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1102, 154, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1103, 153, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1104, 152, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1105, 151, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1106, 150, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1107, 149, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1108, 140, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1109, 148, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1110, 270, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1111, 265, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1112, 271, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1113, 266, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1114, 267, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1115, 272, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1116, 268, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1117, 273, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1118, 269, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1119, 281, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1120, 274, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1121, 275, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1122, 282, 'city', '2014-08-20 05:48:12', 'delete', NULL, NULL),
(1123, 283, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1124, 276, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1125, 277, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1126, 278, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1127, 280, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1128, 279, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1129, 299, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1130, 295, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1131, 296, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1132, 284, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1133, 285, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1134, 300, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1135, 301, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1136, 302, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1137, 303, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1138, 297, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1139, 305, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1140, 304, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1141, 286, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1142, 287, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1143, 288, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1144, 298, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1145, 289, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1146, 290, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1147, 291, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1148, 292, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1149, 293, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1150, 294, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1151, 309, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1152, 308, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1153, 306, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1154, 307, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1155, 313, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1156, 330, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1157, 326, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1158, 310, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1159, 331, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1160, 332, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1161, 311, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1162, 312, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1163, 333, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1164, 314, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1165, 327, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1166, 316, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1167, 317, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1168, 334, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1169, 318, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1170, 324, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1171, 319, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1172, 320, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1173, 335, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1174, 315, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1175, 328, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1176, 329, 'city', '2014-08-20 05:48:13', 'delete', NULL, NULL),
(1177, 336, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1178, 321, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1179, 337, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1180, 338, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1181, 325, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1182, 322, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1183, 339, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1184, 323, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1185, 340, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1186, 341, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1187, 346, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1188, 348, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1189, 342, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1190, 343, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1191, 344, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1192, 347, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1193, 345, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1194, 354, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1195, 355, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1196, 349, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1197, 350, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1198, 351, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1199, 352, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1200, 353, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1201, 356, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1202, 358, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1203, 359, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1204, 357, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1205, 367, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1206, 360, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1207, 361, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1208, 362, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1209, 363, 'city', '2014-08-20 05:48:33', 'delete', NULL, NULL),
(1210, 366, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1211, 364, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1212, 365, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1213, 368, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1214, 388, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1215, 389, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1216, 382, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1217, 369, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1218, 383, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1219, 370, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1220, 372, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1221, 390, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1222, 391, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1223, 392, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1224, 394, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1225, 384, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1226, 393, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1227, 373, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1228, 395, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1229, 374, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1230, 396, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1231, 375, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1232, 397, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1233, 398, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1234, 376, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1235, 385, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1236, 400, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1237, 377, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1238, 386, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1239, 399, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1240, 401, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1241, 387, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1242, 405, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1243, 402, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1244, 378, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1245, 379, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1246, 403, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1247, 404, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1248, 380, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1249, 381, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1250, 410, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1251, 406, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1252, 411, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1253, 407, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1254, 408, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1255, 409, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1256, 414, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1257, 415, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1258, 412, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1259, 413, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1260, 416, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1261, 417, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1262, 418, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1263, 424, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1264, 425, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1265, 419, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1266, 426, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1267, 420, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1268, 421, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1269, 422, 'city', '2014-08-20 05:48:34', 'delete', NULL, NULL),
(1270, 427, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1271, 423, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1272, 446, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1273, 428, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1274, 447, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1275, 429, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1276, 442, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1277, 430, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1278, 448, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1279, 441, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1280, 440, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1281, 449, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1282, 444, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1283, 450, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1284, 431, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1285, 445, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1286, 443, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1287, 432, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1288, 451, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1289, 433, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1290, 434, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1291, 435, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1292, 452, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1293, 453, 'city', '2014-08-20 05:48:35', 'delete', NULL, NULL),
(1294, 436, 'city', '2014-08-20 05:48:36', 'delete', NULL, NULL),
(1295, 454, 'city', '2014-08-20 05:48:36', 'delete', NULL, NULL),
(1296, 437, 'city', '2014-08-20 05:48:36', 'delete', NULL, NULL),
(1297, 455, 'city', '2014-08-20 05:48:36', 'delete', NULL, NULL),
(1298, 438, 'city', '2014-08-20 05:48:36', 'delete', NULL, NULL),
(1299, 456, 'city', '2014-08-20 05:48:36', 'delete', NULL, NULL),
(1300, 439, 'city', '2014-08-20 05:48:36', 'delete', NULL, NULL),
(1301, 457, 'city', '2014-08-20 05:48:36', 'delete', NULL, NULL),
(1302, 468, 'city', '2014-08-20 05:48:36', 'delete', NULL, NULL),
(1303, 458, 'city', '2014-08-20 05:48:36', 'delete', NULL, NULL),
(1304, 466, 'city', '2014-08-20 05:48:36', 'delete', NULL, NULL),
(1305, 465, 'city', '2014-08-20 05:48:36', 'delete', NULL, NULL),
(1306, 459, 'city', '2014-08-20 05:48:36', 'delete', NULL, NULL),
(1307, 460, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1308, 461, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1309, 462, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1310, 463, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1311, 464, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1312, 467, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1313, 469, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1314, 473, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1315, 470, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1316, 472, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1317, 474, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1318, 475, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1319, 471, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1320, 481, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1321, 482, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1322, 480, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1323, 483, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1324, 484, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1325, 485, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1326, 476, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1327, 486, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1328, 487, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1329, 477, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1330, 478, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1331, 479, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1332, 488, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1333, 496, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1334, 497, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1335, 490, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1336, 493, 'city', '2014-08-20 05:48:37', 'delete', NULL, NULL),
(1337, 489, 'city', '2014-08-20 05:48:38', 'delete', NULL, NULL),
(1338, 498, 'city', '2014-08-20 05:48:38', 'delete', NULL, NULL),
(1339, 494, 'city', '2014-08-20 05:48:38', 'delete', NULL, NULL),
(1340, 499, 'city', '2014-08-20 05:48:38', 'delete', NULL, NULL),
(1341, 500, 'city', '2014-08-20 05:48:38', 'delete', NULL, NULL),
(1342, 495, 'city', '2014-08-20 05:48:38', 'delete', NULL, NULL),
(1343, 501, 'city', '2014-08-20 05:48:38', 'delete', NULL, NULL),
(1344, 491, 'city', '2014-08-20 05:48:38', 'delete', NULL, NULL),
(1345, 502, 'city', '2014-08-20 05:48:38', 'delete', NULL, NULL),
(1346, 492, 'city', '2014-08-20 05:48:38', 'delete', NULL, NULL),
(1347, 503, 'city', '2014-08-20 05:48:38', 'delete', NULL, NULL),
(1348, 504, 'city', '2014-08-20 05:48:38', 'delete', NULL, NULL),
(1349, 505, 'city', '2014-08-20 05:48:39', 'delete', NULL, NULL),
(1350, 506, 'city', '2014-08-20 05:48:39', 'delete', NULL, NULL),
(1351, 509, 'city', '2014-08-20 05:48:39', 'delete', NULL, NULL),
(1352, 507, 'city', '2014-08-20 05:48:39', 'delete', NULL, NULL),
(1353, 510, 'city', '2014-08-20 05:48:39', 'delete', NULL, NULL),
(1354, 508, 'city', '2014-08-20 05:48:39', 'delete', NULL, NULL),
(1355, 511, 'city', '2014-08-20 05:48:39', 'delete', NULL, NULL),
(1356, 513, 'city', '2014-08-20 05:48:39', 'delete', NULL, NULL),
(1357, 512, 'city', '2014-08-20 05:48:39', 'delete', NULL, NULL),
(1358, 521, 'city', '2014-08-20 05:48:39', 'delete', NULL, NULL),
(1359, 514, 'city', '2014-08-20 05:48:39', 'delete', NULL, NULL),
(1360, 525, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1361, 522, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1362, 516, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1363, 523, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1364, 526, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1365, 532, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1366, 515, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1367, 527, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1368, 528, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1369, 517, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1370, 535, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1371, 529, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1372, 518, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1373, 519, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1374, 524, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1375, 534, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1376, 530, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1377, 531, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1378, 533, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1379, 520, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1380, 543, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1381, 536, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1382, 537, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1383, 538, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1384, 539, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1385, 540, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1386, 542, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1387, 544, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1388, 545, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1389, 546, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1390, 541, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1391, 547, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1392, 548, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1393, 549, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1394, 558, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1395, 552, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1396, 559, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1397, 550, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1398, 551, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1399, 556, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1400, 553, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1401, 561, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1402, 562, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1403, 560, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1404, 554, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1405, 555, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1406, 557, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1407, 567, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1408, 568, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1409, 566, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1410, 572, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1411, 569, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1412, 573, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1413, 574, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1414, 575, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1415, 576, 'city', '2014-08-20 05:48:40', 'delete', NULL, NULL),
(1416, 571, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1417, 570, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1418, 577, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1419, 563, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1420, 564, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1421, 565, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1422, 578, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1423, 589, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1424, 579, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1425, 590, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1426, 580, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1427, 588, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1428, 587, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1429, 581, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1430, 582, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1431, 583, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1432, 584, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1433, 585, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1434, 586, 'city', '2014-08-20 05:48:41', 'delete', NULL, NULL),
(1435, 1, 'city', '2014-08-20 05:48:53', 'delete', NULL, NULL),
(1436, 8, 'city', '2014-08-20 05:48:53', 'delete', NULL, NULL),
(1437, 3, 'city', '2014-08-20 05:48:53', 'delete', NULL, NULL),
(1438, 2, 'city', '2014-08-20 05:48:53', 'delete', NULL, NULL),
(1439, 13, 'city', '2014-08-20 05:48:53', 'delete', NULL, NULL),
(1440, 4, 'city', '2014-08-20 05:48:53', 'delete', NULL, NULL),
(1441, 5, 'city', '2014-08-20 05:48:53', 'delete', NULL, NULL),
(1442, 7, 'city', '2014-08-20 05:48:53', 'delete', NULL, NULL),
(1443, 12, 'city', '2014-08-20 05:48:53', 'delete', NULL, NULL),
(1444, 11, 'city', '2014-08-20 05:48:53', 'delete', NULL, NULL),
(1445, 6, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1446, 10, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1447, 9, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1448, 38, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1449, 14, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1450, 15, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1451, 16, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1452, 46, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1453, 47, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1454, 48, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1455, 49, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1456, 50, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1457, 39, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1458, 51, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1459, 52, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1460, 29, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1461, 40, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1462, 17, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1463, 18, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1464, 19, 'city', '2014-08-20 05:48:54', 'delete', NULL, NULL),
(1465, 1, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1466, 2, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1467, 3, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1468, 4, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1469, 5, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1470, 6, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1471, 7, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1472, 8, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1473, 9, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1474, 10, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1475, 11, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1476, 12, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1477, 13, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1478, 14, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1479, 15, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1480, 16, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1481, 17, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1482, 18, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1483, 19, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1484, 20, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1485, 21, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1486, 22, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1487, 23, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1488, 24, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1489, 25, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1490, 26, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1491, 27, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1492, 28, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1493, 29, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1494, 30, 'province', '2014-08-20 05:58:34', 'delete', NULL, NULL),
(1495, 1, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1496, 2, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1497, 3, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1498, 4, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1499, 5, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1500, 6, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1501, 7, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1502, 8, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1503, 9, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1504, 10, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1505, 11, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1506, 12, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1507, 13, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1508, 14, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1509, 15, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1510, 16, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1511, 17, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1512, 18, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1513, 19, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1514, 20, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1515, 21, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1516, 22, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1517, 23, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1518, 24, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1519, 25, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1520, 26, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1521, 27, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1522, 28, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1523, 29, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1524, 30, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(1525, 31, 'province', '2014-08-20 05:59:12', 'insert', NULL, NULL),
(2347, 2, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2348, 3, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2349, 4, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2350, 5, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2351, 6, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2352, 7, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2353, 8, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2354, 9, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2355, 10, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2356, 11, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2357, 12, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2358, 13, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2359, 14, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2360, 15, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2361, 16, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2362, 17, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2363, 18, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2364, 19, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2365, 20, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2366, 21, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2367, 22, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2368, 23, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2369, 24, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2370, 25, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2371, 26, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2372, 27, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2373, 28, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2374, 29, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2375, 30, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2376, 31, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2377, 32, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2378, 33, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2379, 34, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2380, 35, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2381, 36, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2382, 37, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2383, 38, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2384, 39, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2385, 40, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2386, 41, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2387, 42, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2388, 43, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2389, 44, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2390, 45, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2391, 46, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2392, 47, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2393, 48, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2394, 49, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2395, 50, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2396, 51, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2397, 52, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2398, 53, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2399, 54, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2400, 55, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2401, 56, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2402, 57, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2403, 58, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2404, 59, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2405, 60, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2406, 61, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2407, 62, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2408, 63, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2409, 64, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2410, 65, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2411, 66, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2412, 67, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2413, 68, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2414, 69, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2415, 70, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2416, 71, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2417, 72, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2418, 73, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2419, 74, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2420, 75, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2421, 76, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2422, 77, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2423, 78, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2424, 79, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2425, 80, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2426, 81, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2427, 82, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2428, 83, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2429, 84, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2430, 85, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2431, 86, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2432, 87, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2433, 88, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2434, 89, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2435, 90, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2436, 91, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2437, 92, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2438, 93, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2439, 94, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2440, 95, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL);
INSERT INTO `history` (`id`, `record_id`, `table`, `date`, `query_type`, `users_id`, `ip`) VALUES
(2441, 96, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2442, 97, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2443, 98, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2444, 99, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2445, 100, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2446, 101, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2447, 102, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2448, 103, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2449, 104, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2450, 105, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2451, 106, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2452, 107, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2453, 108, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2454, 109, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2455, 110, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2456, 111, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2457, 112, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2458, 113, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2459, 114, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2460, 115, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2461, 116, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2462, 117, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2463, 118, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2464, 119, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2465, 120, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2466, 121, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2467, 122, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2468, 123, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2469, 124, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2470, 125, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2471, 126, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2472, 127, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2473, 128, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2474, 129, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2475, 130, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2476, 131, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2477, 132, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2478, 133, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2479, 134, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2480, 135, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2481, 136, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2482, 137, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2483, 138, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2484, 139, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2485, 140, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2486, 141, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2487, 142, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2488, 143, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2489, 144, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2490, 145, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2491, 146, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2492, 147, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2493, 148, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2494, 149, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2495, 150, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2496, 151, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2497, 152, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2498, 153, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2499, 154, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2500, 155, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2501, 156, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2502, 157, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2503, 158, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2504, 159, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2505, 160, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2506, 161, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2507, 162, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2508, 163, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2509, 164, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2510, 165, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2511, 166, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2512, 167, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2513, 168, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2514, 169, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2515, 170, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2516, 171, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2517, 172, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2518, 173, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2519, 174, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2520, 175, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2521, 176, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2522, 177, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2523, 178, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2524, 179, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2525, 180, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2526, 181, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2527, 182, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2528, 183, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2529, 184, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2530, 185, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2531, 186, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2532, 187, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2533, 188, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2534, 189, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2535, 190, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2536, 191, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2537, 192, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2538, 193, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2539, 194, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2540, 195, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2541, 196, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2542, 197, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2543, 198, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2544, 199, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2545, 200, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2546, 201, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2547, 202, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2548, 203, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2549, 204, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2550, 206, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2551, 207, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2552, 208, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2553, 209, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2554, 210, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2555, 211, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2556, 212, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2557, 213, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2558, 214, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2559, 215, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2560, 216, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2561, 217, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2562, 218, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2563, 219, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2564, 220, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2565, 221, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2566, 222, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2567, 223, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2568, 224, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2569, 225, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2570, 226, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2571, 227, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2572, 228, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2573, 229, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2574, 230, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2575, 231, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2576, 232, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2577, 233, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2578, 234, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2579, 235, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2580, 236, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2581, 237, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2582, 238, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2583, 239, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2584, 240, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2585, 241, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2586, 242, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2587, 243, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2588, 244, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2589, 245, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2590, 246, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2591, 247, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2592, 248, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2593, 249, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2594, 250, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2595, 251, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2596, 252, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2597, 253, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2598, 254, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2599, 255, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2600, 256, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2601, 257, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2602, 258, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2603, 259, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2604, 260, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2605, 261, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2606, 262, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2607, 263, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2608, 264, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2609, 265, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2610, 266, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2611, 267, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2612, 268, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2613, 269, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2614, 270, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2615, 271, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2616, 272, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2617, 273, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2618, 274, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2619, 275, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2620, 276, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2621, 277, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2622, 278, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2623, 279, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2624, 280, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2625, 281, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2626, 282, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2627, 283, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2628, 284, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2629, 285, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2630, 286, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2631, 287, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2632, 288, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2633, 289, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2634, 290, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2635, 291, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2636, 292, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2637, 293, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2638, 294, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2639, 295, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2640, 296, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2641, 297, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2642, 298, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2643, 299, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2644, 300, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2645, 301, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2646, 302, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2647, 303, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2648, 304, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2649, 305, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2650, 306, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2651, 307, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2652, 308, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2653, 309, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2654, 310, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2655, 311, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2656, 312, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2657, 313, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2658, 314, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2659, 315, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2660, 316, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2661, 317, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2662, 318, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2663, 319, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2664, 320, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2665, 321, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2666, 322, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2667, 323, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2668, 324, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2669, 325, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2670, 326, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2671, 327, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2672, 328, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2673, 329, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2674, 330, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2675, 331, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2676, 332, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2677, 333, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2678, 334, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2679, 335, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2680, 336, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2681, 337, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2682, 338, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2683, 339, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2684, 340, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2685, 341, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2686, 342, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2687, 343, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2688, 344, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2689, 345, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2690, 346, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2691, 347, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2692, 348, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2693, 349, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2694, 350, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2695, 351, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2696, 352, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2697, 353, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2698, 354, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2699, 355, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2700, 356, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2701, 357, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2702, 358, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2703, 359, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2704, 360, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2705, 361, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2706, 362, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2707, 363, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2708, 364, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2709, 365, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2710, 366, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2711, 367, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2712, 368, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2713, 369, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2714, 370, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2715, 371, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2716, 372, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2717, 373, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2718, 374, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2719, 375, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2720, 376, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2721, 377, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2722, 378, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2723, 379, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2724, 380, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2725, 381, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2726, 382, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2727, 383, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2728, 384, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2729, 385, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2730, 386, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2731, 387, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2732, 388, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2733, 389, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2734, 390, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2735, 391, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2736, 392, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2737, 393, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2738, 394, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2739, 395, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2740, 396, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2741, 397, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2742, 398, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2743, 399, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2744, 400, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2745, 401, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2746, 402, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2747, 403, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2748, 404, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2749, 405, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2750, 406, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2751, 407, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2752, 408, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2753, 409, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2754, 410, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2755, 411, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2756, 412, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2757, 413, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2758, 414, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2759, 415, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2760, 416, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2761, 417, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2762, 419, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2763, 420, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2764, 421, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2765, 422, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2766, 423, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2767, 424, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2768, 425, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2769, 426, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2770, 427, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2771, 428, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2772, 429, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2773, 430, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2774, 431, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2775, 432, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2776, 433, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2777, 434, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2778, 435, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2779, 436, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2780, 437, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2781, 438, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2782, 439, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2783, 440, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2784, 441, 'city', '2014-08-20 06:03:35', 'insert', NULL, NULL),
(2785, 2, 'news_group', '2014-08-20 08:56:30', 'update', NULL, NULL),
(2786, 4, 'news_group', '2014-08-20 08:57:46', 'insert', NULL, NULL),
(2787, 3, 'absence', '2014-08-20 11:41:05', 'update', NULL, NULL),
(2788, 1, 'bridge', '2014-08-20 11:46:31', 'update', NULL, NULL),
(2789, 2, 'posts', '2014-08-20 12:55:47', 'insert', NULL, NULL),
(2790, 1, 'posts', '2014-08-20 12:56:00', 'update', NULL, NULL),
(2791, 1, 'course', '2014-08-21 05:48:12', 'update', NULL, NULL),
(2792, 1, 'regulation', '2014-08-21 06:39:38', 'update', NULL, NULL),
(2793, 1, 'regulation', '2014-08-21 06:46:50', 'update', NULL, NULL),
(2794, 1, 'regulation', '2014-08-21 06:52:38', 'update', NULL, NULL),
(2798, 116, 'users', '2014-08-21 07:34:39', 'insert', NULL, NULL),
(2799, 11, 'person', '2014-08-21 07:34:40', 'insert', NULL, NULL),
(2812, 11, 'person', '2014-08-21 07:40:29', 'delete', NULL, NULL),
(2813, 130, 'users', '2014-08-21 07:43:09', 'insert', NULL, NULL),
(2814, 20, 'person', '2014-08-21 07:43:09', 'insert', NULL, NULL),
(2815, 132, 'users', '2014-08-21 07:46:00', 'insert', NULL, NULL),
(2816, 21, 'person', '2014-08-21 07:46:00', 'insert', NULL, NULL),
(2824, 139, 'users', '2014-08-21 11:18:46', 'insert', NULL, NULL),
(2825, 25, 'person', '2014-08-21 11:18:46', 'insert', NULL, NULL),
(2826, 3, 'files', '2014-08-21 12:30:13', 'insert', NULL, NULL),
(2827, 1, 'files', '2014-08-21 12:30:25', 'delete', NULL, NULL),
(2828, 3, 'files', '2014-08-21 12:30:25', 'delete', NULL, NULL),
(2829, 2, 'files', '2014-08-21 12:30:25', 'delete', NULL, NULL),
(2830, 4, 'files', '2014-08-21 12:30:36', 'insert', NULL, NULL),
(2831, 2000, 'files', '2014-08-21 12:31:45', 'insert', NULL, NULL),
(2832, 2000, 'files', '2014-08-21 12:31:57', 'update', NULL, NULL),
(2833, 4000, 'files', '2014-08-21 12:32:16', 'insert', NULL, NULL),
(2834, 40000, 'files', '2014-08-21 12:32:33', 'insert', NULL, NULL),
(2835, 5002, 'files', '2014-08-21 12:33:44', 'insert', NULL, NULL),
(2836, 40001, 'files', '2014-08-21 12:34:49', 'insert', NULL, NULL),
(2837, 1, 'files', '2014-08-21 12:38:25', 'insert', NULL, NULL),
(2838, 999, 'files', '2014-08-21 12:38:38', 'insert', NULL, NULL),
(2839, 1000, 'files', '2014-08-21 12:38:47', 'insert', NULL, NULL),
(2840, 1001, 'files', '2014-08-21 12:38:58', 'insert', NULL, NULL),
(2841, 145, 'users', '2014-08-21 12:41:59', 'insert', NULL, NULL),
(2842, 26, 'person', '2014-08-21 12:41:59', 'insert', NULL, NULL),
(2843, 147, 'users', '2014-08-21 12:43:01', 'insert', NULL, NULL),
(2844, 27, 'person', '2014-08-21 12:43:01', 'insert', NULL, NULL),
(2845, 149, 'users', '2014-08-21 12:43:58', 'insert', NULL, NULL),
(2846, 28, 'person', '2014-08-21 12:43:58', 'insert', NULL, NULL),
(2858, 165, 'users', '2014-08-21 12:49:53', 'insert', NULL, NULL),
(2859, 167, 'users', '2014-08-21 12:52:24', 'insert', NULL, NULL),
(2868, 177, 'users', '2014-08-21 13:21:34', 'insert', NULL, NULL),
(2869, 40, 'person', '2014-08-21 13:21:34', 'insert', NULL, NULL),
(2872, 179, 'users', '2014-08-21 13:23:15', 'insert', NULL, NULL),
(2873, 42, 'person', '2014-08-21 13:23:15', 'insert', NULL, NULL),
(2884, 186, 'users', '2014-08-21 13:34:49', 'insert', NULL, NULL),
(2885, 48, 'person', '2014-08-21 13:34:49', 'insert', NULL, NULL),
(2890, 191, 'users', '2014-08-21 13:36:11', 'insert', NULL, NULL),
(2891, 52, 'person', '2014-08-21 13:36:11', 'insert', NULL, NULL),
(2893, 194, 'users', '2014-08-21 13:43:32', 'insert', NULL, NULL),
(2894, 53, 'person', '2014-08-21 13:43:32', 'insert', NULL, NULL),
(2895, 195, 'users', '2014-08-21 13:43:32', 'insert', NULL, NULL),
(2896, 54, 'person', '2014-08-21 13:43:32', 'insert', NULL, NULL),
(2897, 196, 'users', '2014-08-21 13:43:37', 'insert', NULL, NULL),
(2898, 55, 'person', '2014-08-21 13:43:38', 'insert', NULL, NULL),
(2899, 197, 'users', '2014-08-21 13:45:32', 'insert', NULL, NULL),
(2900, 56, 'person', '2014-08-21 13:45:32', 'insert', NULL, NULL),
(2901, 198, 'users', '2014-08-21 13:45:36', 'insert', NULL, NULL),
(2902, 57, 'person', '2014-08-21 13:45:36', 'insert', NULL, NULL),
(2903, 199, 'users', '2014-08-21 13:45:41', 'insert', NULL, NULL),
(2904, 58, 'person', '2014-08-21 13:45:41', 'insert', NULL, NULL),
(2905, 200, 'users', '2014-08-21 13:45:51', 'insert', NULL, NULL),
(2906, 59, 'person', '2014-08-21 13:45:51', 'insert', NULL, NULL),
(2907, 201, 'users', '2014-08-21 13:50:07', 'insert', NULL, NULL),
(2908, 60, 'person', '2014-08-21 13:50:07', 'insert', NULL, NULL),
(2909, 202, 'users', '2014-08-21 13:50:12', 'insert', NULL, NULL),
(2910, 61, 'person', '2014-08-21 13:50:12', 'insert', NULL, NULL),
(2911, 203, 'users', '2014-08-21 13:50:24', 'insert', NULL, NULL),
(2912, 62, 'person', '2014-08-21 13:50:24', 'insert', NULL, NULL),
(2913, 204, 'users', '2014-08-21 13:57:08', 'insert', NULL, NULL),
(2914, 63, 'person', '2014-08-21 13:57:08', 'insert', NULL, NULL),
(2915, 205, 'users', '2014-08-21 13:57:14', 'insert', NULL, NULL),
(2916, 64, 'person', '2014-08-21 13:57:14', 'insert', NULL, NULL),
(3015, 131, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3016, 132, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3017, 133, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3018, 134, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3019, 135, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3020, 136, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3021, 137, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3022, 138, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3023, 139, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3024, 140, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3025, 141, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3026, 142, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3027, 143, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3028, 144, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3029, 145, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3030, 146, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3031, 147, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3032, 148, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3033, 149, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3034, 150, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3035, 151, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3036, 152, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3037, 153, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3038, 154, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3039, 155, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3040, 156, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3041, 157, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3042, 158, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3043, 159, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3044, 160, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3045, 161, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3046, 162, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3047, 163, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3048, 164, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3049, 165, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3050, 166, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3051, 167, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3052, 168, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3053, 169, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3054, 170, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3055, 171, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3056, 172, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3057, 173, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3058, 174, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3059, 175, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3060, 176, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3061, 177, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3062, 178, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3063, 179, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3064, 180, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3065, 181, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3066, 182, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3067, 183, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3068, 184, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3069, 185, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3070, 186, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3071, 187, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3072, 188, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3073, 189, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3074, 190, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3075, 191, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3076, 192, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3077, 193, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3078, 194, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3079, 195, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3080, 196, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3081, 197, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3082, 198, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3083, 199, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3084, 200, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3085, 201, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3086, 202, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3087, 203, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3088, 204, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3089, 205, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3090, 206, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3091, 207, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3092, 208, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3093, 209, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3094, 210, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3095, 211, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3096, 212, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3097, 213, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3098, 214, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3099, 215, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3100, 216, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3101, 217, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3102, 218, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3103, 219, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3104, 220, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3105, 221, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3106, 222, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3107, 223, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3108, 224, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3109, 225, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3110, 226, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3111, 227, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3112, 228, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3113, 229, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3114, 230, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3115, 231, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3116, 232, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3117, 233, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3118, 234, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3119, 235, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3120, 236, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3121, 237, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3122, 238, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3123, 239, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3124, 240, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3125, 241, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3126, 242, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3127, 243, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3128, 244, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3129, 245, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3130, 246, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3131, 247, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3132, 248, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3133, 249, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3134, 250, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3135, 251, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3136, 252, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3137, 253, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3138, 254, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3139, 255, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3140, 256, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3141, 257, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3142, 258, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3143, 259, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3144, 260, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3145, 261, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3146, 262, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3147, 263, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3148, 264, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3149, 265, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3150, 266, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3151, 267, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3152, 268, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3153, 269, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3154, 270, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3155, 271, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3156, 272, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3157, 273, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3158, 274, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3159, 275, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3160, 276, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3161, 277, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3162, 278, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3163, 279, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3164, 280, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3165, 281, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3166, 282, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3167, 283, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3168, 284, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3169, 285, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3170, 286, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3171, 287, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3172, 288, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3173, 289, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3174, 290, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3175, 291, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3176, 292, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3177, 293, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3178, 294, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3179, 295, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3180, 296, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3181, 297, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3182, 298, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3183, 299, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3184, 300, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3185, 301, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3186, 302, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3187, 303, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3188, 304, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3189, 305, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3190, 306, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3191, 307, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3192, 308, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3193, 309, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3194, 310, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3195, 311, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3196, 312, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3197, 313, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3198, 314, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3199, 315, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3200, 316, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3201, 317, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3202, 318, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3203, 319, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3204, 320, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3205, 321, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3206, 322, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3207, 323, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3208, 324, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3209, 325, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3210, 326, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3211, 327, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3212, 328, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3213, 329, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3214, 330, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3215, 331, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3216, 332, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3217, 333, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3218, 334, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3219, 335, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3220, 336, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3221, 337, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3222, 338, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3223, 339, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3224, 340, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3225, 341, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3226, 342, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3227, 343, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3228, 344, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3229, 345, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3230, 346, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3231, 347, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3232, 348, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3233, 349, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3234, 350, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3235, 351, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3236, 352, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3237, 353, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3238, 354, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3239, 355, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3240, 356, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3241, 357, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3242, 358, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3243, 359, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3244, 360, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3245, 361, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3246, 362, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3247, 363, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3248, 364, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3249, 365, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3250, 366, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3251, 367, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3252, 368, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3253, 369, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3254, 370, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3255, 371, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3256, 372, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3257, 373, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3258, 374, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3259, 375, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3260, 376, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3261, 377, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3262, 378, 'country', '2014-08-25 06:44:13', 'insert', NULL, NULL),
(3263, 234, 'country', '2014-08-25 06:45:02', 'update', NULL, NULL),
(3264, 328, 'country', '2014-08-25 06:45:16', 'update', NULL, NULL),
(3265, 333, 'country', '2014-08-25 06:45:48', 'update', NULL, NULL),
(3266, 227, 'country', '2014-08-25 06:48:07', 'update', NULL, NULL),
(3267, 246, 'country', '2014-08-25 06:49:55', 'delete', NULL, NULL),
(3268, 245, 'country', '2014-08-25 06:50:00', 'delete', NULL, NULL),
(3269, 365, 'country', '2014-08-25 06:50:21', 'delete', NULL, NULL),
(3270, 1, 'country', '2014-08-25 06:51:38', 'delete', NULL, NULL),
(3271, 20, 'person', '2014-08-25 06:52:12', 'update', NULL, NULL),
(3272, 21, 'person', '2014-08-25 06:52:30', 'update', NULL, NULL),
(3273, 25, 'person', '2014-08-25 06:52:33', 'update', NULL, NULL),
(3274, 20, 'person', '2014-08-25 06:53:11', 'update', NULL, NULL),
(3275, 21, 'person', '2014-08-25 06:53:14', 'update', NULL, NULL),
(3276, 25, 'person', '2014-08-25 06:53:17', 'update', NULL, NULL),
(3277, 3, 'country', '2014-08-25 06:53:27', 'delete', NULL, NULL),
(3278, 4, 'country', '2014-08-25 06:53:30', 'delete', NULL, NULL),
(3279, 134, 'country', '2014-08-25 06:53:46', 'update', NULL, NULL),
(3280, 161, 'country', '2014-08-25 06:55:01', 'delete', NULL, NULL),
(3281, 179, 'country', '2014-08-25 06:56:26', 'delete', NULL, NULL),
(3282, 201, 'country', '2014-08-25 06:58:07', 'update', NULL, NULL),
(3283, 206, 'country', '2014-08-25 06:58:19', 'delete', NULL, NULL),
(3284, 207, 'country', '2014-08-25 06:58:26', 'delete', NULL, NULL),
(3285, 208, 'country', '2014-08-25 06:58:37', 'delete', NULL, NULL),
(3286, 209, 'country', '2014-08-25 06:58:41', 'delete', NULL, NULL),
(3287, 219, 'country', '2014-08-25 06:59:39', 'update', NULL, NULL),
(3288, 226, 'country', '2014-08-25 07:00:01', 'delete', NULL, NULL),
(3289, 237, 'country', '2014-08-25 07:00:16', 'delete', NULL, NULL),
(3290, 247, 'country', '2014-08-25 07:02:06', 'update', NULL, NULL),
(3291, 248, 'country', '2014-08-25 07:02:13', 'update', NULL, NULL),
(3292, 252, 'country', '2014-08-25 07:02:21', 'delete', NULL, NULL),
(3293, 263, 'country', '2014-08-25 07:02:54', 'delete', NULL, NULL),
(3294, 279, 'country', '2014-08-25 07:03:19', 'delete', NULL, NULL),
(3295, 277, 'country', '2014-08-25 07:03:34', 'update', NULL, NULL),
(3296, 276, 'country', '2014-08-25 07:03:57', 'delete', NULL, NULL),
(3297, 290, 'country', '2014-08-25 07:04:24', 'delete', NULL, NULL),
(3298, 291, 'country', '2014-08-25 07:04:32', 'delete', NULL, NULL),
(3299, 313, 'country', '2014-08-25 07:06:10', 'update', NULL, NULL),
(3300, 315, 'country', '2014-08-25 07:06:22', 'delete', NULL, NULL),
(3301, 317, 'country', '2014-08-25 07:07:01', 'update', NULL, NULL),
(3302, 340, 'country', '2014-08-25 07:10:34', 'update', NULL, NULL),
(3303, 344, 'country', '2014-08-25 07:10:59', 'update', NULL, NULL),
(3304, 346, 'country', '2014-08-25 07:11:38', 'delete', NULL, NULL),
(3305, 349, 'country', '2014-08-25 07:12:02', 'delete', NULL, NULL),
(3306, 358, 'country', '2014-08-25 07:12:22', 'delete', NULL, NULL),
(3307, 363, 'country', '2014-08-25 07:12:43', 'update', NULL, NULL),
(3308, 364, 'country', '2014-08-25 07:12:55', 'update', NULL, NULL),
(3309, 371, 'country', '2014-08-25 07:13:34', 'delete', NULL, NULL),
(3310, 372, 'country', '2014-08-25 07:13:36', 'delete', NULL, NULL),
(3311, 373, 'country', '2014-08-25 07:13:51', 'delete', NULL, NULL),
(3312, 131, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3313, 132, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3314, 133, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3315, 134, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3316, 135, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3317, 136, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3318, 137, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3319, 138, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3320, 139, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3321, 140, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3322, 141, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3323, 142, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3324, 143, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3325, 144, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3326, 145, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3327, 146, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3328, 147, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3329, 148, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3330, 149, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3331, 150, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3332, 151, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3333, 152, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3334, 153, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3335, 154, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3336, 155, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3337, 156, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3338, 157, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3339, 158, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3340, 159, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3341, 160, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3342, 162, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3343, 163, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3344, 164, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3345, 165, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3346, 166, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3347, 167, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3348, 168, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3349, 169, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3350, 170, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3351, 171, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3352, 172, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3353, 173, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3354, 174, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3355, 175, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3356, 176, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3357, 177, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3358, 178, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL);
INSERT INTO `history` (`id`, `record_id`, `table`, `date`, `query_type`, `users_id`, `ip`) VALUES
(3359, 180, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3360, 181, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3361, 182, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3362, 183, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3363, 184, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3364, 185, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3365, 186, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3366, 187, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3367, 188, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3368, 189, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3369, 190, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3370, 191, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3371, 192, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3372, 193, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3373, 194, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3374, 195, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3375, 196, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3376, 197, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3377, 198, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3378, 199, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3379, 200, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3380, 201, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3381, 202, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3382, 203, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3383, 204, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3384, 205, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3385, 210, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3386, 211, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3387, 212, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3388, 213, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3389, 214, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3390, 215, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3391, 216, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3392, 217, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3393, 218, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3394, 219, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3395, 220, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3396, 221, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3397, 222, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3398, 223, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3399, 224, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3400, 225, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3401, 227, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3402, 228, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3403, 229, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3404, 230, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3405, 231, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3406, 232, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3407, 233, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3408, 234, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3409, 235, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3410, 236, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3411, 238, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3412, 239, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3413, 240, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3414, 241, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3415, 242, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3416, 243, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3417, 244, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3418, 247, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3419, 248, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3420, 249, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3421, 250, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3422, 251, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3423, 253, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3424, 254, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3425, 255, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3426, 256, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3427, 257, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3428, 258, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3429, 259, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3430, 260, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3431, 261, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3432, 262, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3433, 264, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3434, 265, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3435, 266, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3436, 267, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3437, 268, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3438, 269, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3439, 270, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3440, 271, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3441, 272, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3442, 273, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3443, 274, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3444, 275, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3445, 277, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3446, 278, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3447, 280, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3448, 281, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3449, 282, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3450, 283, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3451, 284, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3452, 285, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3453, 286, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3454, 287, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3455, 288, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3456, 289, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3457, 292, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3458, 293, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3459, 294, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3460, 295, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3461, 296, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3462, 297, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3463, 298, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3464, 299, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3465, 300, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3466, 301, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3467, 302, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3468, 303, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3469, 304, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3470, 305, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3471, 306, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3472, 307, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3473, 308, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3474, 309, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3475, 310, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3476, 311, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3477, 312, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3478, 313, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3479, 314, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3480, 316, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3481, 317, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3482, 318, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3483, 319, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3484, 320, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3485, 321, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3486, 322, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3487, 323, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3488, 324, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3489, 325, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3490, 326, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3491, 327, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3492, 328, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3493, 329, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3494, 330, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3495, 331, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3496, 332, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3497, 333, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3498, 334, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3499, 335, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3500, 336, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3501, 337, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3502, 338, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3503, 339, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3504, 340, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3505, 341, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3506, 342, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3507, 343, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3508, 344, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3509, 345, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3510, 347, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3511, 348, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3512, 350, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3513, 351, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3514, 352, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3515, 353, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3516, 354, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3517, 355, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3518, 356, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3519, 357, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3520, 359, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3521, 360, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3522, 361, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3523, 362, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3524, 363, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3525, 364, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3526, 366, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3527, 367, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3528, 368, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3529, 369, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3530, 370, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3531, 374, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3532, 375, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3533, 376, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3534, 377, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3535, 378, 'country', '2014-08-25 07:17:20', 'delete', NULL, NULL),
(3536, 386, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3537, 387, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3538, 388, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3539, 389, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3540, 390, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3541, 391, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3542, 392, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3543, 393, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3544, 394, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3545, 395, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3546, 396, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3547, 397, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3548, 398, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3549, 399, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3550, 400, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3551, 401, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3552, 402, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3553, 403, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3554, 404, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3555, 405, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3556, 406, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3557, 407, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3558, 408, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3559, 409, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3560, 410, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3561, 411, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3562, 412, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3563, 413, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3564, 414, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3565, 415, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3566, 416, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3567, 417, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3568, 418, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3569, 419, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3570, 420, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3571, 421, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3572, 422, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3573, 423, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3574, 424, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3575, 425, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3576, 426, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3577, 427, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3578, 428, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3579, 429, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3580, 430, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3581, 431, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3582, 432, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3583, 433, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3584, 434, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3585, 435, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3586, 436, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3587, 437, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3588, 438, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3589, 439, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3590, 440, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3591, 441, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3592, 442, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3593, 443, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3594, 444, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3595, 445, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3596, 446, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3597, 447, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3598, 448, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3599, 449, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3600, 450, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3601, 451, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3602, 452, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3603, 453, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3604, 454, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3605, 455, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3606, 456, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3607, 457, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3608, 458, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3609, 459, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3610, 460, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3611, 461, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3612, 462, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3613, 463, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3614, 464, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3615, 465, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3616, 466, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3617, 467, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3618, 468, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3619, 469, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3620, 470, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3621, 471, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3622, 472, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3623, 473, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3624, 474, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3625, 475, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3626, 476, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3627, 477, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3628, 478, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3629, 479, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3630, 480, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3631, 481, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3632, 482, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3633, 483, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3634, 484, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3635, 485, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3636, 486, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3637, 487, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3638, 488, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3639, 489, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3640, 490, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3641, 491, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3642, 492, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3643, 493, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3644, 494, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3645, 495, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3646, 496, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3647, 497, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3648, 498, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3649, 499, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3650, 500, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3651, 501, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3652, 502, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3653, 503, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3654, 504, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3655, 505, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3656, 506, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3657, 507, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3658, 508, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3659, 509, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3660, 510, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3661, 511, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3662, 512, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3663, 513, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3664, 514, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3665, 515, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3666, 516, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3667, 517, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3668, 518, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3669, 519, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3670, 520, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3671, 521, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3672, 522, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3673, 523, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3674, 524, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3675, 525, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3676, 526, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3677, 527, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3678, 528, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3679, 529, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3680, 530, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3681, 531, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3682, 532, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3683, 533, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3684, 534, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3685, 535, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3686, 536, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3687, 537, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3688, 538, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3689, 539, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3690, 540, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3691, 541, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3692, 542, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3693, 543, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3694, 544, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3695, 545, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3696, 546, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3697, 547, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3698, 548, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3699, 549, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3700, 550, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3701, 551, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3702, 552, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3703, 553, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3704, 554, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3705, 555, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3706, 556, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3707, 557, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3708, 558, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3709, 559, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3710, 560, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3711, 561, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3712, 562, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3713, 563, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3714, 564, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3715, 565, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3716, 566, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3717, 567, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3718, 568, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3719, 569, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3720, 570, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3721, 571, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3722, 572, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3723, 573, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3724, 574, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3725, 575, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3726, 576, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3727, 577, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3728, 578, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3729, 579, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3730, 580, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3731, 581, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3732, 582, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3733, 583, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3734, 584, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3735, 585, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3736, 586, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3737, 587, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3738, 588, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3739, 589, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3740, 590, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3741, 591, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3742, 592, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3743, 593, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3744, 594, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3745, 595, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3746, 596, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3747, 597, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3748, 598, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3749, 599, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3750, 600, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3751, 601, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3752, 602, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3753, 603, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3754, 604, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3755, 605, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3756, 606, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3757, 607, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3758, 608, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3759, 609, 'country', '2014-08-25 07:17:44', 'insert', NULL, NULL),
(3760, 1, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3761, 2, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3762, 3, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3763, 4, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3764, 5, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3765, 6, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3766, 7, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3767, 8, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3768, 9, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3769, 10, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3770, 11, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3771, 12, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3772, 13, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3773, 14, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3774, 15, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3775, 16, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3776, 17, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3777, 18, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3778, 19, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3779, 20, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3780, 21, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3781, 22, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3782, 23, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3783, 24, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3784, 25, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3785, 26, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3786, 27, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3787, 28, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3788, 29, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3789, 30, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3790, 31, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3791, 32, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3792, 33, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3793, 34, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3794, 35, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3795, 36, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3796, 37, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3797, 38, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3798, 39, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3799, 40, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3800, 41, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3801, 42, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3802, 43, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3803, 44, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3804, 45, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3805, 46, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3806, 47, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3807, 48, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3808, 49, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3809, 50, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3810, 51, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3811, 52, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3812, 53, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3813, 54, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3814, 55, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3815, 56, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3816, 57, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3817, 58, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3818, 59, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3819, 60, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3820, 61, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3821, 62, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3822, 63, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3823, 64, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3824, 65, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3825, 66, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3826, 67, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3827, 68, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3828, 69, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3829, 70, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3830, 71, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3831, 72, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3832, 73, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3833, 74, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3834, 75, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3835, 76, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3836, 77, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3837, 78, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3838, 79, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3839, 80, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3840, 81, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3841, 82, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3842, 83, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3843, 84, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3844, 85, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3845, 86, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3846, 87, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3847, 88, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3848, 89, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3849, 90, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3850, 91, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3851, 92, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3852, 93, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3853, 94, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3854, 95, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3855, 96, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3856, 97, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3857, 98, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3858, 99, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3859, 100, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3860, 101, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3861, 102, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3862, 103, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3863, 104, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3864, 105, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3865, 106, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3866, 107, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3867, 108, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3868, 109, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3869, 110, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3870, 111, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3871, 112, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3872, 113, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3873, 114, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3874, 115, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3875, 116, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3876, 117, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3877, 118, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3878, 119, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3879, 120, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3880, 121, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3881, 122, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3882, 123, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3883, 124, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3884, 125, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3885, 126, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3886, 127, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3887, 128, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3888, 129, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3889, 130, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3890, 131, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3891, 132, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3892, 133, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3893, 134, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3894, 135, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3895, 136, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3896, 137, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3897, 138, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3898, 139, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3899, 140, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3900, 141, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3901, 142, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3902, 143, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3903, 144, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3904, 145, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3905, 146, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3906, 147, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3907, 148, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3908, 149, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3909, 150, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3910, 151, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3911, 152, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3912, 153, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3913, 154, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3914, 155, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3915, 156, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3916, 157, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3917, 158, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3918, 159, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3919, 160, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3920, 161, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3921, 162, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3922, 163, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3923, 164, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3924, 165, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3925, 166, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3926, 167, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3927, 168, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3928, 169, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3929, 170, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3930, 171, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3931, 172, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3932, 173, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3933, 174, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3934, 175, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3935, 176, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3936, 177, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3937, 178, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3938, 179, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3939, 180, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3940, 181, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3941, 182, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3942, 183, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3943, 184, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3944, 185, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3945, 186, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3946, 187, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3947, 188, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3948, 189, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3949, 190, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3950, 191, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3951, 192, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3952, 193, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3953, 194, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3954, 195, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3955, 196, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3956, 197, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3957, 198, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3958, 199, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3959, 200, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3960, 201, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3961, 202, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3962, 203, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3963, 204, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3964, 205, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3965, 206, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3966, 207, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3967, 208, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3968, 209, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3969, 210, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3970, 211, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3971, 212, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3972, 213, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3973, 214, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3974, 215, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3975, 216, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3976, 217, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3977, 218, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3978, 219, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3979, 220, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3980, 221, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3981, 222, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3982, 223, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3983, 224, 'country', '2014-08-25 07:18:26', 'insert', NULL, NULL),
(3996, 3, 'education', '2014-08-25 17:51:01', 'update', NULL, NULL),
(3997, 2, 'education', '2014-08-25 17:51:08', 'update', NULL, NULL),
(3998, 5, 'education', '2014-08-25 17:51:12', 'update', NULL, NULL),
(3999, 4, 'education', '2014-08-25 17:51:16', 'update', NULL, NULL),
(4000, 1, 'education', '2014-08-25 17:51:19', 'update', NULL, NULL),
(4001, 3, 'education', '2014-08-25 17:51:28', 'update', NULL, NULL),
(4002, 2, 'education', '2014-08-25 17:51:44', 'update', NULL, NULL),
(4003, 5, 'education', '2014-08-25 17:51:50', 'update', NULL, NULL),
(4004, 4, 'education', '2014-08-25 17:51:55', 'update', NULL, NULL),
(4005, 1, 'education', '2014-08-25 17:52:00', 'update', NULL, NULL),
(4006, 6, 'education', '2014-08-25 17:52:09', 'insert', NULL, NULL),
(4007, 7, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4008, 8, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4009, 9, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4010, 10, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4011, 11, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4012, 12, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4013, 13, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4014, 14, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4015, 15, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4016, 16, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4017, 17, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4018, 18, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4019, 19, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4020, 20, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4021, 21, 'education', '2014-08-25 17:53:42', 'insert', NULL, NULL),
(4022, 22, 'education', '2014-08-25 17:54:26', 'insert', NULL, NULL),
(4023, 23, 'education', '2014-08-25 17:54:26', 'insert', NULL, NULL),
(4024, 24, 'education', '2014-08-25 17:54:26', 'insert', NULL, NULL),
(4025, 25, 'education', '2014-08-25 17:54:26', 'insert', NULL, NULL),
(4026, 26, 'education', '2014-08-25 17:54:26', 'insert', NULL, NULL),
(4027, 45, 'country', '2014-08-26 02:28:33', 'delete', NULL, NULL),
(4028, 3, 'news', '2014-08-27 12:16:38', 'update', NULL, NULL),
(4029, 3, 'news', '2014-08-27 12:16:58', 'update', NULL, NULL),
(4030, 3, 'news', '2014-08-27 12:17:26', 'update', NULL, NULL),
(4031, 2, 'users', '2014-08-29 14:56:01', 'update', NULL, NULL),
(4032, 1002, 'files', '2014-08-29 15:44:54', 'insert', NULL, NULL),
(4033, 1, 'permission', '2014-09-02 06:49:59', 'update', NULL, NULL),
(4034, 2, 'permission', '2014-09-02 06:55:04', 'update', NULL, NULL),
(4035, 1003, 'files', '2014-09-02 06:56:27', 'insert', NULL, NULL),
(4036, 19, 'news', '2014-09-02 06:56:40', 'insert', NULL, NULL),
(4037, 0, 'table_files', '2014-09-02 06:56:41', 'insert', NULL, NULL),
(4038, 21, 'news', '2014-09-02 06:57:48', 'insert', NULL, NULL),
(4039, 2, 'table_files', '2014-09-02 06:57:48', 'insert', NULL, NULL),
(4040, 1004, 'files', '2014-09-02 08:38:27', 'insert', NULL, NULL),
(4041, 22, 'news', '2014-09-02 08:38:42', 'insert', NULL, NULL),
(4042, 3, 'table_files', '2014-09-02 08:38:42', 'insert', NULL, NULL),
(4043, 1008, 'files', '2014-09-02 09:07:32', 'insert', NULL, NULL),
(4044, 23, 'news', '2014-09-02 09:07:48', 'insert', NULL, NULL),
(4045, 4, 'table_files', '2014-09-02 09:07:48', 'insert', NULL, NULL),
(4046, 1009, 'files', '2014-09-02 09:09:46', 'insert', NULL, NULL),
(4047, 24, 'news', '2014-09-02 09:09:54', 'insert', NULL, NULL),
(4048, 5, 'table_files', '2014-09-02 09:09:54', 'insert', NULL, NULL),
(4049, 25, 'news', '2014-09-02 09:38:22', 'insert', NULL, NULL),
(4050, 6, 'table_files', '2014-09-02 09:38:22', 'insert', NULL, NULL),
(4051, 26, 'news', '2014-09-02 09:38:38', 'insert', NULL, NULL),
(4052, 7, 'table_files', '2014-09-02 09:38:38', 'insert', NULL, NULL),
(4053, 27, 'news', '2014-09-02 09:38:54', 'insert', NULL, NULL),
(4054, 8, 'table_files', '2014-09-02 09:38:54', 'insert', NULL, NULL),
(4055, 28, 'news', '2014-09-02 09:39:11', 'insert', NULL, NULL),
(4056, 9, 'table_files', '2014-09-02 09:39:11', 'insert', NULL, NULL),
(4057, 29, 'news', '2014-09-02 09:39:24', 'insert', NULL, NULL),
(4058, 10, 'table_files', '2014-09-02 09:39:24', 'insert', NULL, NULL),
(4059, 30, 'news', '2014-09-02 09:39:53', 'insert', NULL, NULL),
(4060, 11, 'table_files', '2014-09-02 09:39:53', 'insert', NULL, NULL),
(4061, 31, 'news', '2014-09-02 09:40:09', 'insert', NULL, NULL),
(4062, 12, 'table_files', '2014-09-02 09:40:09', 'insert', NULL, NULL),
(4063, 34, 'news', '2014-09-02 09:42:07', 'insert', NULL, NULL),
(4064, 13, 'table_files', '2014-09-02 09:42:08', 'insert', NULL, NULL),
(4065, 35, 'news', '2014-09-02 09:42:24', 'insert', NULL, NULL),
(4066, 14, 'table_files', '2014-09-02 09:42:24', 'insert', NULL, NULL),
(4067, 36, 'news', '2014-09-02 09:42:31', 'insert', NULL, NULL),
(4068, 15, 'table_files', '2014-09-02 09:42:31', 'insert', NULL, NULL),
(4069, 1010, 'files', '2014-09-02 09:43:03', 'insert', NULL, NULL),
(4070, 37, 'news', '2014-09-02 09:43:16', 'insert', NULL, NULL),
(4071, 16, 'table_files', '2014-09-02 09:43:17', 'insert', NULL, NULL),
(4072, 38, 'news', '2014-09-02 09:43:29', 'insert', NULL, NULL),
(4073, 17, 'table_files', '2014-09-02 09:43:29', 'insert', NULL, NULL),
(4074, 1011, 'files', '2014-09-02 09:44:56', 'insert', NULL, NULL),
(4075, 39, 'news', '2014-09-02 09:45:18', 'insert', NULL, NULL),
(4076, 18, 'table_files', '2014-09-02 09:45:18', 'insert', NULL, NULL),
(4077, 40, 'news', '2014-09-02 09:45:29', 'insert', NULL, NULL),
(4078, 19, 'table_files', '2014-09-02 09:45:29', 'insert', NULL, NULL),
(4079, 41, 'news', '2014-09-02 09:47:52', 'insert', NULL, NULL),
(4080, 20, 'table_files', '2014-09-02 09:47:53', 'insert', NULL, NULL),
(4081, 42, 'news', '2014-09-02 10:02:14', 'insert', NULL, NULL),
(4082, 21, 'table_files', '2014-09-02 10:02:14', 'insert', NULL, NULL),
(4083, 43, 'news', '2014-09-02 10:02:25', 'insert', NULL, NULL),
(4084, 22, 'table_files', '2014-09-02 10:02:26', 'insert', NULL, NULL),
(4085, 1013, 'files', '2014-09-02 10:02:51', 'insert', NULL, NULL),
(4086, 44, 'news', '2014-09-02 10:02:57', 'insert', NULL, NULL),
(4087, 23, 'table_files', '2014-09-02 10:02:58', 'insert', NULL, NULL),
(4088, 45, 'news', '2014-09-02 10:03:11', 'insert', NULL, NULL),
(4089, 24, 'table_files', '2014-09-02 10:03:11', 'insert', NULL, NULL),
(4090, 46, 'news', '2014-09-02 10:03:21', 'insert', NULL, NULL),
(4091, 25, 'table_files', '2014-09-02 10:03:21', 'insert', NULL, NULL),
(4092, 1014, 'files', '2014-09-02 10:39:23', 'insert', NULL, NULL),
(4093, 47, 'news', '2014-09-02 10:41:30', 'insert', NULL, NULL),
(4094, 26, 'table_files', '2014-09-02 10:41:30', 'insert', NULL, NULL),
(4095, 218, 'users', '2014-09-02 11:46:36', 'insert', NULL, NULL),
(4096, 69, 'users', '2014-09-02 11:47:17', 'update', NULL, NULL),
(4097, 2, 'users', '2014-09-02 12:05:30', 'update', NULL, NULL),
(4098, 20, 'person', '2014-09-02 12:06:48', 'update', NULL, NULL),
(4100, 218, 'users', '2014-09-03 05:06:26', 'delete', NULL, NULL),
(4101, 64, 'person', '2014-09-03 05:06:47', 'delete', NULL, NULL),
(4102, 63, 'person', '2014-09-03 05:06:47', 'delete', NULL, NULL),
(4103, 62, 'person', '2014-09-03 05:06:47', 'delete', NULL, NULL),
(4104, 61, 'person', '2014-09-03 05:06:47', 'delete', NULL, NULL),
(4105, 60, 'person', '2014-09-03 05:06:48', 'delete', NULL, NULL),
(4106, 59, 'person', '2014-09-03 05:06:48', 'delete', NULL, NULL),
(4107, 58, 'person', '2014-09-03 05:06:48', 'delete', NULL, NULL),
(4108, 57, 'person', '2014-09-03 05:06:48', 'delete', NULL, NULL),
(4109, 56, 'person', '2014-09-03 05:06:48', 'delete', NULL, NULL),
(4110, 55, 'person', '2014-09-03 05:06:48', 'delete', NULL, NULL),
(4111, 54, 'person', '2014-09-03 05:06:48', 'delete', NULL, NULL),
(4112, 53, 'person', '2014-09-03 05:06:48', 'delete', NULL, NULL),
(4113, 52, 'person', '2014-09-03 05:06:49', 'delete', NULL, NULL),
(4114, 48, 'person', '2014-09-03 05:06:49', 'delete', NULL, NULL),
(4115, 42, 'person', '2014-09-03 05:06:49', 'delete', NULL, NULL),
(4116, 40, 'person', '2014-09-03 05:06:49', 'delete', NULL, NULL),
(4117, 28, 'person', '2014-09-03 05:06:49', 'delete', NULL, NULL),
(4118, 27, 'person', '2014-09-03 05:06:49', 'delete', NULL, NULL);
INSERT INTO `history` (`id`, `record_id`, `table`, `date`, `query_type`, `users_id`, `ip`) VALUES
(4119, 26, 'person', '2014-09-03 05:06:49', 'delete', NULL, NULL),
(4120, 21, 'person', '2014-09-03 05:07:01', 'update', NULL, NULL),
(4121, 25, 'person', '2014-09-03 05:07:05', 'update', NULL, NULL),
(4122, 205, 'users', '2014-09-03 05:07:12', 'delete', NULL, NULL),
(4123, 204, 'users', '2014-09-03 05:07:12', 'delete', NULL, NULL),
(4124, 203, 'users', '2014-09-03 05:07:12', 'delete', NULL, NULL),
(4125, 202, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4126, 201, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4127, 200, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4128, 199, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4129, 198, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4130, 197, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4131, 196, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4132, 195, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4133, 194, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4134, 191, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4135, 186, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4136, 179, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4137, 177, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4138, 167, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4139, 165, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4140, 149, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4141, 147, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4142, 145, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4143, 139, 'users', '2014-09-03 05:07:13', 'delete', NULL, NULL),
(4144, 132, 'users', '2014-09-03 05:07:17', 'delete', NULL, NULL),
(4145, 130, 'users', '2014-09-03 05:07:17', 'delete', NULL, NULL),
(4146, 116, 'users', '2014-09-03 05:07:17', 'delete', NULL, NULL),
(4147, 73, 'users', '2014-09-03 05:07:17', 'delete', NULL, NULL),
(4148, 21, 'person', '2014-09-03 05:10:42', 'update', NULL, NULL),
(4149, 25, 'person', '2014-09-03 05:10:47', 'update', NULL, NULL),
(4150, 25, 'person', '2014-09-03 05:14:03', 'update', NULL, NULL),
(4151, 68, 'person', '2014-09-03 05:15:10', 'insert', NULL, NULL),
(4152, 70, 'person', '2014-09-03 05:15:42', 'insert', NULL, NULL),
(4153, 71, 'person', '2014-09-03 05:16:16', 'insert', NULL, NULL),
(4154, 220, 'users', '2014-09-03 09:04:14', 'insert', NULL, NULL),
(4155, 72, 'person', '2014-09-03 09:04:15', 'insert', NULL, NULL),
(4156, 221, 'users', '2014-09-03 09:06:08', 'insert', NULL, NULL),
(4157, 73, 'person', '2014-09-03 09:06:08', 'insert', NULL, NULL),
(4158, 222, 'users', '2014-09-03 09:08:17', 'insert', NULL, NULL),
(4159, 74, 'person', '2014-09-03 09:08:17', 'insert', NULL, NULL),
(4160, 3, 'absence', '2014-09-03 18:43:19', 'delete', NULL, NULL),
(4161, 54, 'branch', '2014-09-03 18:43:26', 'delete', NULL, NULL),
(4162, 52, 'branch', '2014-09-03 18:43:26', 'delete', NULL, NULL),
(4163, 50, 'branch', '2014-09-03 18:43:26', 'delete', NULL, NULL),
(4164, 49, 'branch', '2014-09-03 18:43:26', 'delete', NULL, NULL),
(4165, 45, 'branch', '2014-09-03 18:43:26', 'delete', NULL, NULL),
(4166, 44, 'branch', '2014-09-03 18:43:26', 'delete', NULL, NULL),
(4167, 42, 'branch', '2014-09-03 18:43:26', 'delete', NULL, NULL),
(4168, 24, 'branch', '2014-09-03 18:43:27', 'delete', NULL, NULL),
(4169, 8, 'branch', '2014-09-03 18:43:27', 'delete', NULL, NULL),
(4170, 7, 'branch', '2014-09-03 18:43:27', 'delete', NULL, NULL),
(4171, 6, 'branch', '2014-09-03 18:43:27', 'delete', NULL, NULL),
(4172, 2, 'branch', '2014-09-03 18:43:55', 'update', NULL, NULL),
(4173, 3, 'branch', '2014-09-03 18:44:02', 'update', NULL, NULL),
(4174, 4, 'branch', '2014-09-03 18:44:07', 'update', NULL, NULL),
(4175, 1, 'branch_description', '2014-09-03 18:44:34', 'update', NULL, NULL),
(4176, 2, 'branch_description', '2014-09-03 18:44:35', 'delete', NULL, NULL),
(4177, 1, 'branch_description', '2014-09-03 18:44:39', 'delete', NULL, NULL),
(4178, 1, 'bridge', '2014-09-03 18:44:53', 'delete', NULL, NULL),
(4179, 6, 'bridge', '2014-09-03 18:44:53', 'delete', NULL, NULL),
(4180, 7, 'bridge', '2014-09-03 18:44:53', 'delete', NULL, NULL),
(4181, 1, 'classification', '2014-09-03 18:45:15', 'delete', NULL, NULL),
(4182, 1, 'graduate_classes', '2014-09-03 18:45:34', 'delete', NULL, NULL),
(4183, 17, 'class', '2014-09-03 18:45:41', 'delete', NULL, NULL),
(4184, 5, 'class', '2014-09-03 18:45:41', 'delete', NULL, NULL),
(4185, 3, 'class', '2014-09-03 18:45:41', 'delete', NULL, NULL),
(4186, 3, 'course', '2014-09-03 18:45:52', 'delete', NULL, NULL),
(4187, 1, 'course_description', '2014-09-03 18:45:59', 'delete', NULL, NULL),
(4188, 1, 'course', '2014-09-03 18:46:04', 'delete', NULL, NULL),
(4194, 26, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4195, 25, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4196, 24, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4197, 23, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4198, 22, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4199, 21, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4200, 20, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4201, 19, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4202, 18, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4203, 17, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4204, 16, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4205, 15, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4206, 14, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4207, 13, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4208, 12, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4209, 11, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4210, 10, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4211, 9, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4212, 8, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4213, 7, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4214, 6, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4215, 5, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4216, 4, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4217, 3, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4218, 2, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4219, 1, 'table_files', '2014-09-03 18:46:44', 'delete', NULL, NULL),
(4220, 1, 'files', '2014-09-03 18:46:51', 'delete', NULL, NULL),
(4221, 999, 'files', '2014-09-03 18:46:51', 'delete', NULL, NULL),
(4222, 1000, 'files', '2014-09-03 18:46:51', 'delete', NULL, NULL),
(4223, 1001, 'files', '2014-09-03 18:46:51', 'delete', NULL, NULL),
(4224, 1002, 'files', '2014-09-03 18:46:51', 'delete', NULL, NULL),
(4225, 1003, 'files', '2014-09-03 18:46:51', 'delete', NULL, NULL),
(4226, 1004, 'files', '2014-09-03 18:46:51', 'delete', NULL, NULL),
(4227, 1008, 'files', '2014-09-03 18:46:51', 'delete', NULL, NULL),
(4228, 1009, 'files', '2014-09-03 18:46:51', 'delete', NULL, NULL),
(4229, 1010, 'files', '2014-09-03 18:46:51', 'delete', NULL, NULL),
(4230, 1011, 'files', '2014-09-03 18:46:51', 'delete', NULL, NULL),
(4231, 1013, 'files', '2014-09-03 18:46:51', 'delete', NULL, NULL),
(4232, 1014, 'files', '2014-09-03 18:46:51', 'delete', NULL, NULL),
(4233, 1, 'graduate', '2014-09-03 18:47:03', 'delete', NULL, NULL),
(4234, 1, 'gorup', '2014-09-03 18:47:32', 'update', NULL, NULL),
(4235, 2, 'gorup', '2014-09-03 18:47:37', 'update', NULL, NULL),
(4236, 4, 'gorup', '2014-09-03 18:47:54', 'insert', NULL, NULL),
(4237, 5, 'group_expert', '2014-09-03 18:48:01', 'delete', NULL, NULL),
(4238, 1, 'users_group', '2014-09-03 18:48:35', 'delete', NULL, NULL),
(4239, 1, 'group_list', '2014-09-03 18:48:41', 'delete', NULL, NULL),
(4240, 4, 'group_expert', '2014-09-03 18:48:46', 'delete', NULL, NULL),
(4241, 3, 'group_expert', '2014-09-03 18:48:47', 'delete', NULL, NULL),
(4242, 2, 'group_expert', '2014-09-03 18:48:47', 'delete', NULL, NULL),
(4243, 32, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4244, 31, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4245, 30, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4246, 29, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4247, 28, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4248, 27, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4249, 26, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4250, 25, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4251, 24, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4252, 23, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4253, 22, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4254, 21, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4255, 20, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4256, 19, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4257, 18, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4258, 17, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4259, 16, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4260, 15, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4261, 14, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4262, 13, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4263, 12, 'permission', '2014-09-03 18:48:57', 'delete', NULL, NULL),
(4264, 11, 'permission', '2014-09-03 18:48:58', 'delete', NULL, NULL),
(4265, 10, 'permission', '2014-09-03 18:48:58', 'delete', NULL, NULL),
(4266, 9, 'permission', '2014-09-03 18:48:58', 'delete', NULL, NULL),
(4267, 8, 'permission', '2014-09-03 18:48:58', 'delete', NULL, NULL),
(4268, 7, 'permission', '2014-09-03 18:48:58', 'delete', NULL, NULL),
(4269, 6, 'permission', '2014-09-03 18:48:58', 'delete', NULL, NULL),
(4270, 5, 'permission', '2014-09-03 18:48:58', 'delete', NULL, NULL),
(4271, 4, 'permission', '2014-09-03 18:48:58', 'delete', NULL, NULL),
(4272, 3, 'permission', '2014-09-03 18:48:58', 'delete', NULL, NULL),
(4273, 2, 'permission', '2014-09-03 18:48:58', 'delete', NULL, NULL),
(4274, 1, 'permission', '2014-09-03 18:48:58', 'delete', NULL, NULL),
(4275, 74, 'person', '2014-09-03 18:49:02', 'delete', NULL, NULL),
(4276, 73, 'person', '2014-09-03 18:49:02', 'delete', NULL, NULL),
(4277, 72, 'person', '2014-09-03 18:49:02', 'delete', NULL, NULL),
(4278, 71, 'person', '2014-09-03 18:49:02', 'delete', NULL, NULL),
(4279, 70, 'person', '2014-09-03 18:49:02', 'delete', NULL, NULL),
(4280, 68, 'person', '2014-09-03 18:49:02', 'delete', NULL, NULL),
(4281, 25, 'person', '2014-09-03 18:49:02', 'delete', NULL, NULL),
(4282, 21, 'person', '2014-09-03 18:49:02', 'delete', NULL, NULL),
(4283, 20, 'person', '2014-09-03 18:49:02', 'delete', NULL, NULL),
(4284, 2, 'place', '2014-09-03 18:49:07', 'delete', NULL, NULL),
(4285, 1, 'place', '2014-09-03 18:49:07', 'delete', NULL, NULL),
(4286, 1, 'prerequisite', '2014-09-03 18:49:31', 'delete', NULL, NULL),
(4287, 2, 'plan', '2014-09-03 18:49:36', 'delete', NULL, NULL),
(4288, 1, 'plan_section', '2014-09-03 18:49:50', 'delete', NULL, NULL),
(4289, 1, 'plan', '2014-09-03 18:49:56', 'delete', NULL, NULL),
(4290, 2, 'posts', '2014-09-03 18:50:14', 'update', NULL, NULL),
(4291, 3, 'posts', '2014-09-03 18:50:17', 'insert', NULL, NULL),
(4292, 4, 'posts', '2014-09-03 18:50:21', 'insert', NULL, NULL),
(4293, 5, 'posts', '2014-09-03 18:50:23', 'insert', NULL, NULL),
(4294, 6, 'posts', '2014-09-03 18:50:26', 'insert', NULL, NULL),
(4295, 7, 'posts', '2014-09-03 18:50:28', 'insert', NULL, NULL),
(4296, 8, 'posts', '2014-09-03 18:50:32', 'insert', NULL, NULL),
(4297, 9, 'posts', '2014-09-03 18:50:36', 'insert', NULL, NULL),
(4298, 10, 'posts', '2014-09-03 18:50:40', 'insert', NULL, NULL),
(4299, 11, 'posts', '2014-09-03 18:50:50', 'insert', NULL, NULL),
(4300, 12, 'posts', '2014-09-03 18:50:59', 'insert', NULL, NULL),
(4301, 13, 'posts', '2014-09-03 18:51:06', 'insert', NULL, NULL),
(4302, 14, 'posts', '2014-09-03 18:51:14', 'insert', NULL, NULL),
(4303, 14, 'posts', '2014-09-03 18:51:21', 'delete', NULL, NULL),
(4304, 4, 'news_group', '2014-09-03 18:51:34', 'delete', NULL, NULL),
(4305, 2, 'news_group', '2014-09-03 18:51:34', 'delete', NULL, NULL),
(4306, 2, 'news_tags', '2014-09-03 18:51:38', 'delete', NULL, NULL),
(4307, 1, 'news_tags', '2014-09-03 18:51:38', 'delete', NULL, NULL),
(4308, 1, 'race_history', '2014-09-03 18:51:49', 'delete', NULL, NULL),
(4309, 2, 'requlation', '2014-09-03 18:51:57', 'delete', NULL, NULL),
(4310, 1, 'tags', '2014-09-03 18:52:28', 'delete', NULL, NULL),
(4311, 2, 'tags', '2014-09-03 18:52:28', 'delete', NULL, NULL),
(4312, 4, 'tags', '2014-09-03 18:52:28', 'delete', NULL, NULL),
(4313, 5, 'tags', '2014-09-03 18:52:29', 'delete', NULL, NULL),
(4314, 8, 'tags', '2014-09-03 18:52:29', 'delete', NULL, NULL),
(4315, 6, 'tags', '2014-09-03 18:52:29', 'delete', NULL, NULL),
(4316, 7, 'tags', '2014-09-03 18:52:29', 'delete', NULL, NULL),
(4317, 1, 'teachinghistory', '2014-09-03 18:52:32', 'delete', NULL, NULL),
(4318, 222, 'users', '2014-09-03 18:52:36', 'delete', NULL, NULL),
(4319, 221, 'users', '2014-09-03 18:52:36', 'delete', NULL, NULL),
(4320, 220, 'users', '2014-09-03 18:52:36', 'delete', NULL, NULL),
(4321, 72, 'users', '2014-09-03 18:52:36', 'delete', NULL, NULL),
(4322, 1, 'users_branch', '2014-09-03 18:52:45', 'delete', NULL, NULL),
(4323, 1, 'users_description', '2014-09-03 18:52:48', 'delete', NULL, NULL),
(4324, 71, 'users', '2014-09-03 18:52:54', 'delete', NULL, NULL),
(4325, 70, 'users', '2014-09-03 18:52:54', 'delete', NULL, NULL),
(4326, 69, 'users', '2014-09-03 18:52:54', 'delete', NULL, NULL),
(4327, 2, 'users', '2014-09-03 18:52:54', 'delete', NULL, NULL),
(4328, 1, 'users', '2014-09-03 18:52:54', 'delete', NULL, NULL),
(4329, 47, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4330, 46, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4331, 45, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4332, 44, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4333, 43, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4334, 42, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4335, 41, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4336, 40, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4337, 39, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4338, 38, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4339, 37, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4340, 36, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4341, 35, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4342, 34, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4343, 31, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4344, 30, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4345, 29, 'news', '2014-09-03 18:53:31', 'delete', NULL, NULL),
(4346, 28, 'news', '2014-09-03 18:53:32', 'delete', NULL, NULL),
(4347, 27, 'news', '2014-09-03 18:53:32', 'delete', NULL, NULL),
(4348, 26, 'news', '2014-09-03 18:53:32', 'delete', NULL, NULL),
(4349, 25, 'news', '2014-09-03 18:53:32', 'delete', NULL, NULL),
(4350, 24, 'news', '2014-09-03 18:53:32', 'delete', NULL, NULL),
(4351, 23, 'news', '2014-09-03 18:53:32', 'delete', NULL, NULL),
(4352, 22, 'news', '2014-09-03 18:53:32', 'delete', NULL, NULL),
(4353, 21, 'news', '2014-09-03 18:53:32', 'delete', NULL, NULL),
(4354, 19, 'news', '2014-09-03 18:53:32', 'delete', NULL, NULL),
(4355, 18, 'news', '2014-09-03 18:53:32', 'delete', NULL, NULL),
(4356, 17, 'news', '2014-09-03 18:53:32', 'delete', NULL, NULL),
(4357, 16, 'news', '2014-09-03 18:53:32', 'delete', NULL, NULL),
(4358, 15, 'news', '2014-09-03 18:53:32', 'delete', NULL, NULL),
(4359, 3, 'news', '2014-09-03 18:53:32', 'delete', NULL, NULL),
(4360, 1015, 'files', '2014-09-03 19:08:57', 'insert', NULL, NULL),
(4361, 48, 'news', '2014-09-03 19:13:31', 'insert', NULL, NULL),
(4362, 27, 'table_files', '2014-09-03 19:13:31', 'insert', NULL, NULL),
(4363, 48, 'news', '2014-09-03 19:19:55', 'update', NULL, NULL),
(4364, 1018, 'files', '2014-09-03 19:42:26', 'insert', NULL, NULL),
(4365, 52, 'news', '2014-09-03 19:48:49', 'insert', NULL, NULL),
(4366, 28, 'table_files', '2014-09-03 19:48:49', 'insert', NULL, NULL),
(4367, 52, 'news', '2014-09-03 19:52:42', 'update', NULL, NULL),
(4368, 52, 'news', '2014-09-03 19:52:56', 'update', NULL, NULL),
(4370, 1019, 'files', '2014-09-03 19:57:53', 'insert', NULL, NULL),
(4371, 54, 'news', '2014-09-03 19:57:57', 'insert', NULL, NULL),
(4372, 29, 'table_files', '2014-09-03 19:57:57', 'insert', NULL, NULL),
(4373, 3, 'place', '2014-09-03 20:08:52', 'insert', NULL, NULL),
(4374, 4, 'place', '2014-09-03 20:08:55', 'insert', NULL, NULL),
(4375, 5, 'place', '2014-09-03 20:09:05', 'insert', NULL, NULL),
(4376, 6, 'place', '2014-09-03 20:09:08', 'insert', NULL, NULL),
(4377, 7, 'place', '2014-09-03 20:09:49', 'insert', NULL, NULL),
(4378, 8, 'place', '2014-09-03 20:09:59', 'insert', NULL, NULL),
(4379, 4, 'place', '2014-09-03 20:10:18', 'delete', NULL, NULL),
(4380, 5, 'place', '2014-09-03 20:10:22', 'delete', NULL, NULL),
(4381, 7, 'place', '2014-09-03 20:10:24', 'delete', NULL, NULL),
(4382, 9, 'place', '2014-09-03 20:12:13', 'insert', NULL, NULL),
(4383, 10, 'place', '2014-09-03 20:12:15', 'insert', NULL, NULL),
(4384, 11, 'place', '2014-09-03 20:12:19', 'insert', NULL, NULL),
(4385, 12, 'place', '2014-09-03 20:12:22', 'insert', NULL, NULL),
(4386, 13, 'place', '2014-09-03 20:12:32', 'insert', NULL, NULL),
(4387, 14, 'place', '2014-09-03 20:12:35', 'insert', NULL, NULL),
(4388, 15, 'place', '2014-09-03 20:12:37', 'insert', NULL, NULL),
(4389, 16, 'place', '2014-09-03 20:12:40', 'insert', NULL, NULL),
(4390, 17, 'place', '2014-09-03 20:12:43', 'insert', NULL, NULL),
(4391, 18, 'place', '2014-09-03 20:12:45', 'insert', NULL, NULL),
(4392, 19, 'place', '2014-09-03 20:12:48', 'insert', NULL, NULL),
(4393, 20, 'place', '2014-09-03 20:12:51', 'insert', NULL, NULL),
(4394, 21, 'place', '2014-09-03 20:12:53', 'insert', NULL, NULL),
(4395, 22, 'place', '2014-09-03 20:12:57', 'insert', NULL, NULL),
(4396, 23, 'place', '2014-09-03 20:13:00', 'insert', NULL, NULL),
(4397, 24, 'place', '2014-09-03 20:13:04', 'insert', NULL, NULL),
(4398, 25, 'place', '2014-09-03 20:13:08', 'insert', NULL, NULL),
(4399, 4, 'course', '2014-09-03 20:33:36', 'insert', NULL, NULL),
(4400, 5, 'course', '2014-09-03 20:38:22', 'insert', NULL, NULL),
(4401, 6, 'course', '2014-09-03 20:39:24', 'insert', NULL, NULL),
(4402, 6, 'course', '2014-09-03 20:39:42', 'update', NULL, NULL),
(4403, 4, 'course', '2014-09-03 20:40:02', 'update', NULL, NULL),
(4404, 5, 'course', '2014-09-03 20:40:08', 'update', NULL, NULL),
(4405, 6, 'course', '2014-09-03 20:40:18', 'update', NULL, NULL),
(4406, 5, 'plan', '2014-09-03 20:42:09', 'insert', NULL, NULL),
(4407, 6, 'plan', '2014-09-03 20:43:01', 'insert', NULL, NULL),
(4408, 7, 'plan', '2014-09-03 20:43:09', 'insert', NULL, NULL),
(4409, 9, 'plan', '2014-09-03 20:43:19', 'insert', NULL, NULL),
(4410, 10, 'plan', '2014-09-03 20:43:25', 'insert', NULL, NULL),
(4411, 11, 'plan', '2014-09-03 20:43:31', 'insert', NULL, NULL),
(4412, 12, 'plan', '2014-09-03 20:43:46', 'insert', NULL, NULL),
(4413, 13, 'plan', '2014-09-03 20:43:57', 'insert', NULL, NULL),
(4414, 14, 'plan', '2014-09-03 20:44:32', 'insert', NULL, NULL),
(4415, 15, 'plan', '2014-09-03 20:44:39', 'insert', NULL, NULL),
(4416, 16, 'plan', '2014-09-03 20:44:50', 'insert', NULL, NULL),
(4417, 17, 'plan', '2014-09-03 20:44:58', 'insert', NULL, NULL),
(4418, 18, 'plan', '2014-09-03 20:45:11', 'insert', NULL, NULL),
(4419, 19, 'plan', '2014-09-03 20:45:21', 'insert', NULL, NULL),
(4420, 20, 'plan', '2014-09-03 20:45:43', 'insert', NULL, NULL),
(4421, 21, 'plan', '2014-09-03 20:45:50', 'insert', NULL, NULL),
(4422, 22, 'plan', '2014-09-03 20:46:01', 'insert', NULL, NULL),
(4423, 223, 'users', '2014-09-03 20:47:40', 'insert', NULL, NULL),
(4424, 75, 'person', '2014-09-03 20:47:40', 'insert', NULL, NULL),
(4425, 224, 'users', '2014-09-03 20:49:43', 'insert', NULL, NULL),
(4426, 76, 'person', '2014-09-03 20:49:43', 'insert', NULL, NULL),
(4427, 18, 'class', '2014-09-03 20:55:51', 'insert', NULL, NULL),
(4428, 1, 'branch', '2014-09-12 07:22:28', 'update', NULL, NULL),
(4429, 2, 'branch', '2014-09-12 07:22:30', 'update', NULL, NULL),
(4430, 3, 'branch', '2014-09-12 07:22:33', 'update', NULL, NULL),
(4431, 4, 'branch', '2014-09-12 07:22:37', 'update', NULL, NULL),
(4432, 2, 'users_branch', '2014-09-12 07:37:57', 'insert', NULL, NULL),
(4433, 3, 'users_branch', '2014-09-12 07:38:06', 'insert', NULL, NULL),
(4434, 223, 'users', '2014-09-12 07:39:03', 'update', NULL, NULL),
(4435, 223, 'users', '2014-09-12 07:40:17', 'update', NULL, NULL),
(4436, 18, 'class', '2014-09-12 19:13:13', 'update', NULL, NULL),
(4437, 1, 'consoltation', '2014-09-14 04:53:28', 'insert', NULL, NULL),
(4438, 2, 'consoltation_list', '2014-09-14 10:51:27', 'insert', NULL, NULL),
(4439, 4, 'consoltation_list', '2014-09-14 10:52:31', 'insert', NULL, NULL),
(4440, 5, 'consoltation_list', '2014-09-14 10:53:52', 'insert', NULL, NULL),
(4441, 6, 'consoltation_list', '2014-09-14 10:57:46', 'insert', NULL, NULL),
(4442, 6, 'consultation_list', '2014-09-14 10:57:50', 'delete', NULL, NULL),
(4443, 5, 'consultation_list', '2014-09-14 10:57:50', 'delete', NULL, NULL),
(4444, 4, 'consultation_list', '2014-09-14 10:57:50', 'delete', NULL, NULL),
(4445, 2, 'consultation_list', '2014-09-14 10:57:50', 'delete', NULL, NULL),
(4446, 7, 'consoltation_list', '2014-09-14 11:03:26', 'insert', NULL, NULL),
(4447, 8, 'consoltation_list', '2014-09-14 11:03:55', 'insert', NULL, NULL),
(4448, 9, 'consoltation_list', '2014-09-14 11:05:43', 'insert', NULL, NULL),
(4449, 7, 'consultation_list', '2014-09-14 11:15:33', 'update', NULL, NULL),
(4450, 7, 'consultation_list', '2014-09-14 11:15:59', 'update', NULL, NULL),
(4451, 225, 'users', '2014-09-16 06:17:34', 'insert', NULL, NULL),
(4452, 77, 'person', '2014-09-16 06:17:34', 'insert', NULL, NULL),
(4453, 1, 'bridge', '2014-09-16 06:17:34', 'insert', NULL, NULL),
(4454, 226, 'users', '2014-09-16 08:18:15', 'insert', NULL, NULL),
(4455, 78, 'person', '2014-09-16 08:18:16', 'insert', NULL, NULL),
(4456, 2, 'bridge', '2014-09-16 08:18:16', 'insert', NULL, NULL),
(4457, 227, 'users', '2014-09-16 20:48:35', 'insert', NULL, NULL),
(4458, 79, 'person', '2014-09-16 20:48:35', 'insert', NULL, NULL),
(4459, 3, 'bridge', '2014-09-16 20:48:35', 'insert', NULL, NULL),
(4460, 228, 'users', '2014-09-19 15:21:36', 'insert', NULL, NULL),
(4461, 229, 'users', '2014-09-19 15:22:04', 'insert', NULL, NULL),
(4462, 230, 'users', '2014-09-19 15:22:06', 'insert', NULL, NULL),
(4463, 230, 'users', '2014-09-19 15:22:11', 'delete', NULL, NULL),
(4464, 229, 'users', '2014-09-19 15:22:11', 'delete', NULL, NULL),
(4465, 228, 'users', '2014-09-19 15:22:11', 'delete', NULL, NULL),
(4466, 1, 'permission', '2014-09-20 07:16:56', 'insert', NULL, NULL),
(4467, 223, 'users', '2014-09-22 06:48:56', 'update', NULL, NULL),
(4468, 223, 'users', '2014-09-22 07:26:01', 'update', NULL, NULL),
(4469, 223, 'users', '2014-09-22 07:26:03', 'update', NULL, NULL),
(4470, 223, 'users', '2014-09-22 07:26:04', 'update', NULL, NULL),
(4473, 1, 'permission', '2014-09-22 08:53:50', 'update', NULL, NULL),
(4474, 2, 'permission', '2014-09-22 09:15:47', 'insert', NULL, NULL),
(4475, 3, 'permission', '2014-09-22 09:15:52', 'insert', NULL, NULL),
(4476, 4, 'permission', '2014-09-22 09:16:00', 'insert', NULL, NULL),
(4477, 5, 'permission', '2014-09-22 09:16:06', 'insert', NULL, NULL),
(4478, 3, 'permission', '2014-09-22 09:28:11', 'update', NULL, NULL),
(4479, 4, 'permission', '2014-09-22 09:28:14', 'update', NULL, NULL),
(4480, 2, 'permission', '2014-09-22 11:53:27', 'delete', NULL, NULL),
(4489, 9, 'classification', '2014-09-24 12:05:33', 'insert', NULL, NULL),
(4490, 11, 'classification', '2014-09-24 12:06:10', 'insert', NULL, NULL),
(4491, 13, 'classification', '2014-09-24 12:15:02', 'insert', NULL, NULL),
(4492, 9, 'classification', '2014-09-24 12:16:04', 'delete', NULL, NULL),
(4493, 11, 'classification', '2014-09-24 12:16:04', 'delete', NULL, NULL),
(4494, 13, 'classification', '2014-09-24 12:16:04', 'delete', NULL, NULL),
(4495, 14, 'classification', '2014-09-24 12:16:20', 'insert', NULL, NULL),
(4496, 15, 'classification', '2014-09-24 12:16:27', 'insert', NULL, NULL),
(4497, 16, 'classification', '2014-09-24 18:31:02', 'insert', NULL, NULL),
(4498, 223, 'users', '2014-09-26 17:34:53', 'update', NULL, NULL),
(4500, 223, 'users', '2014-09-28 05:06:17', 'update', NULL, NULL),
(4501, 223, 'users', '2014-09-28 05:10:25', 'update', NULL, NULL),
(4502, 223, 'users', '2014-09-28 05:10:44', 'update', NULL, NULL),
(4503, 1, 'permission', '2014-09-28 05:16:32', 'update', NULL, NULL),
(4504, 223, 'users', '2014-09-28 08:02:19', 'update', NULL, NULL),
(4505, 223, 'users', '2014-09-28 08:09:07', 'update', NULL, NULL),
(4506, 223, 'users', '2014-09-28 08:09:21', 'update', NULL, NULL),
(4507, 223, 'users', '2014-09-28 08:09:29', 'update', NULL, NULL),
(4508, 75, 'person', '2014-09-28 08:59:04', 'update', NULL, NULL),
(4509, 75, 'person', '2014-09-28 09:01:19', 'update', NULL, NULL),
(4510, 223, 'users', '2014-09-28 10:01:31', 'update', NULL, NULL),
(4511, 75, 'person', '2014-09-29 05:56:13', 'update', NULL, NULL),
(4512, 75, 'person', '2014-09-29 06:55:09', 'update', NULL, NULL),
(4513, 1020, 'files', '2014-09-30 06:21:30', 'insert', NULL, NULL),
(4514, 55, 'news', '2014-09-30 06:21:46', 'insert', NULL, NULL),
(4515, 30, 'table_files', '2014-09-30 06:21:46', 'insert', NULL, NULL),
(4516, 57, 'news', '2014-09-30 06:22:39', 'insert', NULL, NULL),
(4517, 31, 'table_files', '2014-09-30 06:22:39', 'insert', NULL, NULL),
(4518, 55, 'news', '2014-09-30 07:19:20', 'delete', NULL, NULL),
(4519, 57, 'news', '2014-09-30 07:19:20', 'delete', NULL, NULL),
(4520, 223, 'users', '2014-09-30 08:32:23', 'update', NULL, NULL),
(4521, 223, 'users', '2014-09-30 08:32:34', 'update', NULL, NULL),
(4522, 223, 'users', '2014-09-30 08:32:44', 'update', NULL, NULL),
(4523, 223, 'users', '2014-09-30 08:32:57', 'update', NULL, NULL),
(4524, 1, 'permission', '2014-09-30 08:42:17', 'update', NULL, NULL),
(4525, 3, 'permission', '2014-09-30 08:43:27', 'delete', NULL, NULL),
(4526, 4, 'permission', '2014-09-30 08:43:27', 'delete', NULL, NULL),
(4527, 5, 'permission', '2014-09-30 08:43:27', 'delete', NULL, NULL),
(4528, 6, 'permission', '2014-09-30 08:55:52', 'insert', NULL, NULL),
(4529, 8, 'permission', '2014-09-30 08:57:12', 'insert', NULL, NULL),
(4530, 9, 'permission', '2014-09-30 08:58:40', 'insert', NULL, NULL),
(4531, 10, 'permission', '2014-09-30 08:59:05', 'insert', NULL, NULL),
(4534, 230, 'users', '2014-09-30 13:52:56', 'insert', NULL, NULL),
(4535, 4, 'bridge', '2014-09-30 13:52:56', 'insert', NULL, NULL),
(4536, 231, 'users', '2014-09-30 14:00:46', 'insert', NULL, NULL),
(4537, 80, 'person', '2014-09-30 14:00:46', 'insert', NULL, NULL),
(4538, 5, 'bridge', '2014-09-30 14:00:46', 'insert', NULL, NULL),
(4539, 232, 'users', '2014-09-30 14:04:06', 'insert', NULL, NULL),
(4540, 81, 'person', '2014-09-30 14:04:06', 'insert', NULL, NULL),
(4541, 6, 'bridge', '2014-09-30 14:04:06', 'insert', NULL, NULL),
(4542, 232, 'users', '2014-09-30 14:11:01', 'update', NULL, NULL),
(4544, 17, 'classification', '2014-09-30 14:27:54', 'insert', NULL, NULL),
(4545, 19, 'classification', '2014-09-30 14:43:53', 'insert', NULL, NULL),
(4546, 20, 'classification', '2014-09-30 14:44:05', 'insert', NULL, NULL),
(4547, 6, 'permission', '2014-09-30 19:05:20', 'update', NULL, NULL),
(4548, 8, 'permission', '2014-09-30 19:05:27', 'update', NULL, NULL),
(4549, 11, 'permission', '2014-09-30 20:00:15', 'insert', NULL, NULL),
(4550, 12, 'permission', '2014-09-30 20:24:25', 'insert', NULL, NULL),
(4552, 234, 'users', '2014-10-01 04:00:53', 'insert', NULL, NULL),
(4553, 82, 'person', '2014-10-01 04:00:53', 'insert', NULL, NULL),
(4554, 7, 'bridge', '2014-10-01 04:00:53', 'insert', NULL, NULL),
(4555, 13, 'permission', '2014-10-01 04:12:31', 'insert', NULL, NULL),
(4557, 236, 'users', '2014-10-01 04:16:04', 'insert', NULL, NULL),
(4558, 83, 'person', '2014-10-01 04:16:04', 'insert', NULL, NULL),
(4559, 8, 'bridge', '2014-10-01 04:16:04', 'insert', NULL, NULL),
(4560, 2, 'branch', '2014-10-01 04:22:48', 'update', NULL, NULL),
(4561, 3, 'branch', '2014-10-01 04:22:53', 'update', NULL, NULL),
(4562, 4, 'branch', '2014-10-01 04:22:58', 'update', NULL, NULL),
(4563, 14, 'permission', '2014-10-01 04:32:58', 'insert', NULL, NULL),
(4564, 15, 'permission', '2014-10-01 04:44:54', 'insert', NULL, NULL),
(4565, 6, 'permission', '2014-10-01 04:46:33', 'delete', NULL, NULL),
(4566, 8, 'permission', '2014-10-01 04:46:34', 'delete', NULL, NULL),
(4567, 9, 'permission', '2014-10-01 04:46:34', 'delete', NULL, NULL),
(4568, 10, 'permission', '2014-10-01 04:46:34', 'delete', NULL, NULL),
(4569, 11, 'permission', '2014-10-01 04:46:34', 'delete', NULL, NULL),
(4570, 12, 'permission', '2014-10-01 04:46:34', 'delete', NULL, NULL),
(4571, 13, 'permission', '2014-10-01 04:46:34', 'delete', NULL, NULL),
(4572, 14, 'permission', '2014-10-01 04:46:34', 'delete', NULL, NULL),
(4573, 15, 'permission', '2014-10-01 04:46:34', 'delete', NULL, NULL),
(4574, 16, 'permission', '2014-10-01 04:46:58', 'insert', NULL, NULL),
(4575, 17, 'permission', '2014-10-01 04:47:19', 'insert', NULL, NULL),
(4576, 18, 'permission', '2014-10-01 04:47:25', 'insert', NULL, NULL),
(4577, 19, 'permission', '2014-10-01 04:50:20', 'insert', NULL, NULL),
(4578, 20, 'permission', '2014-10-01 04:51:11', 'insert', NULL, NULL),
(4579, 18, 'class', '2014-10-01 06:09:23', 'update', NULL, NULL),
(4580, 18, 'class', '2014-10-01 06:09:33', 'update', NULL, NULL),
(4581, 237, 'users', '2014-10-01 07:52:04', 'insert', NULL, NULL),
(4582, 84, 'person', '2014-10-01 07:52:04', 'insert', NULL, NULL),
(4583, 9, 'bridge', '2014-10-01 07:52:04', 'insert', NULL, NULL),
(4584, 84, 'person', '2014-10-01 08:01:02', 'update', NULL, NULL),
(4585, 1, 'permission', '2014-10-01 08:03:29', 'update', NULL, NULL),
(4586, 21, 'permission', '2014-10-01 08:03:47', 'insert', NULL, NULL),
(4587, 22, 'permission', '2014-10-01 08:15:35', 'insert', NULL, NULL),
(4588, 19, 'class', '2014-10-01 08:36:31', 'insert', NULL, NULL),
(4589, 24, 'classification', '2014-10-01 08:49:02', 'insert', NULL, NULL),
(4590, 25, 'classification', '2014-10-01 08:49:49', 'insert', NULL, NULL),
(4591, 1, 'permission', '2014-10-01 08:52:34', 'delete', NULL, NULL),
(4592, 16, 'permission', '2014-10-01 08:52:34', 'delete', NULL, NULL),
(4593, 17, 'permission', '2014-10-01 08:52:34', 'delete', NULL, NULL),
(4594, 18, 'permission', '2014-10-01 08:52:34', 'delete', NULL, NULL),
(4595, 19, 'permission', '2014-10-01 08:52:34', 'delete', NULL, NULL),
(4596, 20, 'permission', '2014-10-01 08:52:34', 'delete', NULL, NULL),
(4597, 21, 'permission', '2014-10-01 08:52:34', 'delete', NULL, NULL),
(4598, 22, 'permission', '2014-10-01 08:52:34', 'delete', NULL, NULL),
(4599, 75, 'person', '2014-10-01 08:52:56', 'delete', NULL, NULL),
(4600, 76, 'person', '2014-10-01 08:52:56', 'delete', NULL, NULL),
(4601, 77, 'person', '2014-10-01 08:52:56', 'delete', NULL, NULL),
(4602, 78, 'person', '2014-10-01 08:52:56', 'delete', NULL, NULL),
(4603, 79, 'person', '2014-10-01 08:52:56', 'delete', NULL, NULL),
(4604, 80, 'person', '2014-10-01 08:52:56', 'delete', NULL, NULL),
(4605, 81, 'person', '2014-10-01 08:52:56', 'delete', NULL, NULL),
(4606, 82, 'person', '2014-10-01 08:52:56', 'delete', NULL, NULL),
(4607, 83, 'person', '2014-10-01 08:52:56', 'delete', NULL, NULL),
(4608, 84, 'person', '2014-10-01 08:52:56', 'delete', NULL, NULL),
(4609, 14, 'classification', '2014-10-01 08:53:52', 'delete', NULL, NULL),
(4610, 15, 'classification', '2014-10-01 08:53:52', 'delete', NULL, NULL),
(4611, 16, 'classification', '2014-10-01 08:53:52', 'delete', NULL, NULL),
(4612, 17, 'classification', '2014-10-01 08:53:52', 'delete', NULL, NULL),
(4613, 19, 'classification', '2014-10-01 08:53:52', 'delete', NULL, NULL),
(4614, 20, 'classification', '2014-10-01 08:53:52', 'delete', NULL, NULL),
(4615, 24, 'classification', '2014-10-01 08:53:52', 'delete', NULL, NULL),
(4616, 25, 'classification', '2014-10-01 08:53:52', 'delete', NULL, NULL),
(4617, 18, 'class', '2014-10-01 08:54:03', 'delete', NULL, NULL),
(4618, 19, 'class', '2014-10-01 08:54:03', 'delete', NULL, NULL),
(4619, 2, 'users_branch', '2014-10-01 08:54:24', 'delete', NULL, NULL),
(4620, 3, 'users_branch', '2014-10-01 08:54:24', 'delete', NULL, NULL),
(4621, 223, 'users', '2014-10-01 08:54:30', 'delete', NULL, NULL),
(4622, 224, 'users', '2014-10-01 08:54:30', 'delete', NULL, NULL),
(4623, 1, 'bridge', '2014-10-01 08:54:41', 'delete', NULL, NULL),
(4624, 2, 'bridge', '2014-10-01 08:54:42', 'delete', NULL, NULL),
(4625, 3, 'bridge', '2014-10-01 08:54:42', 'delete', NULL, NULL),
(4626, 4, 'bridge', '2014-10-01 08:54:42', 'delete', NULL, NULL),
(4627, 5, 'bridge', '2014-10-01 08:54:42', 'delete', NULL, NULL),
(4628, 6, 'bridge', '2014-10-01 08:54:42', 'delete', NULL, NULL),
(4629, 7, 'bridge', '2014-10-01 08:54:42', 'delete', NULL, NULL),
(4630, 8, 'bridge', '2014-10-01 08:54:42', 'delete', NULL, NULL),
(4631, 9, 'bridge', '2014-10-01 08:54:42', 'delete', NULL, NULL),
(4632, 225, 'users', '2014-10-01 08:54:49', 'delete', NULL, NULL),
(4633, 226, 'users', '2014-10-01 08:54:49', 'delete', NULL, NULL),
(4634, 227, 'users', '2014-10-01 08:54:49', 'delete', NULL, NULL),
(4635, 230, 'users', '2014-10-01 08:54:49', 'delete', NULL, NULL),
(4636, 231, 'users', '2014-10-01 08:54:49', 'delete', NULL, NULL),
(4637, 232, 'users', '2014-10-01 08:54:49', 'delete', NULL, NULL),
(4638, 234, 'users', '2014-10-01 08:54:49', 'delete', NULL, NULL),
(4639, 236, 'users', '2014-10-01 08:54:49', 'delete', NULL, NULL),
(4640, 237, 'users', '2014-10-01 08:54:49', 'delete', NULL, NULL),
(4641, 238, 'users', '2014-10-01 08:57:11', 'insert', NULL, NULL),
(4642, 85, 'person', '2014-10-01 08:57:11', 'insert', NULL, NULL),
(4643, 10, 'bridge', '2014-10-01 08:57:11', 'insert', NULL, NULL),
(4644, 85, 'person', '2014-10-01 08:58:04', 'update', NULL, NULL),
(4645, 85, 'person', '2014-10-01 08:59:29', 'update', NULL, NULL),
(4646, 85, 'person', '2014-10-01 08:59:44', 'update', NULL, NULL),
(4647, 85, 'person', '2014-10-01 08:59:54', 'update', NULL, NULL),
(4648, 23, 'permission', '2014-10-01 09:00:33', 'insert', NULL, NULL),
(4649, 24, 'permission', '2014-10-01 09:00:54', 'insert', NULL, NULL),
(4650, 25, 'permission', '2014-10-01 09:01:06', 'insert', NULL, NULL),
(4651, 26, 'permission', '2014-10-01 09:01:11', 'insert', NULL, NULL),
(4652, 27, 'permission', '2014-10-01 09:01:14', 'insert', NULL, NULL),
(4653, 28, 'permission', '2014-10-01 09:01:20', 'insert', NULL, NULL),
(4654, 29, 'permission', '2014-10-01 09:01:26', 'insert', NULL, NULL),
(4655, 30, 'permission', '2014-10-01 09:01:31', 'insert', NULL, NULL),
(4656, 31, 'permission', '2014-10-01 09:01:44', 'insert', NULL, NULL),
(4657, 32, 'permission', '2014-10-01 09:01:55', 'insert', NULL, NULL),
(4658, 33, 'permission', '2014-10-01 09:01:58', 'insert', NULL, NULL),
(4659, 35, 'permission', '2014-10-01 09:02:25', 'insert', NULL, NULL),
(4660, 36, 'permission', '2014-10-01 09:02:38', 'insert', NULL, NULL),
(4661, 37, 'permission', '2014-10-01 09:02:44', 'insert', NULL, NULL),
(4662, 20, 'class', '2014-10-01 09:05:11', 'insert', NULL, NULL),
(4663, 20, 'class', '2014-10-01 09:05:43', 'delete', NULL, NULL),
(4664, 21, 'class', '2014-10-01 09:06:35', 'insert', NULL, NULL),
(4665, 26, 'classification', '2014-10-01 09:08:51', 'insert', NULL, NULL),
(4666, 26, 'classification', '2014-10-01 09:16:43', 'delete', NULL, NULL),
(4667, 28, 'classification', '2014-10-01 09:17:09', 'insert', NULL, NULL),
(4668, 28, 'classification', '2014-10-01 09:21:04', 'delete', NULL, NULL),
(4669, 29, 'classification', '2014-10-01 09:21:15', 'insert', NULL, NULL),
(4670, 29, 'classification', '2014-10-01 09:25:02', 'delete', NULL, NULL),
(4671, 33, 'classification', '2014-10-01 09:25:18', 'insert', NULL, NULL),
(4672, 33, 'classification', '2014-10-01 09:25:50', 'delete', NULL, NULL),
(4673, 34, 'classification', '2014-10-01 09:26:04', 'insert', NULL, NULL),
(4674, 34, 'classification', '2014-10-01 09:26:35', 'delete', NULL, NULL),
(4675, 35, 'classification', '2014-10-01 09:26:46', 'insert', NULL, NULL),
(4676, 238, 'users', '2014-10-01 09:29:08', 'update', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_counter`
--

DROP TABLE IF EXISTS `login_counter`;
CREATE TABLE IF NOT EXISTS `login_counter` (
  `ip` varchar(15) COLLATE utf8_persian_ci NOT NULL,
  `count` int(3) NOT NULL,
  `time` varchar(64) COLLATE utf8_persian_ci NOT NULL,
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` enum('login','register') COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=295 ;

-- --------------------------------------------------------

--
-- Table structure for table `pending_classes`
--

DROP TABLE IF EXISTS `pending_classes`;
CREATE TABLE IF NOT EXISTS `pending_classes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `users_id` int(10) DEFAULT NULL,
  `classes_id` int(10) DEFAULT NULL,
  `date` int(8) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users` (`users_id`,`classes_id`) USING BTREE,
  KEY `classes_id` (`classes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tables` varchar(64) COLLATE utf8_persian_ci NOT NULL,
  `users_id` int(10) NOT NULL,
  `select` enum('private','public') COLLATE utf8_persian_ci DEFAULT NULL,
  `update` enum('private','public') COLLATE utf8_persian_ci DEFAULT NULL,
  `insert` enum('private','public') COLLATE utf8_persian_ci DEFAULT NULL,
  `delete` enum('private','public') COLLATE utf8_persian_ci DEFAULT NULL,
  `condition` text COLLATE utf8_persian_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `table` (`tables`,`users_id`),
  KEY `users_id` (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=39 ;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `tables`, `users_id`, `select`, `update`, `insert`, `delete`, `condition`) VALUES
(23, 'permission', 238, 'public', 'public', 'public', 'public', NULL),
(24, 'branch', 238, 'public', 'public', 'public', 'public', NULL),
(25, 'city', 238, 'public', 'public', 'public', 'public', NULL),
(26, 'classes', 238, 'public', 'public', 'public', 'public', NULL),
(27, 'classification', 238, 'public', 'public', 'public', 'public', NULL),
(28, 'country', 238, 'public', 'public', 'public', 'public', NULL),
(29, 'course', 238, 'public', 'public', 'public', 'public', NULL),
(30, 'education', 238, 'public', 'public', 'public', 'public', NULL),
(31, 'group', 238, 'public', 'public', 'public', 'public', NULL),
(32, 'place', 238, 'public', 'public', 'public', 'public', NULL),
(33, 'person', 238, 'public', 'public', 'public', 'public', NULL),
(35, 'province', 238, 'public', 'public', 'public', 'public', NULL),
(36, 'regulation', 238, 'public', 'public', 'public', 'public', NULL),
(37, 'users', 238, 'public', 'public', 'public', 'public', NULL);

--
-- Triggers `permission`
--
DROP TRIGGER IF EXISTS `permission_delete`;
DELIMITER //
CREATE TRIGGER `permission_delete` AFTER DELETE ON `permission`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'permission','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `permission_insert`;
DELIMITER //
CREATE TRIGGER `permission_insert` AFTER INSERT ON `permission`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'permission','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `permission_update`;
DELIMITER //
CREATE TRIGGER `permission_update` AFTER UPDATE ON `permission`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'permission','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
CREATE TABLE IF NOT EXISTS `person` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'شماره',
  `name` varchar(32) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام',
  `family` varchar(32) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام خانوادگی',
  `father` varchar(16) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام پدر',
  `birthday` int(8) DEFAULT NULL COMMENT 'تاریخ تولد',
  `gender` enum('male','female') COLLATE utf8_persian_ci DEFAULT 'male' COMMENT 'جنسیت',
  `nationalcode` varchar(16) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد ملی / گذر نامه',
  `code` int(10) DEFAULT NULL COMMENT 'شماره شناسنامه',
  `from` int(10) DEFAULT NULL COMMENT 'صادره',
  `nationality` int(10) DEFAULT NULL COMMENT 'ملیت',
  `marriage` enum('single','married') COLLATE utf8_persian_ci DEFAULT 'single' COMMENT 'وضعیت تاهل',
  `child` int(2) DEFAULT NULL COMMENT 'تعداد فرزندان',
  `type` enum('student','teacher','operator','baby') COLLATE utf8_persian_ci DEFAULT 'student' COMMENT 'گروه',
  `casecode` int(11) DEFAULT NULL COMMENT 'شماره پرونده',
  `casecode_old` int(9) DEFAULT NULL COMMENT 'شماره پرونده قدیم',
  `education_id` int(10) DEFAULT NULL COMMENT 'تحصیلات',
  `en_name` varchar(32) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام به انگلیسی',
  `en_family` varchar(32) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام خانوادگی به انگلیسی',
  `en_father` varchar(32) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام پدر به انگلیسی',
  `third_name` varchar(32) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام به زبان سوم',
  `third_family` varchar(32) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام خانوادگی به زبان سوم',
  `third_father` varchar(32) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام پدر به زبان سوم',
  `pasport_date` int(8) DEFAULT NULL COMMENT 'تاریخ اعتبار گذرنامه',
  `users_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `from` (`from`),
  KEY `nationality` (`nationality`),
  KEY `education_id` (`education_id`),
  KEY `users_id` (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='اعضاء' AUTO_INCREMENT=86 ;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `name`, `family`, `father`, `birthday`, `gender`, `nationalcode`, `code`, `from`, `nationality`, `marriage`, `child`, `type`, `casecode`, `casecode_old`, `education_id`, `en_name`, `en_family`, `en_father`, `third_name`, `third_family`, `third_father`, `pasport_date`, `users_id`) VALUES
(85, 'رضا', 'محیطی', 'احمد', 137000116, 'male', '0370581644', NULL, 275, 97, 'single', NULL, 'student', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 238);

--
-- Triggers `person`
--
DROP TRIGGER IF EXISTS `person_delete`;
DELIMITER //
CREATE TRIGGER `person_delete` AFTER DELETE ON `person`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'person','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `person_insert`;
DELIMITER //
CREATE TRIGGER `person_insert` AFTER INSERT ON `person`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'person','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `person_update`;
DELIMITER //
CREATE TRIGGER `person_update` AFTER UPDATE ON `person`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'person','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `place`
--

DROP TABLE IF EXISTS `place`;
CREATE TABLE IF NOT EXISTS `place` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_persian_ci NOT NULL COMMENT 'مدرس',
  `branch_id` int(10) NOT NULL COMMENT 'شماره شعبه',
  `description` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`branch_id`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='مدرس' AUTO_INCREMENT=26 ;

--
-- Dumping data for table `place`
--

INSERT INTO `place` (`id`, `name`, `branch_id`, `description`) VALUES
(3, 'شبستان حضرت نجمه خاتون علیها الس', 1, ''),
(6, 'سالن بیت النور', 1, ''),
(8, 'مدرس شماره 1', 2, ''),
(9, 'مدرس شماره 2', 1, ''),
(10, 'مدرس شماره 3', 1, ''),
(11, 'مدرس شماره 4', 1, ''),
(12, 'مدرس شماره 5', 1, ''),
(13, 'مدرس شماره 6', 1, ''),
(14, 'مدرس شماره 7', 1, ''),
(15, 'مدرس شماره 8', 1, ''),
(16, 'مدرس شماره 9', 1, ''),
(17, 'مدرس شماره 10', 1, ''),
(18, 'مدرس شماره 11', 1, ''),
(19, 'مدرس شماره 12', 1, ''),
(20, 'مدرس شماره 13', 1, ''),
(21, 'مدرس شماره 14', 1, ''),
(22, 'مدرس شماره 15', 1, ''),
(23, 'مدرس شماره 16', 1, ''),
(24, 'مدرس شماره 17', 1, ''),
(25, 'مدرس شماره 18', 1, '');

--
-- Triggers `place`
--
DROP TRIGGER IF EXISTS `place_delete`;
DELIMITER //
CREATE TRIGGER `place_delete` AFTER DELETE ON `place`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'place','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `place_insert`;
DELIMITER //
CREATE TRIGGER `place_insert` AFTER INSERT ON `place`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'place','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `place_update`;
DELIMITER //
CREATE TRIGGER `place_update` AFTER UPDATE ON `place`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'place','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

DROP TABLE IF EXISTS `plan`;
CREATE TABLE IF NOT EXISTS `plan` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'شماره',
  `group_id` int(10) NOT NULL COMMENT 'گروه',
  `name` varchar(32) COLLATE utf8_persian_ci NOT NULL COMMENT 'نام طرح',
  `price` int(7) DEFAULT NULL COMMENT 'مبلغ شهریه',
  `absence` int(2) DEFAULT NULL COMMENT 'تعداد غیبت مجاز',
  `certificate` int(1) DEFAULT NULL COMMENT 'گواهی نامه',
  `mark` float DEFAULT NULL COMMENT 'امتیاز قبولی',
  `rule` int(10) DEFAULT NULL COMMENT 'آیین نامه ها',
  `min_person` int(3) DEFAULT NULL COMMENT 'حد اقل اعضاء',
  `max_person` int(4) DEFAULT NULL COMMENT 'حد اکثر اعضاء',
  PRIMARY KEY (`id`),
  UNIQUE KEY `group` (`group_id`,`name`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='طرح ها' AUTO_INCREMENT=23 ;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`id`, `group_id`, `name`, `price`, `absence`, `certificate`, `mark`, `rule`, `min_person`, `max_person`) VALUES
(5, 2, 'روخوانی قرآن کریم', 100000, NULL, 1, 16, NULL, 15, 25),
(6, 2, 'تجوید قرآن کریم', 100000, NULL, 1, 16, NULL, 10, 30),
(7, 2, 'تجوید سطح دو قرآن کریم', 100000, NULL, 1, 16, NULL, 10, 30),
(9, 2, 'صوت و لحن قرآن کریم', 100000, NULL, 1, 16, NULL, 10, 30),
(10, 2, 'آموزش اذان', 100000, NULL, 1, 16, NULL, 10, 30),
(11, 2, 'آموزش تواشیح', 100000, NULL, 1, 16, NULL, 10, 30),
(12, 2, 'کارگاه آموزشی روخوانی و روان خوا', 100000, NULL, 1, 16, NULL, 10, 30),
(13, 2, 'کارگاه آموزش تجوید قرآن کریم', 100000, NULL, 1, 16, NULL, 10, 30),
(14, 3, 'حفظ آزمایشی قرآن کریم', 200000, NULL, 1, 17, NULL, 5, 15),
(15, 3, 'حفظ دوساله قرآن کریم', 200000, NULL, 1, 17, NULL, 5, 15),
(16, 3, 'حفظ چهار ساله قرآن کریم', 200000, NULL, 1, 17, NULL, 5, 15),
(17, 3, 'حفظ شش ساله قرآن کریم', 200000, NULL, 1, 17, NULL, 5, 15),
(18, 3, 'طرح تثبیت محفوظات', 200000, NULL, 1, 17, NULL, 5, 15),
(19, 3, 'حفظ نهج البلاغه', 200000, NULL, 1, 17, NULL, 5, 15),
(20, 1, 'مداحی', 100000, NULL, 1, 17, NULL, 15, 50),
(21, 1, 'ترجمه و مفاهیم', 100000, NULL, 1, 17, NULL, 15, 25),
(22, 1, 'معصوم شناسی', 100000, NULL, 1, 17, NULL, 15, 300);

--
-- Triggers `plan`
--
DROP TRIGGER IF EXISTS `plan_delete`;
DELIMITER //
CREATE TRIGGER `plan_delete` AFTER DELETE ON `plan`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'plan','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `plan_insert`;
DELIMITER //
CREATE TRIGGER `plan_insert` AFTER INSERT ON `plan`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'plan','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `plan_update`;
DELIMITER //
CREATE TRIGGER `plan_update` AFTER UPDATE ON `plan`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'plan','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `plan_section`
--

DROP TABLE IF EXISTS `plan_section`;
CREATE TABLE IF NOT EXISTS `plan_section` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `plan_id` int(10) NOT NULL,
  `section` varchar(64) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `section` (`plan_id`,`section`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

--
-- Triggers `plan_section`
--
DROP TRIGGER IF EXISTS `plan_section_delete`;
DELIMITER //
CREATE TRIGGER `plan_section_delete` AFTER DELETE ON `plan_section`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'plan_section','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `plan_section_insert`;
DELIMITER //
CREATE TRIGGER `plan_section_insert` AFTER INSERT ON `plan_section`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'plan_section','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `plan_section_update`;
DELIMITER //
CREATE TRIGGER `plan_section_update` AFTER UPDATE ON `plan_section`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'plan_section','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

DROP TABLE IF EXISTS `position`;
CREATE TABLE IF NOT EXISTS `position` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `position` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'منصب',
  PRIMARY KEY (`id`),
  UNIQUE KEY `postion` (`position`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `position`) VALUES
(8, 'استاد'),
(12, 'خدمات'),
(5, 'رئیس اداره'),
(9, 'فراگیر'),
(2, 'کارشناس'),
(1, 'کارشناس مسئول'),
(7, 'متصدی'),
(11, 'مدیر'),
(10, 'مربی'),
(3, 'مسئول'),
(6, 'مسئول دفتر'),
(13, 'هماهنگ کننده'),
(4, 'هیئت علمی');

--
-- Triggers `position`
--
DROP TRIGGER IF EXISTS `posts_delete`;
DELIMITER //
CREATE TRIGGER `posts_delete` AFTER DELETE ON `position`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'posts','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `posts_insert`;
DELIMITER //
CREATE TRIGGER `posts_insert` AFTER INSERT ON `position`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'posts','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `posts_update`;
DELIMITER //
CREATE TRIGGER `posts_update` AFTER UPDATE ON `position`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'posts','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'شمارگان',
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
  `group` int(10) NOT NULL COMMENT 'گروه خبری',
  `short` text COLLATE utf8_persian_ci NOT NULL COMMENT 'خلاصه',
  `text` text COLLATE utf8_persian_ci NOT NULL COMMENT 'متن اصلی',
  `time_spread` varchar(16) COLLATE utf8_persian_ci NOT NULL COMMENT 'زمان انتشار',
  `end_spread` varchar(16) COLLATE utf8_persian_ci NOT NULL COMMENT 'پایان انتشار',
  `curl` varchar(64) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوانک',
  `type` enum('page','post') COLLATE utf8_persian_ci NOT NULL DEFAULT 'post',
  PRIMARY KEY (`id`),
  UNIQUE KEY `curl` (`curl`),
  UNIQUE KEY `id` (`title`,`group`,`time_spread`,`end_spread`) USING BTREE,
  KEY `group` (`group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=55 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `group`, `short`, `text`, `time_spread`, `end_spread`, `curl`, `type`) VALUES
(48, 'همایش سالانه مرکز قرآن و حدیث', 1, 'همایش سالانه مرکز قرآن و حدیث کریمه اهل بیت علیها السلام برگزار می شود', 'در دهه کرامت 93، همایش سالانه مرکز قرآن و حدیث کریمه اهل‌بیت (س) در حرم مطهر برگزار می‌شود.\r\nبه گزارش روابط عمومی و امور بین‌الملل آستان مقدس حضرت فاطمه معصومه علیهاالسلام،‌ مدیر مرکز قرآن و حدیث کریمه اهل‌بیت(س) با اعلام این خبر گفت: همایش سالانه این مرکز در روزهای شنبه و یکشنبه، 15 و 16 شهریورماه جاری در حرم مطهر برگزار می‌شود.\r\nحجت‌الاسلام علی قاسمی ادامه داد:‌ در روز شنبه،‌ همایش سالانه ویژه دانش‌آموختگان خواهر مرکز قرآن و حدیث ساعت 17:30 در شبستان حضرت نجمه خاتون(س) حرم مطهر با سخنرانی آیت‌الله سعیدی، تولیت آستان مقدس قم برگزار می‌شود.\r\nوی ادامه داد:‌ دومین روز از همایش سالانه مرکز قرآن و حدیث کریمه اهل‌بیت(س) ویژه برادران در روز یکشنبه، از ساعت 17:30 با حضور اساتید برجسته قرآنی کشوری برگزار خواهد شد.\r\nمدیر مرکز قرآن و حدیث کریمه اهل‌بیت(س) در پایان افزود: در این همایش سالانه، از حافظان کل قرآن کریم و نفرات برجسته در فعالت‌های قرآنی و حدیثی این مرکز تجلیل به عمل خواهد آمد.', '1111111', '111111', 'همایش سالانه', 'post'),
(52, 'آموزش بیش از 30 هزار نفر در کلاس های مرکز قرآن و حدیث', 1, 'از ابتدای تاسیس مرکز تا کنون بیش از 30 هزار نفر در کلاس های مختلف آموزشی این مجموعه شرکت کرده اند', 'حجت الاسلام  والمسلمین مهدی احمدی اعلام داشتند: تا کنون بیش از 30 هزار نفر از امکانات آموزشی و تربیتی مرکز قرآن و حدیث کریمه اهل بیت علهیا السلام استفاده کرده اند.این قرآن آموزان در رشته های مختلف روخوانی، روان خوانی، تجوید، صوت و لحن، حفظ قرآن کریم، ترجمه و مفاهیم، مداحی و ... شرکت داشته اند.', '', '', 'آموزش بیش از 30 هزار نفر', 'post'),
(54, 'افتتاح پورتال جامع مرکز قرآن و حدیث', 1, 'همزمان با دهه کرامت، سامانه جامع مدیریت اطلاعات آموزشی مرکز قرآن و حدیث کریمه اهل بیت علیها السلام، افتتاح شد', 'سامانه جامع مرکز قرآن و حدیث، اطلاعات آموزشی فراگیران این مجموعه را از زمان ثبت نام تا دریافت گواهی نامه پایان دوره مدیریت می کند.\r\nبرنامه نویسی این سامانه، با همت و تلاش کارشناسان مرکز قرآن و حدیث و با استفاده از تیم برنامه نویسی افتخاری، زمستان 1392 شروع و هم اکنون آماده بهره برداری می باشد.', '', '', 'افتتاح سامانه جامع', 'post');

--
-- Triggers `posts`
--
DROP TRIGGER IF EXISTS `news_delete`;
DELIMITER //
CREATE TRIGGER `news_delete` AFTER DELETE ON `posts`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'news','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `news_insert`;
DELIMITER //
CREATE TRIGGER `news_insert` AFTER INSERT ON `posts`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'news','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `news_update`;
DELIMITER //
CREATE TRIGGER `news_update` AFTER UPDATE ON `posts`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'news','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `posts_group`
--

DROP TABLE IF EXISTS `posts_group`;
CREATE TABLE IF NOT EXISTS `posts_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group` varchar(64) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group` (`group`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `posts_group`
--

INSERT INTO `posts_group` (`id`, `group`) VALUES
(3, 'اختصاصی'),
(1, 'عمومی');

--
-- Triggers `posts_group`
--
DROP TRIGGER IF EXISTS `news_group_delete`;
DELIMITER //
CREATE TRIGGER `news_group_delete` AFTER DELETE ON `posts_group`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'news_group','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `news_group_insert`;
DELIMITER //
CREATE TRIGGER `news_group_insert` AFTER INSERT ON `posts_group`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'news_group','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `news_group_update`;
DELIMITER //
CREATE TRIGGER `news_group_update` AFTER UPDATE ON `posts_group`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'news_group','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `posts_tags`
--

DROP TABLE IF EXISTS `posts_tags`;
CREATE TABLE IF NOT EXISTS `posts_tags` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `posts_id` int(10) NOT NULL,
  `tags_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`posts_id`,`tags_id`),
  KEY `tags_id` (`tags_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

--
-- Triggers `posts_tags`
--
DROP TRIGGER IF EXISTS `news_tags_delete`;
DELIMITER //
CREATE TRIGGER `news_tags_delete` AFTER DELETE ON `posts_tags`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'news_tags','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `news_tags_insert`;
DELIMITER //
CREATE TRIGGER `news_tags_insert` AFTER INSERT ON `posts_tags`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'news_tags','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `news_tags_update`;
DELIMITER //
CREATE TRIGGER `news_tags_update` AFTER UPDATE ON `posts_tags`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'news_tags','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `prerequisite`
--

DROP TABLE IF EXISTS `prerequisite`;
CREATE TABLE IF NOT EXISTS `prerequisite` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `plan_id` int(10) NOT NULL COMMENT 'طرح',
  `prerequisite` int(10) DEFAULT NULL COMMENT 'پیش نیاز',
  PRIMARY KEY (`id`),
  UNIQUE KEY `plan` (`plan_id`,`prerequisite`) USING BTREE,
  KEY `plan_id` (`plan_id`),
  KEY `prerequisite` (`prerequisite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='پیش نیاز طرح ها' AUTO_INCREMENT=1 ;

--
-- Triggers `prerequisite`
--
DROP TRIGGER IF EXISTS `prerequisite_delete`;
DELIMITER //
CREATE TRIGGER `prerequisite_delete` AFTER DELETE ON `prerequisite`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'prerequisite','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `prerequisite_insert`;
DELIMITER //
CREATE TRIGGER `prerequisite_insert` AFTER INSERT ON `prerequisite`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'prerequisite','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `prerequsite_upate`;
DELIMITER //
CREATE TRIGGER `prerequsite_upate` AFTER UPDATE ON `prerequisite`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'prerequisite','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

DROP TABLE IF EXISTS `price`;
CREATE TABLE IF NOT EXISTS `price` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `course_id` int(10) NOT NULL COMMENT 'دوره',
  `plan_id` int(10) NOT NULL COMMENT 'طرح',
  `users_id` int(10) NOT NULL COMMENT 'قرآن آموز',
  `value` int(7) DEFAULT NULL COMMENT 'مبلغ قابل پرداخت',
  `status` enum('فعال','استفاده شده','ارجاع داده شده','بلوکه شده') COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'وضعیت',
  `date_change_status` int(8) DEFAULT NULL COMMENT 'تاریخ تغییر وضعیت',
  `expert` int(10) DEFAULT NULL COMMENT 'کارشناس مربوطه',
  `value_back` int(7) DEFAULT NULL COMMENT 'مبلغ ارجاع داده شده',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`course_id`,`plan_id`,`users_id`,`value`,`status`) USING BTREE,
  KEY `course_id` (`course_id`),
  KEY `plan_id` (`plan_id`),
  KEY `users_id` (`users_id`),
  KEY `expert` (`expert`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='شهریه' AUTO_INCREMENT=1 ;

--
-- Triggers `price`
--
DROP TRIGGER IF EXISTS `price_delete`;
DELIMITER //
CREATE TRIGGER `price_delete` AFTER DELETE ON `price`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'price','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `price_insert`;
DELIMITER //
CREATE TRIGGER `price_insert` AFTER INSERT ON `price`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'price','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `price_update`;
DELIMITER //
CREATE TRIGGER `price_update` AFTER UPDATE ON `price`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'price','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

DROP TABLE IF EXISTS `province`;
CREATE TABLE IF NOT EXISTS `province` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=32 ;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`id`, `name`) VALUES
(1, 'آذربايجان شرقي'),
(2, 'آذربايجان غربي'),
(3, 'اردبيل'),
(4, 'اصفهان'),
(19, 'البرز'),
(5, 'ايلام'),
(6, 'بوشهر'),
(7, 'تهران'),
(8, 'چهارمحال بختياري'),
(9, 'خراسان جنوبي'),
(10, 'خراسان رضوي'),
(11, 'خراسان شمالي'),
(12, 'خوزستان'),
(13, 'زنجان'),
(14, 'سمنان'),
(15, 'سيستان و بلوچستان'),
(16, 'فارس'),
(17, 'قزوين'),
(18, 'قم'),
(20, 'كردستان'),
(21, 'كرمان'),
(22, 'كرمانشاه'),
(23, 'كهكيلويه و بويراحمد'),
(24, 'گلستان'),
(25, 'گيلان'),
(26, 'لرستان'),
(27, 'مازندران'),
(28, 'مركزي'),
(29, 'هرمزگان'),
(30, 'همدان'),
(31, 'يزد');

--
-- Triggers `province`
--
DROP TRIGGER IF EXISTS `province_delete`;
DELIMITER //
CREATE TRIGGER `province_delete` AFTER DELETE ON `province`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'province','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `province_insert`;
DELIMITER //
CREATE TRIGGER `province_insert` AFTER INSERT ON `province`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'province','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `province_update`;
DELIMITER //
CREATE TRIGGER `province_update` AFTER UPDATE ON `province`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'province','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `racehistory`
--

DROP TABLE IF EXISTS `racehistory`;
CREATE TABLE IF NOT EXISTS `racehistory` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `users_id` int(10) NOT NULL,
  `field` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'رشته',
  `club` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'مرکز یا موسسه',
  `step` enum('provincial','country','international') COLLATE utf8_persian_ci DEFAULT 'provincial' COMMENT 'مرحله',
  `rank` int(2) DEFAULT NULL COMMENT 'رتبه',
  `year` int(4) DEFAULT NULL COMMENT 'سال',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`users_id`,`field`,`club`,`step`,`rank`,`year`) USING BTREE,
  KEY `users_id` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='سوابق مسابقات' AUTO_INCREMENT=1 ;

--
-- Triggers `racehistory`
--
DROP TRIGGER IF EXISTS `race_history_delete`;
DELIMITER //
CREATE TRIGGER `race_history_delete` AFTER DELETE ON `racehistory`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'race_history','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `race_history_insert`;
DELIMITER //
CREATE TRIGGER `race_history_insert` AFTER INSERT ON `racehistory`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'race_history','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `race_history_update`;
DELIMITER //
CREATE TRIGGER `race_history_update` AFTER UPDATE ON `racehistory`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'race_history','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `regulation`
--

DROP TABLE IF EXISTS `regulation`;
CREATE TABLE IF NOT EXISTS `regulation` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8_persian_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_persian_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `regulation`
--

INSERT INTO `regulation` (`id`, `text`, `status`) VALUES
(1, 'اهداف کلی مدیریت مرکز قرآن و حدیث:\n1. ترویج، تبیین و تعمیق علوم و معارف قرآن و اهل بیت علیهم السلام با استفاده از ابزار‎های آموزشی. \\n\n2. تدوین راهبردهای کلان و سیاستگذاری آموزشی و تربیتی متناسب با راهبردهای آستان مقدس حضرت معصومه علیها السلام.\\n\n3. برنامه¬ریزی، اجرا و توسعه برنامه¬های متنوع آموزش معارف قرآنی و حدیثی متناسب با نیازهای جامعه و مخاطبان.\\n\n4.  تهیه طرح جامع تعلیم و تربیت در آستان مقدس حضرت فاطمه معصومه علیها السلام.\\n\n5.  تدوین کتب و محصولات آموزشی، تحقیقاتی به منظور افزایش بهره¬وری آموزش قرآنی و حدیثی. \\n\n6.  شناسایی، جذب و تربیت اساتید مجرب بمنظور بهره¬گیری در زمینه تحقق برنامه‎های آموزشی.\\n\n7. طراحی، تنظیم و بکارگیری سیستم نوین ارزیابی آموزشی و تربیتی بر اساس مبانی قرآنی و حدیثی.\\n\n8.  شناسایی، جذب و ارتقاء سطح نخبگان و برگزیدگان قرآنی و حدیثی به منظور گسترش و تعمیق فرهنگ اسلامی و شیعی.\\n\n9. به کارگیری فناوری‎ها و روش‎های نوین اطلاعاتی و ارتباطی با حفظ محتوای غنی مفاهیم قرآن و اهل بیت اطهار علیهم السلام در حوزه آموزش.\\n\n10.  ایجاد بانک جامع و به روز اطلاعاتی و آماری در خصوص مربيان، متربيان، پژوهشگران، محققان و متفکران گروه در حوزه آموزش\\n\n11. شناسایی اولويت‎ها و ضرورت‎هاي گروه‎های هدف و تعامل با دستگاه‎های ذی‎ربط برای اجرای طرح‎های آموزشی.\\n\n', 'active');

--
-- Triggers `regulation`
--
DROP TRIGGER IF EXISTS `regulation_insert`;
DELIMITER //
CREATE TRIGGER `regulation_insert` AFTER INSERT ON `regulation`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'regulation','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `regulation_update`;
DELIMITER //
CREATE TRIGGER `regulation_update` AFTER UPDATE ON `regulation`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'regulation','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `requlation_delete`;
DELIMITER //
CREATE TRIGGER `requlation_delete` AFTER DELETE ON `regulation`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'requlation','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `table_files`
--

DROP TABLE IF EXISTS `table_files`;
CREATE TABLE IF NOT EXISTS `table_files` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `table` varchar(32) COLLATE utf8_persian_ci NOT NULL,
  `record_id` int(10) NOT NULL,
  `files_id` int(10) NOT NULL,
  `description` text COLLATE utf8_persian_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `table` (`table`,`record_id`,`files_id`),
  KEY `files_id` (`files_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=32 ;

--
-- Dumping data for table `table_files`
--

INSERT INTO `table_files` (`id`, `table`, `record_id`, `files_id`, `description`) VALUES
(27, 'posts', 48, 1015, 'postsImage'),
(28, 'posts', 52, 1018, 'postsImage'),
(29, 'posts', 54, 1019, 'postsImage'),
(30, 'posts', 55, 1020, 'postsImage'),
(31, 'posts', 57, 1020, 'postsImage');

--
-- Triggers `table_files`
--
DROP TRIGGER IF EXISTS `table_files_delete`;
DELIMITER //
CREATE TRIGGER `table_files_delete` AFTER DELETE ON `table_files`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'table_files','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `table_files_insert`;
DELIMITER //
CREATE TRIGGER `table_files_insert` AFTER INSERT ON `table_files`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'table_files','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `table_files_update`;
DELIMITER //
CREATE TRIGGER `table_files_update` AFTER UPDATE ON `table_files`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'table_files','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
CREATE TABLE IF NOT EXISTS `tables` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_persian_ci NOT NULL,
  `faname` varchar(32) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=37 ;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `name`, `faname`) VALUES
(1, 'absence', 'غیبت'),
(2, 'branch', ''),
(3, 'branch_description', ''),
(4, 'bridge', ''),
(5, 'certification', ''),
(6, 'city', ''),
(7, 'calss', ''),
(8, 'country', ''),
(9, 'course', ''),
(10, 'course_description', ''),
(11, 'education', ''),
(12, 'files', ''),
(13, 'folders', ''),
(14, 'get_price', ''),
(15, 'group', ''),
(16, 'history', ''),
(17, 'permission', ''),
(18, 'plase', ''),
(19, 'plan', ''),
(20, 'plan_file', ''),
(21, 'prerequisite', ''),
(22, 'price', ''),
(23, 'provinvce', ''),
(24, 'race_history', ''),
(25, 'tables', ''),
(26, 'teaching_history', ''),
(27, 'users', ''),
(28, 'users_description', ''),
(29, 'users_document', ''),
(30, 'users2class', ''),
(31, 'person', ''),
(32, 'news', ''),
(33, 'news_files', ''),
(34, 'news_group', ''),
(35, 'news_tags', ''),
(36, 'tags', '');

--
-- Triggers `tables`
--
DROP TRIGGER IF EXISTS `tables_delete`;
DELIMITER //
CREATE TRIGGER `tables_delete` AFTER DELETE ON `tables`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'tables','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tables_insert`;
DELIMITER //
CREATE TRIGGER `tables_insert` AFTER INSERT ON `tables`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'tables','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tables_update`;
DELIMITER //
CREATE TRIGGER `tables_update` AFTER UPDATE ON `tables`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'tables','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'نشانک',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

--
-- Triggers `tags`
--
DROP TRIGGER IF EXISTS `tags_delete`;
DELIMITER //
CREATE TRIGGER `tags_delete` AFTER DELETE ON `tags`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'tags','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tags_insert`;
DELIMITER //
CREATE TRIGGER `tags_insert` AFTER INSERT ON `tags`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'tags','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tags_update`;
DELIMITER //
CREATE TRIGGER `tags_update` AFTER UPDATE ON `tags`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'tags','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `teachinghistory`
--

DROP TABLE IF EXISTS `teachinghistory`;
CREATE TABLE IF NOT EXISTS `teachinghistory` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `users_id` int(10) NOT NULL,
  `field` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'رشته',
  `club` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'مرکز یا موسسه',
  `length` enum('less than one year','between one and two years','between two and five years','more than five years') COLLATE utf8_persian_ci DEFAULT 'less than one year' COMMENT 'مدت تدریس',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`users_id`,`field`,`club`,`length`) USING BTREE,
  KEY `users_id` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='سوابق تدریس' AUTO_INCREMENT=1 ;

--
-- Triggers `teachinghistory`
--
DROP TRIGGER IF EXISTS `teachinghistory_delete`;
DELIMITER //
CREATE TRIGGER `teachinghistory_delete` AFTER DELETE ON `teachinghistory`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'teachinghistory','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `teachinghistory_insert`;
DELIMITER //
CREATE TRIGGER `teachinghistory_insert` AFTER INSERT ON `teachinghistory`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'teachinghistory','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `teachinghistory_update`;
DELIMITER //
CREATE TRIGGER `teachinghistory_update` AFTER UPDATE ON `teachinghistory`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'teachinghistory','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` int(11) NOT NULL COMMENT 'نام کاربری / شماره پرونده',
  `password` varchar(32) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کلمه عبور',
  `email` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL,
  `status` enum('waiting','block','delete','enable') COLLATE utf8_persian_ci NOT NULL DEFAULT 'waiting',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=239 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `status`) VALUES
(238, 39300001, '202cb962ac59075b964b07152d234b70', 'rm.biqarar@gmail.com', 'waiting');

--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `users_delete`;
DELIMITER //
CREATE TRIGGER `users_delete` AFTER DELETE ON `users`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'users','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `users_insert`;
DELIMITER //
CREATE TRIGGER `users_insert` AFTER INSERT ON `users`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'users','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `users_update`;
DELIMITER //
CREATE TRIGGER `users_update` AFTER UPDATE ON `users`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'users','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users_branch`
--

DROP TABLE IF EXISTS `users_branch`;
CREATE TABLE IF NOT EXISTS `users_branch` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `users_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users` (`users_id`,`branch_id`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=4 ;

--
-- Triggers `users_branch`
--
DROP TRIGGER IF EXISTS `users_branch_delete`;
DELIMITER //
CREATE TRIGGER `users_branch_delete` AFTER DELETE ON `users_branch`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'users_branch','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `users_branch_insert`;
DELIMITER //
CREATE TRIGGER `users_branch_insert` AFTER INSERT ON `users_branch`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'users_branch','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `users_branch_update`;
DELIMITER //
CREATE TRIGGER `users_branch_update` AFTER UPDATE ON `users_branch`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'users_branch','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users_description`
--

DROP TABLE IF EXISTS `users_description`;
CREATE TABLE IF NOT EXISTS `users_description` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `users_id` int(10) NOT NULL,
  `text` text COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

--
-- Triggers `users_description`
--
DROP TRIGGER IF EXISTS `users_description_delete`;
DELIMITER //
CREATE TRIGGER `users_description_delete` AFTER DELETE ON `users_description`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'users_description','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `users_description_insert`;
DELIMITER //
CREATE TRIGGER `users_description_insert` AFTER INSERT ON `users_description`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'users_description','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `users_description_update`;
DELIMITER //
CREATE TRIGGER `users_description_update` AFTER UPDATE ON `users_description`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'users_description','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users_group`
--

DROP TABLE IF EXISTS `users_group`;
CREATE TABLE IF NOT EXISTS `users_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group_list_id` int(10) NOT NULL,
  `users_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users` (`group_list_id`,`users_id`) USING BTREE,
  KEY `users_id` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

--
-- Triggers `users_group`
--
DROP TRIGGER IF EXISTS `users_group_insert`;
DELIMITER //
CREATE TRIGGER `users_group_insert` AFTER INSERT ON `users_group`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'users_group','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `users_group_update`;
DELIMITER //
CREATE TRIGGER `users_group_update` AFTER UPDATE ON `users_group`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'users_group','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `usrers_group_delete`;
DELIMITER //
CREATE TRIGGER `usrers_group_delete` AFTER DELETE ON `users_group`
 FOR EACH ROW BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id_,'users_group','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absence`
--
ALTER TABLE `absence`
  ADD CONSTRAINT `absence_ibfk_1` FOREIGN KEY (`classification_id`) REFERENCES `classification` (`id`);

--
-- Constraints for table `branch_description`
--
ALTER TABLE `branch_description`
  ADD CONSTRAINT `branch_description_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`);

--
-- Constraints for table `bridge`
--
ALTER TABLE `bridge`
  ADD CONSTRAINT `bridge_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `certification`
--
ALTER TABLE `certification`
  ADD CONSTRAINT `certification_ibfk_1` FOREIGN KEY (`classification_id`) REFERENCES `classification` (`id`);

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`);

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`),
  ADD CONSTRAINT `classes_ibfk_3` FOREIGN KEY (`place_id`) REFERENCES `place` (`id`),
  ADD CONSTRAINT `classes_ibfk_4` FOREIGN KEY (`teacher`) REFERENCES `users` (`id`);

--
-- Constraints for table `classification`
--
ALTER TABLE `classification`
  ADD CONSTRAINT `classification_ibfk_1` FOREIGN KEY (`classes_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `classification_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `classification_ibfk_3` FOREIGN KEY (`plan_section_id`) REFERENCES `plan_section` (`id`);

--
-- Constraints for table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `consultation_ibfk_2` FOREIGN KEY (`expert`) REFERENCES `users` (`id`);

--
-- Constraints for table `consultation_list`
--
ALTER TABLE `consultation_list`
  ADD CONSTRAINT `consultation_list_ibfk_1` FOREIGN KEY (`consultation_id`) REFERENCES `consultation` (`id`),
  ADD CONSTRAINT `consultation_list_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `consultation_list_ibfk_3` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`);

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `course_ibfk_2` FOREIGN KEY (`expert`) REFERENCES `group_expert` (`id`);

--
-- Constraints for table `course_description`
--
ALTER TABLE `course_description`
  ADD CONSTRAINT `course_description_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`);

--
-- Constraints for table `experiences`
--
ALTER TABLE `experiences`
  ADD CONSTRAINT `experiences_ibfk_1` FOREIGN KEY (`graduate_id`) REFERENCES `graduate` (`id`);

--
-- Constraints for table `get_price`
--
ALTER TABLE `get_price`
  ADD CONSTRAINT `get_price_ibfk_2` FOREIGN KEY (`price_id`) REFERENCES `price` (`id`),
  ADD CONSTRAINT `get_price_ibfk_3` FOREIGN KEY (`receiver`) REFERENCES `users` (`id`);

--
-- Constraints for table `graduate`
--
ALTER TABLE `graduate`
  ADD CONSTRAINT `graduate_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `graduate_classes`
--
ALTER TABLE `graduate_classes`
  ADD CONSTRAINT `graduate_classes_ibfk_1` FOREIGN KEY (`graduate_id`) REFERENCES `graduate` (`id`),
  ADD CONSTRAINT `graduate_classes_ibfk_2` FOREIGN KEY (`classes_id`) REFERENCES `classes` (`id`);

--
-- Constraints for table `group_expert`
--
ALTER TABLE `group_expert`
  ADD CONSTRAINT `group_expert_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `group_expert_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`),
  ADD CONSTRAINT `group_expert_ibfk_4` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`);

--
-- Constraints for table `group_list`
--
ALTER TABLE `group_list`
  ADD CONSTRAINT `group_list_ibfk_1` FOREIGN KEY (`expert`) REFERENCES `group_expert` (`id`);

--
-- Constraints for table `pending_classes`
--
ALTER TABLE `pending_classes`
  ADD CONSTRAINT `pending_classes_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pending_classes_ibfk_2` FOREIGN KEY (`classes_id`) REFERENCES `classes` (`id`);

--
-- Constraints for table `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `permission_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `person_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `person_ibfk_2` FOREIGN KEY (`from`) REFERENCES `city` (`id`),
  ADD CONSTRAINT `person_ibfk_4` FOREIGN KEY (`education_id`) REFERENCES `education` (`id`),
  ADD CONSTRAINT `person_ibfk_5` FOREIGN KEY (`nationality`) REFERENCES `country` (`id`);

--
-- Constraints for table `place`
--
ALTER TABLE `place`
  ADD CONSTRAINT `place_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`);

--
-- Constraints for table `plan`
--
ALTER TABLE `plan`
  ADD CONSTRAINT `plan_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`);

--
-- Constraints for table `plan_section`
--
ALTER TABLE `plan_section`
  ADD CONSTRAINT `plan_section_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`group`) REFERENCES `posts_group` (`id`);

--
-- Constraints for table `posts_tags`
--
ALTER TABLE `posts_tags`
  ADD CONSTRAINT `posts_tags_ibfk_2` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`id`),
  ADD CONSTRAINT `posts_tags_ibfk_3` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `prerequisite`
--
ALTER TABLE `prerequisite`
  ADD CONSTRAINT `prerequisite_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`),
  ADD CONSTRAINT `prerequisite_ibfk_2` FOREIGN KEY (`prerequisite`) REFERENCES `plan` (`id`);

--
-- Constraints for table `price`
--
ALTER TABLE `price`
  ADD CONSTRAINT `price_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `price_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`),
  ADD CONSTRAINT `price_ibfk_3` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `racehistory`
--
ALTER TABLE `racehistory`
  ADD CONSTRAINT `racehistory_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `table_files`
--
ALTER TABLE `table_files`
  ADD CONSTRAINT `table_files_ibfk_1` FOREIGN KEY (`files_id`) REFERENCES `files` (`id`);

--
-- Constraints for table `teachinghistory`
--
ALTER TABLE `teachinghistory`
  ADD CONSTRAINT `teachinghistory_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users_branch`
--
ALTER TABLE `users_branch`
  ADD CONSTRAINT `users_branch_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_branch_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`);

--
-- Constraints for table `users_description`
--
ALTER TABLE `users_description`
  ADD CONSTRAINT `users_description_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users_group`
--
ALTER TABLE `users_group`
  ADD CONSTRAINT `users_group_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_group_ibfk_2` FOREIGN KEY (`group_list_id`) REFERENCES `group_list` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;