<?php
namespace sql;
class form_answer 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $users_id = array('type' => 'int@10', 'label' => 'users_id');
	public $form_questions_id = array('type' => 'int@10', 'label' => 'form_questions_id');
	public $answer = array('type' => 'text@', 'label' => 'answer');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function users_id() {
		$this->form("#fatext")->name("users_id");
		$this->validate("id");
	}

	//------------------------------------------------------------------ id - foreign key
	public function form_questions_id() {
		$this->validate("id");
	}
	public function answer() {
		$this->from("#text_desc")->name("answer");
	}
}
?>