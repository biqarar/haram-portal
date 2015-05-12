<?php
namespace sql;
class courseclasses {
	public $id           = array('type'=> 'int@10', 'autoI', 'label' => 'prerequisite_id');
	public $course_id      = array('type'=> 'int@10', 'label' => 'course_id');
	public $classes_id      = array('type'=> 'int@10', 'label' => 'classes_id');

	public $foreign = array("course_id" => "course@id!name");

	public function id() {
		$this->validate("id");
	}

	public function course_id() {
		$this->form("select")->name("course_id")->class("notselect");
		$this->setChild();
	}

	public function classes_id() {
		// $this->form("select")->name("classes_id");
		// $this->setChild();
	}
}
?>