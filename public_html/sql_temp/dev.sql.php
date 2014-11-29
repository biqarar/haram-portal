<?php
namespace sql;
class dev 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $date = array('type' => 'int@8', 'label' => 'date');
	public $description = array('type' => 'text@', 'label' => 'description');
	public $adress = array('type' => 'varchar@255', 'label' => 'adress');
	public $report = array('type' => 'enum@Hasan Salehi,Ahmad Karimi,Reza Mohiti', 'label' => 'report');
	public $repair = array('type' => 'enum@Hasan Salehi,Ahmad Karimi,Reza Mohiti,', 'label' => 'repair');
	public $status = array('type' => 'enum@report,checking...,test,OK', 'label' => 'status');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}
	public function date() 
	{
		
	}
	public function description() 
	{
		
	}
	public function adress() 
	{
		
	}
	public function report() 
	{
		
	}
	public function repair() 
	{
		
	}
	public function status() 
	{
		
	}
}
?>