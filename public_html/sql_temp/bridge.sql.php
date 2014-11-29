<?php
namespace sql;
class bridge 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $users_id = array('type' => 'int@10', 'label' => 'users_id');
	public $title = array('type' => 'enum@phone,mobile,email,address!phone', 'label' => 'title');
	public $value = array('type' => 'varchar@255', 'label' => 'value');
	public $description = array('type' => 'varchar@255', 'label' => 'description');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function users_id() 
	{
		$this->validate("id");
	}

	//------------------------------------------------------------------ title
	public function title() 
	{
		$this->form("title")->name("title");
	}
	public function value() 
	{
		
	}
	public function description() 
	{
		
	}
}
?>