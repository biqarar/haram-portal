<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class controller extends main_controller{
	function config(){
		//------------------------------ plan section (use in classification)
		$this->listen(array(
			"max" => 3,
			"url" => array("section", "/^(add|edit)$/")
			), 
			function () {
				save(array("plan", "section"));
				$this->permission = array("plan_section" => array("insert" => array("public"), "update" => array("public")));
			}
		);
	}
}
?>