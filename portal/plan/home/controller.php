<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class controller extends main_controller{
	function config(){
		$this->listen(array(
			"max" => 1,
			"url" => "/^(|add)$/"
		), function() {
			save(array("plan", "option"));
			$this->permission = array("plan" => array("insert" => array("public")));
		} );

		$this->listen(array(
			"max" => 2,
			"url" => array("edit" , "/^\d+$/")
		), function() {
			save(array("plan", "option"));
			$this->permission = array("plan" => array("update" => array("public")));
		});
		$this->listen(array(
			"max" => 3,
			"url" => array("section", "/^(add|edit)$/")
			), function () {
			save(array("plan", "section"));
			$this->permission = array("plan_section" => array("insert" => array("public"), "update" => array("public")));
		});
	}
}
?>