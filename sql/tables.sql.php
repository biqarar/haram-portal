<?php
namespace sql;
class tables {
	public $id     = array('type'=> 'int@10', 'autoI', 'label' => 'tables_id');
	public $name   = array('type'=> 'varchar@32', 'label' => 'tables_name');
	public $faname = array('type'=> 'varchar@32', 'label' => 'tables_faname');

	public $unique = array("name");

	public function id() {
		$this->validate("id");
	}

	public function name() {
		$this->form("#entext")->name("name");
	}

	public function faname() {
		$this->form("#fatext")->name("faname");
	}
}
?>