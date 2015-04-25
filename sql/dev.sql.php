<?php
namespace sql;

class dev {
	public $id       = array('type'=> 'int@10', 'autoI', 'label' => 'dev_id');
	public $date = array('type'=> 'int@10', 'label' => 'date');
	public $description = array('type'=> 'varchar@32', 'label' => 'description');
	public $adress    = array('type'=> 'varchar@64', 'label' => 'adress');
	public $report    = array('type'=> 'enum@Hasan Salehi,Ahmad Karimi,Reza Mohiti', 'label' => 'reporter');
	public $repair    = array('type'=> 'enum@Hasan Salehi,Ahmad Karimi,Reza Mohiti', 'label' => 'repair');
	public $status    = array('type'=> 'enum@report,checking...,test,OK!report', 'label' => 'status');

	public function id() {
		$this->validate("id");
	}

	public function date() {
		$this->form("text")->name("date")->label("date")->date("date");
		$this->validate()->date();
	}
	
	public function description() {
		$this->form("textarea")->name("description")->label("description");
	}
	
	public function adress () {
		$this->form("#text_desc")->name("adress")->label("adress");
	}
	
	public function report() {
		$this->form("select")->name("report")->label("report");
		$this->setChild($this->form);
	}
	
	public function repair() {
		$this->form("select")->name("repair")->label("repair");
		$this->setChild($this->form);
	}
	
	public function status() {
		$this->form("select")->name("status")->label("status");
		$this->setChild($this->form);
	} 
}
?>