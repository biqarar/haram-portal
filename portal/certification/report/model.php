<?php 

/**
* @auther reza mohiti
*/
class model extends main_model {
	public function sql_reportCertification($type = false) {
		
		$reprot = $this->sql()->tableCertification()->fieldId()->fieldDate_request()->fieldDate_print()->fieldDate_deliver();
		$reprot->joinClassification()->whereId("#certification.classification_id")->fieldMark();
		$reprot->joinPerson()->whereUsers_id("#classification.users_id")
		->fieldName()
		->fieldFamily()
		->fieldFather()
		->fieldBirthday()
		->fieldGender()
		->fieldNationality()
		->fieldFrom()
		->fieldNationalcode();
		$reprot->joinUsers()->whereId("#classification.users_id")->fieldUsername();
		// $reprot->joinCity()->whereId("#person.from")->fieldName("city");
		// $reprot->joinCountry()->whereId("#person.nationality")->fieldName("country");
		if($type == "print") {
			$reprot->whereDate_print("is", "#null");
		}elseif($type == "request"){
			$reprot->whereDate_print("is", "#null")->andDate_deliver("is", "#null");
		}elseif($type == "all"){
			// all 
		}elseif($type == "deliver"){
			$reprot->whereDate_deliver("is", "#null");
		}
		// echo "string";($reprot->select()->string());exit();
		$reprot = $reprot->select()->allAssoc();
		foreach ($reprot as $key => $value) {
			if($value['nationality'] != "") {
				$reprot[$key]['nationality'] = $this->sql()->tableCountry()->whereId($value['nationality'])->limit(1)->select()->assoc("name");
			}
			if($value['from'] != "") {
				$reprot[$key]['from'] = $this->sql()->tableCity()->whereId($value['from'])->limit(1)->select()->assoc("name");
			}
		}
		// var_dump($reprot);exit();
		return $reprot;

	}
}
?>