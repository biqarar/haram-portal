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

		$oldcertification = $this->sql()->tableOldcertification()->select()->allAssoc();
		  foreach ($oldcertification as $key => $value) {
                    $x = $this->sql()->tableBranch_cash()->setTable("oldcertification")->setRecord_id($value['id'])
                    ->setBranch_id($value['branch'])
                    ->insert()->LAST_INSERT_ID();
            }
		$q = $sql->query("COMMIT");

							
		// die(":( THE CODE DIE :(");

		$oldclasses = $this->sql()->tableOldclasses()->select()->allAssoc();
		// $oldclassification = $this->sql()->tableOldclassification()->select()->allAssoc();

        foreach ($oldclasses as $key => $value) {
                    $x = $this->sql()->tableBranch_cash()->setTable("oldclasses")->setRecord_id($value['id'])
                    ->setBranch_id($value['branch'])
                    ->insert()->LAST_INSERT_ID();
            }
		$q = $sql->query("COMMIT");
		
		// die(":( THE CODE DIE :(");
		$oldclassification = $this->sql()->tableOldclassification()->select()->allAssoc();
            foreach ($oldclassification as $key => $value) {
            	$x = $this->sql()->tableBranch_cash()->setTable("oldclassification")->setRecord_id($value['id'])
                    ->setBranch_id($value['branch'])
                    ->insert()->LAST_INSERT_ID();
            }
		$q = $sql->query("COMMIT");
		

		// die(":( THE CODE DIE :(");
		// $oldprice = $this->sql()->tableOldprice()->select()->allAssoc();
		 $all =  $this->sql()->tableOldprice()->select()->allAssoc();
                foreach ($all as $key => $value) {
                        $x = $this->sql()->tableBranch_cash()->setTable("oldprice")->setRecord_id($value['id'])
                        ->setBranch_id($value['branch'])
                        ->insert()->LAST_INSERT_ID();
                }
		$q = $sql->query("COMMIT");
		

		// die(":( THE CODE DIE :(");
		$student = $this->sql()->tableStudent()->select()->allAssoc();
		$all =  $this->sql()->tableStudent()->select()->allAssoc();
		foreach ($all as $key => $value) {
			$x = $this->sql()->tableBranch_cash()->setTable("student")->setRecord_id($value['id'])->setBranch_id($value['branch'])
			->insert()->LAST_INSERT_ID();
		}
		$q = $sql->query("COMMIT");
		
		die(":( THE CODE DIE :(");
			
	}
}
?>