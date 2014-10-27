<?php
namespace sql;
class table_files {
	public $id          = array('type'=> 'int@10', 'label' => 'table_files_id');
	public $table       = array('type'=> 'varchar@32', 'label' => 'table_files_table');
	public $record_id   = array('type'=> 'int@10', 'label' => 'table_files_record_id');
	public $files_id    = array('type'=> 'int@10', 'label' => 'files_id');
	public $description = array('type'=> 'text@', 'label' => 'table_files_description');
	
}
?>