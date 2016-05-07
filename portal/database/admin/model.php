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
		$this->ready(10);

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
		*/
				
		$sql = new dbconnection_lib;


		$database_change = array(

			"ALTER TABLE `plan`  ADD `branch_id` INT(10) NULL",
			"ALTER TABLE `plan` ADD CONSTRAINT `plan_branch_id_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`)",

			"update plan as us 
			inner join branch_cash as br on us.id = br.record_id and br.table = 'plan' 
			set us.branch_id = br.branch_id",

			"ALTER TABLE `plan`  CHANGE `branch_id`  `branch_id` INT(10) NOT NULL",

			
			"ALTER TABLE `course`  ADD `branch_id` INT(10) NULL",
			"ALTER TABLE `course` ADD CONSTRAINT `course_branch_id_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`)",

			"update course as us 
			inner join branch_cash as br on us.id = br.record_id and br.table = 'course' 
			set us.branch_id = br.branch_id",

			"ALTER TABLE `course`  CHANGE `branch_id`  `branch_id` INT(10) NOT NULL",

			"ALTER TABLE `place`  ADD `branch_id` INT(10) NULL",
			"ALTER TABLE `place` ADD CONSTRAINT `place_branch_id_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`)",

			"update place as us 
			inner join branch_cash as br on us.id = br.record_id and br.table = 'place' 
			set us.branch_id = br.branch_id",

			"ALTER TABLE `place`  CHANGE `branch_id`  `branch_id` INT(10) NOT NULL",


			// "ALTER TABLE `price_change`  ADD `branch_id` INT(10) NULL",
			// "ALTER TABLE `price_change` ADD CONSTRAINT `price_change_branch_id_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`)",

			// "update price_change as us 
			// inner join branch_cash as br on us.id = br.record_id and br.table = 'price_change' 
			// set us.branch_id = br.branch_id",

			// "ALTER TABLE `price_change`  CHANGE `branch_id`  `branch_id` INT(10) NOT NULL",

			// "ALTER TABLE `price`  ADD `branch_id` INT(10) NULL",
			// "ALTER TABLE `price` ADD CONSTRAINT `price_branch_id_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`)",

			// "update price as us 
			// inner join branch_cash as br on us.id = br.record_id and br.table = 'price' 
			// set us.branch_id = br.branch_id",

			// "ALTER TABLE `price`  CHANGE `branch_id`  `branch_id` INT(10) NOT NULL",

			"ALTER TABLE `group`  ADD `branch_id` INT(10) NULL",
			"ALTER TABLE `group` ADD CONSTRAINT `group_branch_id_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`)",

			"update `group` as us 
			inner join branch_cash as br on us.id = br.record_id and br.table = 'group' 
			set us.branch_id = br.branch_id",


			"ALTER TABLE `group`  CHANGE `branch_id`  `branch_id` INT(10) NOT NULL",
			
 			

 			"ALTER TABLE `permission`  ADD `users_branch_id` INT(10) NULL AFTER `users_id`",

			"ALTER TABLE `permission` ADD CONSTRAINT `permission_branch_id_ibfk_1` FOREIGN KEY (`users_branch_id`) REFERENCES `users_branch` (`id`)",

			"update `permission` as perm 
			inner join users_branch as ub  on perm.users_id = ub.users_id
			set perm.users_branch_id = ub.id",


			"ALTER TABLE `permission`  CHANGE `users_branch_id`  `users_branch_id` INT(10) NOT NULL",
			
			"ALTER TABLE `permission` DROP FOREIGN KEY `permission_ibfk_2`",

			"ALTER TABLE permission DROP INDEX users_id",

			"ALTER TABLE `permission` DROP `users_id`",


			// "ALTER TABLE `quran_hadith`.`permission` DROP INDEX `table`, ADD UNIQUE `table` (`tables`, `users_id`, `users_branch_id`) USING BTREE",
			


			"CREATE TABLE `logs` (
			  `id` bigint(20) UNSIGNED NOT NULL,
			  `user_id` int(10) UNSIGNED DEFAULT NULL,
			  `log_data` varchar(200) DEFAULT NULL,
			  `log_meta` mediumtext,
			  `log_status` enum('enable','disable','expire','deliver') DEFAULT NULL,
			  `log_createdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `date_modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

			"ALTER TABLE `logs`
			  ADD PRIMARY KEY (`id`),
			  ADD KEY `logs_users_id` (`user_id`) USING BTREE;",

  			"ALTER TABLE `logs`
  				MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;",



			"DROP TABLE `dev`",

			"DROP TABLE `form_answer`",
			
			"DROP TABLE `form_group`",
			
			"DROP TABLE `form_group_item`",
			
			"DROP TABLE `form_questions`",
			
			"DROP TABLE `nezarat_program_item`",
			
			"DROP TABLE `nezarat_item`",
			
			"DROP TABLE `nezarat_program`",

			"ALTER TABLE `group` DROP INDEX `name`, ADD UNIQUE `name` (`name`, `branch_id`) USING BTREE;",

			"ALTER TABLE `users_branch` ADD `type` ENUM('student','teacher','operator') NOT NULL DEFAULT 'student'",

			"update `users_branch` as br 
			inner join users as us on us.id = br.users_id  
			set br.type = us.type",

			"ALTER TABLE `users` DROP `type`",

			"ALTER TABLE `users_branch` ADD `status` ENUM('waiting','block','delete','enable') NOT NULL DEFAULT 'waiting'",
			"update `users_branch` as br 
			inner join users as us on us.id = br.users_id  
			set br.status = us.status",


			"ALTER TABLE `users` DROP `status`",
			




		);


		$this->run($database_change);


		$list_table = $sql->query("SELECT * FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` LIKE 'quran_hadith'");

		$list_table = $list_table->allAssoc('TABLE_NAME');

		foreach ($list_table as $key => $value) {
			if(
				$value == "history" || 
				$value == "branch_users_key" || 
				$value == "city" || 
				$value == "province" || 
				$value == "country" || 
				$value == "education" || 
				$value == "logs" 
				
				) {

			}else{
				$this->run($this->trigger($value));
			}
		}
		
		// exit();
		
	
		/**

		*/
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

			$this->xecho( "<div style='background :green'>done.  Database set on version ". $this->version ." 
			 all perosses =  <b> $all </b>    
			 by <b> $error </b> error </div></pre>");

	}


	public function trigger($table = false) {
			return  array(

			// "ALTER TABLE `$table` ADD `date_insert` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ",

			// "ALTER TABLE `$table` ADD `date_modified` TIMESTAMP on update CURRENT_TIMESTAMP  NULL ",
			
				//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `{$table}_insert`",
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `" . $table . "_insert` AFTER INSERT ON `$table`
			FOR EACH ROW BEGIN
			call setHistory('$table', 'insert', NEW.id);
			END",

					//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `" . $table . "_update`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `" . $table . "_update` AFTER UPDATE ON `$table`
			FOR EACH ROW BEGIN
			call setHistory('$table', 'update', OLD.id);
			END",

			//-----------------------------------------------------------------------------
			"DROP TRIGGER IF EXISTS `" . $table . "_delete`",
			
			//-----------------------------------------------------------------------------
			"CREATE TRIGGER `" . $table . "_delete` AFTER DELETE ON `$table`
			FOR EACH ROW BEGIN
			call setHistory('$table', 'delete', OLD.id);
			END"
			);
	} 


}
?>