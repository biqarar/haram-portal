<?php
namespace sql;
class branch_cash 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $table = array('type' => 'varchar@64', 'label' => 'table');
	public $record_id = array('type' => 'int@10', 'label' => 'record_id');
	public $branch_id = array('type' => 'int@10', 'label' => 'branch_id');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}
	public function table() 
	{
		
	}

	//------------------------------------------------------------------ id - foreign key
	public function record_id() 
	{
		$this->validate("id");
	}

	//------------------------------------------------------------------ id - foreign key
	public function branch_id() 
	{
		$this->validate("id");
	}
}
?>