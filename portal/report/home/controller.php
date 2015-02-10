<?php  
class controller extends main_controller {
	public function config(){

	//----------------------------
	$this->listen(array(
			"max" => 3,
			"url" => array("classes", "status" => "apilist")
			), function (){
				save(array("report","classes", "mod" => "api"));
				$this->permission = array("report" => array("select" => array("public")));
	});

	//---------------------------- bridge
	$this->listen(array(
			"url" => array("classes", "type" => "bridge", "/(.*)/")
			), function (){
				save(array("report","classes","bridge"));
				$this->permission = array("report" => array("select" => array("public")));
	});

	//----------------------------
	$this->listen(array(
			"max" => 3,
			"url" => array("classes", "status" => "report")
			), function (){
				save(array("report","classes","report",  "mod" => "report"));
				$this->permission = array("report" => array("select" => array("public")));

	});

	//----------------------------
	$this->listen(array(
				"max" => 3,
				"url" => array("classes")
				), function (){
					save(array("report","classes"));
					$this->permission = array("report" => array("select" => array("public")));
		});		
	}
}
?>  