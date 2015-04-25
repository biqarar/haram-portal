<?php 
class controller extends main_controller{
	
	function config(){	
//------------------------------ branch admin (for developer)
		$this->listen(array(
			"max" => 3,
			"url" => array("status" => "admin")
			), 
			function() {
				save(array("database", "admin"));
				$this->access = global_cls::supervisor();
			}
		);
	}
}
 ?>