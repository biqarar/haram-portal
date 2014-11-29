<?php
namespace sql;
class experiences 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $graduate_id = array('type' => 'int@10', 'label' => 'graduate_id');
	public $short = array('type' => 'varchar@255', 'label' => 'short');
	public $type = array('type' => 'enum@experience,recommend,tip', 'label' => 'type');
	public $text = array('type' => 'text@', 'label' => 'text');
	public $status = array('type' => 'enum@checking,personal,public!checking', 'label' => 'status');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function graduate_id() 
	{
		$this->validate("id");
	}
	public function short() 
	{
		
	}
	public function type() 
	{
		
	}
	public function text() 
	{
		
	}
	public function status() 
	{
		
	}
}
?>