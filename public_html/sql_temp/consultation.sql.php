<?php
namespace sql;
class consultation 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $group = array('type' => 'enum@level,consultation,exam', 'label' => 'group');
	public $name = array('type' => 'varchar@64', 'label' => 'name');
	public $expert = array('type' => 'int@10', 'label' => 'expert');
	public $branch_id = array('type' => 'int@10', 'label' => 'branch_id');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}
	public function group() 
	{
		
	}
	public function name() 
	{
		
	}
	public function expert() 
	{
		
	}

	//------------------------------------------------------------------ id - foreign key
	public function branch_id() 
	{
		$this->validate("id");
	}
}
?>