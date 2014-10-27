<?php
namespace sql;
class history {
	public $id         = array('type'=> 'int@10', 'autoI');
	public $record_id  = array('type'=> 'int@10');
	public $table      = array('type'=> 'varchar@32');
	public $date       = array('type'=> 'timestamp@');
	public $query_type = array('type'=> 'enum@insert,update,delete');
	public $users_id   = array('type'=> 'int@10');
	public $ip         = array('type'=> 'varchar@15');
}
?>