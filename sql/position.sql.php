<?php
namespace sql;
class position {
	public $id    = array('type'=> 'int@10' , 'label' => 'position_id');
	public $position = array('type'=> 'varchar@255', 'label' => 'position_position');

	public $unique = array("position");

	public function id() {
		$this->validate("id");
	}

	public function position() {
		$this->form("#fatext")->name("position");
		$this->validate()->farsi(3,255);
	}
}
?>