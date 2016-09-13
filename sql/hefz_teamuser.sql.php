<?php
/**
* @author reza mohiti
*/
namespace sql;
class hefz_teamuser {

	public $id = array("type" => "int@10",'autoI', "label" => "hefz_ligs_id");
		public $hefz_team_id = array('type'=> 'int@8', 'label' => 'hefz_ligs_start_date');
	public $users_id   = array('type'=> 'int@8', 'label' => 'hefz_ligs_end_date');


	public function id() {
		$this->validate("id");
	}

	public function hefz_team_id() {
		// $this->form("#fatext")->name("name")->required();
		// $this->validate()->farsi()->form->farsi("ligs name must be persian");
	}

	public function users_id() {
		// $this->form("#date")->name("start_date")->required();
		// $this->validate()->date()->form->date("start date is not valid");
		// $this->validate()->;
	}


}

?>