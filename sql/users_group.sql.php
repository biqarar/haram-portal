<?php
namespace sql;
class users_group {
	public $id            = array('type'=> 'int@10', 'label' => 'users_group_id');
	public $group_list_id = array('type'=> 'int@10', 'label' => 'group_list_id');
	public $users_id      = array('type'=> 'int@10', 'label' => 'users_id');

	public $unique = array("users");
	public $foreign = array("group_list_id" => "group_list@id!name",
						"users_id" => "users@id!id");
	public function id() {
		$this->validate("id");
	}

	public function group_list_id() {
		$this->form("select")->name("group_list_id");
		$this->setChild();
	}

	public function users_id() {
		$this->form("select")->name("users_id");
		$this->setChild();
	}
}
?>