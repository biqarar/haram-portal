<?php
namespace sql;
class branch 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $name = array('type' => 'varchar@32', 'label' => 'name');
	public $code = array('type' => 'int@3', 'label' => 'code');
	public $gender = array('type' => 'enum@male,female,male_female', 'label' => 'gender');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}
	public function name() 
	{
		
	}
	public function code() 
	{
		
	}
	public function gender() 
	{
		
	}
}
?>