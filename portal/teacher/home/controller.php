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
					save(array("teacher", "option"));
					$this->permission = array("teacher" => array("select" => array("public")));
				}
			);

		$this->listen(
				array(
					"max" => 2,
					'url' => array("status" => "detail", "usersid" => "/^(\d+)$/")
					),
				function(){
					save(array("teacher", "detail"));
					$this->permission = array("teacher" => array("select" => array("public")));
				}
			);
	}
}
?>