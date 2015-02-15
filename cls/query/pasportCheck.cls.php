<?php

class query_pasportCheck_cls extends query_cls {
	public function config($usersid) {
		ini_set('xdebug.var_display_max_depth', -1);
		ini_set('xdebug.var_display_max_children', -1);
		ini_set('xdebug.var_display_max_data', -1);
		
		$person = $this->sql()->tablePerson()->whereUsers_id($usersid)
					->select();

					var_dump($person , $person->string());exit();
		

		$dateNow = $this->dateNow("Ymd");
		var_dump($dateNow);

		if($person['nationality'] != 97 && $dateNow > $person['pasport_date'] && !global_cls::superperson()) {
			return false;
		}
		return true;
	}
}
?>1