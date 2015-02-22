<?php 
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
// include_once("databaseVersion.php");


class model extends main_model{

	public $start_time;
	public $end_time;
	public $all_tiem;
	public $i = 0;
	public $title = "";
	public $version;

	public function xecho($str = false) {echo "<pre><br>" . $str . "<br></pre>";}
	
	public function ready($version = "new version") {

		$this->xecho("In The Name Of Allah");
		if(!isset($_GET['password']) || $_GET['password'] != 'ali110') {
			$this->xecho("password incorect.");
			exit(); die();
		}else{

			$this->xecho("Checking password ....");
			$this->xecho("Password OK");
		
			set_time_limit(30000);
			ini_set('memory_limit', '-1');
		
			if (ob_get_level() == 0) ob_start();

			$this->xecho( "Starting ... ");
			$this->xecho( "Set time start as : " . time());

			$this->xecho( "Set version $version in mysql ");

			$this->start_time = time();
			$this->version = $version;
		}
	}

	public function count() {
		$sql = new dbconnection_lib;
		$sql::$resum_on_error = true;
		$sql->query("COMMIT");
		$this->i++;
	}

	public function title($title) {
		$this->xecho(" -------------------------------------------- $title ... ");
		$this->title = $title;
	}

	public function set_version_history($version = 0 , $query = false) {
		$sql = new dbconnection_lib;
		$sql::$resum_on_error = true;
		$s = $sql->query("INSERT INTO 
			`quran_hadith`.`database_version` 
			(`id`, `version`, `query`, `time`) 
			VALUES (NULL, '$version', '$query', CURRENT_TIMESTAMP)");
		$this->xecho( "Saved in History (table database_version)");
	}

	public function flush() {
		$this->set_version_history($this->version, $this->title . " ( " . $this->i . " record)");
		$this->xecho( "num = " . $this->i );
		$this->xecho(" -------------------------------------------- ");
		$this->i = 0;
		ob_flush();
		flush();
	}

	public function end() {
		$this->xecho( " --------------------------------------------  End :)   ");
		$this->end_time = time();
		$this->xecho(" End time : " . $this->end_time);
		$this->all_tiem = intval($this->end_time) - intval($this->start_time);

        $this->xecho( "<div style='background :green'><br><br> all perosses ended 
        	in :" . $this->all_tiem / 60  .  "   min <br><br><br></div></pre>");
		ob_end_flush();
		exit(); die();
	}

	public function sql_admin() {
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		$this->ready(4);
		
		//----------------------------- new version function (database change)	
		// $this->database_change();		
		
		//----------------------------- new version function (query on record)
		$this->query_on_record();
		
		$this->end();
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
	}

	public function query_on_record() {
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		// $classification = $this->sql()->tableClassification();

		// $classification->joinBridge()->whereUsers_id("#classification.users_id")->andTitle("mobile");
		// $classification = $classification->select()->allAssoc();
		
		// header('Content-Type: text/html; charset=utf-8'); 
  //       header("Content-Disposition: attachment; filename=1.xlsx");  
  //       header("Pragma: no-cache"); 
  //       header("Expires: 0");

		// print "<table>";
		// foreach ($classification as $key => $value) {
		// 	print "<tr><td>" . $value['value'] . "</td></tr>";
		// }
		// print "</table>";
		// exit();
		// $this->title("change passwrod");
		// $all = $this->sql()->tableBridge()->whereTitle("mobile");
		// $all->joinClassification()->whereUsers_id("#bridge.users_id");
		// $all->joinBranch_cash()->whereTable("classification")->andRecord_id("#classification.id")->andBranch_id(1);
		// $a = $all->select();
		// var_dump($a->num(), $a->string());
		// echo "<table>";
		// foreach ($a->allAssoc() as $key => $value) {
		// 	echo "<tr><td>" . $value['value'] . "</td></tr>";
		// }
		// echo "</table>";
		// $this->flush();

		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
	}

	public function database_change() {
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		
		
		$sql = new dbconnection_lib;
		$database_change = array(

			"CREATE TABLE IF NOT EXISTS `report` (
			`id` int(10) NOT NULL,
			  `tables` varchar(64) NOT NULL,
			  `name` varchar(255) NOT NULL,
			  `url` varchar(255) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ",
			
			"ALTER TABLE `report` ADD PRIMARY KEY(`id`)",
			"ALTER TABLE `report` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT",
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `report_delete`",

			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `report_delete` AFTER DELETE ON `report`
			 FOR EACH ROW BEGIN
			call setHistory('report', 'delete', OLD.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `report_insert`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `report_insert` AFTER INSERT ON `report`
			 FOR EACH ROW BEGIN
			call setCash('report', NEW.id, @branch_id);
			call setHistory('report', 'insert', NEW.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `report_update`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `report_update` AFTER UPDATE ON `report`
			 FOR EACH ROW BEGIN
			call setHistory('report', 'update', OLD.id);
			END",


			"CREATE TABLE IF NOT EXISTS `drafts` (
			  `id` int(10) NOT NULL,
			  `group` enum('classes', 'classification', 'score', 'person','absence') COLLATE utf32_persian_ci NOT NULL,
			  `tag` varchar(255) NOT NULL,
			  `text` text NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ",
			
			"ALTER TABLE `drafts` ADD PRIMARY KEY(`id`)",
			"ALTER TABLE `drafts` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT",
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `drafts_delete`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `drafts_delete` AFTER DELETE ON `drafts`
			 FOR EACH ROW BEGIN
			call setHistory('drafts', 'delete', OLD.id);
			END",
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `drafts_insert`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `drafts_insert` AFTER INSERT ON `drafts`
			 FOR EACH ROW BEGIN
			call setCash('drafts', NEW.id, @branch_id);
			call setHistory('drafts', 'insert', NEW.id);
			END",
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `drafts_update`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `drafts_update` AFTER UPDATE ON `drafts`
			 FOR EACH ROW BEGIN
			call setHistory('drafts', 'update', OLD.id);
			END",


			"CREATE TABLE IF NOT EXISTS `sms_log` (
			  `id` int(10) NOT NULL,
			  `sender` int(10) NOT NULL,
			  `text` int(10) NOT NULL,
			  `reciver` int(10) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ",
			
			"ALTER TABLE `sms_log` ADD PRIMARY KEY(`id`)",
			"ALTER TABLE `sms_log` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT",

			"ALTER TABLE `sms_log` ADD CONSTRAINT `sms_log_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `users` (`id`)",
			"ALTER TABLE `sms_log` ADD CONSTRAINT `sms_log_ibfk_2` FOREIGN KEY (`reciver`) REFERENCES `users` (`id`)",
			"ALTER TABLE `sms_log` ADD CONSTRAINT `sms_log_ibfk_3` FOREIGN KEY (`text`) REFERENCES `drafts` (`id`)",

			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `sms_log_delete`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `sms_log_delete` AFTER DELETE ON `sms_log`
			 FOR EACH ROW BEGIN
			call setHistory('sms_log', 'delete', OLD.id);
			END",
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `sms_log_insert`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `sms_log_insert` AFTER INSERT ON `sms_log`
			 FOR EACH ROW BEGIN
			call setHistory('sms_log', 'insert', NEW.id);
			END",
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `sms_log_update`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `sms_log_update` AFTER UPDATE ON `sms_log`
			 FOR EACH ROW BEGIN
			call setHistory('sms_log', 'update', OLD.id);
			END",

			
			"CREATE DEFINER=`root`@`localhost` PROCEDURE `set_sms_log`(IN `_sender` INT(10), IN `_reciver` INT(10), IN `_text` INT(10)) NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER BEGIN
			INSERT INTO sms_log 
			(sender,reciver,sms_log.text)
			VALUES
			(_sender, _reciver, _text);
			END",

			////////////////////////////////////////////////////
			"TRUNCATE table_files",
			"DROP TABLE `table_files`",
			"DROP TABLE `files`",
			"CREATE TABLE IF NOT EXISTS `files` (
			`id` int(10) NOT NULL,
			`title` varchar(255) NOT NULL,
			`size` float NOT NULL,
			`type` varchar(6) NOT NULL,
			`folder` int(4) NOT NULL,
			`file_tag_id` int(10) NOT NULL,
			`description` text NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ",
			
			"ALTER TABLE `files` ADD PRIMARY KEY(`id`)",
			"ALTER TABLE `files` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT",
			"ALTER TABLE `files` ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`file_tag_id`) REFERENCES `file_tag` (`id`)",

			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `files_delete`",

			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `files_delete` AFTER DELETE ON `files`
			 FOR EACH ROW BEGIN
			call setHistory('files', 'delete', OLD.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `files_insert`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `files_insert` AFTER INSERT ON `files`
			 FOR EACH ROW BEGIN
			call setCash('files', NEW.id, @branch_id);
			call setHistory('files', 'insert', NEW.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `files_update`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `files_update` AFTER UPDATE ON `files`
			 FOR EACH ROW BEGIN
			call setHistory('files', 'update', OLD.id);
			END",

			"CREATE TRIGGER `set_folder` BEFORE INSERT ON `files`
				 FOR EACH ROW BEGIN
				SET NEW.folder =1000 + CEILING((SELECT AUTO_INCREMENT FROM
				 information_schema.TABLES WHERE TABLE_SCHEMA
				 =DATABASE() AND TABLE_NAME = 'files')/1000);
				END",

			////////////////////////////////////////////////////
			"CREATE TABLE IF NOT EXISTS `update_log` (
			  `id` int(10) NOT NULL,
			  `users_id` int(10) NOT NULL,
			  `table` varchar(255) NOT NULL,
			  `field` varchar(64) NOT NULL,
			  `record_id` int(10) NOT NULL,
			  `old_value` text NOT NULL,
			  `new_value` text NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ",
			
			"ALTER TABLE `update_log` ADD PRIMARY KEY(`id`)",
			"ALTER TABLE `update_log` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT",

			"ALTER TABLE `update_log` ADD CONSTRAINT `update_log_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)",
			"ALTER TABLE `update_log` ADD `time` TIMESTAMP NOT NULL ",


			/////////////////////////////////////////////////////
			"CREATE TABLE IF NOT EXISTS `file_tag` (
			`id` int(10) NOT NULL,
			`tag` varchar(64) NOT NULL,
			`table` enum('users','posts','plan') NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ",
			
			"ALTER TABLE `file_tag` ADD PRIMARY KEY(`id`)",
			"ALTER TABLE `file_tag` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT",
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `file_tag_delete`",

			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `file_tag_delete` AFTER DELETE ON `file_tag`
			 FOR EACH ROW BEGIN
			call setHistory('file_tag', 'delete', OLD.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `file_tag_insert`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `file_tag_insert` AFTER INSERT ON `file_tag`
			 FOR EACH ROW BEGIN
			call setCash('file_tag', NEW.id, @branch_id);
			call setHistory('file_tag', 'insert', NEW.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `file_tag_update`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `file_tag_update` AFTER UPDATE ON `file_tag`
			 FOR EACH ROW BEGIN
			call setHistory('file_tag', 'update', OLD.id);
			END",
			////////////////////////////////////////////////////

			"CREATE TABLE IF NOT EXISTS `file_user` (
			`id` int(10) NOT NULL,
			`file_id` int(10) NOT NULL,
			`users_id` int(10) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ",
			
			"ALTER TABLE `file_user` ADD PRIMARY KEY(`id`)",
			"ALTER TABLE `file_user` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT",
			"ALTER TABLE `file_user` ADD CONSTRAINT `file_user_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`)",
			"ALTER TABLE `file_user` ADD CONSTRAINT `file_user_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)",

			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `file_user_delete`",

			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `file_user_delete` AFTER DELETE ON `file_user`
			 FOR EACH ROW BEGIN
			call setHistory('file_user', 'delete', OLD.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `file_user_insert`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `file_user_insert` AFTER INSERT ON `file_user`
			 FOR EACH ROW BEGIN
			call setCash('file_user', NEW.id, @branch_id);
			call setHistory('file_user', 'insert', NEW.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `file_user_update`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `file_user_update` AFTER UPDATE ON `file_user`
			 FOR EACH ROW BEGIN
			call setHistory('file_user', 'update', OLD.id);
			END",
			////////////////////////////////////////////////////

			"CREATE TABLE IF NOT EXISTS `file_post` (
			`id` int(10) NOT NULL,
			`file_id` int(10) NOT NULL,
			`posts_id` int(10) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ",
			
			"ALTER TABLE `file_post` ADD PRIMARY KEY(`id`)",
			"ALTER TABLE `file_post` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT",
			"ALTER TABLE `file_post` ADD CONSTRAINT `file_post_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`)",
			"ALTER TABLE `file_post` ADD CONSTRAINT `file_post_ibfk_2` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`)",

			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `file_post_delete`",

			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `file_post_delete` AFTER DELETE ON `file_post`
			 FOR EACH ROW BEGIN
			call setHistory('file_post', 'delete', OLD.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `file_post_insert`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `file_post_insert` AFTER INSERT ON `file_post`
			 FOR EACH ROW BEGIN
			call setCash('file_post', NEW.id, @branch_id);
			call setHistory('file_post', 'insert', NEW.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `file_post_update`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `file_post_update` AFTER UPDATE ON `file_post`
			 FOR EACH ROW BEGIN
			call setHistory('file_post', 'update', OLD.id);
			END",
			////////////////////////////////////////////////////
			////////////////////////////////////////////////////

			"CREATE TABLE IF NOT EXISTS `file_plan` (
			`id` int(10) NOT NULL,
			`file_id` int(10) NOT NULL,
			`plan_id` int(10) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ",
			
			"ALTER TABLE `file_plan` ADD PRIMARY KEY(`id`)",
			"ALTER TABLE `file_plan` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT",
			"ALTER TABLE `file_plan` ADD CONSTRAINT `file_plan_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`)",
			"ALTER TABLE `file_plan` ADD CONSTRAINT `file_plan_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`)",

			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `file_plan_delete`",

			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `file_plan_delete` AFTER DELETE ON `file_plan`
			 FOR EACH ROW BEGIN
			call setHistory('file_plan', 'delete', OLD.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `file_plan_insert`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `file_plan_insert` AFTER INSERT ON `file_plan`
			 FOR EACH ROW BEGIN
			call setCash('file_plan', NEW.id, @branch_id);
			call setHistory('file_plan', 'insert', NEW.id);
			END",
		
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `file_plan_update`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `file_plan_update` AFTER UPDATE ON `file_plan`
			 FOR EACH ROW BEGIN
			call setHistory('file_plan', 'update', OLD.id);
			END",


			);


		$error = 0;
		$all = 0;

		foreach ($database_change as $key => $value) {
			$this->title($value);
			$s = $sql->query($value);
			$this->xecho( "<b>Result:</b>". $sql->result . "\n");
			if(!$sql->result){
				$this->xecho( "<div style='background :red'> -- Error-- ");
				$this->xecho( "<b>Error number:</b>". $sql::$connection->errno  . "\n");
				$this->xecho( "<b>String error:</b>".  $sql::$connection->error . "\n");
				$this->xecho( "<b> -- Error-- </b></div>");
				$error++;
			}
			$this->flush();
			$all++;
		}
		
		$this->xecho( "<div style='background :green'>done.  Database set on version ". $this->version ." 
			 all perosses =  <b> $all </b>    
			 by <b> $error </b> error </div></pre>");

		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------

	}
}
?>