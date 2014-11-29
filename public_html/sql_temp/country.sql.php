<?php
namespace sql;
class country 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $name = array('type' => 'varchar@32', 'label' => 'name');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}
	public function name() 
	{
		
	}
}
?>