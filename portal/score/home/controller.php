<?php  
class controller extends main_controller {
	
	public function config(){
		$this->listen(array(
				"max" => 3,
				"url" => array("type", "status" => "add")
				), array("score", "type", "option"));
		
		$this->listen(array(
				"max" => 3,
				"url" => array("type", "status" => "edit", "id" => "/^\d+$/")
				), array("score", "type", "option"));


		$this->listen(array(
				"max" => 3,
				"url" => array("calculation", "status" => "add")
				), array("score", "calculation", "option"));
		
		$this->listen(array(
				"max" => 3,
				"url" => array("calculation", "status" => "edit", "id" => "/^\d+$/")
				), array("score", "calculation", "option"));
		
		$this->listen(array(
				"max" => 3,
				"url" => array("type", "status" => "apilist")
				), array("score","type" ,"list", "mod" => "api"));


		$this->listen(array(
				"max" => 3,
				"url" => array("calculation", "status" => "apilist")
				), array("score","calculation" ,"list", "mod" => "api"));
	}
}
?>  