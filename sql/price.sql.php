<?php
namespace sql;
class price {
	public $id                 = array('type'=> 'int@10', 'autoI', 'label' => 'price_id');
	public $course_id          = array('type'=> 'int@10');
	public $plan_id            = array('type'=> 'int@10');
	public $users_id           = array('type'=> 'int@10');
	public $value              = array('type'=> 'int@10');
	public $status             = array('type'=> 'enum@فعال,استفاده شده,ارجاع داده شده,بلوکه شده');
	public $date_change_status = array('type'=> 'int@10');
	public $expert             = array('type'=> 'int@10');
	public $value_back         = array('type'=> 'int@10');

	public $unique = array("id");
}
?>