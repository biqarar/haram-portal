<?php
/**
* @author Reza Mohiti rm.biqarar@gmail.com
*/
class controller extends main_controller{
	function config(){
		$this->listen(array(
			"max" =>1,
			"url"=>array("add")
			), array("getprice","option"));
	}
}
?>