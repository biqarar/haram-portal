<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
class controller extends main_controller{

	function config(){

		//------------------------------ pending classes
		$this->listen(array(
			"max" => 2,
			"url" => array("status" => "setdone", "classesid" => "/^\d+$/")
			), 
			function () {
				save(array("classes", "done", "mod" => "setdone"));
				$this->permission = array("classes" => array("delete" => array("public"), "update" => array("public")));
			}
		);
		//------------------------------ pending classes
		$this->listen(array(
			"max" => 2,
			"url" => array("status" => "done", "classesid" => "/^\d+$/")
			), 
			function () {
				save(array("classes", "done"));
				$this->permission = array("classes" => array("delete" => array("public"), "update" => array("public")));
			}
		);
		//------------------------------ pending classes
		$this->listen(array(
			"max" => 2,
			"url" => array("pending", "/^(|add|edit)$/")
			), 
			function () {
				save(array("classes", "pending"));
				$this->permission = array("pending_classes" => array("insert" => array("public"), "update" => array("public")));
			}
		);
	}
}
?>