<?php
/**
 * @author reza mohiti
 */
namespace sql;
class files {
	public $id          = array('type'=> 'int@10', 'autoI', 'label' => 'files_id');
	public $title       = array('type'=> 'varchar@32', 'label' => 'files_title');
	public $size        = array('type'=> 'float@', 'label' => 'files_size');
	public $type        = array('type'=> 'varchar@6', 'label' => 'files_type');
	public $folders  = array('type'=> 'int@10', 'label' => 'files_folders');
	public $description = array('type'=> 'varchar@255', 'label' => 'files_description');
	
	public $unique      = array("id");
	public $index       = array("folders_id");

	public function id() {
		$this->validate("id");
	}
	
	public function title() {
		$x = $this->form("#fatext")->name("title");
		$x->validate()->rename(function (){
			$this->value = preg_replace("/[^a-zA-Z0-9".FACHR."]/", '-', $this->value);
		});
	}
	
	public function description() {
		$this->form("#text_desc")->name("description");
	}
}
?>