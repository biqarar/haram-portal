<?php
namespace sql;
class form_group_item 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $form_group_id = array('type' => 'int@10', 'label' => 'form_group_id');
	public $form_questions_id = array('type' => 'int@10', 'label' => 'form_questions_id');

	public $foreign = array("form_questions_id" => "form_questions@id!string",
							"form_group_id" => "form_group@id!name");
	//------------------------------------------------------------------ id - primary key
	public function id() {
		$this->validate("id");
	}

	//------------------------------------------------------------------ id - foreign key
	public function form_group_id() {
		$this->form("text")->name("form_group_id");
		// $this->setChild();
		// $this->validate("id");
	}

	//------------------------------------------------------------------ id - foreign key
	public function form_questions_id() {
		$this->form("text")->name("form_questions_id");
		// $this->setChild();
		
		// $this->validate("id");
	}
}
?>