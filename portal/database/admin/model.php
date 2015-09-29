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

		// $this->branch_id_set();
		// exit();
		// die();

		$this->query_on_record();
		$this->ready(6);
		//----------------------------- new version function (database change)	
		// $this->database_change();		
		
		//----------------------------- new version function (query on record)
		
		$this->end();
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
	}

	public function query_on_record() {
		
		// ---------------------------------------------------------------------------------------------------
		$person = $this->sql()->tablePerson();//->select()->string();
		$person->joinBranch_cash()->whereTable("person")->andRecord_id("#person.id")->andBranch_id(7);
		// $person->joinBridge()->whereUsers_id("#person.users_id");
		$person = $person->select()->allAssoc();
		foreach ($person as $key => $value) {
			$bridge = $this->sql()->tableBridge()->whereUsers_id($value['users_id'])->select()->allAssoc();
			// var_dump($value);exit();
			$person[$key]['phone'] = isset($bridge[0]['value']) ? $bridge[0]['value'] : "-";
			$person[$key]['mobile'] = isset($bridge[1]['value']) ? $bridge[1]['value'] : "-";
			$person[$key]['education_id'] = $this->sql(".assoc.foreign", "education", $value['education_id'], "section");
			$person[$key]['from'] = $this->sql(".assoc.foreign", "city", $value['from'], "name");
			$person[$key]['nationality'] = $this->sql(".assoc.foreign", "country", $value['nationality'], "name");
			$person[$key]['id'] = $this->sql(".assoc.foreign", "users", $value['users_id'], "username");
			// var_dump( $this->sql(".assoc.foreign", "users", $value['users_id'], "username"));exit();
			// echo $value['value'] . "<br>";
			// var_dump($this->sql(".assoc.foreign", "city", $value['from'], "name"));exit();
		}
		// var_dump($person);exit();
		// var_dump(count($person));
		$this->sql(".xlsx", $person);exit();
exit();
		// $classes = $this->sql()->tableClassification()->whereBecause("done")->setBecause("#null")->setDate_delete("#null")->update();
		// $this->commit(function(){
		// 	echo "set all active classes to runnig status";
		// });
		// var_dump($classes->string());
		// $this->flush();


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

			"CREATE TABLE IF NOT EXISTS `presence` (
			`id` int(10) NULL DEFAULT NULL,
			  `classification_id` int(10) NOT NULL,
			  `type` enum('presence','unjustified absence') NOT NULL DEFAULT 'unjustified absence',
			  `date` int(8) NOT NULL,
			  `because` time NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci",
			"ALTER TABLE `presence` ADD UNIQUE `unique_index`(`classification_id`, `date`);",
			
		
			"ALTER TABLE `presence` ADD CONSTRAINT `presence_log_ibfk_1` FOREIGN KEY (`classification_id`) REFERENCES `classification` (`id`)",

			//-----------------------------------------------------------------------------
			"CREATE TABLE IF NOT EXISTS `presence_classes` (
			`id` int(10) NOT NULL,
			  `classes_id` int(10) NOT NULL,
			  `date` int(8) NOT NULL,
			  `start_time` varchar(32) NOT NULL,
			  `end_time` varchar(32) NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ",
			"ALTER TABLE `presence_classes` ADD UNIQUE `unique_index`(`classes_id`, `date`);",

			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `presence_classes_insert` AFTER INSERT ON `presence_classes`
			 FOR EACH ROW BEGIN
			call setCash('presence_classes', NEW.id, @branch_id);
			call setHistory('presence_classes', 'insert', NEW.id);
			END",
			"ALTER TABLE `presence_classes` ADD PRIMARY KEY(`id`)",
			"ALTER TABLE `presence_classes` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT",
			"ALTER TABLE `presence_classes` ADD CONSTRAINT `presence_classes_log_ibfk_1` FOREIGN KEY (`classes_id`) REFERENCES `classes` (`id`)",

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