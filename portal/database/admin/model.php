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
		$this->database_change();		
		
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
			  `table` varchar(64) NOT NULL,
			  `name` varchar(255) NOT NULL,
			  `url` varchar(255) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ",

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
			END"

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