<?php
namespace sql;
class users {
	public $id       = array('type'=> 'int@10', 'autoI', 'label' => 'users_id');
	public $username = array('type'=> 'int@10', 'label' => 'users_name');
	public $password = array('type'=> 'varchar@32', 'label' => 'users_password');

	public $email    = array('type'=> 'varchar@64', 'label' => 'users_email');
	public $type = array("type" => "enum@student,teacher,operator,baby!student");
	public $status = array("type" => "enum@waiting,block,delete,enable!waiting");
	public $unique   = array("username", "email");
	

	public function id() {
		$this->validate("id");
	}

	public function username() {
		$this->form("#number")->name("username");
		$this->validate()->number(8);
	}

	public function password() {
		$this->form("password")->name("password");
		$this->validate()->reg("/(.*){3,32}/");
	}

	public function type() {
		$this->form("select")->name("type");
		$this->setChild($this->form);
	}

	public function status() {
		$this->form("select")->name("status");
		$this->setChild($this->form);
	}

	
	public function email() {
		$this->form("#email")->name("email");
	}
}
?>