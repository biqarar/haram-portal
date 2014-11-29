<?php
namespace sql;
class form_questions 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $string = array('type' => 'varchar@255', 'label' => 'string');
	public $answer_type = array('type' => 'enum@string,enum,set,bolean,table,file', 'label' => 'answer_type');
	public $answer_value = array('type' => 'text@', 'label' => 'answer_value');
	public $answer_validte = array('type' => 'varchar@255', 'label' => 'answer_validte');
	public $allow_null = array('type' => 'enum@yes,no', 'label' => 'allow_null');
	public $multiple_answer = array('type' => 'enum@yes,no', 'label' => 'multiple_answer');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}
	public function string() 
	{
		
	}
	public function answer_type() 
	{
		
	}
	public function answer_value() 
	{
		
	}
	public function answer_validte() 
	{
		
	}
	public function allow_null() 
	{
		
	}
	public function multiple_answer() 
	{
		
	}
}
?>