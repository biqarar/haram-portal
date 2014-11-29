<?php
namespace sql;
class classes 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $course_id = array('type' => 'int@10', 'label' => 'course_id');
	public $plan_id = array('type' => 'int@10', 'label' => 'plan_id');
	public $meeting_no = array('type' => 'int@3', 'label' => 'meeting_no');
	public $teacher = array('type' => 'int@10', 'label' => 'teacher');
	public $age_range = array('type' => 'enum@child,teen,young,adult', 'label' => 'age_range');
	public $quality = array('type' => 'enum@level one,level two,level three,begginer level,medium,advanced', 'label' => 'quality');
	public $place_id = array('type' => 'int@10', 'label' => 'place_id');
	public $start_time = array('type' => 'time@', 'label' => 'start_time');
	public $end_time = array('type' => 'time@', 'label' => 'end_time');
	public $start_date = array('type' => 'int@8', 'label' => 'start_date');
	public $end_date = array('type' => 'int@8', 'label' => 'end_date');
	public $week_days = array('type' => 'set@'sunday','monday','tuesday','wednesday','thursday','friday','saturday'', 'label' => 'week_days');
	public $name = array('type' => 'varchar@64', 'label' => 'name');
	public $status = array('type' => 'enum@ready,running,done', 'label' => 'status');
	public $type = array('type' => 'enum@physical,virtual!physical', 'label' => 'type');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function course_id() 
	{
		$this->validate("id");
	}

	//------------------------------------------------------------------ id - foreign key
	public function plan_id() 
	{
		$this->validate("id");
	}
	public function meeting_no() 
	{
		
	}
	public function teacher() 
	{
		
	}
	public function age_range() 
	{
		
	}
	public function quality() 
	{
		
	}

	//------------------------------------------------------------------ id - foreign key
	public function place_id() 
	{
		$this->validate("id");
	}
	public function start_time() 
	{
		
	}
	public function end_time() 
	{
		
	}
	public function start_date() 
	{
		
	}
	public function end_date() 
	{
		
	}
	public function week_days() 
	{
		
	}
	public function name() 
	{
		
	}
	public function status() 
	{
		
	}
	public function type() 
	{
		
	}
}
?>