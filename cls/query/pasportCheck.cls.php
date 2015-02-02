<?php

class query_pasportCheck_cls extends query_cls {
	public function config($usersid) {
		$person = $this->sql()->tablePerson()->whereUsers_id($usersid)
					->fieldPasport_date()
					->fieldNationality()->limit(1)->select()
					->assoc();
		
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