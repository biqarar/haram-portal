<?php
namespace sql;
class nezarat_item {

	
	public $id = array('type' => "int@10", 'label'=> "nezarat_item_id");
	
	public $title = array('type' => "varchar@255", 'label'=> "title");
	
	public $validation = array('type' => "enum@number,text", 'label'=> "validation");
	
	public $group = array('type' => "enum@مالی,ارزیابی,عملکرد,نظرسنجی,خود ارزیابی,شناسه ای,آسیب ها و مشکلات", 'label'=> "group");
	
	public $description = array('type' => "text@", 'label'=> "description");

	public function id() {
		$this->validate("id");
	}
	
	public function title() {
		$this->form("text")->name("title");
	}
	
	public function validation() {
		$this->form("select")->name("validation");
		$this->setChild($this->form);
	}
	
	public function group() {
		$this->form("select")->name("group");
		$this->setChild($this->form);
	}
	
	public function description() {
		$this->form("textarea")->name("description");
	}
	
}
?>