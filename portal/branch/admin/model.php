<?php 
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class model extends main_model{
	
	public function sql_admin() {
		$sql = new dbconnection_lib;
		set_time_limit(30000);
		ini_set('memory_limit', '-1');
		die(":( THE CODE DIE :(");
		$perso = $this->sql()->tablePerson()->select()->allAssoc();
		foreach ($perso as $key => $value) {
			if(
				preg_match("/(^\s+)|(\s+$)/", $value['name']) || 
				preg_match("/(^\s+)|(\s+$)/", $value['family']) || 
				preg_match("/(^\s+)|(\s+$)/", $value['father'])

				){

			$new_name = preg_replace("/(^\s+)|(\s+$)/", "", $value['name']);
			$new_family = preg_replace("/(^\s+)|(\s+$)/", "", $value['family']);
			$new_father = preg_replace("/(^\s+)|(\s+$)/", "", $value['father']);
				var_dump($value['id']);
			// exit();
			$x =$this->sql()->tablePerson()->setName($new_name)->setFamily($new_family)->setFather($new_father)
				->whereId($value['id'])
				->update();
				// var_dump($x);
				// exit();
		$q = $sql->query("COMMIT");	
			}

		}

		$province = $this->sql()->tableProvince()->select()->allAssoc();
		foreach ($province as $key => $value) {
			$this->sql()->tableProvince()
			->setName($value['name'])
			->whereId($value['id'])
			->update();
		}
		$city = $this->sql()->tableCity()->select()->allAssoc();
		foreach ($city as $key => $value) {
			$this->sql()->tableCity()
			->setName($value['name'])
			->whereId($value['id'])
			->update();
		}
		$q = $sql->query("COMMIT");

		$person = $this->sql()->tablePerson()->whereType("operator")->select()->allAssoc() ; 
		  foreach ($person as $key => $value) {
                    $x = $this->sql()->tableUsers()->setType("operator")->whereId($value['users_id'])->update();
            }
		$q = $sql->query("COMMIT");
		
		$person = $this->sql()->tablePerson()->whereType("teacher")->select()->allAssoc();
		  foreach ($person as $key => $value) {
                    $x = $this->sql()->tableUsers()->setType("teacher")->whereId($value['users_id'])->update();
            }

		die(":( THE CODE DIE :( END OF FUNCTION :(");
			
	}
}
?>