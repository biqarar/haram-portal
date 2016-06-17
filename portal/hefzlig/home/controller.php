<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class controller extends main_controller{
	
	function config(){	

		$this->listen(array(
			"max" => 5,
			"url" => array(
				"race",
			 	"status" => "raceapi",
			 	"teamid" => "/^\d+$/",
			 	"raceid" => "/^\d+$/",
			 	"type" => "/^(up|down)$/"
			 	)
			), 
			function() {
				save(array("hefzlig","racing", "mod" => "insertmanfiapi"));
				$this->permission = array("hrfzligs" => array("insert" => array("public"), "update" => array("public")));
			}
		);

		$this->listen(array(
			"max" => 3,
			"url" => array(
				"racing",
			 	"status" => "resultapi",
			 	"raceid" => "/^\d+$/")
			), 
			function() {
				save(array("hefzlig","racing", "mod" => "resultapi"));
				$this->permission = array("hrfzligs" => array("insert" => array("public"), "update" => array("public")));
			}
		);

		$this->listen(array(
			"max" => 6,
			"url" => array(
				"race",
			 	"status" => "raceapi",
			 	"teamuserid" => "/^\d+$/",
			 	"raceid" => "/^\d+$/",
			 	"value" => "/^(.*)$/",
			 	"type" => "/^(race1|race2)$/")
			), 
			function() {
				save(array("hefzlig","racing", "mod" => "insertapi"));
				$this->permission = array("hrfzligs" => array("insert" => array("public"), "update" => array("public")));
			}
		);

		$this->listen(array(
			"max" => 3,
			"url" => array("race", "status" => "racing", "id" => "/^\d+$/")
			), 
			function() {
				save(array("hefzlig","racing"));
				$this->permission = array("hrfzligs" => array("insert" => array("public"), "update" => array("public")));
			}
		);

		$this->listen(array(
			"max" => 3,
			"url" => array("race", "status" => "listapi")
			), 
			function() {
				save(array("hefzlig","race", "mod" => "listapi"));
				$this->permission = array("hrfzligs" => array("select" => array("public"), "update" => array("public")));
			}
		);
		
		$this->listen(array(
			"max" => 3,
			"url" => array("race")
			), 
			function() {
				save(array("hefzlig","race"));
				$this->permission = array("hrfzligs" => array("insert" => array("public"), "update" => array("public")));
			}
		);

		$this->listen(array(
			"max" => 5,
			"url" => array("teams", "status" => "apidelete", "teamuserid" => "/^\d+$/")
			), 
			function() {
				save(array("hefzlig","teams", "mod"=> "apidelete"));
				$this->permission = array("hrfzligs" => array("insert" => array("public"), "update" => array("public")));
			}
		);

		$this->listen(array(
			"max" => 5,
			"url" => array("teams", "status" => "apiadd", "usersid" => "/^\d+$/", "teamid" => "/^\d+$/")
			), 
			function() {
				save(array("hefzlig","teams", "mod"=> "apiadd"));
				$this->permission = array("hrfzligs" => array("insert" => array("public"), "update" => array("public")));
			}
		);

		$this->listen(array(
			"max" => 3,
			"url" => array("teams", "status" => "show", "id" => "/^\d+$/")
			), 
			function() {
				save(array("hefzlig","teamsshow"));
				$this->permission = array("hrfzligs" => array("insert" => array("public"), "update" => array("public")));
			}
		);
		//------------------------------ branch descriptiion
		$this->listen(array(
			"max" => 4,
			"url" => array("ligs", "status" => "listapi", "type" => "/^(race|manage)$/")
			), 
			function() {
				save(array("hefzlig","ligs", "mod" => "listapi"));
				$this->permission = array("hrfzligs" => array("select" => array("public")));
			}
		);
		$this->listen(array(
			"max" => 3,
			"url" => array("ligs")
			), 
			function() {
				save(array("hefzlig","ligs"));
				$this->permission = array("hrfzligs" => array("insert" => array("public"), "update" => array("public")));
			}
		);

		$this->listen(array(
			"max" => 4,
			"url" => array("teams", "status" => "listapi")
			), 
			function() {
				save(array("hefzlig","teams", "mod" => "listapi"));
				$this->permission = array("hrfzligs" => array("select" => array("public")));
			}
		);
		$this->listen(array(
			"max" => 3,
			"url" => array("teams")
			), 
			function() {
				save(array("hefzlig","teams"));
				$this->permission = array("hrfzligs" => array("insert" => array("public"), "update" => array("public")));
			}
		);

		

		
	}

}
?>