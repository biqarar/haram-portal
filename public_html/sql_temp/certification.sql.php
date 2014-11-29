<?php
namespace sql;
class certification 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $classification_id = array('type' => 'int@10', 'label' => 'classification_id');
	public $date_design = array('type' => 'int@8', 'label' => 'date_design');
	public $date_print = array('type' => 'int@8', 'label' => 'date_print');
	public $date_deliver = array('type' => 'int@8', 'label' => 'date_deliver');
	public $date_request = array('type' => 'int@8', 'label' => 'date_request');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function classification_id() 
	{
		$this->validate("id");
	}
	public function date_design() 
	{
		
	}
	public function date_print() 
	{
		
	}
	public function date_deliver() 
	{
		
	}
	public function date_request() 
	{
		
	}
}
?>