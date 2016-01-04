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

	public function xecho($str = false) {echo "<pre><br>" . $str . "</pre>";}
	
	public function ready($version = "new version") {
// var_dump("fuck", $_GET);exit();
		$this->xecho("In The Name Of Allah");
		if(!isset($_GET['password']) || $_GET['password'] != 'ali110') {
			$this->xecho("password incorect.");
			exit(); die();
		}else{

			$this->xecho("Checking password ....");
			$this->xecho("Password OK");
		
			set_time_limit(30000);
			ini_set('memory_limit', '-1');
			ini_set("max_execution_time", "-1");
		
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

		$this->query_on_record();
		$this->ready(8);
		//----------------------------- new version function (database change)	
		$this->database_change();		
		
		//----------------------------- new version function (query on record)
		
		$this->end();
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
	}

	public function query_on_record() {
		
		// ---------------------------------------------------------------------------------------------------
		// echo "<table>";
	
		// $sql = $this->sql()->tableBridge()->whereTitle("mobile")->select()->allAssoc();

		// foreach ($sql as $key => $value) {
		// 	echo "<tr><td>" . $value['value'] . "</td></tr>";
		// }
		// echo "</table>";
		// exit();


		/**

		*/
	}

	public function database_change() {
		/**

		*/
				
		$sql = new dbconnection_lib;
		$database_change = array(
			// "ALTER TABLE `users`  ADD `branch_id` INT(10) NULL",
			// "ALTER TABLE `users` ADD CONSTRAINT `users_branch_id_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`)",

			// "ALTER TABLE `classes`  ADD `branch_id` INT(10) NULL",
			// "ALTER TABLE `classes` ADD CONSTRAINT `classes_branch_id_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`)",

			// "ALTER TABLE `price`  ADD `branch_id` INT(10) NULL",
			// "ALTER TABLE `price` ADD CONSTRAINT `price_branch_id_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`)",

			// "ALTER TABLE `plan`  ADD `branch_id` INT(10) NULL",
			// "ALTER TABLE `plan` ADD CONSTRAINT `plan_branch_id_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`)",

			// "ALTER TABLE `group`  ADD `branch_id` INT(10) NULL",
			// "ALTER TABLE `group` ADD CONSTRAINT `group_branch_id_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`)",

			// //---------------------------------------------------------

			// "update users as us 
			// inner join branch_cash as br on us.id = br.record_id and br.table = 'users' 
			// set us.branch_id = br.branch_id",


			// "update classes as us 
			// inner join branch_cash as br on us.id = br.record_id and br.table = 'classes' 
			// set us.branch_id = br.branch_id",


			// "update place as us 
			// inner join branch_cash as br on us.id = br.record_id and br.table = 'place' 
			// set us.branch_id = br.branch_id",


			// "update price as us 
			// inner join branch_cash as br on us.id = br.record_id and br.table = 'price' 
			// set us.branch_id = br.branch_id",


			// "update plan as us 
			// inner join branch_cash as br on us.id = br.record_id and br.table = 'plan' 
			// set us.branch_id = br.branch_id",


			// "update course as us 
			// inner join branch_cash as br on us.id = br.record_id and br.table = 'course' 
			// set us.branch_id = br.branch_id",


			// "update `group` as us 
			// inner join branch_cash as br on us.id = br.record_id and br.table = 'group' 
			// set us.branch_id = br.branch_id",


			// "ALTER TABLE `users`  CHANGE `branch_id`  `branch_id` INT(10) NOT NULL",

			// "ALTER TABLE `classes`  CHANGE `branch_id`  `branch_id` INT(10) NOT NULL",

			// "ALTER TABLE `price`  CHANGE `branch_id`  `branch_id` INT(10) NOT NULL",

			// "ALTER TABLE `plan`  CHANGE `branch_id`  `branch_id` INT(10) NOT NULL",

			// "ALTER TABLE `group`  CHANGE `branch_id`  `branch_id` INT(10) NOT NULL",


			//-----------------------------------------------------------------------

			

			"CREATE TABLE IF NOT EXISTS `nezarat_item` (
			  `id` int(10) NOT NULL,
			  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
			  `validation` enum('number','text') COLLATE utf8_persian_ci NOT NULL,
			  `group` enum('مالی','ارزیابی','عملکرد','نظرسنجی','خود ارزیابی','شناسه ای','آسیب ها و مشکلات') COLLATE utf8_persian_ci DEFAULT NULL,
			  `description` text COLLATE utf8_persian_ci
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;",

	"ALTER TABLE `nezarat_item`
			  ADD PRIMARY KEY (`id`);",
			  	"ALTER TABLE `nezarat_item`
			  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;",


			"DROP TRIGGER IF EXISTS `nezarat_item_delete`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `nezarat_item_delete` AFTER DELETE ON `nezarat_item`
			 FOR EACH ROW BEGIN
			call setHistory('nezarat_item', 'delete', OLD.id);
			END",
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `nezarat_item_insert`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `nezarat_item_insert` AFTER INSERT ON `nezarat_item`
			 FOR EACH ROW BEGIN
			call setCash('nezarat_item', NEW.id, @branch_id);
			call setHistory('nezarat_item', 'insert', NEW.id);
			END",
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `nezarat_item_update`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `nezarat_item_update` AFTER UPDATE ON `nezarat_item`
			 FOR EACH ROW BEGIN
			call setHistory('nezarat_item', 'update', OLD.id);
			END",


			"CREATE TABLE IF NOT EXISTS `nezarat_program` (
			  `id` int(10) NOT NULL,
			  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
			  `parent` int(10) NOT NULL,
			  `description` text COLLATE utf8_persian_ci
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;",


			"ALTER TABLE `nezarat_program`
			  ADD PRIMARY KEY (`id`);",
			"ALTER TABLE `nezarat_program`
			  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;",

			"ALTER TABLE  `nezarat_program` CHANGE  `parent`  `parent` INT( 10 ) NULL DEFAULT NULL ;",
			
			"DROP TRIGGER IF EXISTS `nezarat_program_delete`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `nezarat_program_delete` AFTER DELETE ON `nezarat_program`
			 FOR EACH ROW BEGIN
			call setHistory('nezarat_program', 'delete', OLD.id);
			END",
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `nezarat_program_insert`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `nezarat_program_insert` AFTER INSERT ON `nezarat_program`
			 FOR EACH ROW BEGIN
			call setCash('nezarat_program', NEW.id, @branch_id);
			call setHistory('nezarat_program', 'insert', NEW.id);
			END",
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `nezarat_program_update`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `nezarat_program_update` AFTER UPDATE ON `nezarat_program`
			 FOR EACH ROW BEGIN
			call setHistory('nezarat_program', 'update', OLD.id);
			END",

			"CREATE TABLE IF NOT EXISTS `nezarat_program_item` (
			  `id` int(10) NOT NULL,
			  `nezarat_program_id` int(10) NOT NULL,
			  `nezarat_item_id` int(10) NOT NULL,
			  `value` text COLLATE utf8_persian_ci,
			  `users_id` int(10) DEFAULT NULL,
			  `description` text COLLATE utf8_persian_ci
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;",


			"ALTER TABLE `nezarat_program_item`
			  ADD PRIMARY KEY (`id`),
			  ADD KEY `nezarat_program_id` (`nezarat_program_id`),
			  ADD KEY `nezarat_item_id` (`nezarat_item_id`);",


		

		

			"ALTER TABLE `nezarat_program_item`
			  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;",


			"DROP TRIGGER IF EXISTS `nezarat_program_item_delete`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `nezarat_program_item_delete` AFTER DELETE ON `nezarat_program_item`
			 FOR EACH ROW BEGIN
			call setHistory('nezarat_program_item', 'delete', OLD.id);
			END",
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `nezarat_program_item_insert`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `nezarat_program_item_insert` AFTER INSERT ON `nezarat_program_item`
			 FOR EACH ROW BEGIN
			call setCash('nezarat_program_item', NEW.id, @branch_id);
			call setHistory('nezarat_program_item', 'insert', NEW.id);
			END",
			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `nezarat_program_item_update`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `nezarat_program_item_update` AFTER UPDATE ON `nezarat_program_item`
			 FOR EACH ROW BEGIN
			call setHistory('nezarat_program_item', 'update', OLD.id);
			END",

		





			"ALTER TABLE `nezarat_program_item`
			  ADD CONSTRAINT `nezarat_program_item_ibfk_1` FOREIGN KEY (`nezarat_program_id`) REFERENCES `nezarat_program` (`id`),
			  ADD CONSTRAINT `nezarat_program_item_ibfk_2` FOREIGN KEY (`nezarat_item_id`) REFERENCES `nezarat_item` (`id`);"

			//-----------------------------------------------------------------------------
						

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

		/**

		*/
	}


}
?>