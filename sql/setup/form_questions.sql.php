<?php
namespace sql;
class form_questions 
{
	public $id              = array('type' => 'int@10', 'label' => 'id');
	public $string          = array('type' => 'varchar@255', 'label' => 'string');
	public $answer_type     = array('type' => 'enum@string,enum,set,bolean,table,file', 'label' => 'answer_type');
	public $answer_value    = array('type' => 'text@', 'label' => 'answer_value');
	public $answer_validate  = array('type' => 'enum@persian,english,number,enum', 'label' => 'answer_validate');
	public $allow_null      = array('type' => 'enum@yes,no', 'label' => 'allow_null');
	public $multiple_answer = array('type' => 'enum@yes,no', 'label' => 'multiple_answer');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}
	public function string() 
	{
		$this->form("#text_desc")->name("string");
		
	}
	public function answer_type() {
		$this->form("select")->name("answer_type")->label("answer_type");
		$this->setChild($this->form);
	}

	public function answer_value() {
		$this->form("#text_desc")->name("answer_value");
		
	}

	public function answer_validate() {
		$this->form("select")->name("answer_validate");
		$this->setChild($this->form);
	}

	public function allow_null() {
		$this->form("radio")->name("allow_null")->label("allow_null");
		$this->setChild($this->form);
	}

	public function multiple_answer() {
		$this->form("radio")->name("multiple_answer")->label("multiple_answer");
		$this->setChild($this->form);
	}
}
?>