<?php
namespace sql;

class ahmad {
	public $id 			= array('type' => 'int@10', 'autoI', 'label' => 'id');
	public $name 		= array('type' => 'varchar@255', 'label' => 'name');
	public $type 		= array('type' => 'enum@old,young,child!young', 'label' => 'type');
	public $description = array('type' => 'text@', 'label' => 'description');

	public function id() {}

	public function name() {
		$this->form('text')->name('name')->pl('name');
	}

	public function type() {
		$this->form('select')->name('type');
		$this->setChild($this->form);
	}

	public function description() {
		$this->form('#text_desc');
	}
}
?>