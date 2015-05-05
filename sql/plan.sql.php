<?php
namespace sql;
class plan {
	public $id          = array('type'=> 'int@10', 'autoI', 'label' => 'plan_id');
	public $group_id    = array('type'=> 'int@10', 'label' => 'group_id');
	public $name        = array('type'=> 'varchar@32', 'label' => 'plan_name');
	public $price       = array('type'=> 'int@7', 'label' => 'plan_price');
	public $absence     = array('type'=> 'int@2', 'label' => 'plan_absence');
	public $certificate = array('type'=> 'enum@yes,no!yes', 'label' => 'plan_certificate');
	public $mark        = array('type'=> 'float@', 'label' => 'plan_mark');
	public $rule        = array('type'=> 'int@10', 'label' => 'plan_rule');
	public $min_person  = array('type'=> 'int@3', 'label' => 'plan_min_person');
	public $max_person  = array('type'=> 'int@4', 'label' => 'plan_max_person');
	public $expired_price 	= array("type" => "int@3", 'label' => "plan_expired_price");

	public $unique = array("group");
	public $index = array("group_id");

	public $foreign = array("group_id" => "group@id!name");

	public function id() {
		$this->validate("id");
	}
	
	public function group_id() {
		$this->form("select")->name("group_id");
		$this->setChild();
	}
	
	public function name() {
		$this->form("#fatext")->name("name");
		$this->validate()->farsi()->form->farsi("plan name should be persian");
	}
	
	public function price() {
		$this->form("#price")->name("price")->id("no-icon-price");
		$this->validate()->number(3, 7)->form->number("entered price is not valid");
	}
	
	public function absence() {
		$this->form("#number")->name("absence");
		$this->validate()->number(1, 2)->form->number("absences number is not valid");
	}
	
	public function certificate() {
		$this->form("radio")->name("certificate");
		$this->setChild($this->form);
	}
	
	public function mark() {
		$this->form("#number")->name("mark")->addClass('slider-number')->min(0)->max(100);
		$this->validate()->number(1, 3)->form->number("plan score is not valid");
	}
	
	public function rule() {
		$this->validate("id");
	}
	
	public function min_person() {
		$this->form("#number")->name("min_person");
		$this->validate()->number(1, 3)->form->number("minimum persons number is not valid");
	}
	
	public function max_person() {
		$this->form("#number")->name("max_person");
		$this->validate()->number(1, 4)->form->number("maximum persons number is not valid");
	}

	public function expired_price() {
		$this->form("#number")->name("expired_price")->pl("تعداد روز");
		$this->validate()->number()->form->number("expired_price is not valid");
	}
}
?>