<?php
namespace sql;
class branch_description 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $branch_id = array('type' => 'int@10', 'label' => 'branch_id');
	public $title = array('type' => 'enum@buss,address,working hours,phone,branch sections', 'label' => 'title');
	public $value = array('type' => 'varchar@255', 'label' => 'value');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function branch_id() 
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
}
?>