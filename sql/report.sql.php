<?php
/**
 * @author Reza Mohiti
 */

namespace sql;

class report {
	
	public $id    = array('type'=> 'int@10', 'autoI', 'label' => 'report_id');
	public $table = array('type'=> 'varchar@255', 'label' => 'table');
	public $name  = array('type'=> 'varchar@255', 'label' => 'name');
	public $url   = array('type'=> 'varchar@255', 'label' => 'url');

	public function id() {
		$this->validate("id");
	}

	public function table() {
		$this->form("text")->name("table")->label("table");
		$this->validate();
	}
	public function name() {
		$this->form("text")->name("name")->label("name");
		$this->validate();


	}
	public function url() {
		$this->form("text")->name("url")->label("url");
		$this->validate();

	}

}
?>