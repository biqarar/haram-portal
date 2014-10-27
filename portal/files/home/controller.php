<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class controller extends main_controller{
	public $permission = array("files" => array("insert" => array("public"),
						"update" => array("public")));
	function config(){
		$this->listen(array(
			"max" =>2,
			"url"=>array("add")
			), function(){
			save(array("files","option"));
			$this->permission = array("files" => array("insert"));
		});
		$this->listen(array(
			"max" => 2,
			"url" => array("edit", "/^\d+$/")
			), array("files", "option"));
	}
}
?>