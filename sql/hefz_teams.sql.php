<?php
/**
* @author reza mohiti
*/
namespace sql;
class hefz_teams {
	public $id = array("type" =>"int@10", "label" => "hefz_teams_id");
	public $lig_id = array("type" =>"int@10", "label" => "hefz_teams_lig_id");
	public $grupname = array("type" =>"int@10", "label" => "hefz_teams_groupname");
	public $name = array("type" =>"varchar@255", "label" => "hefz_teams_name");
	public $min_person = array("type" =>"int@5", "label" => "hefz_teams_min_person");
	public $max_person = array("type" =>"int@5", "label" => "hefz_teams_max_person");
	public $hefz = array("type" =>"text@", "label" => "hefz_teams_hefz");
	public $teacher = array("type" =>"int@10", "label" => "hefz_teams_teacher");

	public $foreign = array("lig_id" => "hefz_ligs@id!name", "groupname" => "hefz_group@id!name");


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

	public function name() {
		$this->form("#fatext")->name("name")->required();
		$this->validate()->farsi()->form->farsi("teams name must be persian");
	}

	public function min_person() {
		$this->form("#number")->name("min_person");
		$this->validate()->number(1, 3)->form->number("minimum persons number is not valid");
	}
	
	public function max_person() {
		$this->form("#number")->name("max_person");
		$this->validate()->number(1, 4)->form->number("maximum persons number is not valid");
	}

	public function teacher(){
		 $this->form("text")->name("teacher")->required()->id("teachername")->addClass("select-teacher")->data_url("teacher/api/");
	}

	public function hefz() {
		$this->form("text")->name("hefz");
		$this->validate()->description()->form->description("hefz must be between 3 and 255 charset");
	}
}

?>