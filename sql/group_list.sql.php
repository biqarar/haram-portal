<?php
namespace sql;
class group_list {
	public $id          = array('type'=> 'int@10', 'label' => 'group_list_id');
	public $name        = array('type'=> 'varchar@64', 'label' => 'group_list_name');
	public $description = array('type'=> 'text@', 'label' => 'group_list_description');
	public $expert      = array('type'=> 'int@10', 'label' => 'group_list_expert');
	public $status      = array('type'=> 'enum@active,inactive!inactive', 'label' => 'group_list_status');

	public $foreign = array("expert" => "group_expert@id!users_id");

	public function id() {
		$this->validate("id");
	}
	
	public function name() {
		$this->form("#fatext")->name("name");
		$this->validate()->farsi(3, 64);
	}
	
	public function description() {
		$this->form("#text_desc")->name("description");
	}
	
	public function expert() {
		$this->form("select")->name("expert");
		$this->setChild();
	}
	
	public function status() {
		$this->form("select")->name("status");
		$this->setChild($this->form);
			
	}
}
?>