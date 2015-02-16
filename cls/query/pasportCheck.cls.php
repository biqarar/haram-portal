<?php

class query_pasportCheck_cls extends query_cls {
	public function config($usersid) {

		$person = $this->sql()->tablePerson()->limit(10)->whereUsers_id($usersid)
					->select();

					var_dump($person->string());exit();
		

		$dateNow = $this->dateNow("Ymd");
		var_dump($dateNow);

		if($person['nationality'] != 97 && $dateNow > $person['pasport_date'] && !global_cls::superperson()) {
			return false;
		}
		return true;
	}
}
?>1