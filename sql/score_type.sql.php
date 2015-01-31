<?php
/**
* @author reza mohiti
*/
namespace sql;
class score_type {

	public $id          = array('type'=> 'int@10', 'autoI', 'label' => 'score_type_id');
	public $plan_id     = array('type'=> 'int@10', 'label' => 'plan_id');
	public $title       = array('type'=> 'varchar@255', 'label' => 'title');
	public $min         = array('type'=> 'int@3', 'label' => 'min');
	public $max         = array('type'=> 'int@3', 'label' => 'max');
	public $description = array('type'=> 'text@', 'label' => 'description');
	
	public $foreign = array("plan_id" => "plan@id!name");

	public function id() {
		$this->validate("id");
	}

	public function	plan_id(){
		$this->form("select")->name("plan_id")->addClass("select-plan-section")->addClass("not-select");
		$this->setChild(function($q){
			
		}, function($child, $value){
			$child->label($value['name'])->value($value['id']); 
		});
	}

	public function	title(){
		$this->form("text")->name("title")->label("title");
		$this->validate()->farsi()->form->farsi("title is not valid");
	}

	public function	min(){
		$this->form("#number")->name("min")->label("min");
		$this->validate()->number()->form->number("number is not valid");
	}

	public function	max(){
		$this->form("#number")->name("max")->label("max");
		$this->validate()->number()->form->number("number is not valid");
	}

	public function	description(){
		$this->form("#text_desc")->name("description")->label("description");
	}


}

?>