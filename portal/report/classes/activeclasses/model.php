<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
	public function sql_activeclasses() {
		$list = $this->sql()->tableClasses()->whereStatus("running");
		$list->joinClassification()->whereClasses_id("#classes.id");
		$list->joinBridge()->whereUsers_id("#classification.users_id")->andTitle("mobile");
		$list->joinBranch_cash()->whereTable("bridge")->andRecord_id("#bridge.id")->andBranch_id(1);
		$list = $list->select()->allAssoc();
		$all = array();
		foreach ($list as $key => $value) {
			$all[][] = $value['value'];
		}
		return $all;
	}
	public function post_report(){
	
	}	
}
?>