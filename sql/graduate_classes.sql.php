<?php
namespace sql;
class graduate_classes {
	public $id          = array('type'=> 'int@10', 'label' => 'graduate_classes_id');
	public $graduate_id = array('type'=> 'int@10', 'label' => 'graduate_id');
	public $classes_id    = array('type'=> 'int@10', 'label' => 'classes_id');

	public $unique = array("id");
	public $foreign = array("graduate_id" => "graduate@id!id", "classes_id"=> "classes@id!name");

	public function id() {
		$this->validate("id");
	}
	
	public function graduate_id() {
		$this->form("select")->name("graduate_id");
		$this->setChild();
	}
	
	public function classes_id() {
		$this->form("select")->name("classes_id");
		$this->setChild();
	}
}
?>