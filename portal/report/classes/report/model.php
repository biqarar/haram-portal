<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
	public function sql_list($classesid = false) {
		$classes_id = preg_split("/\,/", $classesid);
		// $all = array();
		$all = "<table border='1'>";
		foreach ($classes_id as $key => $value) {
			$all .= $this->list_number($value);
			
		}
		$all .= "</table>";
		return $all;
	}
	public function post_report(){
		// var_dump(config_lib::$surl);exit();
		echo "<table border='1'>";
		foreach ($_POST['list'] as $key => $value) {
			// var_dump($key, $value);
			if($value == "ok") {
				$this->list_number($key);
			}
		}
		echo "</table>";
		exit();
	}	

	public function list_number($classes_id){
		$classification = $this->sql()->tableClassification()->whereClasses_id($classes_id)->fieldId("classificationid");
		$classification->joinBridge()->whereUsers_id("#classification.users_id")->andTitle("mobile")->fieldValue();
		$classification->joinClasses()->whereId("#classification.classes_id");
		$c = $classification->select()->allAssoc("value");
		$ret = "";
		foreach ($c as $key => $value) {
			$ret .= "<tr><td>" . $value . "</td></tr>";
		}

		return $ret;
	}
}
?>