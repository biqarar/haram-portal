<?php
namespace sql;
class prerequisite {
	public $id           = array('type'=> 'int@10', 'autoI', 'label' => 'prerequisite_id');
	public $plan_id      = array('type'=> 'int@10', 'label' => 'plan_id');
	public $prerequisite = array('type'=> 'int@10', 'label' => 'prerequisite_prerequisite');

	public $unique = array("plan");
	public $foreign = array("plan_id" => "plan@id!name", "prerequisite" => "plan@id!name");

	public function id() {
		$this->validate("id");
	}

	public function plan_id() {
		$this->form("select")->name("plan_id");
		$this->setChild();
	}

	public function prerequisite() {
		$this->form("select")->name("prerequisite");
		$this->setChild();
	}
}
?>