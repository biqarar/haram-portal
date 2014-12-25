<?php 
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class model extends main_model{
	
	public function sql_admin() {
		$sql = new dbconnection_lib;
		set_time_limit(30000);
		ini_set('memory_limit', '-1');
		




		$this->db_version();









		die(":( THE CODE DIE :(");
		
		$classes = $this->sql()->tableClasses()->select()->allAssoc();
		foreach ($classes as $key => $value) {
			$this->sql(".classesCount", $value['id']);
			$q = $sql->query("COMMIT");	
		}

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
			$x =$this->sql()->tablePerson()->setName($new_name)->setFamily($new_family)->setFather($new_father)
				->whereId($value['id'])
				->update();
				$q = $sql->query("COMMIT");	
			}
		}

		$province = $this->sql()->tableProvince()->select()->allAssoc();
		foreach ($province as $key => $value) {
			$this->sql()->tableProvince()
			->setName($value['name'])
			->whereId($value['id'])
			->update();
			$q = $sql->query("COMMIT");

		}
		$city = $this->sql()->tableCity()->select()->allAssoc();
		foreach ($city as $key => $value) {
			$this->sql()->tableCity()
			->setName($value['name'])
			->whereId($value['id'])
			->update();
			$q = $sql->query("COMMIT");
		}
		$q = $sql->query("COMMIT");

		$person = $this->sql()->tablePerson()->whereType("operator")->select()->allAssoc() ; 
		  foreach ($person as $key => $value) {
                    $x = $this->sql()->tableUsers()->setType("operator")->whereId($value['users_id'])->update();
                    $q = $sql->query("COMMIT");
            }
		$q = $sql->query("COMMIT");
		
		$person = $this->sql()->tablePerson()->whereType("teacher")->select()->allAssoc();
		  foreach ($person as $key => $value) {
                    $x = $this->sql()->tableUsers()->setType("teacher")->whereId($value['users_id'])->update();
                    $q = $sql->query("COMMIT");
            }

		die(":( THE CODE DIE :( END OF FUNCTION :(");
			
	}

	public function db_version() {
		$sql = new dbconnection_lib;
		set_time_limit(30000);
		ini_set('memory_limit', '-1');

		$version2 = array(
			"ALTER TABLE `classes` DROP FOREIGN KEY `classes_ibfk_2`",
			""
			"fuck"
		);

		$error = 0;
		foreach ($version2 as $key => $value) {
			$s = $sql->query($value);
			var_dump($value, $sql->result);
			if(!$sql->result){
				$error++;
			}
		}

		echo "done.  Database set on version 2.0 
			<br> by ( $error ) error";
		exit();
	}
}
?>