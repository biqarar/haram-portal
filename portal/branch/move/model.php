<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {
	public function post_branch_move() {
		// $sql = $this->sql()->tableUsers()->whereUsername(post::username());
		var_dump(post::username());exit();
		var_dump($_POST);
		exit();

	}
}
?>