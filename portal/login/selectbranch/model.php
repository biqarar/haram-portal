<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {

	public function post_selectbranch() {
		$branch_id = false;
		if(post::logout()) {
			$this->redirect("logout");
		}else{
			foreach ($_POST as $key => $value) {
				if(preg_match("/^selectbranch\_(\d+)$/", $key, $c)){
					$branch_id = $this->sql(".branch.check", $c[1]);
					break;
				}
			}
			if($branch_id) {
				$_SESSION['user']['branch']['selected'][] = $branch_id;
				// var_dump($_SESSION);exit();
				$this->sql(".login", $this->login("id"));
				$this->redirect("profile");
			}else{
				page_lib::access("branch error");
			}

		}

	}
}
?>