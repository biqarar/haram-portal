<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class controller extends main_controller{
	
	function config(){	
		//------------------------------ branch descriptiion
		$this->listen(array(
			"max" => 1,
			"url" => array("classesid" => "/^\d+$/")
			), 
			function() {
				save(array("presence", "classes"));
				$this->permission = array("absence" => array("insert" => array("public"), "update" => array("public")));
			}
		);

			//------------------------------ branch descriptiion
		$this->listen(array(
			"max" => 3,
			"url" => array("apiadd","classesid"=> "/^\d+$/", "username" => "/^\d+$/")
			), 
			function() {
				save(array("presence", "classes", "mod" => "apiadd"));
				$this->permission = array("absence" => array("insert" => array("public"), "update" => array("public")));
			}
		);
	}

}
?>