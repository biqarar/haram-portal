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
		
			if(post::select_branch()){
		
				$branch_id = $this->sql(".branch.check", post::select_branch());
			}
		
			if($branch_id && $branch_id != null) {
		
				$_SESSION['user']['branch'] = array();
		
				$_SESSION['user']['branch']['selected'][] = $branch_id;

				$this->sql(".login", $this->login("id"));

				$this->redirect("profile");
			
			}else{
				$this->redirect("login");
				// page_lib::access("branch error");
			
			}

		}

	}
}
?>