<?php
namespace sql;
class graduate {
	public $id       = array('type'=> 'int@10', 'label' => 'graduate_id');
	public $users_id = array('type'=> 'int@10', 'label' => 'users_id');
	public $status   = array('type'=> 'enum@checking,active,inactive!checking', 'label' => 'graduate_status');

	public $unique = array("users_id");
	public $foreign = array("users_id" => "users@id!id");

	public function id() {
		$this->validate("id");
	}

	public function users_id() {
		$this->form("select")->name("users_id");
		$this->setChild();
	}

	public function status() {
		$this->form("select")->name("status");
		$this->setChild($this->form);
	}
}
?>