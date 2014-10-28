<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class controller extends main_controller{

	function config(){
		$this->listen(array(
			"max" => 1,
			"url" => array("add")
		), function() {
			save(array("course", "option"));
			$this->permission = array("course" => array("insert" => array("public", "private")));
		} );

		$this->listen(array(
			"max" => 2,
			"url" => array("edit" , "/^\d+$/")
		), function() {
			save(array("course", "option"));
			$this->permission = array("course" => array("update" => array("public")));
		});

		$this->listen(array(
			"max" => 3,
			"url" => array("description", "/^(add|edit)$/")
			
			), function () {
			save(array("course", "description"));
			$this->permission = array("course_description" => array("insert" => array("public") , "update" => array("public")));
		});
	}
}
?>