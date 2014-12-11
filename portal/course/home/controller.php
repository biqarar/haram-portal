<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class controller extends main_controller{

	function config(){
		
		//------------------------------ course description
		$this->listen(array(
			"max" => 3,
			"url" => array("description", "/^(add|edit)$/")
			
			), 
			function () {
				save(array("course", "description"));
				$this->permission = array("course_description" => array("insert" => array("public") , "update" => array("public")));
			}
		);
	}
}
?>