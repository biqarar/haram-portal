<?php
namespace sql;
class education 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $group = array('type' => 'enum@academic,howzah!academic', 'label' => 'group');
	public $section = array('type' => 'varchar@32', 'label' => 'section');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}
	public function group() 
	{
		
	}
	public function section() 
	{
		
	}
}
?>