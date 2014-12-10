<?php
class form_users {
	public $id	= array("type" => "int@10");
	public $users_id	= array("type" => "int@10");
	public $form_group_id	= array("type" => "int@10");
	public $status	= array("type" => "enum@completed,needrecomplet,uncomplete!uncomplete");


	public function id() {}	
	public function users_id() {}	
	public function form_group_id() {}
	public function status() {}
}
?>