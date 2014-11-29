<?php
namespace sql;
class graduate 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $users_id = array('type' => 'int@10', 'label' => 'users_id');
	public $status = array('type' => 'enum@checking,active,inactive!checking', 'label' => 'status');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function users_id() 
	{
		$this->validate("id");
	}
	public function status() 
	{
		
	}
}
?>