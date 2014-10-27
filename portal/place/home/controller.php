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
			save(array("place", "option"));
			$this->permission = array("place" => array("insert" => array("public")));
		} );

		$this->listen(array(
			"max" => 2,
			"url" => array("edit" , "/^\d+$/")
		), function() {
			save(array("place", "option"));
			$this->permission = array("place" => array("update" => array("public")));
		});
	}
}
?>