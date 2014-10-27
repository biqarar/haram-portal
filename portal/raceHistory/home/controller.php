<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class controller extends main_controller{
	public $permission = array("racehistory" => array("insert" => array("public"),
						"update" => array("public")));
	function config(){
		$this->listen(array(
			"max" => 1,
			"url"=>array("add")),
			array("racehistory","option"));
		$this->listen(array(
			"max" => 2,
			"url"=>array("edit", "/^\d+$/")),
			array("racehistory","option"));
	}
}
?>