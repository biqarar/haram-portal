<?php
namespace sql;
class consultation_list 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $consultation_id = array('type' => 'int@10', 'label' => 'consultation_id');
	public $date = array('type' => 'int@8', 'label' => 'date');
	public $start_time = array('type' => 'time@', 'label' => 'start_time');
	public $end_time = array('type' => 'time@', 'label' => 'end_time');
	public $users_id = array('type' => 'int@10', 'label' => 'users_id');
	public $plan_id = array('type' => 'int@10', 'label' => 'plan_id');
	public $status = array('type' => 'enum@free,busy,cancel!free', 'label' => 'status');
	public $result = array('type' => 'enum@verify,send_to_other,unverified', 'label' => 'result');
	public $description = array('type' => 'varchar@255', 'label' => 'description');
	public $quality = array('type' => 'enum@great,good,medium,bad', 'label' => 'quality');
	public $good_remember = array('type' => 'set@'1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30'', 'label' => 'good_remember');
	public $bad_remember = array('type' => 'set@'1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30'', 'label' => 'bad_remember');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function consultation_id() 
	{
		$this->validate("id");
	}
	public function date() 
	{
		
	}
	public function start_time() 
	{
		
	}
	public function end_time() 
	{
		
	}

	//------------------------------------------------------------------ id - foreign key
	public function users_id() 
	{
		$this->validate("id");
	}

	//------------------------------------------------------------------ id - foreign key
	public function plan_id() 
	{
		$this->validate("id");
	}
	public function status() 
	{
		
	}
	public function result() 
	{
		
	}
	public function description() 
	{
		
	}
	public function quality() 
	{
		
	}
	public function good_remember() 
	{
		
	}
	public function bad_remember() 
	{
		
	}
}
?>