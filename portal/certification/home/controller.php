<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class controller extends main_controller{
	
	function config(){
		// certification/status=insertapi/classificationid=
		//------------------------------ pending classes
		$this->listen(array(
			"max" => 3,
			"url" => array("status" => "insertapi", "classificationid" => "/^\d+$/")
			), 
			function () {
				save(array("certification", "option", "mod" => "insertapi"));
				$this->permission = array("certification" => array("insert" => array("public")));
			}
		);
	}
}
?>