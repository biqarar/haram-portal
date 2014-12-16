<?php 
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class model extends main_model{
	
	public function sql_admin() {
		$sql = new dbconnection_lib;
		set_time_limit(30000);
		ini_set('memory_limit', '-1');
		
		// die(":( THE CODE DIE :(");
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

		$person = $this->sql()->tablePerson()->whereType("operator")->select()->allAssoc();
		  foreach ($person as $key => $value) {
                    $x = $this->sql()->tableUsers()->setType("operator")->whereId($value['users_id'])->update();
            }
		$q = $sql->query("COMMIT");
		
		$person = $this->sql()->tablePerson()->whereType("teacher")->select()->allAssoc();
		  foreach ($person as $key => $value) {
                    $x = $this->sql()->tableUsers()->setType("teacher")->whereId($value['users_id'])->update();
            }


		

		
		die(":( THE CODE DIE :(");
			
	}
}
?>