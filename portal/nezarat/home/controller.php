<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
class controller extends main_controller{

	function config(){


		//------------------------------ nezarat api (get list of nezarat in one province)
		$this->listen(array(
			"max" => 4,
			"url" => array("item","status","api")
			), 
			function () {
				save(array("nezarat","item","list", "mod" => "api"));
				$this->access = true;
			}
		);
		//------------------------------ nezarat api (get list of nezarat in one province)
		$this->listen(array(
			"max" => 2,
			"url" => array("api", "search" => "/^(.*)$/")
			), 
			function () {
				save(array("class" =>"nezarat" , "method" => 'api', "mod" => "list"));
				$this->access = true;
			}
		);


		//------------------------------item
		$this->listen(array(
			"max" => 2,
			"url" => "item"
			), 
			function () {
				save(array("nezarat","item", "option"));
				$this->access = true;
			}
		);
		$this->listen(array(
			"max" => 2,
			"url" => array("item", "status" => "add")
			), 
			function () {
				save(array("nezarat", "item","option"));
				$this->permission = array("nezarat_item" => array("delete" => array("public")));
			}
		);
		$this->listen(array(
			"max" => 3,
			"url" => array("item", "status" => "edit", "id" => "/^\d+$/")
			), 
			function () {
				save(array("nezarat", "item","option"));
				$this->permission = array("nezarat_item" => array("delete" => array("public")));
			}
		);

		//------------------------------ perogram

		$this->listen(array(
			"max" => 2,
			"url" => "program"
			), 
			function () {
				save(array("nezarat","program", "option"));
				$this->access = true;
			}
		);
		$this->listen(array(
			"max" => 2,
			"url" => array("program", "status" => "add")
			), 
			function () {
				save(array("nezarat", "program","option"));
				$this->permission = array("nezarat_program" => array("delete" => array("public")));
			}
		);
		$this->listen(array(
			"max" => 3,
			"url" => array("program", "status" => "edit", "id" => "/^\d+$/")
			), 
			function () {
				save(array("nezarat", "program","option"));
				$this->permission = array("nezarat_program" => array("delete" => array("public")));
			}
		);
		
	}
}
?>