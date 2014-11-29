<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class controller extends main_controller{
	public $access = true;
	
	function config(){
		//------------------------------ course formmaker
		$this->listen(array(
			"max" => 2,
			"url" => array("group")
			), 
			function () {
				save(array("formmaker", "group"));
				$this->access  = true;
				$this->permission = array("form_gorup" => array("insert" => array("public") , "update" => array("public")));
			}
		);

		//------------------------------ course formmaker
		$this->listen(array(
			"max" => 3,
			"url" => array("questions" , "status" => "/^(edit|add)$/")
			), 
			function () {
				save(array("formmaker", "questions"));
				$this->access  = true;
				$this->permission = array("form_gorup" => array("insert" => array("public") , "update" => array("public")));
			}
		);


		//------------------------------ course formmaker
		$this->listen(array(
			"max" => 4,
			"url" => array("group" , "status" => "/^(edit|add)$/" , "id" => "/^\d+$/")
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