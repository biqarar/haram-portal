<?php
namespace sql;
class course 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $begin_time = array('type' => 'int@8', 'label' => 'begin_time');
	public $end_time = array('type' => 'int@8', 'label' => 'end_time');
	public $name = array('type' => 'varchar@64', 'label' => 'name');
	public $expert = array('type' => 'int@10', 'label' => 'expert');
	public $branch_id = array('type' => 'int@10', 'label' => 'branch_id');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}
	public function begin_time() 
	{
		
	}
	public function end_time() 
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