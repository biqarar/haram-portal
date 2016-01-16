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
			"url" => array("move", "users")
			), 
			function() {
				save(array("branch", "move"));
				$this->permission = array("branch" => array("delete" => array("public")));
			}
		);

		
			
	}

}
?>