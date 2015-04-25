<?php
class query_a_cls extends query_cls
{
	public function config(){
		// var_dump($_SESSION);
		if(isset($_SESSION['users_branch'])){
			$listBranch = $this->sql()->tableBranch();
			if(!global_cls::supervisor()){
				foreach ($_SESSION["users_branch"] as $key => $value) {
					$listBranch->orId($value);
				}
				$listBranch->limit(count($_SESSION["users_branch"]));
			}
			// var_dump($listBranch);
			$listBranch = $listBranch->select();
			return $listBranch->allAssoc();	
		}else{
			return array();
		}
		
	}
}
?>