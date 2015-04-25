<?php
/**
 * @author reza mohiti
 */

namespace sql;
class file_user {
	public $id          = array('type'=> 'int@10', 'autoI', 'label' => 'file_paln_id');
	public $files_id    = array('type'=> 'int@10', 'label' => 'files_id');
	public $user_id        = array('type'=> 'float@', 'label' => 'user_id');

	public $foreign = array("files_id" => "files@id!title", "user_id" => "user@id!name");

	public function id() {
		$this->validate("id");
	}
	
	public function files_id(){
		$this->form("select")->name("files_id")->label("files_id");
		$this->setChild();
	}
	public function user_id(){
		$this->form("select")->name("user_id")->label("user_id");
		$this->setChild();
	}
	
}
?>