<?php
namespace sql;
class course_description 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $course_id = array('type' => 'int@10', 'label' => 'course_id');
	public $title = array('type' => 'enum@test date,end test date,condition', 'label' => 'title');
	public $description = array('type' => 'text@', 'label' => 'description');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function course_id() 
	{
		$this->validate("id");
	}

	//------------------------------------------------------------------ title
	public function title() 
	{
		$this->form("title")->name("title");
	}
	public function description() 
	{
		
	}
}
?>