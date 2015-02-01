<?php  
class controller extends main_controller {
	
	public function config(){

		$this->listen(array(
				"max" => 4,
				"url" => array("status" => "add" ,"classesid" => "/^\d+$/" , "scoretypeid" => "/^\d+$/")
				), array("score", "score"));
		
		$this->listen(array(
				"max" => 5,
				"url" => array("api", "classificationid" => "/^\d+$/" ,"scoretypeid" => "/^\d+$/", "value" => "/(.*)/")
				), array("score", "api", "mod" => "api"));
		
		$this->listen(array(
				"max" => 5,
				"url" => array("classes", "status" => "apilist" ,"classesid" => "/^\d+$/", "scoretypeid" => "/^\d+$/")
				), array("score", "classes", "mod" => "api"));

		$this->listen(array(
				"max" => 5,
				"url" => array("classes", "classesid" => "/^\d+$/")
				), array("score", "classes"));


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