<?php
/**
* @author reza mohiti
*/
namespace sql;
class presence {

	public $id     = array('type'=> 'int@10', 'autoI', 'label' => 'branch_id');
	public $classification_id   = array('type'=> 'int@10', 'label' => 'classification_id');
	public $date   = array('type'=> 'int@8', 'label' => 'date');
	public $end_time_classes   = array('type'=> 'int@8', 'label' => 'end_time_classes');
	public $branch_id   = array('type'=> 'int@8', 'label' => 'branch_id');
	public $users_id   = array('type'=> 'int@8', 'label' => 'users_id');

	public $status = array('type'=> 'enum@presence,absence!absence');
	
	public function id() {
		$this->validate("id");
	}

	public function classification_id() {}
	public function date() {}
	public function status() {}
	public function end_time_classes(){}
	public function branch_id(){}
	public function users_id(){}
}
?>