<?php
/**
 * @author reza mohiti
 */

namespace sql;
class file_tag {
	public $id          = array('type'=> 'int@10', 'autoI', 'label' => 'file_paln_id');
	public $tag    = array('type'=> 'varchar@64', 'label' => 'tag');
	public $table_name        = array('type'=> 'enum@users,posts,plan', 'label' => 'table_name');

	
	public function id() {
		$this->validate("id");
	}
	
	public function tag(){
		$this->form("text")->name("tag")->label("tag");
	}
	public function table_name(){
		$this->form("select")->name("table_name")->label("table_name");
		$this->setChild();
	}
	
}
?>