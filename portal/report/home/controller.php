<?php  
class controller extends main_controller {
	public function config(){
	// var_dump("fuck");
		$this->listen(array(
				"max" => 3,
				"url" => array("classes", "status" => "apilist")
				), function (){
					save(array("report","classes", "mod" => "api"));
					// $this->permission = array("users" => array("select" => array("public")));
					$this->access = true;

		});
		$this->listen(array(
				"url" => array("classes", "status" => "reportall", "/(.*)/")
				), function (){
					save(array("report","classes","report"));
					// $this->permission = array("users" => array("select" => array("public")));
					$this->access = true;

		});
		$this->listen(array(
				"max" => 3,
				"url" => array("classes", "status" => "report")
				), function (){
					save(array("report","classes","report",  "mod" => "report"));
					// $this->permission = array("users" => array("select" => array("public")));
					$this->access = true;

		});

	$this->listen(array(
				"max" => 3,
				"url" => array("classes")
				), function (){
					save(array("report","classes"));
					// $this->permission = array("users" => array("select" => array("public")));
					$this->access = true;

		});


			
	}
}
?>  