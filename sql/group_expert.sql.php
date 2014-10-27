<?php
namespace sql;
class group_expert {
	public $id         = array('type'=> 'int@10', 'label' => 'group_expert_id');
	public $position_id   = array('type'=> 'int@10', 'label' => 'position_id');
	public $users_id   = array('type'=> 'int@10', 'label' => 'users_id');
	public $group_id   = array('type'=> 'int@10', 'label' => 'group_id');
	public $start_date = array('type'=> 'int@10', 'label' => 'group_expert_start_date');
	public $end_date   = array('type'=> 'int@10', 'label' => 'group_expert_end_date');
	public $status     = array('type'=> 'enum@responsible,expert!expert', 'label' => 'group_expert_status');

	public $unique = array("position");
	public $index = array("users_id", "group_id");

	public $foreign = array("position_id" => "position@id!position", "users_id"=>"users@id!id", "group_id"=> "group@id!name");

	public function id() {
		$this->validate("id");
	}

	public function position_id() {
		$this->form("select")->name("position_id");
		$this->setChild();
		$this->validate("id");
	}
	public function users_id() {
		$this->form("select")->name("users_id");
		$this->setChild();
		$this->validate("id");
	}
	public function group_id() {
		$this->form("select")->name("group_id");
		$this->setChild();
		$this->validate("id");
	}
	public function start_date() {
		$this->form("#date")->name("start_date");
	}
	public function end_date() {
		$this->form("#date")->name("end_date");

	}
	public function status() {
		$this->form("select")->name("status");
		$this->setChild($this->form);
	}

}
?>