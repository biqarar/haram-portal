<?php
namespace sql;
class absence 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $classification_id = array('type' => 'int@10', 'label' => 'classification_id');
	public $type = array('type' => 'enum@delay,leave,unjustified absence,justified absence!unjustified absence', 'label' => 'type');
	public $date = array('type' => 'int@8', 'label' => 'date');
	public $because = array('type' => 'varchar@255', 'label' => 'because');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function classification_id() 
	{
		$this->validate("id");
	}
	public function type() 
	{
		
	}
	public function date() 
	{
		
	}
	public function because() 
	{
		
	}
}
?>