<?php  
class controller extends main_controller {

	public $permission = array("report" => array("select" => array("public")));
	public function config(){

	//---------------------------- bridge
	$this->listen(array(
			"url" => array("classes", "type" => "bridge", "/(.*)/")
			), function (){
				save(array("report","classes","bridge"));
				$this->permission = array("report" => array("select" => array("public")));
	});

	//---------------------------- bridge
	$this->listen(array(
			"url" => array("classes", "type" => "activeclasses")
			), function (){
				save(array("report","classes","activeclasses"));
				$this->permission = array("report" => array("select" => array("public")));
	});

	//---------------------------- bridge
	$this->listen(array(
			"url" => array("classes", "type" => "register")
			), function (){
				save(array("report","classes","register"));
				$this->permission = array("report" => array("select" => array("public")));
	});

	//---------------------------- bridge
	$this->listen(array(
			"url" => array("classes", "type" => "classification", "/(.*)/")
			), function (){
				save(array("report","classes","classification"));
				$this->permission = array("report" => array("select" => array("public")));
	});

	//---------------------------- bridge
	$this->listen(array(
			"url" => array("classes", "type" => "person", "/(.*)/")
			), function (){
				save(array("report","classes","person"));
				$this->permission = array("report" => array("select" => array("public")));
	});
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
			"url" => array("classes","type" => "personstatus", "/(.*)/")
			), function (){
				save(array("report","classes","personstatus"));
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
				"url" => array("price", "weekly", "start_date" => "/(.*)/", "end_date" => "/(.*)/")
				), function (){
					save(array("report","price", "weekly"));
					$this->permission = array("report" => array("select" => array("public")));
		});	
	}
}
?>  