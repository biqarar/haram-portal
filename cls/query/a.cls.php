<?php
class query_a_cls extends query_cls
{
	public function config(){
		// var_dump($_SESSION);
		if(isset($_SESSION['users_branch'])){
			$listBranch = $this->sql()->tableBranch();
			foreach ($_SESSION["users_branch"] as $key => $value) {
				$listBranch->orId($value);
			}
			$listBranch = $listBranch->limit(count($_SESSION["users_branch"]))->select();
			// var_dump($listBranch);
			return $listBranch->allAssoc();	
		}else{
			return array();
		}
		
	}
}
?>