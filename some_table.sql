-- phpMyAdmin SQL Dump
-- version 4.2.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 03, 2014 at 11:14 PM
-- Server version: 5.6.19-1~exp1ubuntu2
-- PHP Version: 5.5.12-2ubuntu4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quran_hadith`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `insertPerm`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertPerm`(IN `usersId` INT(10), IN `branchId` INT(10))
    NO SQL
begin
set @ifPerm = perm(usersId , branchId);
if @ifPerm = 1 then
set @branch_id = branchId;
else
call setError("permission denied");
end if;
end$$

DROP PROCEDURE IF EXISTS `setCash`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `setCash`(IN `_T` VARCHAR(64), IN `_R` INT(10), IN `_B` INT(10))
    NO SQL
BEGIN
INSERT INTO `branch_cash` (`table`,`record_id`,`branch_id`)
VALUES (_T,_R,_B);
END$$

DROP PROCEDURE IF EXISTS `setHistory`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `setHistory`(IN `_Table` VARCHAR(64), IN `_operator` VARCHAR(10), IN `_id` INT(10))
    NO SQL
BEGIN
INSERT INTO history 
(users_id,history.table,query_type,record_id,date,ip)
VALUES
(@users_id, _Table ,_operator ,_id,CURRENT_TIMESTAMP(),@ip_);
END$$

DROP PROCEDURE IF EXISTS `setPermError`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `setPermError`(IN `_MSG` VARCHAR(255))
    NO SQL
SIGNAL SQLSTATE '42000' SET message_text = _MSG, mysql_errno = 1211$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `checkPerm`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `checkPerm`(`usersId` INT(10), `branchId` INT(10)) RETURNS int(1)
    NO SQL
BEGIN
DECLARE x  INT;
DECLARE thisId  INT;
DECLARE ifPerm INT DEFAULT 0;
 
      DECLARE countUserBranch INT DEFAULT 0;
      DECLARE totalBranch CURSOR 
      FOR SELECT COUNT(*) FROM users_branch WHERE users_id = usersId;  
		
DECLARE listOfBranch CURSOR 
      FOR SELECT id FROM users_branch WHERE users_id = usersId; 

      OPEN totalBranch;
      FETCH totalBranch INTO countUserBranch;
      CLOSE totalBranch;

      OPEN listOfBranch;
      SET x = 1;
      WHILE  x <= countUserBranch DO
      FETCH listOfBranch into thisId ;
            IF branchId = thisId THEN
                  SET ifPerm = 1;
            END IF;
            SET  x = x + 1; 
      END WHILE;
      CLOSE listOfBranch;
return (ifPerm);
end$$

DROP FUNCTION IF EXISTS `getBranch`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getBranch`(`_Table` VARCHAR(64), `_RecordId` INT(10)) RETURNS int(10)
    NO SQL
begin
set @branchId = (select branch_id from `branch_cash` 
            where 
           `table` = _Table AND 
           `record_id` = _RecordId LIMIT 0,1);
return (@branchId);
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `education_users`
--

DROP TABLE IF EXISTS `education_users`;
CREATE TABLE IF NOT EXISTS `education_users` (
`id` int(10) NOT NULL,
  `users_id` int(10) NOT NULL,
  `education_id` int(10) NOT NULL,
  `year` int(4) NOT NULL,
  `field` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `average` float NOT NULL,
  `trend` varchar(255) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `education_users`
--

INSERT INTO `education_users` (`id`, `users_id`, `education_id`, `year`, `field`, `average`, `trend`) VALUES
(1, 1, 3, 1393, 'روخواین', 13.5, 'سیسیب');

--
-- Triggers `education_users`
--
DROP TRIGGER IF EXISTS `education_users_delete`;
DELIMITER //
CREATE TRIGGER `education_users_delete` AFTER DELETE ON `education_users`
 FOR EACH ROW BEGIN
call setHistory('education_users', 'delete', OLD.id);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `education_users_insert`;
DELIMITER //
CREATE TRIGGER `education_users_insert` AFTER INSERT ON `education_users`
 FOR EACH ROW BEGIN
call setCash('education_users', NEW.id, @branch_id);
call setHistory('education_users', 'insert', NEW.id);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `education_users_update`;
DELIMITER //
CREATE TRIGGER `education_users_update` AFTER UPDATE ON `education_users`
 FOR EACH ROW BEGIN
call setHistory('education_users', 'update', OLD.id);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `form_answer`
--

DROP TABLE IF EXISTS `form_answer`;
CREATE TABLE IF NOT EXISTS `form_answer` (
`id` int(10) NOT NULL,
  `users_id` int(10) NOT NULL,
  `form_questions_id` int(10) NOT NULL,
  `answer` text COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

--
-- Triggers `form_answer`
--
DROP TRIGGER IF EXISTS `form_answer_delete`;
DELIMITER //
CREATE TRIGGER `form_answer_delete` AFTER DELETE ON `form_answer`
 FOR EACH ROW BEGIN
call setHistory('form_answer', 'delete', OLD.id);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `form_answer_insert`;
DELIMITER //
CREATE TRIGGER `form_answer_insert` AFTER INSERT ON `form_answer`
 FOR EACH ROW BEGIN
call setCash('form_answer', NEW.id, @branch_id);
call setHistory('form_answer', 'insert', NEW.id);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `form_answer_update`;
DELIMITER //
CREATE TRIGGER `form_answer_update` AFTER UPDATE ON `form_answer`
 FOR EACH ROW BEGIN
call setHistory('form_answer', 'update', OLD.id);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `form_group`
--

DROP TABLE IF EXISTS `form_group`;
CREATE TABLE IF NOT EXISTS `form_group` (
`id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `description` text COLLATE utf8_persian_ci
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `form_group`
--

INSERT INTO `form_group` (`id`, `name`, `description`) VALUES
(1, 'بسم الله الرحمن الرحیم', 'sdfsdfsdf'),
(2, 'بسم الله الرحمن الرحیم', 'اللهم صل علی محمد و آل محمد و عجل فرجهم'),
(3, 'فرم اطلاعات اساتید', 'مرکز قرآن و حدیث'),
(5, 'فرم اطلاعات پرسنلی', 'کارگزینی حرم مطهر'),
(6, 'فرم تعرفه داخلی', 'حراست آستان');

--
-- Triggers `form_group`
--
DROP TRIGGER IF EXISTS `form_group_delete`;
DELIMITER //
CREATE TRIGGER `form_group_delete` AFTER DELETE ON `form_group`
 FOR EACH ROW BEGIN
call setHistory('form_group', 'delete', OLD.id);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `form_group_insert`;
DELIMITER //
CREATE TRIGGER `form_group_insert` AFTER INSERT ON `form_group`
 FOR EACH ROW BEGIN
call setCash('form_group', NEW.id, @branch_id);
call setHistory('form_group', 'insert', NEW.id);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `form_group_update`;
DELIMITER //
CREATE TRIGGER `form_group_update` AFTER UPDATE ON `form_group`
 FOR EACH ROW BEGIN
call setHistory('form_group', 'update', OLD.id);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `form_group_item`
--

DROP TABLE IF EXISTS `form_group_item`;
CREATE TABLE IF NOT EXISTS `form_group_item` (
`id` int(10) NOT NULL,
  `form_group_id` int(10) NOT NULL,
  `form_questions_id` int(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `form_group_item`
--

INSERT INTO `form_group_item` (`id`, `form_group_id`, `form_questions_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3);

--
-- Triggers `form_group_item`
--
DROP TRIGGER IF EXISTS `form_group_item`;
DELIMITER //
CREATE TRIGGER `form_group_item` AFTER UPDATE ON `form_group_item`
 FOR EACH ROW BEGIN
call setHistory('form_group_item', 'update', OLD.id);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `form_group_item_delete`;
DELIMITER //
CREATE TRIGGER `form_group_item_delete` AFTER DELETE ON `form_group_item`
 FOR EACH ROW BEGIN
call setHistory('form_group_item', 'delete', OLD.id);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `form_group_item_insert`;
DELIMITER //
CREATE TRIGGER `form_group_item_insert` AFTER INSERT ON `form_group_item`
 FOR EACH ROW BEGIN
call setCash('form_group_item', NEW.id, @branch_id);
call setHistory('form_group_item', 'insert', NEW.id);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `form_questions`
--

DROP TABLE IF EXISTS `form_questions`;
CREATE TABLE IF NOT EXISTS `form_questions` (
`id` int(10) NOT NULL,
  `string` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `answer_type` enum('string','enum','set','bolean','table','file') COLLATE utf8_persian_ci NOT NULL,
  `answer_value` text COLLATE utf8_persian_ci NOT NULL,
  `answer_validate` enum('persian','english','number','enum') COLLATE utf8_persian_ci NOT NULL,
  `allow_null` enum('yes','no') COLLATE utf8_persian_ci NOT NULL,
  `multiple_answer` enum('yes','no') COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `form_questions`
--

INSERT INTO `form_questions` (`id`, `string`, `answer_type`, `answer_value`, `answer_validate`, `allow_null`, `multiple_answer`) VALUES
(1, 'نام شما', 'string', '32', 'persian', 'no', 'no'),
(2, 'نام خانوادگی', 'string', '32', 'persian', 'no', 'no'),
(3, 'وضعیت نظام وظیفه', 'enum', 'معاف،دایم،تحصیلی،سایر', 'persian', 'no', 'no');

--
-- Triggers `form_questions`
--
DROP TRIGGER IF EXISTS `form_question_insert`;
DELIMITER //
CREATE TRIGGER `form_question_insert` AFTER INSERT ON `form_questions`
 FOR EACH ROW BEGIN
call setCash('form_questions', NEW.id, @branch_id);
call setHistory('form_questions', 'insert', NEW.id);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `form_question_update`;
DELIMITER //
CREATE TRIGGER `form_question_update` AFTER UPDATE ON `form_questions`
 FOR EACH ROW BEGIN
call setHistory('form_questions', 'update', OLD.id);
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `form_questions_delete`;
DELIMITER //
CREATE TRIGGER `form_questions_delete` AFTER DELETE ON `form_questions`
 FOR EACH ROW BEGIN
call setHistory('form_question', 'delete', OLD.id);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `racehistory`
--

DROP TABLE IF EXISTS `racehistory`;
CREATE TABLE IF NOT EXISTS `racehistory` (
`id` int(10) NOT NULL,
  `users_id` int(10) NOT NULL,
  `field` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'رشته',
  `club` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'مرکز یا موسسه',
  `step` enum('provincial','country','international') COLLATE utf8_persian_ci DEFAULT 'provincial' COMMENT 'مرحله',
  `rank` int(2) DEFAULT NULL COMMENT 'رتبه',
  `year` int(4) DEFAULT NULL COMMENT 'سال'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='سوابق مسابقات' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `racehistory`
--

INSERT INTO `racehistory` (`id`, `users_id`, `field`, `club`, `step`, `rank`, `year`) VALUES
(1, 1, 'روخوانی', 'قمسسسسس', 'country', 1, 10);

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
(@users_id,'race_history','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
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
(@users_id,'race_history','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
call setCash('racehistory', NEW.id, @branch_id);

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
(@users_id,'race_history','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `teachinghistory`
--

DROP TABLE IF EXISTS `teachinghistory`;
CREATE TABLE IF NOT EXISTS `teachinghistory` (
`id` int(10) NOT NULL,
  `users_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `type` enum('cultural','training','administrative','learning') COLLATE utf8_persian_ci NOT NULL,
  `field` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'رشته',
  `club` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'مرکز یا موسسه',
  `length` enum('less than one year','between one and two years','between two and five years','more than five years') COLLATE utf8_persian_ci DEFAULT 'less than one year' COMMENT 'مدت تدریس'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='سوابق تدریس' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `teachinghistory`
--

INSERT INTO `teachinghistory` (`id`, `users_id`, `name`, `type`, `field`, `club`, `length`) VALUES
(2, 14696, 'NULL', 'cultural', 'روخوانی و روان خوانی قرآن کریم', 'قم', 'less than one year'),
(3, 1, 'عنوان فعالیت', 'cultural', 'ترجتمه ومفاهیم', 'قم خیابان اذر', 'more than five years'),
(4, 1, 'تست بدون یوزیر آیدی', 'cultural', 'پخ ر', 'سیبسی', 'between one and two years');

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
(@users_id,'teachinghistory','delete',OLD.id,CURRENT_TIMESTAMP(),@ip_);
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
(@users_id,'teachinghistory','insert',NEW.id,CURRENT_TIMESTAMP(),@ip_);
call setCash('teachinghistory', NEW.id, @branch_id);

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
(@users_id,'teachinghistory','update',OLD.id,CURRENT_TIMESTAMP(),@ip_);
END
//
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `education_users`
--
ALTER TABLE `education_users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_answer`
--
ALTER TABLE `form_answer`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_group`
--
ALTER TABLE `form_group`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_group_item`
--
ALTER TABLE `form_group_item`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_questions`
--
ALTER TABLE `form_questions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `racehistory`
--
ALTER TABLE `racehistory`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`users_id`,`field`,`club`,`step`,`rank`,`year`) USING BTREE, ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `teachinghistory`
--
ALTER TABLE `teachinghistory`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`users_id`,`field`,`club`,`length`) USING BTREE, ADD KEY `users_id` (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `education_users`
--
ALTER TABLE `education_users`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `form_answer`
--
ALTER TABLE `form_answer`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `form_group`
--
ALTER TABLE `form_group`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `form_group_item`
--
ALTER TABLE `form_group_item`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `form_questions`
--
ALTER TABLE `form_questions`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `racehistory`
--
ALTER TABLE `racehistory`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `teachinghistory`
--
ALTER TABLE `teachinghistory`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `racehistory`
--
ALTER TABLE `racehistory`
ADD CONSTRAINT `racehistory_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `teachinghistory`
--
ALTER TABLE `teachinghistory`
ADD CONSTRAINT `teachinghistory_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
