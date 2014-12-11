<?php
/**
 * @author reza mohiti
 */
namespace sql;
class course_description {
	public $id        = array('type'=> 'int@10', 'autoI', 'label' => 'course_description_id');
	public $course_id = array('type'=> 'int@10', 'label' => 'course_id');
	public $title     = array('type'=> 'enum@test date,end test date,condition!condition', 'label' => 'course_description_title');
	public $description     = array('type'=> 'text@','label' => 'course_description_description');
	
	public $unique   = array("title");
	public $foreign   = array("course_id" => "course@id!name");
	public $index    = array("course_id");

	public function id() {
		$this->validate("id");
	}

	public function course_id() {
		$this->form("select")->name("course_id");
		$this->setChild();
		$this->validate("id");
	}
	
	public function title() {
		$this->form("select")->name("title");
		$this->setChild();
	}
	
	public function description() {
		$this->form("#text_desc")->name("description");	
	}
}
?>