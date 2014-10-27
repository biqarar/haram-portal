<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class controller extends main_controller{

	function config(){
		$this->listen(array(
			"max" => 1,
			"url" => array("add")
		), function() {
			save(array("education", "option"));
			$this->permission = array("education" => array("insert" => array("public", "private")));
		} );

		$this->listen(array(
			"max" => 2,
			"url" => array("edit" , "/^\d+$/")
		), function() {
			save(array("education", "option"));
			$this->permission = array("education" => array("update" => array("public")));
		});
		
		$this->listen(array(
			"max"=>2,
			"url"=>array("api", "/^.+$/")
		), function () {
			save(array("method" => "api", "mod" => "list"));
			$this->access = true;
		});
	}
}
?>