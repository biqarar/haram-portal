<?php
/**
* @author reza mohiti
*/
namespace sql;
class presence_classes {

	public $id     = array('type'=> 'int@10', 'autoI', 'label' => 'branch_id');
	public $classes_id   = array('type'=> 'int@10', 'label' => 'classes_id');
	public $start_time   = array('type'=> 'int@8', 'label' => 'start_time');
	public $date   = array('type'=> 'int@8', 'label' => 'date');
	public $end_time = array('type'=> 'enum@presence,absence!absence');
	
	public function id() {
		$this->validate("id");
	}

	public function classes_id() {
	
		// $this->validate()->farsi()->form->farsi("branch name must be persian");
	}

	public function start_time() {
		// $this->validate()->number(1, 3);
	}

	public function date() {
		// $this->validate()->number(1, 3);
	}

	public function end_time() {
		// $this->form("select")->name("gender")->label("gender");
		// $this->setChild($this->form);
	}
}

?>