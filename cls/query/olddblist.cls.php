<?php 
class query_olddblist_cls extends query_cls {
	public function config($table, $id) {
		$field = false;
		switch ($table) {
			case 'student':
				$field = "name1";
				break;
			case 'oldcertification':
			case 'oldclassification':
			case 'oldprice':
				$field = "parvande";
				break;
			case 'oldclasses':
				$field = "code";
				break;
		}

		$query = $this->db("SELECT * FROM  `quran_hadith_old`.`$table` WHERE `$field` LIKE '$id'");

		$return  = array();
		$return['header'] = $query->fieldNames();
		foreach ($return['header'] as $key => $value) {
			$return['header'][$key] = _($value);
		}

		$return['list'] = $query->allAssoc();
		return $return;
		
	}
}


?>