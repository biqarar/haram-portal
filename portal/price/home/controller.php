<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class controller extends main_controller{
	public function config(){
		
	$this->listen(array(
			"max" => 2,
			"url"=>array("status" => "add" , "usersid" => "/^\d+$/")
			), function(){
				save(array("price","option"));
			$this->permission = array("price" => array("insert" => array("public", "private")));
		});

		$this->listen(array(
			"max" => 2,
			"url"=>array("status" => "detail" , "usersid" => "/^\d+$/")
			), function(){
				save(array("price","detail"));
			$this->permission = array("price" => array("insert" => array("public", "private")));
		});
	}
}
?>