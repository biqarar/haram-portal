<?php
namespace sql;
class teachinghistory {
	public $id       = array('type'=> 'int@10', 'autoI', 'label' => 'teachinghistory_id');
	public $users_id = array('type'=> 'int@10', 'label' => 'users_id');
	public $field    = array('type'=> 'varchar@64', 'label' => 'teachinghistory_field');
	public $club     = array('type'=> 'varchar@64', 'label' => 'teachinghistory_club');
	public $length   = array('type'=> 'enum@less than one year,between one and two years,between two and five years,more than five years!less than one year', 'label' => 'teachinghistory_lenght');

	public $unique = array("id");
	public $index = array("users_id");

	public $foreign = array("users_id" => "users@id!id");

	public function id() {
		$this->validate("id");
	}
	
	public function users_id() {
		$this->form("select")->name("users_id");
		$this->setChild();
	}
	
	public function field() {
		$this->form("#fatext")->name("field");
	}
	
	public function club() {
		$this->form("#fatext")->name("club");
	}
	
	public function length() {
		$this->form("select")->name("length");
		$this->setChild($this->form);
	}
}
?>