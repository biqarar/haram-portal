<?php
/**
* @author reza mohiti
*/
namespace sql;
class hefz_group {

	public $id = array("type" => "int@10",'autoI', "label" => "hefz_ligs_id");
	public $lig_id = array("type" =>"int@10", "label" => "hefz_teams_lig_id");
	public $name = array("type" => "varchar@255", "label" => "hefz_ligs_name");
	public $descripiton = array("type" => "text@", "label" => "hefz_ligs_name");


	public function id() {
		$this->validate("id");
	}
	
	public function lig_id(){
		$this->form("select")->name("lig_id")->addClass("notselect")->required();
		$this->setChild(function($q){
			
			// if(!isset($_SESSION['supervisor'])){

				$list = isset($_SESSION['user']['branch']['selected']) ? 
							  $_SESSION['user']['branch']['selected'] : array();
				
				// if(global_cls::supervisor()) exit();
							  // var_dump($_SESSION);exit();
				$q->groupOpen();
				foreach ($list as $key => $value) {
					if($key == 0){
						$q->condition("where", "hefz_ligs.branch_id","=",$value);
					}else{
						$q->condition("or","hefz_ligs.branch_id","=",$value);
					}
				}	
				$q->groupClose();

			// }
		});
	}
	

	

	public function start_date() {
		$this->form("#date")->name("start_date")->required();
		$this->validate()->date()->form->date("start date is not valid");
		// $this->validate()->;
	}

	public function end_date() {
		$this->form("#date")->name("end_date")->required();
		$this->validate()->date()->form->date("end date is not valid");
		// $this->validate()->number(1, 3);
	}


	public function branch_id() {
		
	}
}

?>