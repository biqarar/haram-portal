<?php
namespace sql;
class classification 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $users_id = array('type' => 'int@10', 'label' => 'users_id');
	public $date_entry = array('type' => 'int@8', 'label' => 'date_entry');
	public $date_delete = array('type' => 'int@8', 'label' => 'date_delete');
	public $because = array('type' => 'enum@absence,cansel,done', 'label' => 'because');
	public $mark = array('type' => 'float@', 'label' => 'mark');
	public $plan_section_id = array('type' => 'int@10', 'label' => 'plan_section_id');
	public $classes_id = array('type' => 'int@10', 'label' => 'classes_id');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function users_id() 
	{
		$this->validate("id");
	}
	public function date_entry() 
	{
		
	}
	public function date_delete() 
	{
		
	}
	public function because() 
	{
		
	}
	public function mark() 
	{
		
	}

	//------------------------------------------------------------------ id - foreign key
	public function plan_section_id() 
	{
		$this->validate("id");
	}

	//------------------------------------------------------------------ id - foreign key
	public function classes_id() 
	{
		$this->validate("id");
	}
}
?>