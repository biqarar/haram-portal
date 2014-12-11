<?php
/**
 * @author reza mohiti
 */
namespace sql;
class folders {
	public $id      = array('type'=> 'int@10', 'autoI');
	public $name    = array('type'=> 'varchar@32');
	public $adress  = array('type'=> 'varchar@255');
	
	public $unique = array("name");

	public function id() {
		$this->validate("id");
	}

	public function name() {
		$this->form("#text_desc")->name("name");
	}

	public function adress() {
		$this->form("#text_desc")->name("adress");		
	}
}
?>