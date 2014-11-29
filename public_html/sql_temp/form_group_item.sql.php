<?php
namespace sql;
class form_group_item 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $form_group_id = array('type' => 'int@10', 'label' => 'form_group_id');
	public $form_question_id = array('type' => 'int@10', 'label' => 'form_question_id');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function form_group_id() 
	{
		$this->validate("id");
	}

	//------------------------------------------------------------------ id - foreign key
	public function form_question_id() 
	{
		$this->validate("id");
	}
}
?>