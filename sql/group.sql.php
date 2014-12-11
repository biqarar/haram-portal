<?php
namespace sql;
class group {
	public $id   = array('type'=> 'int@10', 'autoI', 'label' => 'group_id');
	public $name = array('type'=> 'varchar@32', 'label' => 'group_name');

	public $unique = array("name");

	public function id() {
		$this->validate("id");
	}

	public function name() {
		$this->form("#fatext")->name("name");
	}
}
?>