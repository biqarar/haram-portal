<?php 
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class model extends main_model{
	public function xecho($str = false) {
		echo "<pre>" . $str . "<br></pre>";
	}
	
	public function sql_admin() {
		if (ob_get_level() == 0) ob_start();
		$sql = new dbconnection_lib;
		set_time_limit(30000);
		ini_set('memory_limit', '-1');
		

		$this->xecho( "starting ... <br>");
		$this->xecho( "set time start as : " . time());

		$this->xecho( "set version 2.0 in mysql ");
		$start_time = time();

		
		



		$this->db_version();
		




		$i = 0;
		$this->xecho( "<br>------------------  classes count ...<br>");
		ob_flush();
		flush();
		
		$classes = $this->sql()->tableClasses()->select()->allAssoc();
		$i=0;
		foreach ($classes as $key => $value) {
			$this->sql(".classesCount", $value['id']);
			$q = $sql->query("COMMIT", true);
			$i++;

		}

		
		
		$this->xecho( "num = " . $i );
		
		$this->xecho( "<br>------------------  update province name ...<br>");
		ob_flush();
		flush();
		$province = $this->sql()->tableProvince()->select()->allAssoc();
		$i=0;
		foreach ($province as $key => $value) {
			$x = $this->sql()->tableProvince()
			->setName($value['name'])
			->whereId($value['id'])
			->update();
			$i++;
			$q = $sql->query("COMMIT", true);

		}
		
		$this->xecho( "num = " . $i );
		$this->xecho( "<br>------------------  update country name ...<br>");
		ob_flush();
		flush();
		$country = $this->sql()->tableCountry()->select()->allAssoc();
		$i=0;
		foreach ($country as $key => $value) {
			$this->sql()->tableCountry()
			->setName($value['name'])
			->whereId($value['id'])
			->update();
			$i++;
			$q = $sql->query("COMMIT", true);

		}
		
		$this->xecho( "num = " . $i );
		$this->xecho( "<br>------------------  update city name ...<br>");
		ob_flush();
		flush();

		$city = $this->sql()->tableCity()->select()->allAssoc();
		$i=0;
		foreach ($city as $key => $value) {
			$this->sql()->tableCity()
			->setName($value['name'])
			->whereId($value['id'])
			->update();
			$i++;
			$q = $sql->query("COMMIT", true);
		}
		
		$this->xecho( "num = " . $i );
		$this->xecho( "<br>------------------  set operator list ...<br>");
		ob_flush();
		flush();
		$person_o = $this->sql()->tablePerson()->whereType("operator")->select()->allAssoc() ; 

		$i=0;
		  foreach ($person_o as $key => $value) {
                    $x = $this->sql()->tableUsers()->setType("operator")->whereId($value['users_id'])->update();
                    $i++;
                    ob_flush();
					flush();
                    $q = $sql->query("COMMIT", true);
            }
		
		$this->xecho( "num = " . $i );
		$this->xecho( "<br>------------------  set teacher list ...<br>");
		ob_flush();
		flush();
		$person_t = $this->sql()->tablePerson()->whereType("teacher")->select()->allAssoc();
		$i=0;
		  foreach ($person_t as $key => $value) {
                    $x = $this->sql()->tableUsers()->setType("teacher")->whereId($value['users_id'])->update();
                    $i++;
                   
                    ob_flush();
					flush();
                    $q = $sql->query("COMMIT", true);
            
            }
		$this->xecho( "num = " . $i );
		$this->xecho( "<br>------------------  trim name famil and family and father ...<br>");
		ob_flush();
		flush();

		$perso = $this->sql()->tablePerson()->select()->allAssoc();
	
		$i=0;
		foreach ($perso as $key => $value) {

			$new_name   = preg_replace("/\s+/", " ", trim($value['name']));
			$new_family = preg_replace("/\s+/", " ", trim($value['family']));
			$new_father = preg_replace("/\s+/", " ", trim($value['father']));

			$x =$this->sql()->tablePerson()->setName($new_name)->setFamily($new_family)->setFather($new_father)
				->whereId($value['id'])
				->update();
				$i++;
				$q = $sql->query("COMMIT", true);
		}
		
		$this->xecho( "num = " . $i );
		$this->xecho( "<br>------------------  End :)   <br>");
		$end_time = time();
		$this->xecho(" end time : " . $end_time);
		$all_tiem = intval($end_time) - intval($start_time);

        $this->xecho( "<div style='background :green'><br> all perosses ended ");
		$this->xecho("in :" . $all_tiem / 60  .  "   min ");
		$this->xecho( "</div></pre>");
		ob_end_flush();

		die();
			
	}

	public function db_version() {
		
		$sql = new dbconnection_lib;

		$version2 = array(
			//-----------------------------------------------------------------------------

			"UPDATE `quran_hadith`.`city` SET `name` = 'باب انار' WHERE `city`.`id` = 266",
			
			"UPDATE `quran_hadith`.`permission` SET `condition` = '*' WHERE `permission`.`users_id` = 13998 AND `permission`.`tables` = 'branch'",
			
			"ALTER TABLE `classes` DROP FOREIGN KEY `classes_ibfk_1`",

			"ALTER TABLE `classes` DROP INDEX course_id",
			//-----------------------------------------------------------------------------

			//-----------------------------------------------------------------------------
			"DROP PROCEDURE IF EXISTS `insertPerm`",

			//-----------------------------------------------------------------------------
			"CREATE DEFINER=`root`@`localhost` PROCEDURE `insertPerm`(IN `usersId` INT(10), IN `branchId` INT(10))
			 NO SQL
			begin
			set @s = 
				(select count(*) 
			     from `users_branch` 
			     where `users_id` = usersId
			     and `branch_id` = branchId);

			if(@s > 0 ) then
				set @branch_id = branchId;
			else
				call setPermError('permission denied');
			end if;
			end;",

			//-----------------------------------------------------------------------------
			"DROP TABLE IF EXISTS `person_extera`",

			//-----------------------------------------------------------------------------
			"CREATE TABLE IF NOT EXISTS `person_extera` (
			`id` int(10) NOT NULL,
			  `users_id` int(10) DEFAULT NULL,
			  `place_birth` varchar(255) COLLATE utf32_persian_ci DEFAULT NULL,
			  `child_daughter` int(2) DEFAULT NULL,
			  `child_son` int(2) DEFAULT NULL,
			  `dependents` int(2) DEFAULT NULL,
			  `soldiering` enum('done','exempt') COLLATE utf32_persian_ci DEFAULT NULL,
			  `exemption_type` enum('education','dependants','temp','medical','continual') COLLATE utf32_persian_ci DEFAULT NULL,
			  `job` varchar(255) COLLATE utf32_persian_ci DEFAULT NULL,
			  `residence` enum('private_home','rent','some_else') COLLATE utf32_persian_ci DEFAULT NULL,
			  `health` enum('healthy','maim') COLLATE utf32_persian_ci DEFAULT NULL,
			  `treated` enum('yes','no') COLLATE utf32_persian_ci DEFAULT NULL,
			  `stature` float DEFAULT NULL,
			  `weight` int(3) DEFAULT NULL,
			  `blood_group` enum('A+','A-','B+','B-','O+','O-','AB+','AB-') COLLATE utf32_persian_ci DEFAULT NULL,
			  `disease` varchar(255) COLLATE utf32_persian_ci DEFAULT NULL,
			  `insurance_type` varchar(255) COLLATE utf32_persian_ci DEFAULT NULL,
			  `insurance_code` varchar(20) COLLATE utf32_persian_ci DEFAULT NULL,
			  `good_remember` varchar(255) COLLATE utf32_persian_ci DEFAULT NULL,
			  `bad_remember` varchar(255) COLLATE utf32_persian_ci DEFAULT NULL,
			  `tahqiq` float DEFAULT NULL,
			  `tartil` float DEFAULT NULL,
			  `tajvid` float DEFAULT NULL,
			  `melli_account` varchar(13) COLLATE utf32_persian_ci DEFAULT NULL,
			  `melat_account` varchar(10) COLLATE utf32_persian_ci DEFAULT NULL
			) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_persian_ci AUTO_INCREMENT=8",

			"ALTER TABLE `person_extera` ADD CONSTRAINT `person_extera_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)",

			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `person_extera_delete`",

			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `person_extera_delete` AFTER DELETE ON `person_extera`
			 FOR EACH ROW BEGIN
			call setHistory('person_extera', 'delete', OLD.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `person_extera_insert`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `person_extera_insert` AFTER INSERT ON `person_extera`
			 FOR EACH ROW BEGIN
			call setCash('person_extera', NEW.id, @branch_id);
			call setHistory('person_extera', 'insert', NEW.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `person_extera_update`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `person_extera_update` AFTER UPDATE ON `person_extera`
			 FOR EACH ROW BEGIN
			call setHistory('person_extera', 'update', OLD.id);
			END",

			//-----------------------------------------------------------------------------
			"ALTER TABLE `place` ADD `multiclass` enum('no','yes') COLLATE utf8_persian_ci NOT NULL AFTER `name`",

			//-----------------------------------------------------------------------------
			"ALTER TABLE `bridge` CHANGE `title` `title` ENUM('phone','mobile','email','home_address','study_address','work_address','zipcode','website','fax') CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL DEFAULT 'phone' COMMENT 'عنوان'",

			//-----------------------------------------------------------------------------
			"ALTER TABLE `classes` DROP `course_id`",

			"ALTER TABLE `classes` ADD `count` int(7) DEFAULT NULL",

			"ALTER TABLE `branch` CHANGE `name` `name` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام شعبه'",

			"ALTER TABLE `classification` CHANGE `because` `because` ENUM('absence','cansel','done','error') CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL DEFAULT 'absence'",

			//-----------------------------------------------------------------------------
			"DROP TABLE IF EXISTS `get_price`",

			"DROP TABLE IF EXISTS `price`",

			"CREATE TABLE IF NOT EXISTS `price` (
			`id` int(10) NOT NULL,
			  `users_id` int(10) NOT NULL,
			  `type` enum('price_add','price_low') COLLATE utf8_persian_ci NOT NULL,
			  `value` int(7) NOT NULL,
			  `pay_type` enum('bank','pos','cash','rule') COLLATE utf8_persian_ci NOT NULL,
			  `transactions` varchar(255) COLLATE utf8_persian_ci NOT NULL,
			  `description` text COLLATE utf8_persian_ci NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ",

			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `price_delete`",

			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `price_delete` AFTER DELETE ON `price`
			 FOR EACH ROW BEGIN
			call setHistory('price', 'delete', OLD.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `price_insert`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `price_insert` AFTER INSERT ON `price`
			 FOR EACH ROW BEGIN
			call setCash('price', NEW.id, @branch_id);
			call setHistory('price', 'insert', NEW.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `price_update`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `price_update` AFTER UPDATE ON `price`
			 FOR EACH ROW BEGIN
			call setHistory('price', 'update', OLD.id);
			END",

			"ALTER TABLE `users` ADD `type` enum('student','teacher','operator','baby') COLLATE utf8_persian_ci NOT NULL AFTER `email`",



			);

		$error = 0;
		$all = 0;

			
		$this->xecho( "<pre>");
		foreach ($version2 as $key => $value) {
			$s = $sql->query($value , true);
			$this->xecho( "<b>string:</b>". $value . "\n");
			$this->xecho( "<b>result:</b>". $sql->result . "\n");
			if(!$sql->result){
				$this->xecho( "<div style='background :red'><br> -- Error-- <br>");
				$this->xecho( "<b>error number:</b>". $sql::$connection->errno  . "\n");
				$this->xecho( "<b>string error:</b>".  $sql::$connection->error . "\n");
				$this->xecho( "<b> -- Error-- </b></div>");

				$error++;
			}
			$all++;
			$this->xecho( "\n\n--------------------------------------\n\n");
			ob_flush();
			flush();
			// sleep();
		}
		
		$this->xecho( "<div style='background :green'><br>done.  Database set on version 2.0 
			<br> all perosses =  <b> $all </b>    
			<br> by <b> $error </b> error");
		$this->xecho( "</div></pre>");
		
	}
}

?>