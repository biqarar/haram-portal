<?php
/**
* @author reza mohiti
*/
namespace sql;
class presence {

	public $id     = array('type'=> 'int@10', 'autoI', 'label' => 'branch_id');
	public $classification_id   = array('type'=> 'int@10', 'label' => 'classification_id');
	public $date   = array('type'=> 'int@8', 'label' => 'date');
	public $status = array('type'=> 'enum@presence,absence!absence');
	
	public function id() {
		$this->validate("id");
	}

	public function classification_id() {
	
		// $this->validate()->farsi()->form->farsi("branch name must be persian");
	}

	public function date() {
		// $this->validate()->number(1, 3);
	}

	public function status() {
		// $this->form("select")->name("gender")->label("gender");
		// $this->setChild($this->form);
	}
}

?>