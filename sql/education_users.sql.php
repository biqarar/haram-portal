<?php
namespace sql;
class education_users {
	
	public $id           = array("type" => "int@10" , "label" => "id");
	public $users_id     = array("type" => "int@10" , "label" => "users_id");
	public $education_id = array("type" => "int@10" , "label" => "education_id");
	public $year         = array("type" => "int@4" , "label" => "year");
	public $field        = array("type" => "varchar@255" , "label" => "field");
	public $average      = array("type" => "float@" , "label" => "average");
	public $trend        = array("type" => "varchar@255" );
	
	public $foreign = array("education_id" => "education@id!section");	 
	

	public function id(){
		$this->validate("id");
	}

	public function users_id(){
		$this->validate("id");
	}

	public function education_id(){
		$this->form("select")->name("education_id")->label("education");
		$this->setChild();
		$this->validate("id");

	}

	public function year(){	
		$this->form("#number")->name("year")->label("year");
	}

	public function field(){
		$this->form("#fatext")->name("field")->label("field");
	}

	public function average(){
		$this->form("#number")->name("average")->label("average");
	}

	public function trend(){
		$this->form("#fatext")->name("trend")->label("trend");
	}

}
?>