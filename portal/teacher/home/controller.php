<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
class controller extends main_controller{
	public $access = false;

	function config(){
		$users_id = isset($_SESSION['users_id']) ? $_SESSION['users_id'] : 0;
		$surl = config_lib::$surl;

		// $url_id = isset($surl['id']) ? $surl['id'] : (isset($surl['usersid'])) ? $surl['usersid'] : 0 ; 
		$url_id = 13998;
		if(
			isset($_SESSION['users_type']) && 
			$_SESSION['users_type'] == 'teacher' &&
			($url_id == $users_id)) {

			$this->access = true;
		}

		$this->listen(
				array(
					"max" => 3,
					'url' => array("bridge", "status" => "add", "usersid" => $users_id)
					),
				function(){
					save(array("teacher", "bridge"));
				}
			);
	}
}
?>