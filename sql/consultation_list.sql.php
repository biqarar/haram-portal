<?php
namespace sql;
/**
* reza mohiti
*/
class consultation_list {

	public $id              = array('type'=> 'int@10', 'autoI', 'label' => 'consultation_list_id');
	public $consultation_id = array('type' => 'int@10', 'label' => 'consultation_id');
	public $date            = array('type' => 'int@8', 'label' => 'consultation_list_date');
	public $start_time      = array('type' => 'int@4', 'label' => 'consultation_list_statr_time');
	public $end_time        = array('type' => 'int@4', 'label' => 'consultation_list_end_time');
	public $users_id        = array('type' => 'int@10', 'label' => 'users_id');
	public $plan_id         = array('type' => 'int@10', 'label' => 'plan_id');
	public $status          = array('type' => 'enum@free,busy,cancel', 'label' => 'consultation_list_status');
	public $result          = array('type' => 'enum@verify,send_to_other,unverified', 'label' => 'consultation_list_result');
	public $description     = array('type' => 'varchar@255', 'label' => 'consultation_list_description');
	public $quality         = array('type' => 'enum@great,good,medium,bad', 'label' => 'consultation_list_quality');
	public $good_remember   = array('type' => 'set@1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30', 'label' => 'consultation_list_good_remember');
	public $bad_remember    = array('type' => 'set@1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30', 'label' => 'consultation_list_bad_remember');

	public $unique = array("date");
	public $foreign = array("plan_id" => "plan@id!name", "consultation_id" => "consultation@id!name", "users_id" => "users@id!id");
	
	public function id() {
		$this->validate("id");
	}
	
	public function consultation_id() {
		$this->form("select")->name("consultation_id");
		$this->setChild();
	}
	
	public function date() {
		$this->form("#date");
	}
	
	public function start_time() {
		$this->form("#time")->name("start_time")->label("start_time");
		$this->validate()->number(4);
	}
	
	public function end_time() {
		$this->form("#time")->name("end_time")->label("end_time");
		$this->validate()->number(4);
	}
	
	public function users_id() {
		$this->form("select")->name("users_id");
		$this->setChild();
	}
	
	public function plan_id() {
		$this->form("select")->name("plan_id");
		$this->setChild();
	}
	
	public function status() {
		$this->form("select")->name("status");
		$this->setChild($this->form);
	}
	
	public function result() {
		$this->form("select")->name("result");
		$this->setChild($this->form);
	}
	
	public function description() {
		$this->form("#text_desc");
	}
	
	public function quality() {
		$this->form("select")->name("quality");
		$this->setChild($this->form);
	}
	
	public function good_remember() {
		$this->form("select")->name("good_remember");
		$this->setChild($this->form);
	}
	
	public function bad_remember() {
		$this->form("select")->name("bad_remember");
		$this->setChild($this->form);
	}

}
?>