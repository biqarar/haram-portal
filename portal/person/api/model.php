<?php 
/**
* 
*/
class model extends main_model
{
	public function post_list() {
		$nameFamily = config_lib::$aurl[2];
		if(preg_match("/\s{2}/",$nameFamily)){
			$n = preg_split("/\s{2}/", $nameFamily);
			// var_dump($n);
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
		
		
		// $sql = new dbconnection_lib;
		// $q = $sql->query("SELECT person.name,person.father, person.family, person.id, users.username FROM person
		// 	INNER JOIN users ON person.users_id = users.id
		// 	WHERE concat(name, ' ', family , ' ' , father)
		// 	LIKE '%$nameFamily%'
		// 	-- ORDER BY name,family ASC
		// 	-- LIMIT 0 , 10  
		// 	INNER JOIN branch_cash ON `branch_cash`.table = 'person'  AND `branch_cash`.branch_id = 1 
		// 	-- and branch_cash.branch_id = 0
		// 	  " );
		// SELECT `person`.*, `branch_cash`.id FROM `person` INNER JOIN branch_cash ON `branch_cash`.table = 'person' AND `branch_cash`.record_id = person.id AND(`branch_cash`.branch_id = 1 )
		// $nameFamily = "علي";
		// $q = $sql->query("SELECT name,father,family,id FROM person
			// WHERE concat(name, ' ', family , ' ' , father)
			// LIKE '%$nameFamily%'
			// ORDER BY name,family ASC
			// LIMIT 0 , 10 " );
		// $q = $sql->query("SELECT name,father,family,id FROM person
			// WHERE family
			// LIKE ('%$nameFamily%')
			// ORDER BY name,family ASC
			// LIMIT 0 , 10 " );

		// $q = $this->sql()->tablePerson()->likeName("%".$nameFamily."%")
		// ->orlikeFamily("%".$nameFamily."%")
		// ->limit(7)
		// ->fieldId()
		// ->fieldName()
		// ->fieldFamily()
		// ->fieldFather()
		// ->select();
		// var_dump($q->string());
		// var_dump($q->num());
		// var_dump($q->allAssoc());
		// exit();
		debug_lib::msg("person", $q->allAssoc());
	}
}
?>