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

		$this->xecho("In The Name Of Allah");

		if(!isset($_GET['password']) || $_GET['password'] != 'ali110ali110') {
			$this->xecho("password incorect.");
			exit(); die();
		}else{

			$this->xecho("Password OK , U R supervisor :)");
		
			set_time_limit(30000);
			ini_set('memory_limit', '-1');
			ini_set("max_execution_time", "-1");
		
			if (ob_get_level() == 0) ob_start();

			$this->xecho( "Set time start as : " . time());

			$this->xecho( "Set version $version in mysql ");
			
			$this->xecho( "Starting ... ");

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
			`quran_hadith_log`.`database_version` 
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
        	in :" . $this->all_tiem   .  "   sec <br><br><br></div></pre>");
		ob_end_flush();
		exit(); die();
	}

	public function sql_admin() {
		//---------------------------------------------------------------------------------------------------
		$this->ready(11);

		//----------------------------- new version function (database change)	
		$this->database_change();		
		
		//----------------------------- new version function (query on record)
		$this->query_on_record();
		
		//---------------------------------------------------------------------------------------------------
		$this->end();

	}

	public function query_on_record() {
		// ---------------------------------------------------------------------------------------------------

	}

	public function database_change() {
		/**
		* database change
		* CREATE DATABASE `quran_hadith` DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;
		* ALTER TABLE `quran_hadith`.`oldprice` RENAME `quran_hadith_old`.`oldprice`
		*/
				
		$sql = new dbconnection_lib;


		$database_change = array(
			"CREATE TABLE IF NOT EXISTS `hefz_ligs` (
			  `id` int(10) NOT NULL,
			  `start_date` int(8) NOT NULL,
			  `end_date` int(8) NOT NULL,
			  `name` mediumtext NOT NULL,
			  `branch_id` int(10) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;",


			"CREATE TABLE IF NOT EXISTS `hefz_teams` (
			  `id` int(10) NOT NULL,
			  `lig_id` int(10) NOT NULL,
			  `name` mediumtext NOT NULL,
			  `min_person` int(3) NULL,
			  `max_person` int(4) NULL,
			  `hefz` mediumtext NULL,
			  `teacher` int(10) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;",


			"CREATE TABLE IF NOT EXISTS `hefz_teamuser` (
			  `id` int(10) NOT NULL,
			  `hefz_team_id` int(10) NOT NULL,
			  `users_id` int(10) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;",



			"CREATE TABLE IF NOT EXISTS `hefz_race` (
			  `id` int(10) NOT NULL,
			  `hefz_team_id_1` int(10) NOT NULL,
			  `hefz_team_id_2` int(10) NOT NULL,
			  `type` enum('حذفی','دوره ای') COLLATE utf8_persian_ci DEFAULT 'حذفی',
			  `name` varchar(255) null

			) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

			"ALTER TABLE `hefz_race`
			  ADD PRIMARY KEY (`id`);",

			"ALTER TABLE `hefz_race`
			  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;",

			  "ALTER TABLE `hefz_race`
			  ADD CONSTRAINT `hefz_race_ibfk_1` FOREIGN KEY (`hefz_team_id_1`) REFERENCES `hefz_teams` (`id`)",
 
			"ALTER TABLE `hefz_race`
			  ADD CONSTRAINT `hefz_race_ibfk_2` FOREIGN KEY (`hefz_team_id_2`) REFERENCES `hefz_teams` (`id`)",

			  "CREATE TRIGGER `hefz_race_insert` AFTER INSERT ON `hefz_race`
			FOR EACH ROW BEGIN
			call setHistory('hefz_race', 'insert', NEW.id);
			END",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_race_update` AFTER UPDATE ON `hefz_race`
			FOR EACH ROW BEGIN
			call setHistory('hefz_race', 'update', OLD.id);
			END",

			// -----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_race_delete` AFTER DELETE ON `hefz_race`
			FOR EACH ROW BEGIN
			call setHistory('hefz_race', 'delete', OLD.id);
			END",




			"CREATE TABLE IF NOT EXISTS `hefz_race_result` (
			  `id` int(10) NOT NULL,
			  `hefz_race_id` int(10) NOT NULL,
			  `hefz_teamuser_id` int(10) NOT NULL,
			  `type` varchar(64) NULL,
			  `value` float  NULL			  
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

			"ALTER TABLE `hefz_race_result`
			  ADD PRIMARY KEY (`id`);",
			"ALTER TABLE `hefz_race_result`
			  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;",
			  "ALTER TABLE `hefz_race_result`
			  ADD CONSTRAINT `hefz_race_result_ibfk_1` FOREIGN KEY (`hefz_race_id`) REFERENCES `hefz_race` (`id`)",
 			"ALTER TABLE `hefz_race_result`
			  ADD CONSTRAINT `hefz_race_result_ibfk_2` FOREIGN KEY (`hefz_teamuser_id`) REFERENCES `hefz_teamuser` (`id`)",
			  

			  "CREATE TRIGGER `hefz_race_result_insert` AFTER INSERT ON `hefz_race_result`
			FOR EACH ROW BEGIN
			call setHistory('hefz_race_result', 'insert', NEW.id);
			END",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_race_result_update` AFTER UPDATE ON `hefz_race_result`
			FOR EACH ROW BEGIN
			call setHistory('hefz_race_result', 'update', OLD.id);
			END",

			// -----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_race_result_delete` AFTER DELETE ON `hefz_race_result`
			FOR EACH ROW BEGIN
			call setHistory('hefz_race_result', 'delete', OLD.id);
			END",




			"ALTER TABLE `hefz_ligs`
			  ADD PRIMARY KEY (`id`);",

			"ALTER TABLE `hefz_teams`
			  ADD PRIMARY KEY (`id`);",


			"ALTER TABLE `hefz_teamuser`
			  ADD PRIMARY KEY (`id`);",


			"ALTER TABLE `hefz_ligs`
			  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;",

			"ALTER TABLE `hefz_teams`
			  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;",

			"ALTER TABLE `hefz_teamuser`
			  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;",

			"ALTER TABLE `hefz_teams`
			  ADD CONSTRAINT `teame_ibfk_1` FOREIGN KEY (`lig_id`) REFERENCES `hefz_ligs` (`id`)",
			  "ALTER TABLE `hefz_ligs`
			  ADD CONSTRAINT `ligteame_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`)",
			"ALTER TABLE `hefz_teams`
			  ADD CONSTRAINT `ffteame_ibfk_2` FOREIGN KEY (`teacher`) REFERENCES `users` (`id`)",
			"ALTER TABLE `hefz_teamuser`
			  ADD CONSTRAINT `ffrteameuser_ibfk_1` FOREIGN KEY (`hefz_team_id`) REFERENCES `hefz_teams` (`id`)",
			"ALTER TABLE `hefz_teamuser`
			  ADD CONSTRAINT `eteameuser_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)",


			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_ligs_insert` AFTER INSERT ON `hefz_ligs`
			FOR EACH ROW BEGIN
			call setHistory('hefz_ligs', 'insert', NEW.id);
			END",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_ligs_update` AFTER UPDATE ON `hefz_ligs`
			FOR EACH ROW BEGIN
			call setHistory('hefz_ligs', 'update', OLD.id);
			END",

			// -----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_ligs_delete` AFTER DELETE ON `hefz_ligs`
			FOR EACH ROW BEGIN
			call setHistory('hefz_ligs', 'delete', OLD.id);
			END",


			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_teams_insert` AFTER INSERT ON `hefz_teams`
			FOR EACH ROW BEGIN
			call setHistory('hefz_teams', 'insert', NEW.id);
			END",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_teams_update` AFTER UPDATE ON `hefz_teams`
			FOR EACH ROW BEGIN
			call setHistory('hefz_teams', 'update', OLD.id);
			END",

			// -----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_teams_delete` AFTER DELETE ON `hefz_teams`
			FOR EACH ROW BEGIN
			call setHistory('hefz_teams', 'delete', OLD.id);
			END",


			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_teamuser_insert` AFTER INSERT ON `hefz_teamuser`
			FOR EACH ROW BEGIN
			call setHistory('hefz_teamuser', 'insert', NEW.id);
			END",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_teamuser_update` AFTER UPDATE ON `hefz_teamuser`
			FOR EACH ROW BEGIN
			call setHistory('hefz_teamuser', 'update', OLD.id);
			END",

			// -----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_teamuser_delete` AFTER DELETE ON `hefz_teamuser`
			FOR EACH ROW BEGIN
			call setHistory('hefz_teamuser', 'delete', OLD.id);
			END",


			"UPDATE price set title = 1 where title = 9 or title= 10 or title= 11 or title= 12",
			"UPDATE price set title = 2 where title = 13 or title= 14 or title= 15 or title= 16",
			"UPDATE price set title = 3 where title = 17 or title= 18 or title= 19 or title= 20",
			"UPDATE price set title = 4 where title = 21 or title= 22 or title= 23 or title= 24",
			"UPDATE price set title = 5 where title = 25 or title= 26 or title= 27 or title= 28",
			"UPDATE price set title = 6 where title = 29 or title= 30 or title= 31 or title= 32",
			"UPDATE price set title = 7 where title = 33 or title= 34 or title= 35 or title= 36",
			"UPDATE price set title = 8 where title = 37 or title= 38 or title= 39 or title= 40",

			"DELETE from price_change where id = 9 or id = 10 or id = 11 or id = 12 or
				id  = 13 or id = 14 or id = 15 or id = 16 or 
				id  = 17 or id = 18 or id = 19 or id = 20 or
				id  = 21 or id = 22 or id = 23 or id = 24 or
				id  = 25 or id = 26 or id = 27 or id = 28 or
				id  = 29 or id = 30 or id = 31 or id = 32 or
				id  = 33 or id = 34 or id = 35 or id = 36 or
				id  = 37 or id = 38 or id = 39 or id = 40",

				"ALTER TABLE `hefz_teams` ADD `groupname` INT(10) NOT NULL AFTER `lig_id`;",

				"CREATE TABLE `hefz_group` (
				  `id` int(10) NOT NULL,
				  `lig_id` int(10) NOT NULL,
				  `name` varchar(255) NOT NULL,
				  `descripiton` text NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
				"ALTER TABLE `hefz_group`
			  ADD PRIMARY KEY (`id`);",

			"ALTER TABLE `hefz_group`
			  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;",

			  	"ALTER TABLE `hefz_group`
			  ADD CONSTRAINT `hefz_group_ibfk_1` FOREIGN KEY (`lig_id`) REFERENCES `hefz_ligs` (`id`)",

			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_group_insert` AFTER INSERT ON `hefz_group`
			FOR EACH ROW BEGIN
			call setHistory('hefz_group', 'insert', NEW.id);
			END",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_group_update` AFTER UPDATE ON `hefz_group`
			FOR EACH ROW BEGIN
			call setHistory('hefz_group', 'update', OLD.id);
			END",

			// -----------------------------------------------------------------------------
			"CREATE TRIGGER `hefz_group_delete` AFTER DELETE ON `hefz_group`
			FOR EACH ROW BEGIN
			call setHistory('hefz_group', 'delete', OLD.id);
			END",

			"ALTER TABLE `hefz_race` ADD `manfi1` FLOAT NULL AFTER `name`",
			"ALTER TABLE `hefz_race` ADD `manfi2` FLOAT NULL AFTER `manfi1`",


		);


		$this->run($database_change);
	}

	public function run($array =false) {
		
		$sql = new dbconnection_lib;

		$error = 0;
		$all = 0;

		foreach ($array as $key => $value) {
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

		$this->xecho("<div style='background:green'>done.  Database set on version ". $this->version .
					 "all perosses =  <b> $all </b> by <b> $error </b> error </div></pre>");

	}
}
?>