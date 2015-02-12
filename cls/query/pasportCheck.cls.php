<?php

class query_pasportCheck_cls extends query_cls {
	public function config($usersid) {
		ini_set('xdebug.var_display_max_depth', -1);
		ini_set('xdebug.var_display_max_children', -1);
		ini_set('xdebug.var_display_max_data', -1);
		var_dump("expression");
		$person = $this->sql()->tablePerson()->whereUsers_id($usersid)
					->fieldPasport_date()
					->fieldNationality()->limit(1)->select();

					var_dump($person);exit();
		
		$jtime =  new jTime_lib;
		$dateNow =  $jtime->date("Ymd", false, false);
		// var_dump($dateNow);

		if($person['nationality'] != 97 && $dateNow > $person['pasport_date'] && !global_cls::superperson()) {
			return false;
		}
		return true;
	}
}
?>1