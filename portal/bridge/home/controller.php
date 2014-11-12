<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
class controller extends main_controller{
	function config(){
		$this->listen(
				array(
					"max" => 2,
					'url' => array("status" => "add", "usersid" => "/^(\d+)$/")
					),
				function(){
					save(array("bridge", "option"));
					$this->permission = array("bridge" => array("update" => array("public")));
				}
			);
	}
}
?>