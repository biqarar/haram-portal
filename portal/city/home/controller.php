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
			save(array("city", "option"));
			$this->permission = array("city" => array("insert" => array("public", "private")));
		} );

		$this->listen(array(
			"max" => 2,
			"url" => array("edit" , "/^\d+$/")
		), function() {
			save(array("city", "option"));
			$this->permission = array("city" => array("update" => array("public", "private")));
		});
		$this->listen(array(
			"max" => 2,
			"url" => array("api", "/^\d+$/")
			), function () {
			save(array("class" =>"city" , "method" => 'api', "mod" => "list"));
			$this->access = true;
		});
	}
}
?>