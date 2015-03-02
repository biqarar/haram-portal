<?php
/**
* @author reza mohiti
*/
namespace sql;
class drafts {

	public $id     = array('type'=> 'int@10', 'autoI', 'label' => 'drafts_id');
	public $group   = array('type'=> 'enum@classes,classification,score,person,absence','label' => 'group');
	public $tag   = array('type'=> 'varchar@255', 'label' => 'tag');
	public $text   = array('type'=> 'text@', 'label' => 'text');

	public function id() {
		$this->validate("id");
	}


	public function group() {
		$this->form("select")->name("group");
		$this->setChild();
		$this->validate();
	}

	public function tag() {
		$this->form("text")->name("tag");
		$this->validate();
	}

	public function text() {
		$this->form("textarea")->name("text");
		$this->validate()->description(-1);
	}
}

?>