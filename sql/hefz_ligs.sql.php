<?php
/**
* @author reza mohiti
*/
namespace sql;
class hefz_ligs {

	public $id = array("type" => "int@10",'autoI', "label" => "hefz_ligs_id");
		public $start_date = array('type'=> 'int@8', 'label' => 'hefz_ligs_start_date');
	public $end_date   = array('type'=> 'int@8', 'label' => 'hefz_ligs_end_date');
	public $name = array("type" => "varchar@255", "label" => "hefz_ligs_name");
	public $branch_id = array("type" => "int@10", "label" => "hefz_ligs_branch_id");


	public function id() {
		$this->validate("id");
	}

	public function name() {
		$this->form("#fatext")->name("name")->required();
		$this->validate()->farsi()->form->farsi("ligs name must be persian");
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