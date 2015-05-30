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
		$this->ready(6);

		//----------------------------- new version function (database change)	
		$this->database_change();		
		
		//----------------------------- new version function (query on record)
		$this->query_on_record();
		
		$this->end();
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
	}

	public function query_on_record() {
		/**

		*/		
		// ---------------------------------------------------------------------------------------------------
		// $classes = $this->sql()->tableClasses()->whereStatus("is", "#null")->setStatus("running")->update();
		// $this->commit(function(){
		// 	echo "set all active classes to runnig status";
		// });
		// var_dump($classes->string());
		// $this->flush();

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
			"CREATE TABLE IF NOT EXISTS `presence` (
			`id` int(10) NOT NULL,
			  `classification_id` int(10) NOT NULL,
			  `date` int(8) NOT NULL,
			  `status` enum('absence','presence') NOT NULL DEFAULT 'absence'
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ",
			
			"ALTER TABLE `presence` ADD PRIMARY KEY(`id`)",
			"ALTER TABLE `presence` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT",
			"ALTER TABLE `presence` ADD CONSTRAINT `presence_log_ibfk_1` FOREIGN KEY (`classification_id`) REFERENCES `classification` (`id`)",

			//-----------------------------------------------------------------------------
			"CREATE TABLE IF NOT EXISTS `presence_classes` (
			`id` int(10) NOT NULL,
			  `classes_id` int(10) NOT NULL,
			  `date` int(8) NOT NULL,
			  `start_time` varchar(32) NOT NULL,
			  `end_time` varchar(32) NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ",
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