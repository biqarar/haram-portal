<?php
namespace sql;
class form_group 
{
	public $id          = array('type' => 'int@10', 'label' => 'id');
	public $name        = array('type' => 'varchar@255', 'label' => 'name');
	public $description = array('type' => 'text@', 'label' => 'description');


	//------------------------------------------------------------------ id - primary key
	public function id() {
		$this->validate("id");
	}
	
	public function name() 	{
		$this->form("#fatext")->name("name")->lable("name");
	}

	public function description() {
		$this->form("#text_desc");
	}
}
?>