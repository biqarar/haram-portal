<?php
namespace sql;
/**
* reza mohiti
*/
class pending_classes {

	public $id          = array('type'=> 'int@10', 'autoI', 'label' => 'pending_classes_id');
	public $users_id    = array('type'=> 'int@10', 'label' => 'users_id');
	public $classes_id  = array('type' => 'int@10' , 'label' => 'classes_id');
	public $date        = array('type' => 'int@8', 'label' => 'pending_classes_date');
	public $description = array('type' => 'varchar@255', 'label' => 'pending_classes_description');
	
	public $unique      = array("users");
	public $foreign     = array("users_id" => "users@id!id", "classes_id" => "classes@id!name");

	public function id() {
		$this->validate("id");
	}

	public function users_id() {
		// $this->form("select")->name("users_id");
		// $this->setChild($this->form);
	}

	public function classes_id() {
		$this->form("select")->name("classes_id");
		$this->setChild($this->form);
	}

	public function date() {
		// $this->form("#date")->name("date");
	}

	public function description() {
		$this->form("#text_desc");
	}
}
?>