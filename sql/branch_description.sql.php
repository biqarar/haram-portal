<?php
/**
 * reza mohiti
 */
namespace sql;
class branch_description {
	public $id        = array('type'=> 'int@10', 'autoI', 'label' => 'branch_description_id');
	public $branch_id = array('type'=> 'int@10', 'label' => 'branch_id');
	public $title     = array('type'=> 'enum@buss,adress,working hours,phone,branch sections!address', 'label' => 'branch_description_title');
	public $value     = array('type'=> 'varchar@255', 'label' => 'branch_description_value');
	
	public $uniques   = array("branch_id", "title");
	public $foreign   = array("branch_id" => "branch@id!name");

	public function id() {
		$this->validate("id");
	}
	public function branch_id() {
		$this->form("select")->name("branch_id");
		$this->setChild();
		$this->validate("id");
	}

	public function title() {
		$this->form("select")->name("title");
		$this->setChild($this->form);
	}

	public function value() {
		$this->form("#text_desc")->name("value");
	}
}