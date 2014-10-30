<?php 
/**
* 
*/
class model extends main_model
{
	public function post_list() {
		//------------------------------ get text search from url
		$nameFamily = config_lib::$aurl[2];
		if(preg_match("/\s{2}/",$nameFamily)){
			$n = preg_split("/\s{2}/", $nameFamily);
			$name = $n[0];
			$family = $n[1];	
			$q = $this->sql()->tablePerson()->likeName("%".$name."%")
			->andlikeFamily("%".$family."%")
			->limit(700)
			->fieldId()
			->fieldName()
			->fieldFamily()
			->fieldFather()
			->select();
		}else{
			$q = $this->sql()->tablePerson()->likeName("%".$nameFamily."%")
			->orlikeFamily("%".$nameFamily."%")
			->limit(700)
			->fieldId()
			->fieldName()
			->fieldFamily()
			->fieldFather()
			->select();
		}

		// 	WHERE concat(name, ' ', family , ' ' , father)
		// 	LIKE '%$nameFamily%'


		debug_lib::msg("person", $q->allAssoc());
	}
}
?>