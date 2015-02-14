<?php
/**
* @author reza mohiti
*/
namespace sql;
class drafts {

	public $id     = array('type'=> 'int@10', 'autoI', 'label' => 'drafts_id');
	public $tag   = array('type'=> 'varchar@255', 'label' => 'drafts_tag');
	public $text   = array('type'=> 'text@', 'label' => 'drafts_text');

	public function id() {
		$this->validate("id");
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