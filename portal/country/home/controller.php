<?php  
class controller extends main_controller {
	
	public function config(){
		$this->listen(array(
			"max" => 1,
			"url" => array("add")
		), function() {
			save(array("country", "option"));
			$this->permission = array("country" => array("insert" => array("public", "private")));
		} );
		

		$this->listen(array(
			"max" => 2,
			"url" => array("edit" , "/^\d+$/")
		), function() {
			save(array("country", "option"));
			$this->permission = array("country" => array("update" => array("public")));
		});
	}
}
?>  