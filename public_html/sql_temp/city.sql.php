<?php
namespace sql;
class city 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $province_id = array('type' => 'int@10', 'label' => 'province_id');
	public $name = array('type' => 'varchar@32', 'label' => 'name');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function province_id() 
	{
		$this->validate("id");
	}
	public function name() 
	{
		
	}
}
?>