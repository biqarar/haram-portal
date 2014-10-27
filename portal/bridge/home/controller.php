<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
class controller extends main_controller{
	function config(){
		$this->listen(array(
			"max" => 1,
			"url" => array("add")
		), function() {
			save(array("bridge", "option"));
			$this->permission = array("bridge" => array("insert" => array("public", "private")));
		} );

		$this->listen(array(
			"max" => 2,
			"url" => array("edit" , "/^\d+$/")
		), function() {
			save(array("bridge", "option"));
			$this->permission = array("bridge" => array("update" => array("public")));
		});
	}
}
?>