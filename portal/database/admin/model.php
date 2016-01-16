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
			// inner join branch_cash as br on us.id = br.record_id and br.table = 'classes' and br.branch_id = 1 
			// set us.plan_id =181 where us.plan_id = 26",


			// "update score_type as us 
			// inner join branch_cash as br on us.id = br.record_id and br.table = 'score_type' and br.branch_id = 1 
			// set us.plan_id =181 where us.plan_id = 26",

			// "update score_calculation as us 
			// inner join branch_cash as br on us.id = br.record_id and br.table = 'score_calculation' and br.branch_id = 1 
			// set us.plan_id =181 where us.plan_id = 26",
			
			// "delete from branch_cash where branch_cash.table = 'plan' and branch_cash.record_id = 26 and branch_cash.branch_id = 1";


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

		);
		$change_id = array(
			25 => 180,
			26 => 181,
			27 => 182,
			29 => 183,
			31 => 184,
			33 => 185,
			35 => 186,
			36 => 187,
			37 => 188,
			45 => 189,
			46 => 190,
			48 => 191,
			49 => 192,
			50 => 193,
			71 => 194,
			72 => 195

			);
		foreach ($change_id as $old => $new) {
			array_push($database_change, "update classes as us 
			inner join branch_cash as br on us.id = br.record_id and br.table = 'classes' and br.branch_id = 1 
			set us.plan_id =$new where us.plan_id = $old");


			array_push($database_change,"update score_type as us 
			inner join branch_cash as br on us.id = br.record_id and br.table = 'score_type' and br.branch_id = 1 
			set us.plan_id =$new where us.plan_id = $old");

			array_push($database_change,"update score_calculation as us 
			inner join branch_cash as br on us.id = br.record_id and br.table = 'score_calculation' and br.branch_id = 1 
			set us.plan_id =$new where us.plan_id = $old");
			
			array_push($database_change,"delete from branch_cash where branch_cash.table = 'plan' and branch_cash.record_id = $old and branch_cash.branch_id = 1");


		}

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