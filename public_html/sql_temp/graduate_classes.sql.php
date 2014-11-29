<?php
namespace sql;
class graduate_classes 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $graduate_id = array('type' => 'int@10', 'label' => 'graduate_id');
	public $classes_id = array('type' => 'int@10', 'label' => 'classes_id');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function graduate_id() 
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