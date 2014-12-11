<?php
namespace sql;
class permission {
	public $id        = array('type'=> 'int@10', 'autoI', 'label' => 'permission_id');
	public $tables = array('type'=> 'varchar@64', 'label' => 'permission_tables');
	public $users_id  = array('type'=> 'int@10', 'label' => 'users_id');
	public $select    = array('type'=> 'enum@private,public!private', 'label' => 'permission_select');
	public $update    = array('type'=> 'enum@private,public!private', 'label' => 'permission_update');
	public $insert    = array('type'=> 'enum@private,public!private', 'label' => 'permission_insert');
	public $delete    = array('type'=> 'enum@private,public!private', 'label' => 'permission_delete');

	public $unique = array("table");
	public $foreign = array("users_id" => "users@id!id");
	public $index	= array("users_id");

	public function id() {
		$this->validate("id");
	}
	
	public function tables() {
		$this->form("select")->name("tables");
	}
	
	public function users_id() {
		$this->form("text")->name("users_id");
		// $this->setChild();
	}
	
	public function select() {
		$this->form("radio")->name("select");
		$this->setChild($this->form);
		// $this->form("checkbox")->name("select");
		// $this->validate()->number(1);
	}
	
	public function update() {
		$this->form("radio")->name("update");
		$this->setChild($this->form);
		// $this->validate()->number(1);
	}
	
	public function insert() {
		$this->form("radio")->name("insert");
		$this->setChild($this->form);
		// $this->validate()->number(1);	
	}
	
	public function delete() {
		$this->form("radio")->name("delete");
		$this->setChild($this->form);
		// $this->validate()->number(1);
	}
}
?>