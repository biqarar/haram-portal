<?php
namespace sql;
class nezarat_program {

	
	public $id = array('type' => "int@10", 'label'=> "nezarat_program_id");
	
	public $title = array('type' => "varchar@255", 'label'=> "title");
	
	public $parent = array('type' => "int@10", 'label'=> "parent");
	
	public $description = array('type' => "text@", 'label'=> "description");

	// public $foreign = array("parent" => "nezarat_program@id");

	public function id() {
		$this->validate("id");
	}
	
	public function title() {
		$this->form("text")->name("title");
	}
	
	public function parent() {
		$this->form("text")->name("parent");
		// $this->setChild(function($q){
		// }, function($child, $value){
		// 	$child->label($value['title'])->value($value['id']); 
		// });
		$this->validate("id");
	}
	
	
	public function description() {
		$this->form("textarea")->name("description");
	}
	
}
?>