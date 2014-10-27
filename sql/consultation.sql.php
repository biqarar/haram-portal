<?php
namespace sql;
/**
* reza mohiti
*/
class consultation {

	public $id        = array('type'=> 'int@10', 'autoI', 'label' => 'consultation_id');
	public $group     = array('type' => 'enum@level,consultation,exam!level', 'label' => 'consultation_group');
	public $name      = array('type' => 'varchar@64' , 'label' => 'consultation_name');
	public $expert    = array('type' => 'int@10', 'label' => 'group_expert_id');
	public $branch_id = array('type' => 'int@10', 'label'=> 'branch_id');
	
	public $unique    = array("id");
	public $foreign   = array("expert" => "group_expert@id!users_id", "branch_id" => "branch@id!name");
	
	public function id() {
		$this->validate("id");
	}
	
	public function group() {
		$this->form("select")->name("group")->label("consultation_group");
		$this->setChild($this->form);
	}
	
	public function name() {
		$this->form("#fatext")->name("name")->label("consultation_name");
		$this->validate()->farsi(3,64);
	}
	
	public function expert() {
		$this->form("select")->name("expert")->label("group_expert_id");
		$this->setChild();
	}
	
	public function branch_id() {
		$this->form("select")->name("branch_id")->label("branch_id");
		$this->setChild();
	}
}
?>