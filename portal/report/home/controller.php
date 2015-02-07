<?php  
class controller extends main_controller {
	public function config(){

	// var_dump(config_lib::$url); exit();



	// $this->listen(array(
	// 	"max" => 2 ,
	// 	"url" => array("/(.*)/")
	// 	), array("users", "option"));
// exit();

	$this->listen(array(
			"max" => 3,
			"url" => array("classes", "status" => "apilist")
			), function (){
				save(array("report","classes", "mod" => "api"));
				$this->permission = array("report" => array("select" => array("public")));
				// $this->access = true;

	});

	$this->listen(array(
			"url" => array("classes", "status" => "reportall", "/(.*)/")
			), function (){
				save(array("report","classes","report"));
				$this->permission = array("report" => array("select" => array("public")));
				// $this->access = true;

	});

	$this->listen(array(
			"max" => 3,
			"url" => array("classes", "status" => "report")
			), function (){
				save(array("report","classes","report",  "mod" => "report"));
				$this->permission = array("report" => array("select" => array("public")));
				// $this->access = true;

	});

	$this->listen(array(
				"max" => 3,
				"url" => array("classes")
				), function (){
					save(array("report","classes"));
					$this->permission = array("report" => array("select" => array("public")));
					// $this->access = true;

		});


			
	}
}
?>  