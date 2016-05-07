<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {

	public function sql_branch_name($branch_id) {
		return $this->sql()->tableBranch()->whereId($branch_id)->limit(1)->select()->assoc("name");
	}

	public function post_settings() {
		unset($_SESSION['user']['branch']['active']);
		$_SESSION['user']['branch']['active'] = array();
		foreach ($_POST as $key => $value) {
			// var_dump($key);	
			if(preg_match("/^branch_(\d+)$/", $key, $branch_id)) {			
				$_SESSION['user']['branch']['active'][] = $branch_id[1];
			}	
		}
		// print_r($_SESSION);
		// exit();
	}
}
?>