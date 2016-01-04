<?php
/**
* @author reza mohiti
*/
namespace sql;
class presence {

	public $id     = array('type'=> 'int@10', 'autoI', 'label' => 'because');
	public $classification_id   = array('type'=> 'int@10', 'label' => 'classification_id');
	public $date   = array('type'=> 'int@8', 'label' => 'date');
	public $type   = array('type'=> 'enum@presence,unjustified absence', 'label' => 'type');
	public $because   = array('type'=> 'varchar@255', 'label' => 'because');

	public $status = array('type'=> 'enum@presence,absence!absence');
	
	public function id() {
		$this->validate("id");
	}

	public function classification_id() {}
	public function date() {}
	public function type(){}
	public function because(){}
}
?>