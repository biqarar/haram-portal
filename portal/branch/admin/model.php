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
					
		$oldclasses = $this->sql()->tableOldclasses()->select()->allAssoc();
		$oldclassification = $this->sql()->tableOldclassification()->select()->allAssoc();

        foreach ($oldclasses as $key => $value) {
                    $x = $this->sql()->tableBranch_cash()->setTable("oldclasses")->setRecord_id($value['id'])
                    ->setBranch_id($value['branch'])
                    ->insert()->LAST_INSERT_ID();
            }
		$q = $sql->query("COMMIT");
		
		die(":( THE CODE DIE :(");

            foreach ($oldclassification as $key => $value) {
            	$x = $this->sql()->tableBranch_cash()->setTable("oldclassification")->setRecord_id($value['id'])
                    ->setBranch_id($value['branch'])
                    ->insert()->LAST_INSERT_ID();
            }
		$q = $sql->query("COMMIT");
		

		die(":( THE CODE DIE :(");

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