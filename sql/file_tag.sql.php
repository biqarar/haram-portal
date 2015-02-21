<?php
/**
 * @author reza mohiti
 */

namespace sql;
class file_tag {
	public $id          = array('type'=> 'int@10', 'autoI', 'label' => 'file_paln_id');
	public $tag    = array('type'=> 'varchar@64', 'label' => 'tag');
	public $table        = array('type'=> 'enum@users,posts,plan', 'label' => 'table');

	
	public function id() {
		$this->validate("id");
	}
	
	public function tag(){
		$this->form("select")->name("tag")->label("tag");
		$this->setChild();
	}
	public function table(){
		$this->form("select")->name("table")->label("table");
		$this->setChild();
	}
	
}
?>