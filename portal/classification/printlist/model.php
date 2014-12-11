<?php
/**
* @author reza mohiti rm.biqarar@gmail.com 
*/
class model extends main_model {

	public function sql_classes_list($classes_id = false) {
		return $this->sql()->tableClassification()->whereClasses_id($classes_id)->fieldUsers_id()->select()->allAssoc();
	}

	public function sql_classes_detail($classes_id = false) {
		return $this->sql()->tableClasses()->whereId($classes_id)->limit(1)->select()->assco();
	}

}
?>