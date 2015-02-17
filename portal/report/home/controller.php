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
			"url" => array("classes", "bridge", "/(.*)/")
			), function (){
				save(array("report","classes","bridge"));
				$this->permission = array("report" => array("select" => array("public")));
	});

	//---------------------------- bridge
	$this->listen(array(
			"url" => array("classes", "person", "/(.*)/")
			), function (){
				save(array("report","classes","person"));
				$this->permission = array("report" => array("select" => array("public")));
	});
	
	// ----------------------------
	// $this->listen(array(
	// 		"max" => 3,
	// 		"url" => array("classes", "status" => "report")
	// 		), function (){
	// 			save(array("report","classes","report",  "mod" => "report"));
	// 			$this->permission = array("report" => array("select" => array("public")));

	// });

	//----------------------------
	$this->listen(array(
				"max" => 3,
				"url" => array("classes")
				), function (){
					save(array("report","classes"));
					$this->permission = array("report" => array("select" => array("public")));
		});	

	//----------------------------
	$this->listen(array(
				"max" => 3,
				"url" => array("price")
				), function (){
					save(array("report","price"));
					$this->permission = array("report" => array("select" => array("public")));
		});
	

	//----------------------------
	$this->listen(array(
				"max" => 5,
				"url" => array("price", "weekly", "startdate" => "/^\d{8}$/", "enddate" => "/^\d{8}$/")
				), function (){
					save(array("report","price", "weekly"));
					$this->permission = array("report" => array("select" => array("public")));
		});	
	}
}
?>  