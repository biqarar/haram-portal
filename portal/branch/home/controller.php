<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class controller extends main_controller{
	
	function config(){	
		//------------------------------ branch descriptiion
		$this->listen(array(
			"max" => 3,
			"url" => array("description", "/^(add|edit)$/")
			), 
			function() {
				save(array("branch", "description"));
				$this->permission = array("branch_description" => array("insert" => array("public"), "update" => array("public")));
			}
		);

		//------------------------------ branch move (manage branch_cash)
		$this->listen(array(
			"max" => 3,
			"url" => array("cash", "table" => "/^(.*)$/")
			), 
			function() {
				save(array("branch", "cash"));
				$this->permission = array("branch_description" => array("insert" => array("public"), "update" => array("public")));
			}
		);

		//------------------------------ branch admin (for developer)
		$this->listen(array(
			"max" => 3,
			"url" => array("status" => "admin")
			), 
			function() {
				save(array("branch", "admin"));
				$this->permission = array("branch" => array("insert" => array("public"), "update" => array("public")));
			}
		);
			
	}

}
?>