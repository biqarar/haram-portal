<?php
namespace sql;
class files 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $title = array('type' => 'varchar@32', 'label' => 'title');
	public $size = array('type' => 'float@', 'label' => 'size');
	public $type = array('type' => 'varchar@6', 'label' => 'type');
	public $folder = array('type' => 'int@4', 'label' => 'folder');
	public $description = array('type' => 'varchar@255', 'label' => 'description');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ title
	public function title() 
	{
		$this->form("title")->name("title");
	}
	public function size() 
	{
		
	}
	public function type() 
	{
		
	}
	public function folder() 
	{
		
	}
	public function description() 
	{
		
	}
}
?>