<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
class controller extends main_controller{
		public $access = true;
	function config(){

		$this->listen(array(
			"max" => 2,
			"url" => array("gettext","/^(.*)$/")
			),
			function() {
				save(array("class" => "datatable", "method"=> "gettext", "mod" => "text"));
				// $this->permission  =array("classification" => array("select" => array("public", "private")));
			} );
		
		$this->listen(array(
			"max" => 2,
			"url" => array("/^(.*)$/")
			),
			function() {
				save(array("class" => "datatable", "method"=> "api", "mod" => "list"));
				$this->access = global_cls::supervisor();
			} );
	}	
	
}
?>