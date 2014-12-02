<?php 
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class model extends main_model{
	
	public function sql_admin() {
		die(":( THE CODE DIE :(");
		$sql = new dbconnection_lib;
		set_time_limit(3000);
		ini_set('memory_limit', '-1');

		 $all =  $this->sql()->tableOldprice()->select()->allAssoc();
                foreach ($all as $key => $value) {
                        $x = $this->sql()->tableBranch_cash()->setTable("oldprice")->setRecord_id($value['id'])
                        ->setBranch_id($value['branch'])
                        ->insert()->LAST_INSERT_ID();
                }
		$q = $sql->query("COMMIT");
		

		die(":( THE CODE DIE :(");
		
		$all =  $this->sql()->tableStudent1()->select()->allAssoc();
		foreach ($all as $key => $value) {
			$x = $this->sql()->tableBranch_cash()->setTable("student1")->setRecord_id($value['id'])->setBranch_id($value['branch'])
			->insert()->LAST_INSERT_ID();
		}
		$q = $sql->query("COMMIT");
		die(":( THE CODE DIE :(");
			
	}
}
?>