<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class controller extends main_controller{
	
	function config(){
		//------------------------------ course formmaker
		$this->listen(array(
			"max" => 3,
			"url" => array("group")
			
			), 
			function () {
				save(array("formmaker", "group"));
				$this->access  = true;
				$this->permission = array("form_gorup" => array("insert" => array("public") , "update" => array("public")));
			}
		);
	}
}
?>