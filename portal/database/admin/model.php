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
		$this->ready(13);

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
			//--------------------

		"ALTER TABLE `hefz_group` CHANGE `descripiton` `description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL;",
		"ALTER TABLE `hefz_teams` CHANGE `groupname` `hefz_group_id` INT(10) NULL;",

		

		"ALTER TABLE `hefz_teams`
			  ADD CONSTRAINT `hefz_group_ibfk_5` FOREIGN KEY (`hefz_group_id`) REFERENCES `hefz_group` (`id`)",
		
		"ALTER TABLE `hefz_teams` DROP `min_person`;",
		"ALTER TABLE `hefz_teams` DROP `max_person`;",
		"ALTER TABLE `hefz_race_result` CHANGE `value` `value` FLOAT NOT NULL DEFAULT '0';",
		"ALTER TABLE `hefz_race_result` ADD UNIQUE (`hefz_race_id`,`hefz_teamuser_id`, `type`)",
		"ALTER TABLE `hefz_race_result`
			ADD CONSTRAINT `hefz_group_ibfk_6` FOREIGN KEY (`hefz_teamuser_id`) REFERENCES `hefz_teamuser` (`id`)",
			"ALTER TABLE `hefz_race` CHANGE `presence1` `presence1` TEXT NULL DEFAULT NULL;",
			"ALTER TABLE `hefz_race` CHANGE `presence2` `presence2` TEXT NULL DEFAULT NULL;",

			"ALTER TABLE `hefz_race`
			ADD CONSTRAINT `hefz_race_ibfk_6` FOREIGN KEY (`hefz_team_id_1`) REFERENCES `hefz_teams` (`id`)",
			"ALTER TABLE `hefz_race`
			ADD CONSTRAINT `hefz_race_ibfk_7` FOREIGN KEY (`hefz_team_id_2`) REFERENCES `hefz_teams` (`id`)",
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